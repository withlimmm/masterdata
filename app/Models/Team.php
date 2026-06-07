<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use \App\Traits\BelongsToCompany;
    protected $fillable = ['name', 'position', 'description', 'photo'];
}
