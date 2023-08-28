<?php

namespace App\Http\Resources\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
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
            'isAdmin' => (bool) $this->is_admin,
            'email' => $this->email,
            'emailVerifiedAt' => optional($this->email_verified_at)->format($dateFormat),
            'avatar' => $this->avatar,
            'address' => $this->address,
            'phoneNumber' => $this->phone_number,
            'isMarketing' => (bool) $this->is_marketing,
            'createdAt' => optional($this->created_at)->format($dateFormat),
            'updatedAt' => optional($this->updated_at)->format($dateFormat),
            'lastLoginAt' => optional($this->last_login_at)->format($dateFormat),
        ];
    }
}
