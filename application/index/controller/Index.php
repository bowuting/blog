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

            $title = $_POST['find'];
            $data = $Posts->find_post4title($title);

             if($data->isEmpty()){
                 $this->error('找不到您所查找的内容');
             }

        } else {
            $data = $Posts->find_all_posts();
        }

        $date = PostsModel::get_right_month();

        $this->assign('data', $data);
        $this->assign('date', $date);

        $htmls = $this->fetch();
        return $htmls;
    }

    public function month_post(){

        $data = PostsModel::get_month_post($_GET['month']);
        $date = PostsModel::get_right_month();

        $this->assign('date', $date);
        $this->assign('data', $data);
        $htmls = $this->fetch();

        return $htmls;
    }

    public function post(){

        $data = PostsModel::get($_GET['post_id']);

        $this->assign('data',$data);
        $htmls = $this->fetch();

        return $htmls;

    }

    public function photo(){
        $date = PostsModel::get_right_month();

        $this->assign('date', $date);

        $htmls = $this->fetch();



        return $htmls;
    }

    public function about(){
        $htmls = $this->fetch();

        return $htmls;
    }




}
