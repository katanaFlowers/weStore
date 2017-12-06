@extends('master')

@include('component.loading')

@section('title', '岛上书店登录')

@section('content')
<div class="weui_cells_title"></div>
<div class="weui_cells weui_cells_form">
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="text" name="phone_email" placeholder="邮箱或手机号"/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="password" name="passwd" placeholder="不少于6位"/>
      </div>
  </div>
  <div class="weui_cell weui_vcode">
      <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="text" name="verify" placeholder="请输入验证码"/>
      </div>
      <div class="weui_cell_ft">
          <img src="/validate/validate_code/create" class="bk_validate_code"/>
      </div>
  </div>
</div>
<div class="weui_cells_tips"></div>
<div class="weui_btn_area">
  <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
</div>
<a href="/register" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>
@endsection

@section('my-js')
<script type="text/javascript">
  $('.bk_validate_code').click(function () {
    $(this).attr('src', '/validate/validate_code/create?random=' + Math.random());
  });
</script>
<script>
function onLoginClick()
{
  var username = '';
  var password = '';
  var verify = '';
  username = $('input[name=phone_email]').val();
  password = $('input[name=passwd]').val();
  verify = $('input[name=verify]').val();

  if(username == '')
  {
    $('.bk_toptips').show();
    $('.bk_toptips span').html("请输入用户名");
    setTimeout(function(){$('.bk_toptips').hide();},2000);
    return;
  }
  if(password == '')
  {
    $('.bk_toptips').show();
    $('.bk_toptips span').html("请输入密码");
    setTimeout(function(){$('.bk_toptips').hide();},2000);
    return;
  }
  if(verify == '' || verify.length < 4)
  {
    $('.bk_toptips').show();
    $('.bk_toptips span').html("验证码错误");
    setTimeout(function(){$('.bk_toptips').hide();},2000);
    return;
  }

  $.ajax({
    type: 'POST',
    data: {username: username,password: password,verify: verify,_token: "{{csrf_token()}}"},
    dataType: 'json',
    url: 'validate/validate_code/login',
    success:function(data){
      if(data.status != 0)
      {
        $('.bk_toptips').show();
        $('.bk_toptips span').html(data.message);
        setTimeout(function(){$('.bk_toptips').hide();},2000);
        return;
      }
      if(data.status == 0)
      {
        $('.bk_toptips').show();
        $('.bk_toptips span').html("登陆成功");
        setTimeout(function(){$('.bk_toptips').hide();},2000);
        var return_url = "{{$return_url}}";
        if(return_url != '')
        {
          location.href="{{$return_url}}";
        } else {
          location.href="category";
        }
      }
    }
  });
}


</script>
@endsection
