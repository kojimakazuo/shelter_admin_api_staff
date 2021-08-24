<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EntrySheetWeb extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'birthday'  => 'date',
    ];

    public function entrySheet()
    {
        return $this->belongsTo(EntrySheet::class);
    }

    public function companions()
    {
        return $this->hasMany(EntrySheetWebCompanion::class);
    }

    public function enquete()
    {
        return $this->hasOne(EntrySheetWebEnquete::class);
    }
}
