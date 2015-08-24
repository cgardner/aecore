<?php
namespace App\Repositories;

use App\Models\Dcrequipment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcrEquipmentRepository extends AbstractRepository
{
    /**
     * @var Dcr
     */
    protected $model;

    function __construct(Dcrequipment $model)
    {
        $this->model = $model;
    }

    /**
     * Find equipemnt for active DCR
     * @param integer $dcrId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    
    public function findDcrEquipment($dcrId)
    {
        $query = $this->model
            ->newQuery()
            ->where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled')
            ->orderBy('equipment_qty', 'desc');
        return $query->getModels();
    }
    
}