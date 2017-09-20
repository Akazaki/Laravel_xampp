/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.timestamp = '201701231600';
CKEDITOR.editorConfig = function( config ) {
	config.skin = 'moonocolor';
	config.contentsCss = [
		'../../common/css/default.css',
		'../../common/css/base_pc.css',
		'../../common/css/base_sp.css',
		'../../css/detail_pc.css?20170120',
		'../../css/detail_sp.css',
		'http://fonts.googleapis.com/css?family=Josefin+Sans|Quicksand'
	];
	config.extraPlugins = 'widget,lineutils,image2';
	config.allowedContent = true;
	config.filebrowserImageUploadUrl = 'common/js/ckeditor/plugins/image2/fileuploader.php';
	
	config.height = 500;
	config.width = 960;

	config.toolbar = [
		{ name: 'document', items : [ 'Source','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Undo','Redo' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript'] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image', 'HorizontalRule','SpecialChar','Iframe' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
};
