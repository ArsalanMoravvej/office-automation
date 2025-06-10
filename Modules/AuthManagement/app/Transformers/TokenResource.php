<?php

namespace Modules\AuthManagement\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->when(isset($this['access_token']), $this['access_token']),
            'token_type'   => $this->when(isset($this['access_token']), 'bearer'),
            'expires_in'   => $this->when(isset($this['access_token']), $this['expires_in']),

            'whoami'       => $this->when(isset($this['whoami']), new UserResource($this['whoami'])),
        ];
    }
}
