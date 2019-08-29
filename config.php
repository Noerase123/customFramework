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

$str = 'hello {firstname}, welcome to the club!';

$person = array(
    'firstname' => 'Isaac',
);

echo $laravel->interpolate($str,$person);


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