<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'imca_reference_id',
        'frequency',
        'description',
        'expire_date',
    ];
    public function imca(){
        return $this->belongsTo(IMCAReference::class,'imca_reference_id','id');
    }
    

    public function auditlog(){
        return $this->hasMany(AuditLog::class,'task_type','id');
    }


    public function predefinedtasks(){
        return $this->hasMany(PreTask::class,'task_type','id');
    }

}
