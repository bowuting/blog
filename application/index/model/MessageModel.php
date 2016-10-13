<?php

namespace app\index\model;
use think\Model;    // 使用前进行声明


/**
 *
 */
class MessageModel extends Model
{
    protected $table = "blog_message";

    
    public function dataFmart($data){
        $array = $data->toArray();

        $array = $array['data'];
        foreach ($array as $k => $v) {
            $array[$k]['update_time'] = date('Y-m-d H:i:s',$v['update_time']);
            $array[$k]['post_content'] = substr($v['post_content'],0,280).'...';
            $array[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }
        return $array;
    }


    static public function postContent($id){

        $data =  self::get($id);

        $arr  =  $data->toArray();
        $arr['update_time'] = date('Y-m-d H:i:s',$arr['update_time']);
        $arr['create_time'] = date('Y-m-d H:i:s',$arr['create_time']);
        return $arr;
    }



}


 ?>
