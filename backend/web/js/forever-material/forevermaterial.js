(function($){
	$(function(){
		$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
		$('select').select2();
		//类型切换事件
		$('#material_type_selector').live('click',function(){
			var type = $(this).val();
			if (type == 'news') {
				$('#material-tpl-content').html($('#news-tpl').tmpl());
			}else if(type == 'video') {
				$('#material-tpl-content').html($('#video-tpl').tmpl());
			}else{
				$('#material-tpl-content').html($('#upload-tpl').tmpl());
			}
		});
	})
})(jQuery);