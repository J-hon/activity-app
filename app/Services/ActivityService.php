<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class ActivityService
{

    public function get(int $userId = null): array
    {
        try {
            $activities = Activity::query()
                ->when($userId, function ($query) use ($userId) {
                    $query->whereHas('users', fn ($query) => $query->where('users.id', '=', $userId));
                })
                ->get();

            return [
                'status'  => true,
                'message' => 'Activities retrieved!',
                'code'    => 200,
                'data'    => $activities
            ];
        }
        catch (Throwable $th) {
            report($th);
            return [
                'status'  => false,
                'message' => 'An error occurred. Please try again shortly',
                'code'    => 400
            ];
        }
    }

    public function create(array $params, int $userId = null): array
    {
        DB::beginTransaction();

        try {
            $activities = [];
            $activityId = Activity::create($params)->id;

            if ($params['is_global']) {
                $users = User::query()->select(['id', 'user_type'])
                    ->where('user_type', '=', 'user')
                    ->get();

                foreach ($users as $user) {
                    $activities[] = [
                        'activity_id' => $activityId,
                        'user_id'     => $user->id
                    ];
                }

                DB::table('activity_user')->insert($activities);
            }
            else {
                DB::table('activity_user')->insert([
                    'activity_id' => $activityId,
                    'user_id'     => $userId
                ]);
            }

            DB::commit();
            return [
                'status'  => true,
                'message' => 'Activity created!',
                'code'    => 200
            ];
        }
        catch (Throwable $th) {
            DB::rollBack();
            report($th);
            return [
                'status'  => false,
                'message' => 'An error occurred. Please try again shortly',
                'code'    => 400
            ];
        }
    }

    public function update(int $activityId, array $params, int $userId = null): array
    {
        try {
            if (!$userId) {
                Activity::find($activityId)->update($params);
            }
            else {
                $revision = Revision::updateOrCreate([
                    'user_id'     => $userId,
                    'activity_id' => $activityId
                ], $params);

                DB::table('activity_user')
                    ->where([
                        'user_id'     => $userId,
                        'activity_id' => $activityId
                    ])
                    ->update([
                        'revision_id' => $revision->id
                    ]);
            }

            return [
                'status'  => true,
                'message' => 'Activity updated!',
                'code'    => 200
            ];
        }
        catch (Throwable $th) {
            report($th);
            return [
                'status'  => false,
                'message' => 'An error occurred. Please try again shortly',
                'code'    => 400
            ];
        }
    }

}
