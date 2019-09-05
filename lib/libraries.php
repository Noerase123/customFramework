<?php
require ( 'sql.class.php' );
include ( 'sql.helper.class.php' );
require ( 'string.class.php' );
require ( 'helper.class.php' );
require ( 'scaffold.class.php' );
require ( 'hash.crypt.class.php' );
require ( 'image.class.php' );
require ( 'curl.helper.class.php' );
require ( 'form.class.php' );

$db = new db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$sql_helper = new SQLHelper(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
$curlhelper = new CurlHelper;
$string = new String;
$helper = new Helper;
$scaffold = new Scaffold;
$crypt = new hash_encryption(ENCRYPT_KEY);
$image = new Image;
$form_object = new Form_object;
?>