<?php

// namespace framework;

class LaravelLayout extends DbHelper {
    
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

            foreach ($data_arr as $key => $value) {
                $data .= $key." = ".$value." <br>";
            }
        return $data;
        // }
    }

    public function push_notification($topic, $family_code){
        define( 'API_ACCESS_KEY', 'AAAADr_G3HM:APA91bG0SsbB9HjMxGCbq8_PC26N9RBmZXAEsoRM4e4O0VNQKBf2Dr2hpHQU_VDleqC1IhrtRYPa97TjTim-UTgUxyBkKXPzAcK169vaAC5f8LIiwx6w1bVcHVU5Th58vzXmPhiuUcEN');
        define('FIREBASE_URL', 'https://fcm.googleapis.com/fcm/send');
    
        $response = array(
              "condition"       => "'".$topic."' in topics ", 
              "priority"        => "high",
              "data"    => array(
                  "body"        => "Your comment has been ".$family_code.".",
                  "title"       => "Photo gallery",
                  
            )
        );
    
        $headers = array(
              'Authorization: key='.API_ACCESS_KEY,
              'Content-Type: application/json'
        );
    
        $context = curl_init();
        curl_setopt($context, CURLOPT_URL, FIREBASE_URL);
        curl_setopt($context, CURLOPT_POST, true);
        curl_setopt($context, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($context, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($context, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($context, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($context, CURLOPT_POSTFIELDS, json_encode($response));
    
        $result = curl_exec($context);
    
        return $result;
    
        curl_close( $context );
    
        $fields = json_encode($response);
        if ($result) {
            echo $fields . "<br>";
            echo "Successful API key: " . API_ACCESS_KEY;
        }
    }
}


?>