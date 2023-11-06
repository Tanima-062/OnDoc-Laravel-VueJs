<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = null;

    /**
     * @var array
     */
    protected $withoutFields = [];

    public function toArray($request)
    {
        $documents = null;
        $this->when($this->whenLoaded('documents'), function () use (&$documents) {
            $documents["Technical documents"] = $this->documents->where('section', 'technical')->values()->toArray();
            $documents["Supplier documents"] = $this->documents->where('section', 'supplier')->values()->toArray();
            $documents["Drawings"] = $this->documents->where('section', 'drawing')->values()->toArray();
            $documents["Instructions"] = $this->documents->where('section', 'instruction')->values()->toArray();
            $documents["Modifications Guides"] = $this->documents->where('section', 'modification_guide')->values()->toArray();
        });

        return $this->filterFields([
            "id"                  => $this->id,
            "prefix_id"           => $this->prefix_id,
            'name'                => $this->name,
            'serial_number'              => $this->serial_number,
            'company_id'          => $this->company_id,
            'category_id'         => $this->company_id,
            'supplier_id'         => $this->company_id,
            'user_id'             => $this->company_id,
            'status'              => $this->status,
            'company'             => $this->whenLoaded('company'),
            'category'            => $this->whenLoaded('category'),
            'supplier'            => $this->whenLoaded('supplier'),
            'user'                => $this->whenLoaded('user'),
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
            "documents"           => $this->when($documents, $documents),
            'public_access'       => $this->public_access,
            'warranty_start_date' => $this->warranty_start_date,
            'warranty_end_date'   => $this->warranty_end_date,
        ]);
    }

    /**
     * Set the keys that are supposed to be filtered out.
     *
     * @param array $fields
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;

        return $this;
    }


    /**
     * Remove the filtered keys.
     *
     * @param $array
     * @return array
     */
    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
}
