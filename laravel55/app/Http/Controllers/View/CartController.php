<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CartItemClass;
use App\Entify\ProductClass;
use App\Entify\OrderClass;
use App\Entify\OrderItemClass;

class CartController extends Controller
{
    public function toCart(Request $request)
    {
      //未登录时，离线购物车
      $cart_items = array();
      $bk_cart = $request->cookie('bk_cart');
      $bk_cart_arr = ($bk_cart!=null ? explode(',',$bk_cart) : array());

      //登陆时
      $member = $request->session()->get('member','');
      if($member != '')
      {
        $cart_items = $this->syncCart($member->id,$bk_cart_arr);
        return response()->view('cart',['cart_items'=>$cart_items])->withCookie('bk_cart',null);
      }

      foreach($bk_cart_arr as $key=>$value)
      {
        $index = strpos($value,":");

        $cart_item = new CartItemClass();
        $cart_item->id = $key;
        $cart_item->product_id = substr($value,0,$index);
        $cart_item->count = (int)substr($value,$index+1);
        $cart_item->product = ProductClass::find($cart_item->product_id);
        if($cart_item->product != null)
        {
          array_push($cart_items,$cart_item);
        }
      }
      return view('cart')->with('cart_items',$cart_items);
    }
    //同步购物车
    private function syncCart($member_id,$bk_cart_arr)
    {
      $cart_items = CartItemClass::where('member_id',$member_id)->get();
      $cart_items_arr = array();
      //循环对比购物车数据库和离线购物车信息
      foreach($bk_cart_arr as $value)
      {
        $index = strpos($value,":");
        $product_id = substr($value,0,$index);
        $count = (int)substr($value,$index+1);

        $exist = false;
        foreach($cart_items as  $cart_item)
        {
          if($cart_item->product_id == $product_id )
          {
            if($cart_item->count < $count)
            {
              $cart_item->count = $count;
              $cart_item->save();
            }
            $exist = true;
            break;
          }
        }

        if($exist == false)
        {
          $cart = new CartItemClass();
          $cart->product_id = $product_id;
          $cart->member_id = $member_id;
          $cart->count = $count;
          $cart->save();
          $cart->product = ProductClass::find($cart->product_id);
          array_push($cart_items_arr,$cart);
        }
      }
      //查询每个产品的数据product
      foreach($cart_items as $value)
      {
        $value->product = ProductClass::find($value->product_id);
        array_push($cart_items_arr,$value);
      }
      return $cart_items_arr;
    }
   //提交订单
    public function toCommit(Request $request)
    {
      //获取产品的id
      $product_id_arr = $request->input('product_id_arr','');
      $member = $request->session()->get('member','');
      $cart_items_arr = [];
      $prices = [];
      $price = 0;//总价
      $name = '';//存放订单的商品
      $product_ids = ($product_id_arr!=null ? explode(',',$product_id_arr) : array());
      $cart_items = CartItemClass::where('member_id',$member->id)->whereIn('product_id',$product_ids)->get();
      $order = new OrderClass();
      foreach($cart_items as $cart_item)
      {
        $cart_item->product = ProductClass::find($cart_item->product_id);
        if($cart_item->product != null)
        {
          $value = $cart_item->product->price*$cart_item->count;
          array_push($cart_items_arr,$cart_item);
          $price = $price + $value;
          $name .= '《'.$cart_item->product->name.'》';
        }
      }
      if($name != '')
      {
        $order->member_id = $member->id;
        $order->name = $name;
        $order->total_price = $price;
        $order->order_no = 1;
        $order->save();
        $order->order_no = 'E'.time().''.$order->id;
        $order->save();
      }

      foreach ($cart_items_arr as $cart_item) {
        $product_json = json_encode($cart_item->product);
        $order_item =new OrderItemClass();
        $order_item->snapshot = $product_json;
        $order_item->order_id = $order->id;
        $order_item->product_id = $cart_item->product_id;
        $order_item->count =$cart_item->count;
        $order_item->save();
      }
      CartItemClass::where('member_id',$member->id)->delete();
      return view('commit')->with('cart_items',$cart_items_arr)
                           ->with('price',$price);
    }
    //订单列表页
    public function orderList(Request $request)
    {
      $num = 0;
      $member = $request->session()->get('member','');
      $orders = OrderClass::where('member_id',$member->id)->get();
      foreach($orders as $order)
      {
        $order_items = OrderItemClass::where('order_id',$order->id)->get();
        $order->order_items = $order_items;

        foreach($order_items as $order_item)
       {
        $order_item->product = ProductClass::find($order_item->product_id);
        $num += 1;
       }
      }

      return view('orderList')->with('orders',$orders)->with('num',$num);
    }

}
