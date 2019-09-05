<?php
class Image extends Helper
{

	function create_image( $dir, $file, $new_file, $width, $height, $proportional=true, $use_linux_command=false )
	{		
		// Target dimensions
		$max_width = $width;
		$max_height = $height;
			
		$info = getimagesize($dir.$file);
		$image = '';
		
		$final_width = 0;
		$final_height = 0;
		list($width_old, $height_old) = $info;
		
		if ($proportional) {
			// Get current dimensions
			$old_width  = $width_old;
			$old_height = $height_old;
			
			// Calculate the scaling we need to do to fit the image inside our frame
			$scale      = min($max_width/$old_width, $max_height/$old_height);
			
			// Get the new dimensions
			$final_width  = ceil($scale*$old_width);
			$final_height = ceil($scale*$old_height);
		}
		else {
			$final_width = $width;
			$final_height = $height;
		}
		
	
		switch ( $info['mime'] ) {
			case "image/jpeg":
				$image = imagecreatefromjpeg($dir.$file);	
			break;
			case "image/gif":
				$image = imagecreatefromgif($dir.$file);
			break;
			case "image/png":
				$image = imagecreatefrompng($dir.$file);
			break;	
			default:
				return false;
		}
		
		$image_resized = imagecreatetruecolor( $final_width, $final_height );
		imagecolortransparent($image_resized, imagecolorallocate($image_resized, 0, 0, 0) );
		imagealphablending($image_resized, false);
		imagesavealpha($image_resized, true);
		
		imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
		
		switch ( $info['mime'] ) {
			case "image/gif":
				imagegif($image_resized, $dir.$new_file);
			break;
			case "image/jpeg":
				imagejpeg($image_resized, $dir.$new_file, 100);
			break;
			case "image/png":
				imagepng($image_resized, $dir.$new_file, 9);
			break;
			default:
				return false;
		}
		
		return true;
	}
	

	function open_image($file) 
	{
		# JPEG:
		$img = @imagecreatefromjpeg($file);
		if ($img != 0) { return $img; }
	
		# GIF:
		$img = @imagecreatefromgif($file);
		if ($img != 0) { return $img; }
	
		# PNG:
		$img = @imagecreatefrompng($file);
		if ($img != 0) { return $img; }
	
		# GD File:
		$img = @imagecreatefromgd($file);
		if ($img != 0) { return $img; }
	
		# GD2 File:
		$img = @imagecreatefromgd2($file);
		if ($img != 0) { return $img; }
	
		# WBMP:
		$img = @imagecreatefromwbmp($file);
		if ($img != 0) { return $img; }
	
		# XBM:
		$img = @imagecreatefromxbm($file);
		if ($img != 0) { return $img; }
	
		# XPM:
		$img = @imagecreatefromxpm($file);
		if ($img != 0) { return $img; }
	
		# Try and load from string:
		$img = @imagecreatefromstring(file_get_contents($file));
		if ($img != 0) { return $img; }
	
		return false;
	}
	
	function save_image($file,$width,$height,$tumbwidth,$tumbheight,$upload_dir){
		$new_file = $file;
		$filename = $new_file['name'];
		$filename = str_replace(' ', '_', $filename);
		if($filename != ""){				
			$file_tmp = $new_file['tmp_name'];
			$ext = strtolower(strrchr($filename,'.'));	
			$unique_id = $this->unique_id();
			$new_filename = $unique_id.$ext;
			$new_filename_thumb = $unique_id.'_s'.$ext;
			$new_filename_t = 't_'.$unique_id.$ext;
			$imagename = $unique_id.$ext;

			if (move_uploaded_file($file_tmp,$upload_dir.$new_filename)){	
				$img_width 	=  $width;
				$img_height =  $height;
				$img_thumb_width 	= $tumbwidth;
				$img_thumb_height 	= $tumbheight;
			
				if ($this->create_image( $upload_dir, $new_filename, $new_filename, $img_width, $img_height, false, false) ){
					$this->create_image( $upload_dir, $new_filename, $new_filename_t, $img_thumb_width, $img_thumb_height, false, false);
					return $imagename;
				}else{	
					return '';
				}
			}
		}else{
			return '';
		}
	}

}
?>