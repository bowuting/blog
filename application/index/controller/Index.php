<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\index\model\PostsModel;  // 文章模型
use app\index\model\LoginModel;  // 登录模型

class Index extends Controller
{
    public function index()
    {
        $htmls = $this->fetch();

        return $htmls;
    }

    public function allpost()
    {

        $Posts = new PostsModel;
        if (isset($_POST['find'])) {
            // print_r($_POST);
            $find = $_POST['find'];
            $data = $Posts->where('post_title', 'like', '%' . $find . '%')->paginate(5);
            //  print_r($data);
             if($data->isEmpty()){
                 $this->error('找不到您所查找的内容');
             }

        } else {
            $data = $Posts->order('post_id', 'desc')->paginate(5);
        }



        $this->assign('data', $data);



        $htmls = $this->fetch();

        return $htmls;
    }

    public function post(){

        $data = PostsModel::get($_GET['post_id']);
        // print_r($data);
        // echo $data->post_content;
        // exit();
        // $arr = PostsModel::postContent($_GET['post_id']);
        // print_r($arr);
        $this->assign('data',$data);
        $htmls = $this->fetch();

        return $htmls;

    }

    public function find(){

        }

    public function photo(){
        $htmls = $this->fetch();

        return $htmls;
    }

    public function about(){
        $htmls = $this->fetch();

        return $htmls;
    }




}
