<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CategoryClass;
use App\Entify\ProductClass;


class CategoryController extends Controller
{

    public function categoryList()
    {
      $categorys = CategoryClass::get();
      foreach($categorys as $category)
      {
        if($category->parent_id != '' && $category->parent_id != null)
        {
          $category->parent = CategoryClass::find($category->parent_id);
        }
      }
      return view('admin.category')->with('categorys',$categorys);
    }

    public function categoryAdd()
    {
      $categorys = CategoryClass::whereNull('parent_id')->get();
      return view('admin.categoryAdd')->with('categorys',$categorys);
    }

    public function productList()
    {
      $products = ProductClass::get();
      foreach($products as $product)
      {
        $product->category = CategoryClass::find($product->category_id);
      }

      return view('admin.product')->with('products',$products);
    }

    public function productEdit(Request $request)
    {
      $id = $request->input('id','');
      $product = ProductClass::find($id);
      $categorys = CategoryClass::whereNotNull('parent_id')->get();
      return view('admin.product_edit')->with('product',$product)->with('categorys',$categorys);
    }

}
