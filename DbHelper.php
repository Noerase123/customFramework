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

        return $string;
        // if (mysqli_query($this->conn, $string)) {

        //     return true;

        // } else {
        //     mysqli_error($this->conn);
        // }

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

    public function setAttribute($key, $value) {
        $string = '';

        $string = $key.' => '.$value;

        return $string;
    }

    public function attr($arrays) {

        $string = '';

        foreach ($arrays as $array => $value) {
            // $string .= $array.' => '.$value.', <br>';
            $string .= $this->setAttribute($array,$value).''; 
        }

        return $string;
    }

    public function user(array $type) {
        
        foreach ($type as $key => $value) {
            echo $value.'<br>';
        }
    }

}



?>