<?php
class Scaffold
{

	function radio_arr($options=array(), $values=array(), $name="", $selected_value="", $separator="", $other_attributes="")
	{
		$output = '';
		$id = '';
		$i = 0;
		foreach ($values as $value) {
			$check = $selected_value==$value ? 'checked="checked"' : '';
			$output .= "<input class=\"left\" type=\"radio\" name=\"$name\" id=\"$name"."_".$i."\" value=\"$values[$i]\" $check $other_attributes /> <label class=\"left\">".$separator.$options[$i].$separator."</label>\r\n";
			$i++;
		}
		return $output;
	}

	function checkbox($option="",$value="",$name="",$id="",$selected_value, $other_attributes="",$separator="")
	{
		$output = '';
		$check = $selected_value > 0 ? 'checked="checked"' : '';
		$output = "<input class=\"left\" type=\"checkbox\" name=\"$name\" id=\"$id\" value=\"$value\" $check $other_attributes /> <label class=\"left\">".$option." ".$separator."</label>\r\n";
		return $output;
	}


	function dropdown_option($option,$value,$selected=false)
	{
		$select_value = $selected==true ? "selected=\"selected\"" : '';
		return "<option value=\"$value\" $select_value >$option</option>\r\n";
	}


	function dropdown($name,$options,$other_attr)
	{
		return "<select name=\"$name\" id=\"$name\" $other_attr >\r\n$options\r\n</select>\r\n";
	}

	
	function dropdown_rs($rs,$value_display=array(),$name="",$selected_value="",$select_text="",$other_attributes="")
	{	
		$selectopt_tmp = ($selected_value==0 || $selected_value=='') ? "selected=\"selected\"" : '';		
		$output = "";
		$output .= "<select name=\"$name\" id=\"$name\" $other_attributes >\r\n";	
		$output .= "    <option value=\"\" $selectopt_tmp>- $select_text -</option>\r\n";

		if ($rs)
		{
			foreach ($rs as $row)
			{
				$select_option = "";
				if ($selected_value > 0) {				
					if ($row->$value_display['value'] == $selected_value) {
						$select_option = "selected=\"selected\"";
					}
				}
				$output .= "    <option value=\"".$row->$value_display['value']."\" $select_option >".$row->$value_display['display']."</option>\r\n";	
				$i++;
			}
		}
		$output .= "</select>\r\n";
		return $output;
	}

	function dropdown_arr($options=array(), $values=array(), $name="", $selected_value=NULL, $select_text="", $other_attributes="")
	{	
		$selectopt_tmp = ($selected_value==0 || $selected_value=='') ? "selected=\"selected\"" : '';		
		$output = "";
		$output .= "<select name=\"$name\" id=\"$name\" $other_attributes >\r\n";	
		$output .= "    <option value=\"\" $selectopt_tmp>$select_text</option>\r\n";
		
		if ($values)
		{
			$i = 0;	
			foreach ($values as $value)
			{
				$select_option = "";
				if ($selected_value > 0) {				
					if ($values[$i] == $selected_value) {
						$select_option = "selected=\"selected\"";
					}
				}
				$output .= "    <option value=\"$values[$i]\" $select_option >$options[$i]</option>\r\n";	
				$i++;
			}
		}
		$output .= "</select>\r\n";
		return $output;
	}
	
}
?>