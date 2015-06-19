<?php namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const STATUS_ARCHIVED = 'archived';

    protected $table = 'projects';

    protected $fillable = [
        'company_id',
        'user_id',
        'projectcode',
        'number',
        'name',
        'type',
        'start',
        'finish',
        'value',
        'size',
        'size_unit',
        'description',
        'street',
        'city',
        'state',
        'zip_code',
        'status',
        'submittal_code'
    ];

    /**
     * @var DateTime
     */
    private $now;

    function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->now = new DateTime();
    }

    public function getProgressAttribute()
    {
        $startTime = new DateTime($this->start);
        $finishTime = new DateTime($this->finish);

        $totalTime = $finishTime->diff($startTime)
            ->days;

        $currentProgress = $this->getNow()
            ->diff($startTime)
            ->days;

        $progress = ($currentProgress / $totalTime) * 100;

        if ($progress > 100) {
            return 100;
        }
        return sprintf('%1.2f', $progress);
    }

    /**
     * @return DateTime
     */
    public function getNow()
    {
        return $this->now;
    }

    /**
     * @param DateTime $now
     * @return $this
     */
    public function setNow(DateTime $now)
    {
        $this->now = $now;
        return $this;
    }

    /**
     * @return string
     */
    public function getDaysLeftAttribute()
    {
        return $this->getNow()
            ->diff(new DateTime($this->finish))
            ->days;
    }

    /**
     * Relationship with the User model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->hasManyThrough('App\Models\User', 'App\Models\Projectuser', 'user_id', 'id');
    }

    /**
     * Relationship with the Projectuser model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectuser()
    {
        return $this->hasMany('App\Models\Projectuser');
    }
}
