<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Entry extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'enterd_at'  => 'datetime',
        'exited_at' => 'datetime',
    ];

    public function disasterShelter()
    {
        return $this->belongsTo(DisasterShelter::class);
    }

    public function entrySheet()
    {
        return $this->belongsTo(EntrySheet::class);
    }

    public function histories()
    {
        return $this->hasMany(EntryHistory::class);
    }
}
