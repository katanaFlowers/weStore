
@extends('master')

@section('title','订单详情')

@section('content')
<div class="weui_cells">
  <div class="weui_cells weui_cells_access">
      @foreach($cart_items as $cart_item)
      <div class="weui_cell">
          <div class="weui_cell_hd">
            <img class="" src="{{$cart_item->product->preview}}" style="height:54px;width:50px;margin-right:0.8em;" alt="" style=""></div>
          <div class="weui_cell_bd weui_cell_primary">

              <span class="bk_title" style="color:#888;font-size:16px;" >{{$cart_item->product->name}}</span>
              <span class="bk_price" style="float: right;color:#666"><span style="color: red;">{{$cart_item->product->price}}</span> x <span style="color: green;">{{$cart_item->count}}</span></span>


          </div>

      </div>
      @endforeach
  </div>
</div>

<div>
<div class="weui_cells_title">支付方式</div>
   <div class="weui_cells weui_cells_split">
     <div class="weui_cell weui_cell_select">
       <div class="weui_cell_bd weui_cell_primary">
            <select class="weui_select" name="" id="">
            <option value="">微信</option>
            <option value="">支付宝</option>
           </select>
        </div>
     </div>
  </div>
</div>

<div class="weui_cells" style="margin-bottom:50px;">
  <div class="weui_cells_title">
      <span class="bk_title" >总计:</span>
      <span class="" style="color: red;float: right;font-size: 20px;" >￥{{number_format($price,2)}}</span>
  </div>
</div>


<div class="bk_bottom_zero" >
  <div class="" style="position: relative;top: 3px;bottom: 3px;">
      <button class="weui_btn weui_btn_primary" style="width:95%;" onclick="toPay()">提交订单</button>
  </div>
</div>
@endsection

@section('my-js')

@endsection
