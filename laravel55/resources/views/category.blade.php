@extends('master')

@section('title','岛上书店')

@section('content')

<div>
<div class="weui_cells_title">图书分类</div>
   <div class="weui_cells weui_cells_split">
     <div class="weui_cell weui_cell_select">
       <div class="weui_cell_bd weui_cell_primary">
            <select class="weui_select" name="category" id="category_id">
            @foreach($categorys as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
           </select>
        </div>
     </div>
  </div>
</div>

<div class="weui_cells weui_cells_access" id="child">

      <a class="weui_cell weui_cell_access" href="javascript:;">
          <div class="weui_cell_bd">
              <p></p>
          </div>
          <div class="weui_cell_ft">
          </div>
      </a>

</div>

@endsection

@section('my-js')
<script>
var category_id = $('#category_id option:selected').val();
   _init();
$('.weui_select').change(function(){
   _init();
});

function _init(){
  var category_id = $('#category_id option:selected').val();

  $.ajax({
  type: 'GET',
  url: 'category/child/' + category_id,
  dataType: 'json',
  cache: false,
  success: function(data) {
    if(data == null) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('服务端错误');
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }
    if(data.status != 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html(data.message);
      setTimeout(function() {$('.bk_toptips').hide();}, 2000);
      return;
    }

    $('#child').html('');
     for(var i = 0;i < data.child.length; i++){
       var child_id = 'category/child/product/' + data.child[i].id;
      var node = '<a class="weui_cell" href="' + child_id + '">' +
          '<div class="weui_cell_bd weui_cell_primary">' +
              '<p>' + data.child[i].name + '</p>' +
        '  </div>' +
        '  <div class="weui_cell_ft">' +
        '  </div>' +
    '  </a>';
       $('#child').append(node);
     }



  },
  error: function(xhr, status, error) {
    console.log(xhr);
    console.log(status);
    console.log(error);
  }
  });
}
</script>

@endsection
