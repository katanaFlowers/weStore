<?php
namespace App\Http\Controllers\Admin\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entify\CategoryClass;
use App\Entify\ProductClass;
use App\Models\M3Result;

class SqlController extends Controller
{

    public function addcategory(Request $request)
    {
      $name = $request->input('name','');
      $category_no = $request->input('category_no','');
      $parent_id = $request->input('parent_id','');
      $m3 = new M3Result();
      $category = new CategoryClass();

      $category->name = $name;
      $category->category_no = $category_no;
      if($parent_id != '' && $parent_id != null)
      {
        $category->parent_id = $parent_id;
      }
      $category->save();

      $m3->status = 0;
      $m3->message = '添加成功';
      return $m3->toJson();

    }

    public function del(Request $request)
    {
      $id = $request->input('id','');
      CategoryClass::find($id)->delete();

      $m3 = new M3Result();
      $m3->status = 0;
      $m3->message = '删除成功';
      return $m3->toJson();
    }

    public function categoryEdit(Request $request)
    {
      $id = $request->input('id','');
      $category = CategoryClass::find($id);

      $categorys = CategoryClass::whereNull('parent_id')->get();

      $m3 = new M3Result();
      $m3->status = 0;
      $m3->toJson();
      return view('admin.categoryEdit')->with('category',$category)->with('categorys',$categorys);

    }

    public function editCategory(Request $request)
    {
      $name = $request->input('name','');
      $category_no = $request->input('category_no','');
      $parent_id = $request->input('parent_id','');
      $id = $request->input('id','');
      $m3 = new M3Result();

      $cate = CategoryClass::find($id);
      $cate->name = $name;
      $cate->category_no = $category_no;
      $cate ->parent_id = $parent_id;
      $cate->save();


      $m3->status = 0;
      $m3->message = '编辑成功';
      return $m3->toJson();
    }

    public function productadd(Request $request)
    {
      $form = $request->all();
      $product = new ProductClass();

      $product->name = $form['name'];
      $product->summary = $form['summary'];
      $product->price = $form['price'];
      $product->category_id = $form['category_id'];
      $product->preview = $form['preview'];
      $product->save();

      $m3 = new M3Result();
      $m3->status = 0;
      $m3->message = "产品添加成功";
      return $m3->toJson();
    }

    public function productDel(Request $request)
    {
      $value = ProductClass::find($request->input('id',''))->delete();
      if($value)
      {
        $m3 = new M3Result();
        $m3->status = 0;
        $m3->message = "删除成功";
        return $m3->toJson();
      } else {
        $m3 = new M3Result();
        $m3->status = 1;
        $m3->message = "删除失败，请稍后重试";
        return $m3->toJson();
      }
    }

    public function editProduct(Request $request)
    {
      $form = $request->all();
      $product = ProductClass::find($form['id']);

      $product->name = $form['name'];
      $product->summary = $form['summary'];
      $product->price = $form['price'];
      $product->category_id = $form['category_id'];
      $product->preview = $form['preview'];
      $product->save();

      $m3 = new M3Result();
      $m3->status = 0;
      $m3->message = "产品编辑成功";
      return $m3->toJson();
    }



}
