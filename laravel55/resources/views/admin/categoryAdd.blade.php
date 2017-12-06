
@extends('admin.master')
@section('content')

<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 分类管理 <span class="c-gray en">&gt;</span> 添加分类 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
</div>
<article class="cl pd-20">

	<form action="" method="post" class="form form-horizontal" id="form-category-add">
    {{csrf_field()}}
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" style="width:60%;" name="name" nullmsg="名称不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>序号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" style="width:60%;" name="category_no" nullmsg="名称不能为空">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">父类别：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="parent_id" size="1">
					<option value="">无</option>
          @foreach($categorys as $vo)
					<option value="{{$vo->id}}">{{$vo->name}}</option>
					@endforeach
				</select>
				</span> </div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" onclick="form_sub()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

@endsection

@section('my-js')

<script>
$("#form-category-add").validate({
  rules:{
    name:{
      required:true,
    },
    category_no:{
      required:true,
    }
  },
  onkeyup:false,
  focusCleanup:true,
  success:"valid",
  submitHandler:function(form){
    $(form).ajaxSubmit();
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
  }
});

 function form_sub()
 {
   var name = $('input[name=name]').val();
   var category_no = $('input[name=category_no]').val();
   var parent_id = $('.select option:selected').val();

   $.ajax({
     type: 'POST',
     url: '/admin/service/addcategory',
     data: {name: name,category_no: category_no,parent_id: parent_id,_token: "{{csrf_token()}}"},
     dataType: 'json',
     success:function(data){
       if(data.status == 0)
       {
         layer.msg(data.message,{icon:1,time:3000});
         location.href="/admin/category";
       }
     }
   });
 }
</script>
@endsection
