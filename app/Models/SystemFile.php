<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFile extends Model
{
    use HasFactory;
    protected $table = 'system_files';
    protected $fillable = [
        'system_id',
        'tye',
        'file'
    ];

}
