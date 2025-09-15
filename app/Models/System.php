<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    public function systemtype(){
        return $this->hasOne(SystemType::class,'id','system_type_id');
    }
    public function location(){
        return $this->belongsTo(Locations::class,'system_description');
    }
    public function spreadcategory(){
        return $this->hasMany(SpreadCategory::class,'system_id');
    }

    public function spreadcategorytype(){
        return $this->hasMany(SpreadCategory::class,'system_id');
    }
    public function tasks(){
        return $this->hasMany(Task::class,'system_id','id');
    }
    public function assets(){
        return $this->hasMany(Assets::class,'spread_id','id');
    }
    public function projects(){
        return $this->hasMany(Project::class,'spread_id');
    }

    /**
     * Calculate system status based on assets using priority-based logic
     * Priority: Incomplete > Expired > Expiring > Certified
     * 
     * @return string The system status
     */
    public function status() {
        $assets = $this->assets()->whereNotNull('spread_category_id')->get();
        
        if ($assets->isEmpty()) {
            return 'Incomplete';
        }
        
        $statusCounts = [
            'certified' => 0,
            'expired' => 0,
            'expiring' => 0,
            'incomplete' => 0
        ];
        
        foreach ($assets as $asset) {
            $assetStatus = $asset->status();
            switch ($assetStatus) {
                case 'Certified':
                    $statusCounts['certified']++;
                    break;
                case 'Expired':
                    $statusCounts['expired']++;
                    break;
                case 'Expiring':
                    $statusCounts['expiring']++;
                    break;
                case 'Incomplete':
                default:
                    $statusCounts['incomplete']++;
                    break;
            }
        }
        
        return $this->determineStatusFromCounts(
            $statusCounts['certified'],
            $statusCounts['expired'],
            $statusCounts['expiring'],
            $statusCounts['incomplete']
        );
    }

    /**
     * Determine system status based on counts using priority logic
     * 
     * @param int $certified
     * @param int $expired
     * @param int $expiring
     * @param int $incomplete
     * @return string
     */
    private function determineStatusFromCounts($certified, $expired, $expiring, $incomplete) {
        // Priority-based logic: Incomplete > Expired > Expiring > Certified
        if ($incomplete > 0) {
            return 'Incomplete';
        } elseif ($expired > 0) {
            return 'Expired';
        } elseif ($expiring > 0) {
            return 'Expiring';
        } elseif ($certified > 0) {
            return 'Certified';
        } else {
            return 'Incomplete';
        }
    }
}
