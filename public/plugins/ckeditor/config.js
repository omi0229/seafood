/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

// CKEDITOR.editorConfig = function( config ) {
// 	// Define changes to default configuration here. For example:
// 	config.language = 'fr';
// 	config.uiColor = '#AADC6E';
// };

CKEDITOR.editorConfig = function( config ) {

	config.language = 'zh';

    config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'ShowBlocks,About,Maximize,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,SelectAll,Find,Replace,Templates,Save,NewPage,ExportPdf,Preview,Print,Language,Cut,Undo,Redo,Copy,Paste,PasteText,PasteFromWord,Scayt,Subscript,Superscript,CopyFormatting,NumberedList,Outdent,BulletedList,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Unlink,Anchor,Table,Image,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font';

    config.filebrowserBrowseUrl='plugins/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl='plugins/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl='plugins/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl ='plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl='plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl='plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
