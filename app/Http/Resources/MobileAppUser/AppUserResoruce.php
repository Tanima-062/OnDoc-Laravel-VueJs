<?php

namespace App\Http\Resources\MobileAppUser;

use Illuminate\Http\Resources\Json\JsonResource;

class AppUserResoruce extends JsonResource
{

    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user_fields = [];
        if ($this->user) {
            $user_fields = collect($this->user->toArray())->only(['first_name', 'last_name', 'email']);
        }
        return [
            'id'            => $this->id,
            'prefix_id'     => $this->prefix_id,
            'status'        => $this->status,
            'email'         => $this->email,
            'company'       => $this->whenLoaded('company', $this->company),
            ...$user_fields,
        ];
    }
}
