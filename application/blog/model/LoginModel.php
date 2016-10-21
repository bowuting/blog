<?php

namespace app\blog\model;
use think\Model;    // 使用前进行声明


class LoginModel extends Model
{

    protected $table = 'blog_user';

    static public function login($arr){
        $arr['passwd'] = md5($arr['passwd']);
        $passwd = self::where('nick_name',$arr['name'])->value('passwd');
        if ($arr['passwd'] == $passwd) {
            session('name', $arr['name']);
            return true;
        } else {
            return false;
        }
    }

    static public function logout()
   {
       // 销毁session中数据
       session('name', null);
       return true;
   }

   /**
    * 判断用户是否已登录
    * @return boolean 已登录true
    * @author  panjie <panjie@yunzhiclub.com>
    */
   static public function isLogin()
   {
       $name = session('name');
       if (isset($name))
       {
           return true;
       } else {
           return false;
       }
   }
}










 ?>
