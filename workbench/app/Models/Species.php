<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{
    protected $table = 'species';

    protected $guarded = [];

    public $timestamps = false;

    public function breeds(): HasMany
    {
        return $this->hasMany(Breed::class);
    }
}
