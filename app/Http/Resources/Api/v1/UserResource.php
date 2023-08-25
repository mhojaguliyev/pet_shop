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
        $dateFormat = config('app.date_format');
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'isAdmin' => (bool)$this->is_admin,
            'email' => $this->email,
            'emailVerifiedAt' => !empty($this->email_verified_at) ? $this->email_verified_at->format($dateFormat) : null,
            'avatar' => $this->avatar,
            'address' => $this->address,
            'phoneNumber' => $this->phone_number,
            'isMarketing' => (bool)$this->is_marketing,
            'createdAt' => !empty($this->created_at) ? $this->created_at->format($dateFormat) : null,
            'updatedAt' => !empty($this->updated_at) ? $this->updated_at->format($dateFormat) : null,
            'lastLoginAt' => !empty($this->last_login_at) ? $this->last_login_at->format($dateFormat) : null,
        ];
    }
}
