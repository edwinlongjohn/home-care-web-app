<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the homeCare that owns the IncidentDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homeCare(): BelongsTo
    {
        return $this->belongsTo(Incedent::class);
    }
}
