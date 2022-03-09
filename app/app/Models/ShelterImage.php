<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Wildside\Userstamps\Userstamps;

class ShelterImage extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = [
        'id',
    ];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function presignedImageUrl()
    {
        return Storage::disk('s3')->temporaryUrl($this->image_url, now()->addMinutes(1));
    }
}
