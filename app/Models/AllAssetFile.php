<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllAssetFile extends Model
{
    use HasFactory;
    protected $table = "files";
    protected $fillable = [
        'task_id',
        'file',
    ];

    public function asset(){
        return $this->belongsTo(Assets::class);
    }
}