<?php
namespace App\Http\Controllers\Admin\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CategoryClass;
use App\Entify\ProductClass;
use App\Models\M3Result;
use App\Tool\UUID;

class UploadController extends Controller
{
    public function uploadImages(Request $request,$type)
    {
      if($_FILES['file']['error'] > 0)
      {
        $m3 = new M3Result();
        $m3->status = 1;
        $m3->message = "上传错误";
        return $m3->toJson();
      }
      $file_size = $_FILES['file']['size'];
      if($file_size > 1024*1024)
      {
        $m3 = new M3Result();
        $m3->status = 1;
        $m3->message = "文件大小不能超过1M";
        return $m3->toJson();
      }
      $arr_ext = explode('.',$_FILES['file']['name']);
      $file_ext = count($arr_ext) > 1 && strlen(end($arr_ext)) ? end($arr_ext) : 'unknow';

      if($file_ext == 'unknow')
      {
        $m3 = new M3Result();
        $m3->status = 1;
        $m3->message = "请上传正确格式的图片文件";
        return $m3->toJson();
      }
      //elseif ($file_ext != 'jpg' || $file_ext != 'png' || $file_ext != 'gif') {
      //  $m3 = new M3Result();
      //  $m3->status = 1;
      //  $m3->message = "请上传格式为jpg、png、gif的图片文件";
      //  return $m3->toJson();
      //}
      $public_dir = sprintf('/upload/%s/%s/',$type,date('Ymd'));
      $upload_dir = public_path().$public_dir;
      if( !file_exists($upload_dir))
      {
        mkdir($upload_dir,0777,true);
      }

      $file_name = UUID::create();
      $upload_file_path = $upload_dir.$file_name.'.'.$file_ext;

      if(move_uploaded_file($_FILES['file']['tmp_name'],$upload_file_path))
      {
        $public_uri = $public_dir.$file_name.'.'.$file_ext;
        $m3 = new M3Result();
        $m3->status = 0;
        $m3->uri = $public_uri;
        //$m3->ext = $file_ext;
        return $m3->toJson();
      } else {
        $m3 = new M3Result();
        $m3->status = 1;
        $m3->message = "上传失败";
        return $m3->toJson();
      }
    }

}
