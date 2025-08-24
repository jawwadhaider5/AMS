<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMCAReference extends Model
{
    use HasFactory;
    protected $table = 'imca_reference';

    protected $fillable = [
        'name',
        'frequency',
        'description'
    ];

}
