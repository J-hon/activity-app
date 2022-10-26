<?php

namespace App\Services;

use App\Jobs\CreateActivityForUsersJob;
use App\Models\Activity;
use App\Models\Revision;
use Illuminate\Support\Facades\DB;
use Throwable;

class ActivityService
{

    public function get(): array
    {
        try {
            $activities = Activity::get();
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

    public function create(array $params): array
    {
        DB::beginTransaction();

        try {
            $activity = Activity::create($params);
            CreateActivityForUsersJob::dispatch($activity, $params['user_id'] ?? null);

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

                Revision::where('activity_id', '=', $activityId)->update($params);
            }
            else {
                Revision::where([
                    'user_id'     => $userId,
                    'activity_id' => $activityId
                ])
                ->update($params);
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

    public function delete($id): array
    {
        try {
            Activity::find($id)->delete();
            return [
                'status'  => true,
                'message' => 'Activity deleted!',
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
