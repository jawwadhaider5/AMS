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
        $tasks = Task::where('asset_id', $this->id)->where('active', 1)->get(); 
        
        if ($tasks->isEmpty()) {
            return 'Incomplete'; // No tasks = Incomplete
        }
        
        $hasIncomplete = false;
        $hasExpired = false;
        $hasExpiring = false;
        $hasCertified = false;
        
        foreach ($tasks as $task) {
            $taskStatus = $task->status();
            if ($taskStatus == 'Incomplete') {
                $hasIncomplete = true;
            } elseif ($taskStatus == 'Expired') {
                $hasExpired = true;
            } elseif ($taskStatus == 'Expiring') {
                $hasExpiring = true;
            } elseif ($taskStatus == 'Certified') {
                $hasCertified = true;
            }
        }
        
        // Priority-based status determination
        if ($hasIncomplete) {
            return 'Incomplete';
        } elseif ($hasExpired) {
            return 'Expired';
        } elseif ($hasExpiring) {
            return 'Expiring';
        } elseif ($hasCertified) {
            return 'Certified';
        } else {
            return 'Incomplete';
        }
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