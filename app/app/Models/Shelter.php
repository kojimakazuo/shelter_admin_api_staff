<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Shelter extends Model
{
    use HasFactory;
    use Userstamps;

    protected $guarded = [
        'id',
    ];

    public function staffUser()
    {
        return $this->belongsTo(StaffUser::class);
    }
}
