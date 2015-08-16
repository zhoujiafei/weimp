//自定义菜单相关js
(function($){
   $(function(){
     $('#sycn-menus').on('click',function(){
   	  $('#SyncMenusModal').modal('show');
     });
     //点击确认同步菜单
     $('#SyncMenusModal .confirm-sync-menus').on('click',function(){
      	var url = $('.sync-menus-action').val();
      	var _csrf = $('#_csrf').val();
      	$.ajax({
         	type: "POST",
            url: url,
            data:{_csrf:_csrf},
            success: function(obj){
               var obj = eval('(' + obj + ')');
               if (parseInt(obj.errorCode) == 0) {
                  $('#SyncSuccess').fadeIn('fast',function(){
                     $(this).fadeOut(2000);
                  });
               }else{
                  $('#SyncFail .error-msg').text(obj.errorText);
                  $('#SyncFail').fadeIn('fast',function(){
                     $(this).fadeOut(6000);
                  })
               }
            },
            complete:function() {
               $('#SyncMenusModal').modal('hide');
            }
      	});
   	})
   })
})(jQuery);