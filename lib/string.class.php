<?php
class String
{
	function sql_safe($var = "")
	{
		if( ! isset($var) )
		{
			$var = "";
		}
		
		$var = trim($var);
		$var = str_replace("'","'",$var);
		$var = stripslashes($var);
		$var = mysql_escape_string($var);
		return $var;
	}

	/******************************************************************************************************************
	'' @DESCRIPTION: 	Makes a string javascript persistent. Changes special characters, etc.
	'' @DESCRIPTION:	using this function it has to be possible to pass any string which should be 
	''					executed in a javascript later. example: you want to execute the following
	''					onclick="obj.value='" & usrInput & "'. so in this case usrInput needs to be validated that no
	''					javascript error happens when he/she enters e.g. a '.
	'' @PARAM:			val [string]: the value which needs to be encoded
	'' @RETURN:			[string] encoded string which can be used within javascript strings.
	'******************************************************************************************************************/
	function js_encode($val)
	{
		$val = $val . "";
		$tmp = str_replace(chr(92), "\\", $tmp);
		$tmp = str_replace(chr(39), "\'", $val);
		$tmp = str_replace(chr(34), "&quot;", $tmp);
		$tmp = str_replace(chr(13), "<br>", $tmp);
		$tmp = str_replace(chr(10), " ", $tmp);
		return $tmp;
	}

	
	function grid_safe($val)
	{
		$output = '';
		$val = addslashes($val);
		$output = htmlspecialchars($val . "");
		$output = str_replace("'", "&#39;",$output);
		$output = $this->js_encode($output);
		return $output;
	}

}
?>