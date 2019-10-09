<?php
session_start();
// sql config
define("DBHOST", "localhost");
define("DBUSER", "root");
define("DBPASS", "");
define("DBNAME", "db_custom");

include 'framework/Db.php';
include 'framework/DbHelper.php';
include 'framework/ViewClass.php';
include 'framework/laravelLayout.php';

// use framework\Db;
// use framework\DbHelper;
// use framework\ViewClass;
// use framework\LaravelLayout;

$db = new Db();
$dbhelper = new DbHelper();
$view = new ViewClass();
$laravel = new laravelLayout();

echo 'Configuration Activated <br>';

?>