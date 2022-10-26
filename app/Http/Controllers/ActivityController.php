<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;

class ActivityController extends BaseController
{

    public function __construct(protected ActivityService $activityService)
    {
    }

    public function index(): JsonResponse
    {
        $response = $this->activityService->get();
        return $this->responseJson(
            $response['status'],
            $response['code'],
            $response['message'],
            ActivityResource::collection($response['data'])
        );
    }

    public function store(CreateActivityRequest $request): JsonResponse
    {
        $response = $this->activityService->create($request->validated());
        return $this->responseJson(
            $response['status'],
            $response['code'],
            $response['message']
        );
    }

    public function update(int $activityId, UpdateActivityRequest $request): JsonResponse
    {
        $response = $this->activityService->update($activityId, $request->validated());
        return $this->responseJson(
            $response['status'],
            $response['code'],
            $response['message']
        );
    }

    public function updateOne(int $userId, int $activityId, UpdateActivityRequest $request): JsonResponse
    {
        $response = $this->activityService->update($activityId, $request->validated(), $userId);
        return $this->responseJson(
            $response['status'],
            $response['code'],
            $response['message']
        );
    }

    public function destroy(int $activityId): JsonResponse
    {
        $response = $this->activityService->delete($activityId);
        return $this->responseJson(
            $response['status'],
            $response['code'],
            $response['message']
        );
    }

}
