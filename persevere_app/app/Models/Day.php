<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe Day qui met en évidence ses relations
 */
class Day extends Model
{
    use HasFactory;

    /**
     * Renvoi les installations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function day_facility()
    {
        return $this->belongsToMany(Facility::class)
                    ->using(DayFacility::class)
                    ->withPivot("id","created_at","updated_at");
    }
}
