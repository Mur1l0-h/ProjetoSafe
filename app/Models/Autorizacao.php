<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autorizacao extends Model
{

    protected $table = 'autorizacoes';

    public function student() { return $this->belongsTo(Student::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function validator() { return $this->belongsTo(User::class, 'validated_by'); }
}
