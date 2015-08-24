<?php
namespace App\Repositories;

use App\Models\Dcrinspection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcrInspectionRepository extends AbstractRepository
{
    /**
     * @var Dcr
     */
    protected $model;

    function __construct(Dcrinspection $model)
    {
        $this->model = $model;
    }

    /**
     * Find inspections for active DCR
     * @param integer $dcrId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    
    public function findDcrInspections($dcrId)
    {
        $query = $this->model
            ->newQuery()
            ->where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled')
            ->orderBy('inspection_agency', 'asc');
        return $query->getModels();
    }
    
}