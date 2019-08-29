<?php

class ViewClass extends DbHelper {
    
    public function selectAllData($table, $select_content = array()) {

        $selection = '*';
        // $selected = '';

        // $select_content ? $selection : $select_content ;

        if ($select_content != "") {
            $have_content = $select_content;
        }

        $result = implode(",", $have_content);

        if ($result) {
            
            $condition = $result;
        } else {
            $condition = $selection;
        }
        
        $select = "SELECT $condition FROM ".$table;

        $res = mysqli_query($this->conn,$select);

        return $res;
        // return $select;
    }

    public function selectTable($table) {
        
        $query = "SELECT * FROM $table";

        $getTable = mysqli_query($this->conn,$query);

        return $getTable;

    }

    public function selectWhere($table, $select_where) {

        $where_content = '';

        foreach ($select_where as $key => $value) {
            $where_content .= $key." = '".$value."' ";
        }


        $query = "SELECT * FROM ".$table." WHERE ".$where_content;

        return $query;
    }

}

?>