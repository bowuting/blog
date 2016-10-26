<?php

namespace app\blog\model;
use think\Model;    // 使用前进行声明
use traits\model\SoftDelete;

require '../vendor/qiniu/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class PhotoModel extends Model
{


    use SoftDelete;
    protected static $deleteTime = 'delete_time';

    protected $table = "blog_photo";

    static public function upload($file){
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
                    $qiniuurl = "http://file.bowuting.com/";
                    $qiniuurl = $qiniuurl .  $info->getSaveName();
                    return $qiniuurl;
                } else {
                    return($err);
                }
            } else {
                // 上传失败获取错误信息
                return  $file->getError();
            }
    }
}





?>
