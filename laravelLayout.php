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
}


?>