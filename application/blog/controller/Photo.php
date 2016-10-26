<?php
namespace app\blog\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\blog\model\PostsModel;  // 文章模型
use app\blog\model\LoginModel;  // 登录模型
use app\blog\model\PhotoModel;
use think\Db;

class Photo extends Controller
{
    public function index(){


            // $data = Db::table('blog_photo_cat')->column('photo_cat_name');
            $data = Db::table('blog_photo_cat')->select();
            // var_dump($data);
            // exit();
            $this->assign('data',$data);



        $htmls = $this->fetch();

        return $htmls;





        //  $this->assign('token',$token);


    }

    public function add_cat()
    {
        if (LoginModel::isLogin()) {

            $file = request()->file('cat_img');
            if ($file) {
                $qiniuurl = PhotoModel::upload($file);
                $_POST['photo_cat_url'] = $qiniuurl;


                if (Db::table('blog_photo_cat')->insert($_POST)) {

                    return $this->success("新建成功 ",url('index'));
                }
            } else {
                return $this->error('您没有选择文件 不能新建相册');
            }


            // print_r($_POST);
        } else {
            return $this->error('您没有登录 不能新建相册');
        }

    }

    public function photo(){

        $data = DB::table('blog_photo')->where('photo_cat','=',$_GET['cat'])->select();
        // print_r($data);

        $this->assign('data',$data);
        $html = $this->fetch();
        return $html;
        // $photo = new PhotoModel;
        // 统计数量 Db::table('blog_photo')->count('photo_cat');


    }

    public function add()
    {
        if (LoginModel::isLogin()) {
            // print_r($_GET);

            $html = $this->fetch();
            return $html;
            // print_r($_POST);
        } else {
            return $this->error('您没有登录 不能添加照片');
        }

    }
    public function upload(){
        if (LoginModel::isLogin()) {

            // print_r($_POST['cat']);
            // exit();
            $file = request()->file('image');
            if ($file) {
                $qiniuurl = PhotoModel::upload($file);
            } else {
                return $this->error('您没有选择照片 不能添加照片');
            }


            if ($qiniuurl) {
                $photo = new PhotoModel;
                $photo->photo_cat = $_POST['cat'];
                $photo->photo_url = $qiniuurl;
                $photo->photo_name = $_POST['photo_name'];
                $photo->photo_content = $_POST['photo_content'];
                if ($photo->save()) {
                    return $this->success('上传成功',url('photo?cat=') .$_POST['cat'] );
                } else {
                    echo $file->getError();
                }
            } else {
                return $this->error('您没有登录 不能添加照片');
            }
    }
    }
}

?>
