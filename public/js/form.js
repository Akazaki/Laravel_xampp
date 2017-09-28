require.config({
    baseUrl: './js',
    paths: {
        jquery: './js/jquery-3.2.1.min'
    },
});

require(['jquery'], function($) {
//define(['jquery'], function ($) {

	$(function(){
		var $error_text = $('#file_error_text'),
			csrf = $('input[name="_token"]').val(),
			$file_input = $('input[type="file_images"]'),
			$file_images = $("#file_images"),
			$img_name = $('#img_name'),
			$img_path = $('#img_path'),
			$uploaded_images = $('.uploaded_images');

		var form = {
			init: function(){
	            form.event();
	        },
	        event: function(){
	             // アップロードするファイルを選択
			    $('input[type="file"]').change(function() {
			        // アップロードされたファイルを取得
			        var file = $(this).prop('files')[0];
			        // 画像表示
			        var reader = new FileReader();
			        reader.onload = function() {
			        	form.upload_images();
			            //var img_src = $('.uploaded_images').attr('src', reader.result);
			        }
			        reader.readAsDataURL(file);
			    });
	        },
			upload_images: function(){
			    // ファイルが選択されていない時return
			    if ($file_images.val() == "") {
			        $error_text.text('画像がアップされていません');
			        return;
			    }

			    var fd = new FormData();
			    // ファイルを取得
			    fd.append("image", $("input[name='file_images']").prop("files")[0]);
			    fd.append("_tokesn", csrf);
			    var postData = {
			    type : "POST",
			        dataType : "json",
			        data : fd,
			        processData : false,
			        contentType : false
			    };

			    $.ajax(
			        './api/fileup', postData
			    ).fail(function(data) {
			        // dataが不正な場合
			        if(data.responseJSON.errors){
			        	var message = data.responseJSON.errors.image[0];
				        $error_text.text(message);
					}else{
						$error_text.text('エラーが発生しました');
					}
			    }).done(function(data) {
			        // 成功処理
			        var img_path = data.img_path,
			        	img_name = data.img_name;

			        if(img_path && img_name){
						$error_text.text('');
			        	$img_name.val(img_name);
			        	$img_path.val(img_path);
			        	$uploaded_images.attr('src', img_path);
			        }else{
						$error_text.text('エラーが発生しました');
					}
			    });
			}
		};

	    form.init();
	});
});