<?php namespace App\Models;

use Auth;
use Carbon;
use DateTime;
use DateTimeZone;
use Timezone;
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
               
        $startTime = new DateTime($this->start,  new DateTimeZone(Auth::user()->timezone));
        $finishTime = new DateTime($this->finish,  new DateTimeZone(Auth::user()->timezone));
        
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
        return new DateTime(Carbon::now(),  new DateTimeZone(Auth::user()->timezone));
    }

    /**
     * @return string
     */
    public function getDaysLeftAttribute()
    {
        $daysLeft = $this->getNow()
            ->diff(new DateTime($this->finish,  new DateTimeZone(Auth::user()->timezone)))
            ->format('%r%a');
        
        if($daysLeft <= 0) {
            return $daysLeft;
        } elseif($daysLeft > 0) {
            return $daysLeft + 1;
        }
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
