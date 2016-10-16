<?php

require './php-sdk/autoload.php';
// require './php-sdk/vendor/autoload.php';
use Qiniu\Auth;
// use Qiniu\Storage\UploadManager;

$bucket = 'qingdao';
$accessKey = '3qi3glFmW7EAyOntSc6E2TXF2pNxHw4QMT_8VDik';
$secretKey = 'mS4Zp_UCgNWeqBme3zscUVPlbift44GNsSinMQBm';


$auth = new Auth($accessKey, $secretKey);

// var_dump($auth);



 $token = $auth->uploadToken($bucket);
 echo $token;
 // $uploadMgr = new UploadManager();
// echo "string";





 ?>
