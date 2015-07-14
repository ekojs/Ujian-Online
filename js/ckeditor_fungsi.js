// untuk ckeditor
var kaji_editor = new Array();
function hapus_kaji_editor(div){
	if(kaji_editor[div])
		kaji_editor[div].destroy();
	}
function replaceDiv(div){
	hapus_kaji_editor(div);
	kaji_editor[div] = CKEDITOR.replace(div,
	{
		toolbar : 'MyToolbar',
		});
	CKFinder.setupCKEditor(kaji_editor[div],'js/ckfinder/');		
	}
