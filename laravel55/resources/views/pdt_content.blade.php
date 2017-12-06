
@extends('master')

@section('title',$product->name)

@section('content')

<div class="slider">

<ul id="slides" class="slides clearfix">
@foreach($pdt_images as $pdt_image)
<li><img class="responsive" src="{{$pdt_image->image_path}}" alt=""></li>
@endforeach
</ul>
</div>

<div class="weui_cells_title">
    <span class="bk_title" >{{$product->name}}</span>
    <span class="" style="color: red;float: right;font-size: 17px;" >￥{{$product->price}}</span>
</div>
<div class="weui_cells">
    <div class="weui_cell">
        <div class="weui_cell_bd">
          <p style="color: #888">{{$product->summary}}</p>
        </div>
    </div>
</div>

<div class="weui_cells_title" >商品详情</div>
<div class="weui_cells" style="margin-bottom:50px;">
    <div class="weui_cell" >
        <div class="weui_cell_bd">
            <p style="color: #888">
              @if($pdt_content != null)
              {!! $pdt_content->content !!}
              @else

              @endif
            </p>
        </div>
    </div>
  </div>

  <div style="bottom:50px;">
  </div>

<div class="bk_bottom_zero" >
  <div class="bk_half_area">
      <tutton class="weui_btn weui_btn_primary" onclick="addCart()">加入购物车</dutton>
  </div>
  <div class="bk_half_area">
      <tutton class="weui_btn weui_btn_default" onclick="toCart()">购物车(<span id="cart_num" class="cart_num">{{$count}}</span>)</dutton>
  </div>
</div>
@endsection

@section('my-js')
<script type="text/javascript">
 $(document).ready(function() {
 var len = $(".slider li").length-1;
 //给slider设置样式
 $(".slider").css({
  "width":"100%",
  "height": "inherit",
  "overflow": "hidden",
  "display":"inline-block"

 });

 //给ul设置宽度
 $(".slides").css({
  "position": "relative",
  "width":((len+1)*100).toString()+"%",
  "margin":"0",
  "padding":"0",

  "overflow": "hidden"

});
 //给li设置百分比宽度
 $(".slides li").css({
  "width":(100/(len+1)).toString()+"%",
  "float":"left",
  'list-style':"none"
 });
 //给图片设置宽度
 $(".responsive").css({
  "width":"100%",
  "height":"inherit"
 });

 //animate移动
 var i = 0;
 $(".nextpic").click(function(){
  moveNext(i);
 });
 $(".lastpic").click(function(){
  moveLast(i);
 });
 //自动轮播
 var timer = setInterval(function(){
  moveNext(i);
 },5000);
 moveNext = function(n){
  if(n==len){
  i=-1;
  $(".slider .slides").animate({right: ""},800);
  }else{
  $(".slider .slides").animate({right:((n+1)*100).toString()+"%"}, 800);
  }
  i++;
 }
 moveLast = function(n){
  if(n==0){
  i=len+1;
  $(".slider .slides").animate({right:(len*100).toString()+"%"}, 800);
  }else{
  $(".slider .slides").animate({right:((n-1)*100).toString()+"%"}, 800);
  }
  i--;
 }
 //手机触摸效果
 var startX,endX,moveX;
 function touchStart(event){
  var touch = event.touches[0];
  startX = touch.pageX;
 }
 function touchMove(event){
  var touch = event.touches[0];
  endX = touch.pageX;
 }
 function touchEnd(event){
  moveX = startX - endX;
  if(moveX>50){
  moveNext(i);
  }else if(moveX<-50){
  moveLast(i);
  }
 }
 document.getElementById("slides").addEventListener("touchstart",touchStart,false);
 document.getElementById("slides").addEventListener("touchmove",touchMove,false);
 document.getElementById("slides").addEventListener("touchend",touchEnd,false);


 });
</script>

<script>
function addCart()
{
  var product_id = "{{$product->id}}";
  $.ajax({
    type: "GET",
    url: '/service/addCart/' + product_id,
    dataType: 'json',
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
      var num = $('#cart_num').html();
      if(num == 0)
      {
        $('#cart_num').html(0 + 1);
      }
      $('#cart_num').html(Number(num) + 1);
    },
    error: function(xhr, status, error) {
      console.log(xhr);
      console.log(status);
      console.log(error);
    }
  });
}
</script>
<script>
 function toCart()
 {
   location.href="/view/cart";
 }
</script>
@endsection
