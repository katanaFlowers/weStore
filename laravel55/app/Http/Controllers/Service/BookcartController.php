<?php

namespace App\Http\Controllers\service;

use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Http\Controllers\Controller;
use App\Entify\CartItemClass;


class BookcartController extends Controller
{
    public function addCart(Request $request,$product_id)
    {
      //查询cookie里的产品信息
      $member = $request->session()->get('member','');
      if($member != '')
      {
        $cart_item = CartItemClass::where('product_id',$product_id)->first();
        if($cart_item != '')
        {
          $count = $cart_item->count;
          $cart_item->count = $count + 1 ;
          $cart_item->save();

          $m3_result = new M3Result();
          $m3_result->status = 0;
          $m3_result->message = "添加成功";
          return $m3_result->toJson();
        }
      }
      $bk_cart = $request->cookie('bk_cart');
      $bk_cart_arr = ($bk_cart!=null ? explode(',',$bk_cart) : array());

      $count = 1;
      foreach($bk_cart_arr as &$value)
      {
        $index = strpos($value,":");
        if(substr($value,0,$index) == $product_id)
        {
          $count = ((int)substr($value,$index+1)) + 1;
          $value = $product_id.':'.$count;
          break;
        }
      }
      if($count == 1)
      {
        array_push($bk_cart_arr,$product_id.':'.$count);
      }
      $m3_result = new M3Result();
      $m3_result->status = 0;
      $m3_result->message = "添加成功";

      return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }

    public function onDelect(Request $request)
    {
      $product_ids = $request->input('product_ids','');
      $m3_result = new M3Result();

      if($product_ids == '')
      {
        $m3_result ->status = 1;
        $m3_result ->message = "请勾选需要删除的商品";
        return $m3_result->toJson();
      }
      //未登录
      $bk_cart = $request->cookie('bk_cart');
      $bk_cart_arr = ($bk_cart!=null ? explode(',',$bk_cart) : array());

      $product_id_arr = explode(',', $product_ids);
      foreach($bk_cart_arr as $key=>$value)
      {
        $index = strpos($value,':');
        $product_id = substr($value,0,$index);
        if(in_array($product_id,$product_id_arr))
        {
          array_splice($bk_cart_arr,$key,1);
        }
      }
      //登陆后
      $member = $request->session()->get('member','');
      if($member != '')
      {
        foreach($product_id_arr as $product_id)
        {
          CartItemClass::where('product_id',$product_id)->delete();
        }
      }
      $m3_result ->status = 0;
      return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
}
