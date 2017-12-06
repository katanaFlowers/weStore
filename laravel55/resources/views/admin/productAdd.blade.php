@extends('admin.master')
@section('content')
<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 添加产品 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>


<div class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
   {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品标题：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" style="width: 70%;" value="" placeholder="" id="" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>简介：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea class="input-text" value="" style="width: 70%;height:20%;" placeholder="请输入商品的简介" id="" name="summary"></textarea>
			</div>
		</div>
    <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2 "><span class="c-red">*</span>价格：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input style="width: 70%;" type="text" class="input-text" value="" placeholder="" id="" name="price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>父类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width: 70%;">
				<select  name="category_id" class="select">
          @foreach($categorys as $category)
					<option value="{{$category->id}}">{{$category->name}}</option>
          @endforeach
				</select>
				</span> </div>
		</div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2 "><span class="c-red">*</span>预览图：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <img src="/admin/add.jpg" id="preview_id" style="width:100px;height:100px;border:1px solid #b8b9b9;cursor:pointer;" onclick="$('#input_file').click()"/>
        <input style="display: none;" type="file" class="input-file" value="" placeholder="" id="input_file" name="file" onchange="return uploadFileToServer('input_file','images','preview_id')">
      </div>
    </div>

    <div class="row cl">
			<label class="form-label col-xs-4 col-sm-2 "><span class="c-red"></label>
			<div class="formControls col-xs-8 col-sm-9">
				<input class="btn btn-primary radius" style="" type="button" onclick="click_sub()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>

    </form>
				</div>


@endsection


@section('my-js')
<script src="/admin/ajaxfileupload.js" type="text/javascript"></script>
<script>
function uploadFileToServer(fileEmtId,type,id)
{
  $.ajaxFileUpload({
    url: '/admin/service/uploadImages/' + type,
    fileElementId: fileEmtId,
    dataType: 'JSON',
    success:function(data){
      var result = JSON.parse(data);
      if(result.status != 0)
      {
        alert(result.message);
      }

      if(result.status == 0)
      {

          $('#'+id).attr('src',result.uri);
      }
    }
  });
  return false;
}

function click_sub()
{
  var name = $('input[name=name]').val();
  var summary = $('textarea[name=summary]').val();
  var price = $('input[name=price]').val();
  var category_id = $('.select option:selected').val();
  var preview = $('#preview_id').attr('src');

  $.ajax({
    url: '/admin/service/product_add',
    type: 'POST',
    data: {name: name,summary: summary,price: price,category_id: category_id,preview: preview,_token: "{{csrf_token()}}"},
    dataType: 'json',
    success:function(data){
      if(data.status == 0)
      {
        layer.msg(data.message,{icon:1,time:3000});
      }
    }
  });
}

</script>

@endsection
