<?php
    namespace app\index\controller;
    use think\Controller;   // 用于与V层进行数据传递
    use app\index\model\PostsModel;  // 文章模型
    use app\index\model\LoginModel;  // 登录模型
    use app\index\model\MessageModel;  // 留言模型

    /**
     *
     */
    class Message extends Controller
    {
        public function index(){


            $message = new MessageModel;

            $datas = $message->order('update_time', 'desc')->paginate(3);
            $date = PostsModel::order('create_time', 'desc')->column('create_time');
            foreach ($date as $k => $v) {
                $date[$k] = date("Y/m",$v);
            }
            $this->assign('datas', $datas);

            $date = array_unique($date);

            $this->assign('date', $date);
            $htmls = $this->fetch();

            return $htmls;
        }
        public function messageAction(){

            $Message = new MessageModel;
            if ($Message->data($_POST)->save()) {
                return $this->success('发表成功',url('message/index'));
            } else {
                return $this->error('发表失败');
            }

            // print_r($_POST);
        }

    }

?>
