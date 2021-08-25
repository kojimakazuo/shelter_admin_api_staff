<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EntrySheetWebEnquete extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'entry_sheet_web_id',
        'data',
    ];

    protected $casts = [
        'data' => 'json',
    ];
}
