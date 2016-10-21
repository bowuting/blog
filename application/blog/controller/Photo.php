<?php
namespace app\blog\controller;
use think\Controller;   // 用于与V层进行数据传递
use app\blog\model\PostsModel;  // 文章模型
use app\blog\model\LoginModel;  // 登录模型
use app\blog\model\PhotoModel;
use think\Db;
require '../vendor/qiniu/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class Photo extends Controller
{
    public function index(){


            $data = Db::table('blog_photo_cat')->column('photo_cat_name');
            // var_dump($data);
            $this->assign('data',$data);



        $htmls = $this->fetch();

        return $htmls;





        //  $this->assign('token',$token);


    }

    public function add_cat()
    {
        if (LoginModel::isLogin()) {
            if (Db::table('blog_photo_cat')->insert($_POST)) {
                return $this->success("新建成功 ",url('index'));
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

            $path = ROOT_PATH . 'public' . DS . 'uploads/';

            $info = $file->rule('md5')->move($path);
            if($info){

                    $accessKey = '3qi3glFmW7EAyOntSc6E2TXF2pNxHw4QMT_8VDik';
                    $secretKey = 'mS4Zp_UCgNWeqBme3zscUVPlbift44GNsSinMQBm';

                    $auth = new Auth($accessKey, $secretKey);
                    $bucket = 'qingdao';

                    $token = $auth->uploadToken($bucket);
                    $filePath = $path . $info->getSaveName();
                    $key = $info->getSaveName();

                    $uploadMgr = new UploadManager();
                    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
                    if ($err == null) {
                        // var_dump($ret);
                        $qiniu = "http://file.bowuting.com/";
                        $qiniu = $qiniu .  $info->getSaveName();
                        // echo $qiniu;
                        //

                        $photo = new PhotoModel;
                        $photo->photo_cat = $_POST['cat'];
                        $photo->photo_url = $qiniu;
                        $photo->photo_name = $_POST['photo_name'];
                        $photo->photo_content = $_POST['photo_content'];
                        if ($photo->save()) {
                            return $this->success('上传成功',url('photo?cat=') .$_POST['cat'] );
                        }

                    } else {
                        var_dump($err);
                    }
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            } else {
                return $this->error('您没有登录 不能添加照片');
            }
    }

}

?>
