<?php

namespace App\Models;

use App\Enums\Condition;
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

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function numberOfEntries()
    {
        return intval($this->entries()->count());
    }

    public function numberOfEvacuees()
    {
        return intval($this->entries()->join('entry_sheets', 'entries.entry_sheet_id', '=', 'entry_sheets.id')->sum("entry_sheets.number_of_evacuees"));
    }
}
