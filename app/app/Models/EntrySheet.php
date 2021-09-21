<?php

namespace App\Models;

use App\Enums\EntrySheetType;
use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class EntrySheet extends Model
{
    use HasFactory;
    use Userstamps;
    use SoftDeletes;

    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'disaster_id',
        'type',
        'name',
        'name_kana',
    ];

    public function entry()
    {
        return $this->hasOne(Entry::class);
    }

    public function web()
    {
        return $this->hasOne(EntrySheetWeb::class);
    }

    public function paper()
    {
        return $this->hasOne(EntrySheetPaper::class);
    }

    public function breakdown()
    {
        $breakdown = [
            'number_of_male' => 0,
            'number_of_female' => 0,
        ];
        switch ($this->type) {
            case EntrySheetType::WEB:
                if ($this->web->gender == Gender::MALE) {
                    $breakdown['number_of_male']++;
                } else {
                    $breakdown['number_of_female']++;
                }
                foreach($this->web->companions as $companion) {
                    if ($companion->gender == Gender::MALE) {
                        $breakdown['number_of_male']++;
                    } else {
                        $breakdown['number_of_female']++;
                    }
                }
                return $breakdown;
            case EntrySheetType::PAPER:
                if ($this->paper->gender == Gender::MALE) {
                    $breakdown['number_of_male']++;
                } else {
                    $breakdown['number_of_female']++;
                }
                foreach($this->paper->companions as $companion) {
                    if ($companion->gender == Gender::MALE) {
                        $breakdown['number_of_male']++;
                    } else {
                        $breakdown['number_of_female']++;
                    }
                }
                return $breakdown;
        }
    }
}
