<?php
/**
 * Created by PhpStorm.
 * User: Mosng
 * Date: 2019/3/2
 * Time: 10:45
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Banner extends Controller
{
    public function listBanner()
    {
        return $this->fetch();
    }

    public function getBanner()
    {
        $data=Db::table("banner")->select();
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
    }
}