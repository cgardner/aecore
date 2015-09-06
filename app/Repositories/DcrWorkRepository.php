<?php
namespace App\Repositories;

use App\Models\Dcrwork;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcrWorkRepository extends AbstractRepository
{
    /**
     * @var Dcr
     */
    protected $model;

    function __construct(Dcrwork $model)
    {
        $this->model = $model;
    }

    /**
     * Find work for active DCR
     * @param integer $dcrId
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    
    public function findDcrWorks($dcrId)
    {
        $query = $this->model
            ->newQuery()
            ->where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled')
            ->orderBy('crew_company', 'asc');
        return $query->getModels();
    }
    
    public function sumDcrWork($dcrId)
    {
        return Dcrwork::where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled')
            ->get()->sum('crew_size');
    }
    
    public function sumDcrWorkHours($dcrId)
    {
        return Dcrwork::where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled')
            ->get()->sum('crew_hours');
    }
    
}