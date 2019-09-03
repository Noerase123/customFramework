<?php


class laravelLayout extends DbHelper {
    
    public function layout() {
        $layout = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
        </head>
        <body>

        '.$this->content().'
            
        </body>
        </html>
        ';

        return $layout;
    }

    public function content($code='') {
        return $code;
    }

    public function with($keybind, $valuebind) {

        $this->get = $keybind;
        $this->value = $valuebind;

        return true;
    }

    public function get_session($key_str) {

        $with_key = $this->get;
        $with_value = $this->value;

        if ($key_str == $with_key) {
            
            echo $with_value;
        }
    }

    public function interpolate($message, array $context = array())
    {
        $replace = array();
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }
    
        return strtr($message, $replace);
    }

    public function routeGet($url, $source='') {
    
        $get = $_GET;

        $get_url = $get[$url];
        
        if (isset($get_url)) {

            return header("location:".$source);
        }
    }

    public function routePost($data_arr){
        $post = $_POST;
        $data = '';

        // $post_data = $post[$submit];

        // if (isset($post_data)) {

            foreach ($data_arr as $key => $value) {
                $data .= $key." = ".$value." <br>";
            }
        return $data;
        // }
    }
}


?>