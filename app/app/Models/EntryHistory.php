<?php

namespace App\Models;

use App\Enums\EntryHistoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EntryHistory extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'occurred_at'  => 'datetime',
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
