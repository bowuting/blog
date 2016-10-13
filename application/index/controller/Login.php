<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\index\model\PostsModel;  // 文章模型
use app\index\model\LoginModel;  // denglu模型


/**
 *
 */
class Login extends Controller
{
    
    public function index(){

        if (LoginModel::isLogin()) {

            return $this->success('login success', url('admin/index'));
        } else {
            $htmls = $this->fetch();
            return $htmls;
        }
    }
    public function login(){
        //print_r($_POST);
        if (LoginModel::login($_POST)) {
            return $this->success('login success', url('admin/index'));
        } else {
            return $this->error('username or password incorrent', url('index'));
        }
    }

}


 ?>
