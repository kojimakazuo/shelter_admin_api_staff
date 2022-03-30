<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ShelterFacility extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
        'shelter_id',
        'facility_id',
    ];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
