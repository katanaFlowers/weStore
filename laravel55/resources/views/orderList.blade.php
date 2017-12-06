
@extends('master')

@section('title','订单列表')

@section('content')
@foreach($orders as $order)
<div style="display:block;">
<div class="weui_cells_title">订单号：{{$order->order_no}}<p style="float:right;font-size:14px;">订单状态</p></div>
  @foreach($order->order_items as $order_item)
    <div class="weui_cells" style="margin-top:0px;">
    <div class="weui_cell">
        <div class="weui_cell_hd">
          <img src="{{$order_item->product->preview}}" style="height:54px;width:50px;margin-right:0.8em;"></div>
        <div class="weui_cell_bd">
          <span class="bk_title" style="color:#888;font-size:16px;" >{{$order_item->product->name}}</span>
          <span class="bk_price" style="display:block;float: right;color:#666"><span style="color: red;">{{$order_item->product->price}}</span> x <span style="color: green;">{{$order_item->count}}</span></span>

        </div>
    </div>
</div>
    @endforeach
    <div style="width:100%;height:37px;padding:0">
<div class="weui_cells_title" style="float:right;margin-top:3px;margin-bottom:3px;">共计<span style="font-size:18px;color:green;">{{$num}}</span>件,合计<span style="color:red;font-size:18px;">￥{{number_format($order->total_price,2)}}</span></div>
</div>
</div>
@endforeach
@endsection

@section('my-js')

@endsection
