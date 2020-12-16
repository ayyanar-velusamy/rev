/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

/* CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = 'MyToolbar';
    config.toolbar_MyToolbar =[
	[ 'Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates' ],
	[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
	[ 'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt' ],
	[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton',
	'HiddenField' ],
	'/',
	[ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ],
	[ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv',
	'-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ],
	[ 'Link', 'Unlink', 'Anchor' ],
	[ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ],
	];
	
	
	 

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
}; */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'paragraph', groups: [ 'indent', 'align', 'list', 'blocks', 'bidi', 'paragraph' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'about', groups: [ 'about' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		'/',
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'others', groups: [ 'others' ] }
	];
	config.allowedContent = true;
	config.removeButtons = 'Save,NewPage,ExportPdf,Preview,Print,Templates,PasteText,PasteFromWord,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,RemoveFormat,Image,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Font,FontSize,TextColor,BGColor,ShowBlocks,Language,BidiRtl,BidiLtr,CreateDiv,Replace';
	config.extraAllowedContent = 'dl dt dd';
	config.format_ul = { element: 'ul', attributes: { 'class': 'list-img' } };
	//config.toolbar = 'MyToolbarSet'

  /*  config.toolbar_MyToolbarSet =
   [
       ['Cut','Copy','Paste','PasteFromWord','-','SpellChecker'],
       ['Undo','Redo','-','Find','Replace'],
       ['NumberedList','BulletedList','Outdent','Indent','Blockquote','RemoveFormat','Source'],
       ['Link','Unlink'],
       ['Ru','Table','HorizontalRule','SpecialChar'],
       '/',
       ['Bold','Italic','StrikeThrough','-','Subscript','Superscript'],
       ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
       ['Format','FontSize'],
       ['FitWindow','ShowBlocks'],
            ['Maximize', 'ShowBlocks','-','About','RU']
   ]  */
   config.extraPlugins = ['RevTitle'];
   
};

CKEDITOR.plugins.add( 'RevTitle',{ 
   init: function( editor ){
      editor.addCommand( 'insertRevTitle',{            
            exec : function( editor )
            {                
               editor.insertHtml( '<h2 class="text-uppercase mt-0">Sample<span class="text-theme-color-2"> Text</span></h2>' );
            }
     });
      editor.ui.addButton( 'RevTitle',{         
         label: 'Revival Heading Tag',         
         command: 'insertRevTitle',      
         icon: 'icons/h.png'
      });
   }
});

/* CKEDITOR.plugins.add( 'RevLI',{ 
   init: function( editor ){
      editor.addCommand( 'insertRevLI',{            
            exec : function( editor )
            {                
               editor.insertHtml( '<li><img src="http://localhost/laravel/rev/public/revival/images/list-icon.png">Sample</li>' );
            }
     });
      editor.ui.addButton( 'RevLI',{         
         label: 'Revival List Tag',           
         command: 'insertRevLI',      
         icon: 'icons/list-icon.png'
      });
   }
}); */

CKEDITOR.on( 'instanceReady', function( evt ) {
  evt.editor.dataProcessor.htmlFilter.addRules( {
    elements: {
      ul: function(el) { 
        el.addClass('list-img'); 
      }
    }
  });
});


CKEDITOR.on('dialogDefinition', function(ev) { 
    try { 
		var dialogName = ev.data.name; 
		var dialogDefinition = ev.data.definition; 
		if(dialogName == 'link') {  
			//var informationTab = dialogDefinition.getContents('target');  
			//var targetField = informationTab.get('linkTargetType'); 
			//targetField['default'] = '_blank'; 
			var informationTab = dialogDefinition.getContents('advanced');  
			var targetField = informationTab.get('advCSSClasses');
			targetField['default'] = 'btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20' 
		} 
    } catch(exception) { 
        alert('Error ' + ev.message); 
    }

});

 
