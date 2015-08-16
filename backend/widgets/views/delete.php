<!-- Modal -->
<div class="modal fade" id="AlertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">删除确认</h4>
      </div>
      <div class="modal-body">
        您确定要删除该条内容吗？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary confirm-delete" >确定</button>
      </div>
    </div>
  </div>
</div>
<div class="alert alert-success" id="AlertSuccess" style="display:none;">
	<button class="close" data-dismiss="alert">×</button>
	<strong>删除成功!</strong> 您已经删除这条记录！
</div>

<div class="alert alert-error" id="AlertFail" style="display:none;">
	<button class="close" data-dismiss="alert">×</button>
	<strong>删除失败!</strong> <strong class="error-msg">抱歉，删除失败！<strong>
</div>
<script>
$(document).ready(function(){
   //点击删除某一条记录的按钮
	$('.remove-row').on('click',function(){
	     var id = $(this).attr('_id');
   	  $('#AlertModal').modal('show').data('id',id);
	});
	//点击确认删除
	$('.confirm-delete').on('click',function(){
   	var url = $('.delete-action').val();
   	var id = $('#AlertModal').data('id');
   	var _csrf = $('#_csrf').val();
   	$.ajax({
      	type: "POST",
         url: url,
         data:{id:id,_csrf:_csrf},
         success: function(obj){
            var obj = eval('(' + obj + ')');
            if (parseInt(obj.errorCode) == 0) {
               $('#AlertSuccess').fadeIn('fast',function(){
                  $(this).fadeOut(2000,function(){
                     $('#tr_' + id).remove();
                  });
               });
            }else{
               $('#AlertFail .error-msg').text(obj.errorText);
               $('#AlertFail').fadeIn('fast',function(){
                  $(this).fadeOut(6000);
               })
            }
         },
         complete:function() {
            $('#AlertModal').modal('hide');
         }
   	});
	})
});
</script>