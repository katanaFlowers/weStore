
@extends('admin.master')
@section('content')

<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="Hui-article">

		<div style="margin-left:30px;margin-top:30px;">

				 <a class="btn btn-primary radius"  href="/admin/productAdd"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a></span> <span class="r">共有数据：<strong>{{count($products)}}</strong> 条</span> </div>
				<div class="mt-20">
					<table class="table table-border table-bordered table-bg table-hover table-sort">
						<thead>
							<tr class="text-c">
								<th width="40">ID</th>
								<th width="60">名称</th>
								<th width="100">简介</th>
                <th width="70">预览图</th>
								<th width="70">价格</th>
								<th width="100">父类别</th>
								<th width="100">操作</th>
							</tr>
						</thead>
						<tbody>
							@foreach($products as $vo)
							<tr class="text-c va-m">
								<td>{{$vo->id}}</td>
								<td>{{$vo->name}}</td>
								<td>{{$vo->summary}}</td>
								<td>{{$vo->price}}</td>
                <td>
									<img src="{{$vo->preview}}" style="width: 50px;height: 50px;"/>
								</td>
								<td>

								 {{$vo->category->name}}

								</td>
								<td class="td-manage"><a style="text-decoration:none" class="ml-5" href="/admin/service/product_edit?id={{$vo->id}}" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a> <a style="text-decoration:none" class="ml-5" onClick="product_del('{{$vo->name}}',{{$vo->id}})" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</section>

@endsection

@section('my-js')
<script>
function product_del(name,id)
{
	layer.confirm("确认删除" + name + "吗？",function(){
		$.ajax({
			type: 'POST',
			url: '/admin/service/product_del',
			data: {name: name,id: id,_token: "{{csrf_token()}}"},
			dataType: 'json',
			success:function(data){
				if(data.status == 0)
				{
					layer.msg(data.message,{icon:1,time:3000});
					location.replace(location.href);
				} else {
					layer.msg(data.message,{icon:2,time:3000});
				}
			}
		});
	});
}

</script>

@endsection
