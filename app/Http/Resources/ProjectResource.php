<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'attribute_values' => AttributeValueResource::collection($this->whenLoaded('attributeValues')),
            'time_sheets' => TimeSheetResource::collection($this->whenLoaded('timeSheets')),
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
