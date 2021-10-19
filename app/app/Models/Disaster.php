<?php

namespace App\Models;

use App\Enums\Condition;
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

    public function isCurrent()
    {
        return $this->start_at <= now() && $this->end_at == null;
    }

    public function isBeforeStart()
    {
        return $this->start_at > now() && $this->end_at == null;
    }

    public function isEnded()
    {
        return $this->end_at != null;
    }

    public function disasterShelters()
    {
        return $this->hasMany(DisasterShelter::class);
    }

    public function availableDisasterShelters()
    {
        return $this->hasMany(DisasterShelter::class)->where('condition', Condition::AVAILABLE);
    }

    public function numberOfAvailableDisasterShelters()
    {
        return $this->availableDisasterShelters()->count();
    }

    public function shelters()
    {
        return $this->belongsToMany(Shelter::class, 'disaster_shelters', 'disaster_id', 'shelter_id')->whereNull('disaster_shelters.deleted_at');
    }

    public function entrySheets()
    {
        return $this->hasMany(EntrySheet::class);
    }

    public function entries()
    {
        return $this->hasManyThrough(Entry::class, DisasterShelter::class);
    }

    public function availableEntries()
    {
        return $this->hasManyThrough(Entry::class, DisasterShelter::class)->where('disaster_shelters.condition', Condition::AVAILABLE);
    }

    public function numberOfAvailableEntries()
    {
        return $this->availableEntries()->count();
    }

    public function numberOfAvailableDisasterSheltersCapacities()
    {
        return intval($this->availableDisasterShelters()->sum('capacity'));
    }

    public function numberOfEvacuees()
    {
        return intval($this->entrySheets()->whereHas('entry.disasterShelter', function ($query) {
            return $query->where('condition', Condition::AVAILABLE);
        })->sum("number_of_evacuees"));
    }
}
