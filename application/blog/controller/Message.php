<?php
    namespace app\blog\controller;
    use think\Controller;   // 用于与V层进行数据传递
    use app\blog\model\PostsModel;  // 文章模型
    use app\blog\model\LoginModel;  // 登录模型
    use app\blog\model\MessageModel;  // 留言模型

    /**
     *
     */
    class Message extends Controller
    {
        public function index(){


            $message = new MessageModel;

            $datas = $message->order('update_time', 'desc')->paginate(3);
            $date = PostsModel::get_right_month();


            $this->assign('datas', $datas);

            $this->assign('date', $date);
            $htmls = $this->fetch();

            return $htmls;
        }
        public function messageAction(){

            $Message = new MessageModel($_POST);
            // print_r($_POST);
            if(!captcha_check($_POST['captcha'])){
                return $this->error('验证码错误');
            };

            // exit();
            if ($Message->allowField(true)->save()) {
                return $this->success('发表成功',url('message/index'));
            } else {
                return $this->error('发表失败');
            }

            // print_r($_POST);
        }

    }

?>
