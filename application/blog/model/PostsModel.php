<?php

namespace app\blog\model;
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

    public function find_post4title($title){
        $data = self::where('post_title', 'like', '%' . $title . '%')->paginate(5);
        return $data;
    }
    public function find_all_posts(){
        $data = self::order('post_id', 'desc')->paginate(5);
        return $data;
    }

    static public function get_right_month(){
        $date = self::order('create_time', 'desc')->column('create_time');
        foreach ($date as $k => $v) {
            $date[$k] = date("Y/m",$v);
        }
        $date = array_unique($date);
        return $date;
    }

    static public function get_month_post($month){
        $all_data = self::all();  //得到所有文章的集合
        $ids = array();
        $date = array();
        $data = array();

        //得到 文章ID为key  Y/m日期格式的日期为value
        foreach ($all_data as $k => $v) {
            $k = $v->getData('post_id');
            $date[$k] = date("Y/m",$v->getData('create_time'));
        }


        //遍历$date  找到符合日期的文章  并追加到$ids
        foreach ($date as $k => $v) {
            if ($month == $v) {
                $ids[] = $k;
            }
        }

        //返回所有符合日期的文章
        $data = self::all($ids);
        return $data;
    }



    // static public function postContent($id){
    //
    //     $data =  self::get($id);
    //
    //     $arr  =  $data->toArray();
    //     $arr['update_time'] = date('Y-m-d H:i:s',$arr['update_time']);
    //     $arr['create_time'] = date('Y-m-d H:i:s',$arr['create_time']);
    //     return $arr;
    // }



}


 ?>
