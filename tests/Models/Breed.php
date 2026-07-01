<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Breed extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'breeds';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'species_id',
    ];

    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }
}
