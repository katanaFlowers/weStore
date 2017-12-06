<?php

namespace App\Http\Controllers\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CategoryClass;
use App\Models\M3Result;
use App\Entify\ProductClass;
use App\Entify\PdtContentClass;
use App\Entify\PdtImagesClass;
use App\Entify\CartItemClass;

class CategoryController extends Controller
{

  //查询出所有的一级分类
  public function category()
  {
    $categorys = CategoryClass::whereNull('parent_id')->get();
    return view('category')->with('categorys',$categorys);
  }
   //查询一级分类下对应的二级分类
  public function child($category_id)
  {

    $value = CategoryClass::where('parent_id',$category_id)->get();

    $m3_result = new M3Result();
    $m3_result->status = 0;
    $m3_result->child = $value;

    return $m3_result->toJson();

  }
  //查找产品的三级分类
  public function product($child_id)
  {
    $products = ProductClass::where('category_id',$child_id)->get();
    return view('product')->with('products',$products);
  }
  //查询书籍详情信息
  public function pdtContent(Request $request,$product_id)
  {
    $product = ProductClass::where('id',$product_id)->first();
    $pdt_content = PdtContentClass::where('product_id',$product_id)->first();
    $pdt_images = PdtImagesClass::where('product_id',$product_id)->get();
    //查询cookie中商品的数量
    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = ($bk_cart!=null ? explode(',',$bk_cart) : array());
    $count = 0;
    foreach($bk_cart_arr as $value)
    {
      $index = strpos($value,":");
      if(substr($value,0,$index) == $product_id)
      {
        $count = (int)substr($value,$index+1);
        break;
      }
    }
    $member = $request->session()->get('member','');
    if($member != '')
    {
      $cart_item = CartItemClass::where('product_id',$product_id)->first();
      if($cart_item != null)
      {
        $count = $cart_item->count;
      }
    }
    return view('pdt_content')->with('product',$product)
                              ->with('pdt_content',$pdt_content)
                              ->with('pdt_images',$pdt_images)
                              ->with('count',$count);
  }
}
