<?php 


class DbHelper extends Db {

    public function create($tableName, $item_arr) {
        
        $string = "INSERT INTO $tableName (";
        $string .= implode(",", array_keys($item_arr)).") VALUES ('";
        $string .= implode("','", array_values($item_arr))."')";

        if (mysqli_query($this->conn,$string)) {

            return true;
        }
        else {
            mysqli_error($this->conn);
        }
        
    }

    public function update($tableName, $update_arr, $where) {
        $query = '';
        $where_to = '';

        foreach($update_arr as $key => $value) {
            $query .= $key ." = '".$value. "', "; 
        }

        foreach($where as $key => $value) {
            $where_to .= $key ." = ".$value. " "; 
        }
        
        $string = "UPDATE ".$tableName." SET $query WHERE ".$where_to."";

        if (mysqli_query($this->conn, $string)) {

            return true;

        } else {
            mysqli_error($this->conn);
        }

    }

    public function delete($table_name, $delete_arr) {

        $arr = '';
        foreach ($delete_arr as $key => $value) {
            $arr .= $key. " = '" .$value."'";
        }

        $string = "DELETE FROM ".$table_name.' WHERE '.$arr;

        if (mysqli_query($this->conn, $string)) {

            return true;

        } else {
            mysqli_error($this->conn);
        }

    }

    public function customQuery($query) {

        $this->result = mysqli_query($this->conn, $query);
        // $this->result = $query;

        return $this->result;
    }

}



?>