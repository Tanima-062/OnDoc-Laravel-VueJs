<?php

namespace App\Http\Requests\Product;

use App\Models\Bookmark;
use App\Models\Document;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BookmarkStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('bookmark', [Bookmark::class, $this->id, $this->type]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'type' => 'required|in:product,document'
        ];
    }
}
