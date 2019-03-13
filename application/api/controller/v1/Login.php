<?php
namespace app\api\controller\v1;

use app\api\validate\LoginValidate;
use app\api\controller\Base;
use think\Db;

class Login extends Base
{
    public function login()
    {
        (new LoginValidate())->goCheck();
        $req=$this->request;
        $username=$req->post('username');
        $password=$req->post('password');
        Db::table("test")->insert(array('cen'=>$username));
        $member=Db::table("members");
        $whether_User_Exists=$member->where("username",$username)->find();
        if(!$whether_User_Exists){
            $this->ajaxError("请检查用户名是否正确");
        }
        if($whether_User_Exists['password']!=md5($password)){
            $this->ajaxError("请检查密码是否正确");
        }

        $this->ajaxSuccess(array("code"=>1,"msg"=>"登录成功"));
        /*$data=[
            'username'=>$username,
            'password'=>md5($username),
        ];
        $member->where();*/
    }
}
