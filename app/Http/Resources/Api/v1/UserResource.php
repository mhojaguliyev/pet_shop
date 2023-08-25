<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'uuid' => $this->uuid,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'isAdmin' => (bool)$this->is_admin,
            'email' => $this->email,
            'emailVerifiedAt' => $this->email_verified_at,
            'avatar' => $this->avatar,
            'address' => $this->address,
            'phoneNumber' => $this->phone_number,
            'isMarketing' => (bool)$this->is_marketing,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'lastLoginAt' => $this->last_login_at,
        ];
    }
}
