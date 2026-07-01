<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\Database\Factories\OwnerFactory;

class Owner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['date_of_birth' => 'date'];

    public $timestamps = true;

    protected static function newFactory(): OwnerFactory
    {
        return OwnerFactory::new();
    }
}
