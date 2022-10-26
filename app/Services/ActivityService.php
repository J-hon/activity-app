<?php

namespace App\Services;

use App\Contracts\ActivityContract;
use App\Contracts\RevisionContract;
use App\Jobs\CreateActivityForUsersJob;
use Carbon\Carbon;
use Throwable;

class ActivityService
{

    public function __construct(
        protected ActivityContract $activityRepository,
        protected RevisionContract $revisionRepository
    ) {
    }

    public function getBy(int $userId, $startDate, $endDate): array
    {
        try {
            $startDate = Carbon::parse($startDate)->toDateString();
            $endDate   = Carbon::parse($endDate)->toDateString();

            $activities = $this->revisionRepository->getUserActivitiesByDateRange($userId, $startDate, $endDate);
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

    public function get(): array
    {
        try {
            $activities = $this->activityRepository->all();
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
        try {
            $activity = $this->activityRepository->create($params);

            CreateActivityForUsersJob::dispatch($activity, $params['user_id'] ?? null);

            return [
                'status'  => true,
                'message' => 'Activity created!',
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

    public function update(int $activityId, array $params, int $userId = null): array
    {
        try {
            if (!$userId) {
                $this->activityRepository->update($activityId, $params);

                $this->revisionRepository->updateBy([
                    'activity_id' => $activityId
                ], $params);
            }
            else {
                $this->revisionRepository->updateBy([
                    'user_id'     => $userId,
                    'activity_id' => $activityId
                ], $params);
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
            $this->activityRepository->delete($id);
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
