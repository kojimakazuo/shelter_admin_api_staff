<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Wildside\Userstamps\Userstamps;

class EntrySheetPaper extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    public function companions()
    {
        return $this->hasMany(EntrySheetPaperCompanion::class);
    }

    public function pre_signed_front_sheet_image_url()
    {
        return $this->pre_signed_image_url($this->front_sheet_image_url);
    }

    public function pre_signed_back_sheet_image_url()
    {
        return $this->pre_signed_image_url($this->back_sheet_image_url);
    }

    private function pre_signed_image_url($url)
    {
        if (!$this->front_sheet_image_url) {
            return null;
        }
        $path = ltrim(parse_url($url, PHP_URL_PATH), '/');
        $expire = Carbon::now()->addSecond(60);
        return Storage::disk('s3')->temporaryUrl($path, $expire);
    }
}
