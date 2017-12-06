@extends('admin.master')
@section('content')
<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品编辑 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>


<div class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
   {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" style="width: 70%;" value="{{$product->name}}" placeholder="" id="" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea class="input-text" value="" style="width: 70%;height:20%;" placeholder="请输入商品的简介" id="" name="summary">{{$product->summary}}</textarea>
			</div>
		</div>
    <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2 "><span class="c-red">*</span>价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input style="width: 70%;" type="text" class="input-text" value="{{$product->price}}" placeholder="" id="" name="price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>父类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width: 70%;">
				<select  name="category_id" class="select">
          @foreach($categorys as $category)
          @if($category->id == $product->category_id)
          <option selected value="{{$product->id}}">{{$product->name}}</option>
          @else
					<option value="{{$category->id}}">{{$category->name}}</option>
          @endif
          @endforeach
				</select>
				</span> </div>
		</div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2 "><span class="c-red">*</span>预览图：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <img src="{{$product->preview}}" id="preview_id" style="width:100px;height:100px;border:1px solid #b8b9b9;cursor:pointer;" onclick="$('#input_file').click()"/>
        <input style="display: none;" type="file" class="input-file" value="" placeholder="" id="input_file" name="file" onchange="return uploadFileToServer('input_file','images','preview_id')">
      </div>
    </div>

    <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2 "><span class="c-red"></label>
			<div class="formControls col-xs-8 col-sm-9">
				<input class="btn btn-primary radius" style="" type="button" onclick="edit_sub({{$product->id}})" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>

    </form>
				</div>


@endsection

@section('my-js')
<script>
function edit_sub(id)
{
  var name = $('input[name=name]').val();
  var summary = $('textarea[name=summary]').val();
  var price = $('input[name=price]').val();
  var category_id = $('.select option:selected').val();
  var preview = $('#preview_id').attr('src');


  $.ajax({
    type: 'POST',
    url: '/admin/service/edit_product',
    data: {id: id,name: name,summary: summary,price: price,category_id: category_id,preview: preview,_token: "{{csrf_token()}}"},
    dataType: 'json',
    success:function(data){
      if(data.status == 0)
      {
        layer.msg(data.message,{icon:1,time:3000});
        location.href="/admin/product";
      }
    }
  });
}
</script>

@endsection
