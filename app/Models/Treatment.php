<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    protected $fillable = ['name', 'description', 'patient_id'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}