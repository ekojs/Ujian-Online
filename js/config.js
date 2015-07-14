/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.addExternal('fmath_formula', 'plugins/fmath_formula/', 'plugin.js');

CKEDITOR.editorConfig = function( config )
{	
	config.enterMode = CKEDITOR.ENTER_DIV;
	config.toolbar = 'MyToolbar';
	
	 // Declare the additional plugin 
        config.extraPlugins = 'fmath_formula';
      
	
	config.toolbar_MyToolbar =
    [
        ['Preview'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Scayt'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'],
        ['Styles','Format'],
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript','fmath_formula'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote']
    ];

};
