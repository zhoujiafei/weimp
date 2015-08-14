<div style="width:100%;height:800px;">

<?php 
  $this->params = [
  	'breadcrumb'  => [
                      ['name' => 'hello','url' => '#','current' => 1],
                  ],
  
  ];

use kucha\ueditor\UEditor;
echo UEditor::widget([
        'name' => 'content',
		  'clientOptions' => [
        'initialFrameHeight' => '200',
        'lang' =>'en', //zh-cn
        'toolbars' => [
            [
                'fullscreen', 'source', 'undo', 'redo', '|',
                'fontsize',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                'forecolor', 'backcolor', '|',
                'lineheight', '|',
                'indent', '|',
                'insertimage', '|',
            ],
        ]
       ]
    ]);
?>


</div>