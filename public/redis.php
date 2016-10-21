<?php


 $redis = new Redis();
 if($redis->connect('127.0.0.1', 6379))
 echo "Connection to server sucessfully";
 //设置 redis 字符串数据
 $redis->set("tutorial-name", "Redis tutorial");
 // 获取存储的数据并输出
 echo "Stored string in redis:: " . $redis->get("tutorial-name");






 ?>
