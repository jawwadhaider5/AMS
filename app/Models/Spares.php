<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spares extends Model
{
    use HasFactory;
    public function system(){
        return $this->hasOne(System::class,'id','system_name');
    }

    public function task() {
        return $this->belongsTo(Task::class,'task_id');
    }
}