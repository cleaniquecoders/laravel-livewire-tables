<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_visit' => 'date',
        'is_vaccinated' => 'boolean',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}
