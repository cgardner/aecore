<?php namespace App\Models;

use Auth;
use Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use Timezone;

class Project extends Model
{
    const STATUS_ARCHIVED = 'Archived';

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
        'country',
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
        $this->now = $this->createDateTime(Carbon::now());
    }

    public function getProgressAttribute()
    {
        $startTime = $this->createDateTime($this->start);
        $finishTime = $this->createDateTime($this->finish);

        $totalTime = $finishTime
            ->diff($startTime)
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
     * @return Project
     */
    public function setNow($now)
    {
        $this->now = $now;
        return $this;
    }

    /**
     * @return string
     */
    public function getDaysLeftAttribute()
    {
        $daysLeft = $this->getNow()
            ->diff($this->createDateTime($this->finish))
            ->format('%r%a');

        if ($daysLeft <= 0) {
            return $daysLeft;
        }
        return (int)$daysLeft + 1;
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

    /**
     * Relationship with the Slackintegrations model.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function slackintegration()
    {
        return $this->hasMany('App\Models\Slackintegration');
    }
    
    private function createDateTime($dateTime)
    {
        if (Auth::guest()) {
            return new DateTime($dateTime, new DateTimeZone('America/Los_Angeles'));
        }
        return new DateTime($dateTime, new DateTimeZone(Auth::user()->timezone));
    }

    /**
     * RFI Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rfis()
    {
        return $this->hasMany('\App\Models\Rfi');
    }
}
