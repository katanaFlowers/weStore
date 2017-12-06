<?php

namespace App\Http\Controllers\Validate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tool\Validate\ValidateCode;
use App\Tool\SMS\SendTemplateSMS;
use App\Models\M3Result;
use App\Entify\TempPhoneClass;
use App\Entify\TempEmailClass;
use App\Entify\MemberClass;

class VerifyController extends Controller
{
  //创建验证码
    public function verify(Request $request)
    {
      $verify = new ValidateCode();
      $request->session()->put('verify',$verify->getCode());  //不区分大小写
      return $verify->doimg();
    }
  //验证及发送短信
    public function sendSMS(Request $request)
    {
     $m3_result = new M3Result();
     $phone = $request ->input('phone','');

      //发送短信
     $code = '';
     $charset = '1234567890';
     $_len = strlen($charset) - 1;
     for ($i = 0;$i < 6;++$i) {
     $code .= $charset[mt_rand(0, $_len)];
    }
      $tempPhone = TempPhoneClass::where('phone', $phone)->first();
        if($tempPhone == null) {
          $tempPhone = new TempPhoneClass();
        }
        $tempPhone->phone = $phone;
        $tempPhone->code = $code;
        $tempPhone->deadline = date('Y-m-d H-i-s', time() + 60*60);
        $tempPhone->save();
        $m3_result->status = 0;

      return $m3_result->toJson();
    }

    //邮箱激活
    public function validateEmail(Request $request)
    {
      $member_id = $request ->input('member_id','');
      $code  = $request ->input('code','');

      $tempEmail = TempEmailClass::where(['member_id'=>$member_id,'code'=>$code])->first();
      if($tempEmail != '')
      {
        if(time() > strtotime($tempEmail->deadline))
        {
          return "该链接已经失效";
        }
        $member = MemberClass::find($member_id);
        $member->active = 1;
        $member ->save();
        return "验证成功";
      }

    }

}
