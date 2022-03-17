<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Wildside\Userstamps\Userstamps;

class Facility extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = [
        'id',
    ];

    public function imageUrl()
    {
        return Storage::disk('s3')->url($this->image_url);
    }
}
