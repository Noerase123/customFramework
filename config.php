<?php
session_start();
// sql config
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "db_custom");

include 'Db.php';
include 'DbHelper.php';
include 'ViewClass.php';
include 'laravelLayout.php';

$db = new Db();
$dbhelper = new DbHelper();
$view = new ViewClass();
$laravel = new laravelLayout();

echo fn_push_notification_comment_approval('awtvgaewfcawefawefcawe','2q3c52a35rcs2345rs3');

function fn_push_notification_comment_approval($topic, $family_code){
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

    $data1 = str_replace('{',' ',$result);

    $data_in = str_replace('}',' ',$data1);

    $data = explode(':',$data_in);

    return $data[0].' : '.$data[1];
    // $ex_data = explode(':',$result);

    // return $result;

    curl_close( $context );

    // $fields = json_encode($response);
    // if ($result) {
    //     echo $fields . "<br>";
    //     echo "Successful API key: " . API_ACCESS_KEY;
    // }
}
echo '<br>';

$name = 'relationship Blatus vsgain awdaw';

$str = explode(' ', $name);

if ($str >= 2) {

    foreach ($str as $key => $value) {
        $substr = substr($value,0,1);
        $full = ucfirst($substr);
        echo $full;
    }

}

// $date = '2019-10-20';

// $dar = explode('-',$date);

// echo $dar[0];
// echo '<br>';
// echo $dar[1];
// echo '<br>';
// echo $dar[2];

// $type = array();
// $type['ofw'] = 'OFW';
// $type['family'] = 'Family';
// $type['admin'] = 'Admin';

// $types = ['OFW','Family','Admin'];

// $dbhelper->user($type);

// echo 'type inserted to be "'.$type['admin'].'"';

// $message = "User {username} created";

// $context = array('username' => 'bolivar');

// echo interpolate($message, $context);

// @if ($message = Session::get('success'))
// <div class="alert alert-success">
//     <p>{{ $message }}</p>
// </div>
// @endif

// echo $laravel->layout();

// echo $laravel->content(
//     '<h1>Hello World</h1>'
// );

// $arr = array('username');

// $res = $view->selectAllData("tbl_user",$arr);

// foreach($res as $row) {
//     echo $row['username'].'<br>';
// }

// $arr = array();

// $id = 123;
// $username = 'admin';
// $password = 'admin';
// $firstname = 'John Isaac';

// $arr['id'] = $id;
// $arr['username'] = $username;
// $arr['password'] = $password;
// $arr['firstname'] = $firstname;

// echo $dbhelper->create("table",$arr);

// $arr = array();
// $arr['username'] = $username;
// $arr['password'] = $password;
// $arr['firstname'] = $firstname;

// $where = array();
// $where['id'] = 123123;

// echo $dbhelper->update("tbl_user",$arr, $where);

// echo '<br><br>';

// echo $dbhelper->delete("tbl_data", $where);

?>