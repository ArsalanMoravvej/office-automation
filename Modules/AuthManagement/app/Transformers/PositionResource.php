<?php

namespace Modules\AuthManagement\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "user_id" => $this->user_id,
            "title" => $this->title,
            "description" => $this->description,
            "is_active" => $this->is_active,
            'user' => new UserResource(($this->whenLoaded('user'))),
        ];
    }
}
