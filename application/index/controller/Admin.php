<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\index\model\PostsModel;  // 文章模型
use app\index\model\LoginModel;  // denglu模型

class Admin extends Controller
{


        public  function index()
        {
        if(LoginModel::isLogin()) {

            $Posts = new PostsModel;
            $data = $Posts->order('post_id', 'desc')->paginate(10);

            $this->assign('data', $data);

            $htmls = $this->fetch();

            return $htmls;

            } else {
                return $this->error('请先登录', url('login/index'));
            }

        }
        public function add(){
            if(LoginModel::isLogin()) {
            $htmls = $this->fetch();
            return $htmls;
            } else {
                return $this->error('请先登录', url('login/index'));
            }
        }

        public function insert(){
            $Posts = new PostsModel;
            if ($Posts->data($_POST)->save()) {
                return $this->success('发表成功',url('index/index'));
            } else {
                return $this->error('发表失败');
            }
        }

        public function delete(){
            // var_dump(input('?get.post_id'));
            // print_r($_GET);
            // exit;
            //  var_dump(input('get.'));
            $post = PostsModel::get($_GET['post_id']);
            if ($post->delete()) {
                return $this->success('删除成功', url('index'));
            } else {
                return $this->error('删除失败:');
            }
        }

        public function edit(){
            $arr = PostsModel::postContent($_GET['post_id']);
            // print_r($arr);
            $this->assign('arr',$arr);
            $htmls = $this->fetch();
            return $htmls;
        }

        public function update(){
            // print_r($_POST);
            $post = PostsModel::get($_POST['post_id']);
            $post->post_title     = $_POST['post_title'];
            $post->post_content    = $_POST['post_content'];
            if ($post->save()) {
                return $this->success('更新成功', url('index'));
            } else {
                return $this->error('更新失败:');
            }



        }



}
