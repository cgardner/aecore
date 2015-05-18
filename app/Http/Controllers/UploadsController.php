<?php namespace App\Http\Controllers;

  use App\Http\Requests;
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;

  use App\Models\S3file;
  use App\Models\Useravatar;
    
  use AWS;
  use Aws\S3\S3Client;
  use Auth;
  use DB;
  use File;
  use Image;
  use Input;
  use Redirect;
  use Response;
  
  
class UploadsController extends Controller {

  // Files
  public function uploadFile() {
    
    if(Input::hasFile('Filedata')) {
            
      // Get file size & temp location
      $file_location_temp = Input::file('Filedata')->getRealPath();
      $file_size = Input::file('Filedata')->getSize();

      // Remove spaces from file name
      $file_name_upload = str_replace(str_split(':*?&"<>|'), '', Input::file('Filedata')->getClientOriginalName());
      $file_name = str_replace(' ', '-', $file_name_upload);
      
      $ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
      $allowed = array("jpg","JPG","png","PNG","jpeg","JPEG","gif","GIF","pdf","PDF","doc","DOC","docx","DOCX","xls","XLS","xlsx","XLSX","ppt","PPT","pptx","PPTX","txt","TXT","dwg","DWG","dxf","DXF","zip","ZIP");
               
      if(in_array($ext, $allowed)) {
        $s3bucket = 'asm-aecore';
        $s3path = Auth::User()->id . '/' . time();
        
        // Instantiate the S3 client with your AWS credentials
        $s3 = AWS::get('s3');
  
        // Upload the images to s3
        $s3->putObject(array(
          'ACL'                 => 'public-read',
          'Bucket'              => $s3bucket,
          'ContentDisposition'  => 'attachment',
          'Key'                 => $s3path . '/' . $file_name,
          'SourceFile'          => $file_location_temp,
        ));

        // Save image info in the database
        $file_data = array (
          'file_bucket' => $s3bucket,
          'file_path' => $s3path,
          'file_name' => $file_name,
          'file_size' => $file_size
        );
        $id = Auth::user()->s3file()->create($file_data);
        return $id->id;
      }
    }
  }

  // Company logos
  public function uploadLogoCompany() {
        
    if(Input::hasFile('Filedata')) {
      
      require_once __DIR__ . '/../../../vendor/autoload.php';
      
      // Get file size & temp location
      $file_location_temp = Input::file('Filedata')->getRealPath();
      $file_size = Input::file('Filedata')->getSize();
      
      // Remove spaces from file name
      $file_name_upload = str_replace(str_split(':*?&"<>|'), '', Input::file('Filedata')->getClientOriginalName());
      $file_name = str_replace(' ', '-', $file_name_upload);
      
      $ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
      $allowed = array("jpg","JPG","png","PNG","jpeg","JPEG");
      
      if(in_array($ext, $allowed)) {
        $s3bucket = 'asm-aecore';
        $s3path = 'logos/'.Auth::User()->company_id;

        // Instantiate the S3 client with your AWS credentials
        $s3 = AWS::get('s3');
        
        // Upload the images to s3
        $s3->putObject(array(
          'ACL'                 => 'public-read',
          'Bucket'              => $s3bucket,
          'ContentDisposition'  => 'attachment',
          'Key'                 => $s3path . '/' . $file_name,
          'SourceFile'          => $file_location_temp,
        ));
        
        // Save image info in the database
        $id = S3file::create([
          'user_id' => Auth::user()->id,
          'file_bucket' => $s3bucket,
          'file_path' => $s3path,
          'file_name' => $file_name,
          'file_size' => $file_size
        ]);
        
        return $id->id;
      }
    }
  }
  
  // User or company avatars
  public function uploadAvatar($type) {
        
    if(Input::hasFile('Filedata')) {
            
      // Get file size & temp location
      $file_location_temp = Input::file('Filedata')->getRealPath();
      
      // Remove spaces from file name
      $file_name_upload = str_replace(str_split(':*?&"<>|'), '', Input::file('Filedata')->getClientOriginalName());
      $file_name = str_replace(' ', '-', $file_name_upload);
         
      $ext = strtolower(substr($file_name, strrpos($file_name, '.') + 1));
      $allowed_img = array("jpg", "JPG", "png", "PNG", "jpeg", "JPEG", "gif", "GIF");
         
      if(in_array($ext, $allowed_img)){
        
        if($type == 'profile') {
          $file_name_new = Auth::User()->id . '-profile-avatar-original.jpg';
        } elseif($type == 'company') {
          $file_name_new = Auth::User()->company['id'] . '-company-avatar-original.jpg';
        }
           
        // resize the image to a width of 300 and constrain aspect ratio (auto height)
        $img->resize(600, null, function ($constraint) {
          $constraint->aspectRatio();
        });
        $img->save('uploads/' . $file_name_new);
      } 
    }
  }
  
  public function cropAvatar($type) {
        
    // Crop size & coordinates
    $w = Input::get('w');
    $h = Input::get('h');
    $x = Input::get('x');
    $y = Input::get('y');
    
    // Make image
    $img_size = array('lg' => 250, 'sm' => 50);
    if($type == 'profile') {
      $img = Image::make('uploads/' . Auth::User()->id . '-profile-avatar-original.jpg');
    } elseif($type == 'company') {
      $img = Image::make('uploads/' . Auth::User()->company['id'] . '-company-avatar-original.jpg');
    }
    $img->crop($w, $h, $x, $y);
        
    foreach($img_size as $name => $size) {
      
      // Resize & save each temp image
      $file_name = Auth::User()->id . '-' . $name . '-' . time() . '.jpg';
      $img->resize($size, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $img->save('uploads/' . $file_name);
      $file_size = $img->filesize();
      
      $s3bucket = 'asm-aecore';
      if($type == 'profile') {
        $s3path = 'avatars/' . Auth::User()->id;
      } elseif($type == 'company') {
        $s3path = 'companyavatars/' . Auth::User()->company['id'];
      }
      
      // Instantiate the S3 client with your AWS credentials
      $s3 = AWS::get('s3');
      // Upload the images to s3
      $s3->putObject(array(
        'ACL'                 => 'public-read',
        'Bucket'              => $s3bucket,
        'ContentDisposition'  => 'attachment',
        'Key'                 => $s3path . '/' . $file_name,
        'SourceFile'          => 'uploads/' . $file_name,
      ));
      
      // Save image info in the database
      $image_data = array (
        'file_bucket' => $s3bucket,
        'file_path' => $s3path,
        'file_name' => $file_name,
        'file_size' => $file_size
      );
      
      $id = Auth::user()->s3file()->create($image_data);
      
      $file_id_insert = $id->id;
      
      $avatar_data = array (
        'file_id_' . $name => $file_id_insert
      );
      if($type == 'profile') {
        Useravatar::UpdateOrCreate(['user_id' => Auth::User()->id], [
          'user_id' => Auth::User()->id, //pkey
          'file_id_' . $name => $file_id_insert
        ]);
      } elseif($type == 'company') {
        
      }
      
      //Remove resized image
      File::delete('uploads/' . $file_name);
    }
    
    // Delete original file
    if($type == 'profile') {
      File::delete('uploads/' . Auth::User()->id . '-profile-avatar-original.jpg');
    } elseif($type == 'company') {
      File::delete('uploads/' . Auth::User()->company['id'] . '-company-avatar-original.jpg');
    } 
    
    // Return to profile page
    return Redirect::to('settings/'.$type)
              ->with('UpdateSuccess', '<strong>Success!</strong> Your avatar has been updated.');
  }
  
}