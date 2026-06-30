<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $guarded = [];

    protected $casts = ['date_of_birth' => 'date'];

    public $timestamps = true;
}
