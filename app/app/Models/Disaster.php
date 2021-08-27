<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Disaster extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'start_at'  => 'datetime',
        'end_at' => 'datetime',
    ];

    public function disasterShelters()
    {
        return $this->hasMany(DisasterShelter::class);
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'disaster_shelters', 'disaster_id', 'shelter_id')->whereNull('disaster_shelters.deleted_at');
    }

    public function entries()
    {
        return $this->hasManyThrough(Entry::class, DisasterShelter::class);
    }
}
