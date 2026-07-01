<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\Database\Factories\PetFactory;

class Pet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): PetFactory
    {
        return PetFactory::new();
    }

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
