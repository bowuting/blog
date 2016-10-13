<?php

namespace app\index\model;
use think\Model;    // 使用前进行声明
use traits\model\SoftDelete;
/**
 *
 */
class PostsModel extends Model
{

    use SoftDelete;
    protected static $deleteTime = 'delete_time';

    protected $table = "blog_posts";


    static public function postContent($id){

        $data =  self::get($id);

        $arr  =  $data->toArray();
        $arr['update_time'] = date('Y-m-d H:i:s',$arr['update_time']);
        $arr['create_time'] = date('Y-m-d H:i:s',$arr['create_time']);
        return $arr;
    }



}


 ?>
