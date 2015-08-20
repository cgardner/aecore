<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RfiFile
 * @package App\Models
 */
class RfiFile extends Model
{
    protected $table = 'rfi_files';
    protected $fillable = ['rfi_id', 'file_id'];
}