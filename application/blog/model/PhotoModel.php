<?php

namespace app\blog\model;
use think\Model;    // 使用前进行声明
use traits\model\SoftDelete;

class PhotoModel extends Model
{


    use SoftDelete;
    protected static $deleteTime = 'delete_time';

    protected $table = "blog_photo";
}





?>
