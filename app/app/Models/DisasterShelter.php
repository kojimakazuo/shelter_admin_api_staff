<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class DisasterShelter extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'disaster_id',
        'shelter_id',
    ];

    protected $casts = [
        'start_at'  => 'datetime',
        'end_at' => 'datetime',
    ];

    public function shelter()
    {
        return $this->hasOne(Shelter::class, 'id', 'shelter_id');
    }

    public function staffUser()
    {
        return $this->belongsTo(StaffUser::class);
    }
}
