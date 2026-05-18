<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudante extends Model
{
    public function schoolClass() { return $this->belongsTo(SchoolClass::class); }
    public function authorizations() { return $this->hasMany(Authorization::class); }
}
