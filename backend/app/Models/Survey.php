<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

protected $fillable = ['email', 'token'];

public function answers()
{
    return $this->hasMany(Answer::class);
}
}
