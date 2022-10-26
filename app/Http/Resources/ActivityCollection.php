<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivityCollection extends ResourceCollection
{

    private array $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total'        => $resource->total(),
            'count'        => $resource->count(),
            'per_page'     => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages'  => $resource->lastPage(),
            'from'         => $resource->firstItem(),
            'to'           => $resource->lastItem(),
            'next_page'    => $resource->nextPageUrl(),
            'prev_page'    => $resource->previousPageUrl()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'activities' => ActivityResource::collection($this->collection),
            'pagination' => $this->pagination
        ];
    }
}
