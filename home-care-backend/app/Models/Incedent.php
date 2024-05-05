<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incedent extends Model
{
    use HasFactory;

    /**
     * Get all of the incidentDetails for the Incedent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidentDetails(): HasMany
    {
        return $this->hasMany(IncidentDetail::class);
    }
}
