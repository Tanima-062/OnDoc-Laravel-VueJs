<?php

namespace App\Models;

use App\Contracts\CompanyWisePrefixIDContract;
use App\Traits\CompanyWisePrefixID;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix_id', 'product_id', 'name', 'type', 'section', 'filepath', 'disk', 'image_path'
    ];

    protected $appends = ['file_url'];

    const TECHNICAL = 'technical';
    const SUPPLIER = 'supplier';
    const DRAWING = 'drawing';
    const INSTRUCTION = 'instruction';
    const MODIFICATION_GUIDE = 'modification_guide';

    const URL_TYPE = 'url';
    const FILE_TYPE = 'file';

    const DEMO_DISK = 'demo';
    const EXOSCALE_DISK = 'exoscale';
    const PUBLIC_DISK = 'public';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookmarks(): MorphToMany
    {
        return $this->morphToMany(MobileAppUser::class, 'bookmarkable', 'bookmarks')->withTimestamps();
    }



    /**
     * Get file url by type & disk
     *
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        if(is_null($this->filepath)) return null;

        if ($this->type == self::URL_TYPE) {
            return $this->filepath;
        } else if ($this->disk == self::DEMO_DISK) {
            return Storage::disk(self::DEMO_DISK)->url($this->filepath);
        } else if ($this->disk == self::PUBLIC_DISK) {
            return Storage::disk(self::PUBLIC_DISK)->url($this->filepath);
        } else if ($this->disk == self::EXOSCALE_DISK) {
            return Storage::disk('exoscale')->publicUrl($this->filepath);
        }

        return $this->filepath ? Storage::disk('public')->url($this->filepath) : null;
    }

    /**
     * Get file url by type & disk
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        // if($this->type == self::URL_TYPE){
        //     return $this->filepath;
        // }
        if(is_null($this->image_path)) return null;

        if ($this->disk == self::DEMO_DISK) {
            return Storage::disk(self::DEMO_DISK)->url($this->image_path);
        } else if ($this->disk == self::PUBLIC_DISK) {
            return Storage::disk(self::PUBLIC_DISK)->url($this->image_path);
        } else if ($this->disk == self::EXOSCALE_DISK) {
            return Storage::disk('exoscale')->publicUrl($this->image_path);
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
