<?php
namespace App\Repositories;

use App\Models\S3file;
use App\Models\Dcrattachment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DcrAttachmentRepository extends AbstractRepository
{
    /**
     * @var Dcr
     */
    protected $model;

    function __construct(Dcrattachment $model)
    {
        $this->model = $model;
    }

    /**
     * Find attachments for active DCR
     * @param integer $dcrId
     * @return \Illuminate\Database\Eloquent\Model[]
     * @codeCoverageIgnore
     */
    public function findDcrAttachments($dcrId)
    {
        $query = $this->model
            ->newQuery()
            ->where('dcr_id', '=', $dcrId)
            ->where('status', '!=', 'disabled');
        return $query->getModels();
    }
    
}