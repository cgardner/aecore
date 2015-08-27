<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfiComment extends Model
{

    protected $table = 'rfi_comments';

    protected $fillable = [
        'comment',
        'rfi_id',
        'created_by'
    ];

    /**
     * User Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('\App\Models\User');
    }
}
