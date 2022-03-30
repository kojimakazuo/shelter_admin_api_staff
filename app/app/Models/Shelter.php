<?php

namespace App\Models;

use App\Casts\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Shelter extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'target_disaster_types' => Set::class,
    ];

    public function staffUser()
    {
        return $this->belongsTo(StaffUser::class);
    }

    public function shelterImages()
    {
        return $this->hasMany(ShelterImage::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'shelter_facilities', 'shelter_id', 'facility_id')->whereNull('shelter_facilities.deleted_at');
    }

    public function shelterFacilities()
    {
        return $this->hasMany(ShelterFacility::class);
    }
}
