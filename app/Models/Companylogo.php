<?php namespace App\Models;

  use Illuminate\Auth\Authenticatable;
  use Illuminate\Database\Eloquent\Model;

  use App;
  use AWS;
  use DB;
  use URL;
  
  class Companylogo extends Model {
    
    protected $table = 'companylogos';
    protected $fillable = ['company_id', 'file_id_logo', 'file_id_sq_lg', 'file_id_sq_sm'];
    
    // relation
    public function company() {
      return $this->belongsTo('App\Models\Company');
    }
    
    public function getCompanyAvatar($company_id) {
      // Grab company avatar
      $image = Companylogo::where('companylogos.company_id', '=', $company_id)
              ->leftjoin('s3files', 'companylogos.file_id_sq_sm', '=', 's3files.id')
              ->first();
      if($image->file_id_sq_sm != null) {
        $s3 = AWS::get('s3');
        return $s3->getObjectUrl($image->file_bucket, $image->file_path . '/' . $image->file_name);
      } else {
        return URL::asset('css/img/icons/company-avatar-60.png'); 
      }
    }
    
    public function getCompanyLogo($company_id) {
      // Grab company logo
      $logo = Companylogo::where('companylogos.company_id', '=', $company_id)
              ->leftjoin('s3files', 'companylogos.file_id_logo', '=', 's3files.id')
              ->first();
      if(count($logo) > 0) {
        $s3 = AWS::get('s3');
        return $s3->getObjectUrl($logo->file_bucket, $logo->file_path . '/' . $logo->file_name);
      } else {
        return URL::asset('css/img/logos/aecore-default.png');
      }
    }
    
  }