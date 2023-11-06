<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = null;

    public function toArray($request)
    {
        $documents = null;
        $this->when($this->documents, function () use (&$documents) {

            $documents["Technical documents"] = $this->documents->where('section', 'technical')->values()->map(fn ($document) => ['file_url' => $document->file_url, 'thumbnail_url' => $document->image_url, 'name' => $document->name, 'id' => $document->id, 'created_at' => $document->created_at])->toArray();

            $documents["Supplier documents"] = $this->documents->where('section', 'supplier')->values()->map(fn ($document) => ['file_url' => $document->file_url, 'thumbnail_url' => $document->image_url, 'name' => $document->name, 'id' => $document->id, 'created_at' => $document->created_at])->toArray();

            $documents["Drawings"] = $this->documents->where('section', 'drawing')->values()->map(fn ($document) => ['file_url' => $document->file_url, 'thumbnail_url' => $document->image_url, 'name' => $document->name, 'id' => $document->id, 'created_at' => $document->created_at])->toArray();

            $documents["Instructions"] = $this->documents->where('section', 'instruction')->values()->map(fn ($document) => ['file_url' => $document->file_url, 'thumbnail_url' => $document->image_url, 'name' => $document->name, 'id' => $document->id, 'created_at' => $document->created_at])->toArray();

            $documents["Modifications Guides"] = $this->documents->where('section', 'modification_guide')->values()->map(fn ($document) => ['file_url' => $document->file_url, 'thumbnail_url' => $document->image_url, 'name' => $document->name, 'id' => $document->id, 'created_at' => $document->created_at])->toArray();
        });

        return [
            "id"                     => $this->id,
            "product_prefix_id"      => $this->prefix_id,
            'product_name'           => $this->name,
            'serial_number'          => $this->serial_number,
            'type'                   => $this->bookmarkable_type == "App\Models\Product" ? 'product' : 'document',
            "document"               => $this->when($this->document, $this->document),
            "documents"              => $this->when($documents, $documents),
            'scaned_at'              => $this->created_at,
        ];
    }
}
