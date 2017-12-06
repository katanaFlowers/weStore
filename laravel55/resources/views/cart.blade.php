

@extends('master')

@section('title',"购物车")

@section('content')

<div class="weui_cells weui_cells_checkbox" style="margin-bottom:50px;">
   @foreach($cart_items as $cart_item)
    <label class="weui_cell weui_check_label" for="{{$cart_item->product->id}}"  >
        <div class="weui_cell_hd">
            <input type="checkbox" class="weui_check" name="cart_item" id="{{$cart_item->product->id}}" checked="checked"/>
            <i class="weui_icon_checked"></i>
          </div>
          <img src="{{$cart_item->product->preview}}" style="position:relative;max-width:80px;max-height:110px;margin-left:0.6em;margin-right:0.8em" alt="">
          <div class="weui_cell_bd" >
            <p style="font-size:17px;margin-top:5px">{{$cart_item->product->name}}</p>

              <p style="font-size:15px;">&nbsp;</p>
            <p style="font-size:15px;color:#555;">数量: <span style="color:#888;">x{{$cart_item->count}}</span></p>
            <p style="font-size:15px;color:#555;">总计: <span style="color:#cd4a4a;font-size:18px;">￥{{number_format($cart_item->product->price*$cart_item->count,2)}}</span></p>
        </div>
    </label>
   @endforeach
</div>
<div>
  <form id="product_ids" action="/view/toCommit" method="post">
    {{csrf_field()}}
   <input type="hidden" name="product_id_arr" value="" />
  </form>
</div>
<div class="bk_bottom_zero" >
  <div class="bk_half_area">
      <button class="weui_btn weui_btn_primary" onclick="toCommit()">结算</button>
  </div>
  <div class="bk_half_area">
      <button class="weui_btn weui_btn_default" onclick="onDelect()">删除</button>
  </div>
</div>

@endsection

@section('my-js')
<script>
 $('input:checkbox[name=cart_item]').click(function(){
   var checked = $(this).attr('checked');
   if(checked == "checked")
   {
     $(this).attr('checked',false);
     $(this).next().removeClass('weui_icon_checked');
     $(this).next().addClass('weui_icon_unchecked');
   } else {
     $(this).attr('checked','checked');
     $(this).next().removeClass('weui_icon_unchecked');
     $(this).next().addClass('weui_icon_checked');
   }
 });
 function onDelect()
 {
   var product_id_arr = [];
   $('input:checkbox[name=cart_item]').each(function(){
     if($(this).attr('checked') == 'checked')
     {
       product_id_arr.push($(this).attr('id'));
     }
   });
   $.ajax({
     type: "GET",
     url: '/service/onDelect',
     dataType: 'json',
     data: {product_ids: product_id_arr + ''},
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

       location.reload();
     },
     error: function(xhr, status, error) {
       console.log(xhr);
       console.log(status);
       console.log(error);
     }
   });
 }

 function toCommit()
 {
   var product_id_arr = [];
   $('input:checkbox[name=cart_item]').each(function(){
     if($(this).attr('checked') == 'checked')
     {
       product_id_arr.push($(this).attr('id'));
     }
   });
   if(product_id_arr.length == 0 )
   {
     $('.bk_toptips').show();
     $('.bk_toptips span').html('请勾选需要购买的商品');
     setTimeout(function() {$('.bk_toptips').hide();}, 2000);
     return;
   } else {
     //location.href="/view/toCommit/" + product_id_arr;
     $('input[name=product_id_arr]').val(product_id_arr + '');
     $('#product_ids').submit();
   }
 }
</script>


@endsection
