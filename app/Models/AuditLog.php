<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
use App\Models\Assets;
class AuditLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_type',
        'task_id',
        'asset_id',
        'new_notes',
        'user_id',
    ];

    public function task(){
        return $this->belongsTo(Task::class,'task_id','id');
    }
    public function asset(){
        return $this->belongsTo(Assets::class,'asset_id','id');
    }

    public function tasktype(){
        return $this->belongsTo(TaskType::class,'task_type');
    }


}
