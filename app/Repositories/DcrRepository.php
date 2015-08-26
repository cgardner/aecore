<?php
namespace App\Repositories;

use App\Models\Dcr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcrRepository extends AbstractRepository
{
    /**
     * @var Dcr
     */
    protected $model;

    function __construct(Dcr $model)
    {
        $this->model = $model;
    }

    /**
     * Find DCRs for active project & company
     * @param integer $projectId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    public function findDcrsForUser($projectId)
    {
        $query = $this->model
            ->newQuery()
            ->where('project_id', '=', $projectId)
            ->where('company_id', '=', \Auth::User()->company->id)
            ->where('status', '!=', 'disabled')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');
        return $query->getModels();
    } 
    
}