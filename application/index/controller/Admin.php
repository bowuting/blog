<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use think\Db;
use app\index\model\PostsModel;  // 文章模型
use app\index\model\MessageModel;  // 留言模型
use app\index\model\LoginModel;  // denglu模型

class Admin extends Controller
{


        public  function index()
        {
        if(LoginModel::isLogin()) {

            $Posts = new PostsModel;
            $data = $Posts->order('post_id', 'desc')->paginate(10);
            $delete_data = PostsModel::onlyTrashed()->select();
            $this->assign('data', $data);
            $this->assign('delete_data', $delete_data);

            $Message = new MessageModel;
            $msgdata = $Message->order('msg_id', 'desc')->paginate(10);
            $delete_msg_data = MessageModel::onlyTrashed()->select();
            $this->assign('msgdata', $msgdata);
            $this->assign('delete_msg_data',$delete_msg_data);
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

        public function true_delete(){

            if (PostsModel::destroy($_GET['post_id'],true)) {
                return $this->success('彻底删除成功', url('index'));
            } else {
                return $this->error('彻底删除失败:');
            }
        }



        public function regain(){
            // $post = PostsModel::get($_GET['post_id']);
            // $post->delete_time=NULL;
            if (Db::table('blog_posts')->where('post_id', $_GET['post_id'])->update(['delete_time' => null])) {
                return $this->success('恢复成功', url('index'));
            } else {
                return $this->error('恢复失败:');
            }

        }
        public function msgdelete(){
            // var_dump(input('?get.post_id'));
            // print_r($_GET);
            // exit;
            //  var_dump(input('get.'));
            $post = MessageModel::get($_GET['post_id']);
            if ($post->delete()) {
                return $this->success('删除成功', url('index'));
            } else {
                return $this->error('删除失败:');
            }
        }

        public function true_msg_delete(){

            if (MessageModel::destroy($_GET['post_id'],true)) {
                return $this->success('彻底删除成功', url('index'));
            } else {
                return $this->error('彻底删除失败:');
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
