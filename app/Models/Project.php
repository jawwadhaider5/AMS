<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name',
        'client_name',
        'start_date',
        'end_date',
        'description',
    ];
    public function system(){
        return $this->belongsTo(System::class,'spread_id');
    }

    public function locationdata(){
        return $this->belongsTo(Locations::class,'location');
    }

    public function assets(){
        return $this->hasMany(Assets::class,'project_id');
    }
 
}
