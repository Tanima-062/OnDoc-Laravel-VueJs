<?php

namespace App\Http\Resources\MobileAppUser;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Language\LanguageResource;

class MobileAppUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user = request()->user();
        $address = collect([$this->house_number, $this->street, $this->city, getCountryNameFromCode($this->country)])->filter()->implode(', ');
        return [
            'id'                => $this->id,
            'prefix_id'         => $this->prefix_id,
            'photo_url'         => $this->photo_url,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'name'              => $this->name,
            'email'             => $this->email,
            'street'            => $this->street,
            'house_number'      => $this->house_number,
            'zip_code'          => $this->zip_code,
            'city'              => $this->city,
            'country'           => getCountryNameFromCode($this->country),
            'country_iso_code'  => $this->country_iso_code,
            'company'           => $this->company,
            'phone_number'      => $this->phone_number,
            'full_phone_number' => $this->full_phone_number,
            'language_id'       => $this->language_id,
            'address'           => $address,
            // 'status'            => $this->status,
            'created_at'        => $this->created_at,
            'language'          =>  $this->whenLoaded('language', fn () => new LanguageResource($this->language)),
        ];
    }
}
