<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{

    public function index()
    {
        $html = $this->fetch();
        return $html;
    }



}
