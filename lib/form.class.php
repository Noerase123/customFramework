<?php
class Form_object extends Scaffold
{
	function req_field($is_editable_field,$req){
		return $is_editable_field&&$req?'<span class="required">*</span>':'';
	}
	function image($label,$field,$is_editable_field,$data,$width,$height,$image_support,$req,$upload_dir,$note){
	
		$req_fld = $this->req_field($is_editable_field,$req);
		
		if($data==""){
			$data = "<img class='img img-responsive' src='".BASE_URL."img/header-logo-small.png' />";
		}else{
			$data = "<img class='img img-responsive' src='".BASE_URL.$upload_dir.$data."' height=200 />";
		}
		
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
		
		$string .= "<label for=\"".$field."\">".$label." ".$req_fld."&nbsp;&nbsp;</label>";
		$string .= $data;
		$string .= $note;
		
		$string .= '<div class="full-width">';
		$string .= '<b>REQUIRED SIZE: </b>';
		$string .= '<span style="">Height: '.$height.'px</span>';
		$string .= '<span style="">Width: '.$width.'px</span><br />';
		$string .= '<b>REQUIRED FILE TYPE: </b>';
		$string .= '<span style="">'.$image_support.'</span>';
		$string .= '</div>';
		$string .= '<input name="'.$field.'" id="'.$field.'" type="file" size="31" class="left" />'.$note;
		$string .= '<span class="validation-status"></span>';
		
		}else{
		
		$string .= $data;
		
		}
		$string .= "</div>";
		
		
		return $string;
	}
	function ckeditor($label, $field, $is_editable_field, $data, $req, $max, $note){
		
		$req_fld = $this->req_field($is_editable_field,$req);
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		
		if($is_editable_field){
			$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
			$string .= "<textarea class=\"form-control ".$field."\" id=\"".$field."\" name=\"".$field."\" rows=\"10\" cols=\"70\" maxlength=\"".$max."\" />".$data."</textarea>";
			$string .= $note;
			$string .= '<span class="validation-status"></span>';
		}
		else{
			$string .= "<strong>".$label."</strong>: ".$data;
		}
		$string .= "</div>";
		
		return $string;
	}
	
	function input_text($label,$field,$is_editable_field,$data,$req,$max,$class,$note,$password){
	
		$req_fld = $this->req_field($is_editable_field,$req);
		
		$string = "";
		$string .= "<div class=\"form-group\">";

		if($is_editable_field){
			
		if($field == 'password' || $field == 'confirmpassword'){
				
				$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
				$string .= "<input type=\"password\" class=\"form-control ".$class."\" id=\"".$field."\" name=\"".$field."\" value=\"".$password."\" maxlength=\"".$max."\" />";		
				$string .= $note;
				$string .= '<span class="validation-status"></span>';		
			}
		else if($field == 'module_url' || $field == 'meta_page'  ){
			
			$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
			$string .= "<input type=\"text\" class=\"form-control ".$class."\" id=\"".$field."\" name=\"".$field."\" value=\"".$data."\" maxlength=\"".$max."\" readonly/>";		
			}
		else{
			
			$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
			$string .= "<input type=\"input\" class=\"form-control ".$class."\" id=\"".$field."\" name=\"".$field."\" value=\"".$data."\" maxlength=\"".$max."\" />";
			$string .= $note;
			$string .= '<span class="validation-status"></span>';
			}
		
		}
		else{
		if($field == 'password' || $field == 'confirmpassword'){
			$string .= "<tr><td><strong>".$label."</strong>:</td><td>".$password."</td></tr>";
		}
		else{
			$string .= "<tr><td><strong>".$label."</strong>:</td><td>".$data."</td></tr>";
		}
		}
		$string .= "</div>";
	
		return $string;
	}
	
	function color_picker($label,$field,$is_editable_field,$data,$req,$max,$class,$note,$password){
	
		$req_fld = $this->req_field($is_editable_field,$req);
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
				$string .= "<div class=\"col-sm-6\">";
				$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
				$string .= "<input type=\"input\" class=\"form-control ".$class."\" id=\"".$field."\" name=\"".$field."\" value=\"".$data."\" maxlength=\"".$max."\"/>";
				$string .= $note;
				$string .= '<span class="validation-status"></span>';
				$string .= "</div>";
		}
		$string .= "</div>";
	
		return $string;
	}
	
		function text_box($label, $field, $is_editable_field, $data, $req, $max, $note){
		
		$req_fld = $this->req_field($is_editable_field,$req);
		
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
		
		$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
		$string .= "<textarea class=\"form-control ".$field."\" id=\"".$field."\" name=\"".$field."\" rows=\"10\" cols=\"70\" maxlength=\"".$max."\" />".$data."</textarea>";
		$string .= $note;
		$string .= '<span class="validation-status"></span>';
		
		}
		else{
		$string .= "<strong>".$label."</strong>: ".$data;
		
		}
		$string .= "</div>";
		
		return $string;
	}	
	function input_password($password,$varkey){
			$passwordcrypt 	= new hash_encryption($varkey);
			$data = $passwordcrypt->decrypt($password);	
		return $data;
	}
	

	function select($label,$field,$is_editable_field,$data,$value,$req,$max,$class,$note){
	
		$req_fld = $this->req_field($is_editable_field,$req);
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
		
		$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
		$string  .= "<select class='form-control'><option value=".$value.">".$data."</option></select>";
		$string .= $note;
		$string .= '<span class="validation-status"></span>';
		
		}else{
		
		$string .= "<strong>".$label."</strong>: ".$data;
		
		}
		$string .= "</div>";
	
		return $string;
	}

	function select_array($is_editable_field, $data=array(), $field, $label,$req,$fieldname){
		
		$req_fld = $this->req_field($is_editable_field,$req);
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		
		if($is_editable_field){
		$string .= "<label for=\"".$field."\">".$label." ".$req_fld."</label>";
		$string .= "<select class='form-control' name='".$fieldname."'>";

		foreach($data as $key => $value){			
				$field == $key ? $string .= "<option value=".$key." selected>".$value."</option>" :$string .= "<option value=".$key.">".$value."</option>" ;
			}
		$string .= "</select>";
		$string .= '<span class="validation-status"></span>';
		}
		else{
			foreach($data as $key => $value){			
				$field == $key ? $string .= "<tr><td><strong>".$label."</strong>:</td><td>".$value."</td></tr>" : $string .= "" ;
			}
		}
		$string .= "</div>";
	
		return $string;
	}
	
	function enabled($is_editable_field,$mode,$data,$table_name,$note){
		
		$enabled = $mode=='add' ? 1 : $data;
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
		
		$string .= "<label for=\"enabled\">Enabled</label>&nbsp;&nbsp;";
		
		$table_name == "tbl_listing" ? $string .= $this->radio_arr($options=array('Yes','No'), $values=array(1, 0), "enabled", $enabled, "&nbsp;&nbsp;&nbsp;", $other_attributes="style='border:0;'") : $string .= $this->radio_arr($options=array('Yes','No'), $values=array(1, 0), "activated", $enabled, "&nbsp;&nbsp;&nbsp;", $other_attributes="style='border:0;'");
		
		$string .= $note;
		$string .= '<span class="validation-status"></span>';
		
		}else{
		
		$string .= $enabled==1?'<tr><td><strong>Enabled:</strong></td><td> Yes </td></tr>':'<tr><td><strong>Enabled:</strong></td><td> No</td></tr>';
		
		}
		$string .= "</div>";
		
		return $string;
		
	}
	function default_smtp($is_editable_field,$mode,$data,$table_name,$note){
		
		$enabled = $mode=='add' ? 1 : $data;
		
		$string = "";
		$string .= "<div class=\"form-group\">";
		if($is_editable_field){
		
		$string .= "<label for=\"enabled\">Use my SMTP?</label>&nbsp;&nbsp;";
		
		$table_name == "tbl_listing" ? $string .= $this->radio_arr($options=array('Yes','No'), $values=array(1, 0), "enabled", $enabled, "&nbsp;&nbsp;&nbsp;", $other_attributes="style='border:0;'") : $string .= $this->radio_arr($options=array('Yes','No'), $values=array(1, 0), "activated", $enabled, "&nbsp;&nbsp;&nbsp;", $other_attributes="style='border:0;'");
		
		$string .= $note;
		$string .= '<span class="validation-status"></span>';
		
		}else{
		
		$string .= $enabled==1?'<tr><td><strong>Enabled:</strong></td><td> Yes </td></tr>':'<tr><td><strong>Enabled:</strong></td><td> No</td></tr>';
		
		}
		$string .= "</div>";
		
		return $string;
		
	}
	
	function ckeditorscript($field){
		
		$script = "
		window.onload = function()
		{
		CKEDITOR.replace('".$field."',
		{
		filebrowserBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor',
		filebrowserImageBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor&filter=image',
		filebrowserFlashBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor&filter=flash',
		toolbar :
		[
		['Source','-','Maximize','-','Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','SpecialChar'],
		'/',
		['Format','-','Undo','Redo','-','Font','-','FontSize','-','TextColor','BGColor','-','Link','Unlink','Anchor','-','Table','HorizontalRule']
		]
		});
		}";
		
		return $script;
	}
	function ckeditorscriptmultiple($field){
		
		$script = "

		CKEDITOR.replace('".$field."',
		{
		filebrowserBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor',
		filebrowserImageBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor&filter=image',
		filebrowserFlashBrowseUrl : 'plug/ckeditor/plugins/filebrowser/index.php?editor=ckeditor&filter=flash',
		toolbar :
		[
		['Source','-','Maximize','-','Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','SpecialChar'],
		'/',
		['Format','-','Undo','Redo','-','Font','-','FontSize','-','TextColor','BGColor','-','Link','Unlink','Anchor','-','Table','HorizontalRule']
		]
		});";
		
		return $script;
	}
	
	function custom_substr($character, $length){
		if(strlen($character) >= $length){
			echo substr($character, 0, $length)."...";
		}
		else{
			echo $character;
		}
		
		
	}	
	
	//function custom_description($){
		
	//}
}


?>