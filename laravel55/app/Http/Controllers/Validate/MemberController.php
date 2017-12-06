<?php

namespace App\Http\Controllers\Validate;

use Illuminate\Http\Request;
use App\Entify\MemberClass;
use App\Entify\TempPhoneClass;
use App\Entify\TempEmailClass;
use App\Models\M3Result;
use App\Models\M3Email;
use Mail;
use App\Http\Controllers\Controller;
use App\Tool\UUID;

class MemberController extends Controller
{
    //检查手机号和邮箱是否已经被注册
    public function phoneCheck(Request $request)
    {
      $phone = $request->input('phone','');
      $m3_result = new M3Result();
      $member = MemberClass::where('phone',$phone)->first();
      if($member != null)
      {
        $m3_result->status = 0;

      } else {
        $m3_result->status = 1;
      }
        return $m3_result->toJson();
    }
    public function emailCheck(Request $request)
    {
      $email = $request->input('email','');
      $m3_result = new M3Result();
      $member = MemberClass::where('email',$email)->first();
      if($member != null)
      {
        $m3_result->status = 0;

      } else {
        $m3_result->status = 1;
      }
        return $m3_result->toJson();
    }
    //检验注册数据信息
    public function registerCheck(Request $request)
    {
      $m3_result = new M3Result();
      $phone = $request->input('phone','');
      $password = $request->input('password','');
      $comfire = $request->input('comfire','');
      $sms = $request->input('sms','');
      $verify = $request->input('verify','');
      $email = $request->input('email','');

      if($phone != '')
      {
        $tempPhone = TempPhoneClass::where('phone',$phone)->first();
        if($tempPhone->code == $sms) //注意
        {
          if(time() > strtotime($tempPhone->deadline))
          {
            $m3_result->status = 1;
            $m3_result->message = "验证码已失效";
            return $m3_result->toJson();
          }
          $member = MemberClass::where('phone',$phone)->first();
          if($member != '')
          {
            $m3_result->status = 1;
            $m3_result->message = "手机号已被注册";
            return $m3_result->toJson();
          }
          $member = new MemberClass();
          $member->phone = $phone;
          $member->password =MD5('book' + $password);
          $member->save();
          $m3_result->status = 0;
          $m3_result->message = "注册成功";
          return $m3_result->toJson();
        } else {
          $m3_result->status = 1;
          $m3_result->message = "验证码错误";
          return $m3_result->toJson();
        }
      } else {
        if($request->session()->get('verify') == $verify)
        {
          $member = MemberClass::where('email',$email)->first();
          if($member != '')
          {
            $m3_result->status = 1;
            $m3_result->message = "邮箱已被注册";
            return $m3_result->toJson();
          }
          $member = new MemberClass();
          $member->email = $email;
          $member->password = Md5('book' + $password);
          $member->save();

          $uuid = UUID::create();

          $m3email = new M3Email();
          $m3email->to = $email;//注意
          $m3email->cc = "964843964@qq.com";
          $m3email->subject = "岛上书店验证信息";
          $m3email->content = "请于24小时点击该链接完成验证. http://www.lav.com/validate/validate_email?member_id={$member->id}&code={$uuid}";
          Mail::raw($m3email->content,function($m)use($m3email){
            $m->to($m3email->to);
            $m->subject($m3email->subject);
            $m->cc($m3email->cc);
          });

          $tempEmail = new TempEmailClass();
          $tempEmail->member_id = $member->id;
          $tempEmail->code = $uuid;
          $tempEmail->deadline = date('Y-m-d H:i:s',time()+24*60*60);
          $tempEmail->save();

          $m3_result = new M3Result();
          $m3_result->status = 0;
          return $m3_result->toJson();
        }
      }
    }
    public function loginCheck(Request $request)
    {
      $password = $request->input('password','');
      $username = $request->input('username','');
      $verify = $request->input('verify','');
      $m3_result = new M3Result();
      if($request->session()->get('verify') == $verify)
      {
        $pwd = md5('book' + $password);
        if(strstr($username,'@'))
        {
          $member = MemberClass::where(['email'=>$username,'password'=>$pwd])->first();
        } else {
          $member = MemberClass::where(['phone'=>$username,'password'=>$pwd])->first();
        }
        if($member != '')
        {
          $request->session()->put('member',$member);
          $m3_result->status = 0;
          return $m3_result->toJson();
        } else {
          $m3_result->status = 1;
          $m3_result->message = "账号或者密码错误";
          return $m3_result->toJson();
        }

      } else {
        $m3_result->status = 1;
        $m3_result->message = "验证码错误";
        return $m3_result->toJson();
      }
    }
}
