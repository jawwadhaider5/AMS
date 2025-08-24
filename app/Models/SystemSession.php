<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSession extends Model
{
    use HasFactory;
    protected $table = 'systemsession';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'system_id'
    ];
}
