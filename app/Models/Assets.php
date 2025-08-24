<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    use HasFactory;
    protected $table = 'system_assets';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'description',
        'manufacturer',
        'system_modal',
        'serial_no',
        'location',
        'sefety_critical',
        'own',
        'system_project',
        'system_class',
        'class_code',
    ];
    // public function category(){
    //     return $this->hasOne(Category::class,'id','category_id');
    // }
    // public function subcategory(){
    //     return $this->hasOne(SubCategory::class,'id','sub_category_id');
    // }

    public function status(){ 
        $tasks = Task::where('asset_id', $this->id)->get(); 
        $certified_count = $expired_count = $expiring_count = $incomplete_count = 0;
        foreach ($tasks as $task) {
            if ($task && $task->active==1) { 
                if ($task->status() == 'Certified') {
                    $certified_count++;
                } else if ($task->status() == 'Expired') {
                    $expired_count++;
                } else if ($task->status() == 'Expiring') {
                    $expiring_count++;
                } else {
                    $incomplete_count++;
                } 
            } else {
                $incomplete_count++;
            }
        }
        $temptask =new Task();
        $statusLabel = $temptask->statusLabel($certified_count, $expired_count, $expiring_count, $incomplete_count);
        return $statusLabel;
    }
    public function taskCount(){ 
        $taskcount = Task::where('asset_id', $this->id)->where('active', 1)->count();
        return $taskcount;
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }
    public function project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'asset_id', 'id');
    }

    public function system(){
        return $this->belongsTo(System::class,'spread_id');
    }

    public function systemtype(){
        return $this->belongsTo(SystemType::class,'system_id');
    }
    public function assetlocation(){
        return $this->belongsTo(Locations::class,'location');
    }

    public function spreadcategory(){
        return $this->belongsTo(SpreadCategory::class,'spread_category_id');
    }


    public function allfiles(){
        return $this->hasMany(AllAssetFile::class,'asset_id');
    }
}