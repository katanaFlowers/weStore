@extends('master')

@section('title', '注册')

@section('content')
<div class="weui_cells_title">注册方式</div>
<div class="weui_cells weui_cells_radio">
  <label class="weui_cell weui_check_label" for="x11">
      <div class="weui_cell_bd weui_cell_primary">
          <p>手机号注册</p>
      </div>
      <div class="weui_cell_ft">
          <input type="radio" class="weui_check" name="register_type" id="x11" checked="checked">
          <span class="weui_icon_checked"></span>
      </div>
  </label>
  <label class="weui_cell weui_check_label" for="x12">
      <div class="weui_cell_bd weui_cell_primary">
          <p>邮箱注册</p>
      </div>
      <div class="weui_cell_ft">
          <input type="radio" class="weui_check" name="register_type" id="x12">
          <span class="weui_icon_checked"></span>
      </div>
  </label>
</div>
<div class="weui_cells weui_cells_form">
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input id="phone_regi" class="weui_input" type="number" placeholder="" name="phone"/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone'/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone_cfm'/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="number" placeholder="" name='phone_code'/>
      </div>
      <p class="bk_important bk_phone_code_send">获取验证码</p>
      <div class="weui_cell_ft">
      </div>
  </div>
</div>
<div class="weui_cells weui_cells_form" style="display: none;">
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input id="email_regi" class="weui_input" type="text" placeholder="" name='email'/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email'>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email_cfm'/>
      </div>
  </div>
  <div class="weui_cell weui_vcode">
      <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="text" placeholder="请输入验证码" name='validate_code'/>
      </div>
      <div class="weui_cell_ft">
          <img src="/validate/validate_code/create" class="bk_validate_code"/>
      </div>
  </div>
</div>
<div class="weui_cells_tips"></div>
<div class="weui_btn_area">
  <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onRegisterClick();">注册</a>
</div>
<a href="/login" class="bk_bottom_tips bk_important">已有帐号? 去登录</a>
@endsection

@section('my-js')
<script type="text/javascript">
  $('#x12').next().hide();
  $('input:radio[name=register_type]').click(function(){
    $('input:radio[name=register_type]').attr('checked', false);
    $(this).attr('checked',true);
    if($(this).attr('id') == 'x11')
    {
      $('#x11').next().show();
      $('#x12').next().hide();
      $('.weui_cells_form').eq(0).show();
      $('.weui_cells_form').eq(1).hide();
    } else {
      $('#x12').next().show();
      $('#x11').next().hide();
      $('.weui_cells_form').eq(1).show();
      $('.weui_cells_form').eq(0).hide();
    }
  });

  $('.bk_validate_code').click(function () {
    $(this).attr('src', '/validate/validate_code/create?random=' + Math.random());
  });

</script>
<script type="text/javascript">
//短信验证码发送验证
   var enable = true;
   $('.bk_phone_code_send').click(function(){
     if(enable == false)
     {
       return false;
     }
     var phone = $('input[name=phone]').val();
     if(phone =='' )
     {
       $('.bk_toptips').show();
       $('.bk_toptips span').html('请输入手机号');
       setTimeout(function(){$('.bk_toptips').hide();},2000);
       return;
     }
     if(phone.length != 11 || phone[0] != 1)
     {
       $('.bk_toptips').show();
       $('.bk_toptips span').html('手机号码不正确');
       setTimeout(function(){$('.bk_toptips').hide();},2000);
       return;
     }
     //允许发送短信验证码
     $(this).removeClass('bk_important');
     $(this).addClass('bk_summary');
     enable = false;
     var num = 60;
     var interval = window.setInterval(function(){
       $('.bk_phone_code_send').html(--num + 'S 重新发送');
       if(num == 0)
       {
         $('.bk_phone_code_send').removeClass('bk_summary');
         $('.bk_phone_code_send').addClass('bk_important');
         enable = true;
         window.clearInterval(interval);
         $('.bk_phone_code_send').html('重新发送');
       }
     },1000);

     $.ajax({
     type: 'POST',
     url: 'validate/validate_code/send',
     dataType: 'json',
     cache: false,
     data: {phone: phone,_token: "{{csrf_token()}}"},
     success: function(data) {
       if(data == null) {
         $('.bk_toptips').show();
         $('.bk_toptips span').html('服务端错误');
         setTimeout(function() {$('.bk_toptips').hide();}, 2000);
         return;
       }
       if(data.status != 0) {
         $('.bk_toptips').show();
         $('.bk_toptips span').html(data.message);
         setTimeout(function() {$('.bk_toptips').hide();}, 2000);
         return;
       }

       $('.bk_toptips').show();
       $('.bk_toptips span').html('发送成功');
       setTimeout(function() {$('.bk_toptips').hide();}, 2000);
     },
     error: function(xhr, status, error) {
       console.log(xhr);
       console.log(status);
       console.log(error);
     }
   });
 });


</script>

<script>
$('#phone_regi').blur(function(){
  var phone = $('#phone_regi').val();
  if(phone != '')
  {
    $.ajax({
    type: 'POST',
    url: 'validate/validate_code/phone',
    dataType: 'json',
    data: {phone: phone,_token: "{{csrf_token()}}"},
    success: function(data) {
      if(data.status == 0) {
        $('.bk_toptips').show();
        $('.bk_toptips span').html('该手机号已被注册');
        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        $('#phone_regi').focus();
        return;
      }
    }
    });
  }
});


</script>

<script>
$('#email_regi').blur(function(){
  var email = $('#email_regi').val();
  if(email != '')
  {
    $.ajax({
      type: 'POST',
      url: 'validate/validate_code/email',
      data: {email: email,_token: "{{csrf_token()}}"},
      dataType: 'json',
      success:function(data){
        if(data.status == 0)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('该邮箱已被注册');
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          $('#email_regi').focus();
          return;
        }
      }
    });
  }
});


</script>

<script type="text/javascript">
//点击注册时执行函数
  function onRegisterClick() {

 $('input:radio[name=register_type]').each(function(){
    if($(this).attr('checked') == 'checked')
    {
      var phone = '';
      var email = '';
      var password = '';
      var comfire = '';
      var verify = '';
      var sms = '';
      var id = $(this).attr('id');
      if(id == 'x11')
      {
        phone = $('input[name=phone]').val();
        password = $('input[name=passwd_phone]').val();
        comfire = $('input[name=passwd_phone_cfm]').val();
        sms = $('input[name=phone_code]').val();
        if(verifyPhone(phone,password,comfire,sms) == false)
        return;
      } else if (id == 'x12') {
        email = $('input[name=email]').val();
        password = $('input[name=passwd_email]').val();
        comfire = $('input[name=passwd_email_cfm]').val();
        verify = $('input[name=validate_code]').val();
        if(verifyEmail(email,password,comfire,verify) == false)
        return;
      }

      $.ajax({
        type: "POST",
        url: 'validate/validate_code/register',
        dataType: 'json',
        data: {phone: phone,email: email,password: password,comfire: comfire,sms: sms,verify: verify,
                _token: "{{csrf_token()}}"},
        success:function(data){
          if(data.status == null) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html('服务端错误');
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
          }
          if(data.status != 0) {
            $('.bk_toptips').show();
            $('.bk_toptips span').html(data.message);
            setTimeout(function() {$('.bk_toptips').hide();}, 2000);
            return;
          }

          $('.bk_toptips').show();
          $('.bk_toptips span').html('注册成功');
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
        },
        error: function(xhr, status, error) {
          console.log(xhr);
          console.log(status);
          console.log(error);
        }
      });
      function verifyPhone(phone,password,comfire,sms)
      {
        if(phone == '')
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('手机号不能为空');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(phone.length != 11 || phone[0] != 1)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('手机号码错误');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password == '' || comfire == '')
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('请输入密码');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password.length < 6 || comfire.length < 6)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('密码长度不能小于6位');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password != comfire)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('两次密码输入不一样');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(sms == '')
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('请输入短信验证码');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(sms.length < 6)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('短信验证码格式错误');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
      }
      function verifyEmail(email,password,comfire,verify)
      {
        if(email.indexOf('@') == -1 || email.indexOf('.') == -1 || email.indexOf('@') == 0 || email.indexOf('.') == email.length-1)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('邮箱格式错误');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password == '' || comfire == '')
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('请输入密码');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password.length < 6 || comfire.length < 6)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('密码长度不能小于6位');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(password != comfire)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('两次密码输入不一样');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(verify == '')
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('请输入验证码');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
        if(verify.length < 4)
        {
          $('.bk_toptips').show();
          $('.bk_toptips span').html('验证码格式错误');
          setTimeout(function(){$('.bk_toptips').hide();},2000);
          return;
        }
      }

    }
 });
}

</script>

@endsection
