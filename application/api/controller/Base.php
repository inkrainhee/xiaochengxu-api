<?php
namespace app\api\controller;

use think\Request;

class Base
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->tokenAuthentication();
    }

    public function tokenAuthenticationHash()
    {
        $req           = $this->request;
        $param_all     = $req->post();             //All the parameters
        $timestamp     = $req->post("timestamp");  //Timestamp from client
        $token_client  = $req->post("token");      //Token from client
        $str='';
        foreach($param_all as $key=>$val){
            if($key!='token'&&$key!='timestamp'){
                $str.=$param_all[$key];
            }
        }
        
        $Hashcontrast=$this->HashSystem("check",$str.md5('#^@^#[mosng]').$param_all['timestamp'],$token_client);
        
        if(!$Hashcontrast){

            $this->ajaxError("非法数据来源");
        }

    }

    public function tokenAuthentication()
    {
        $req           = $this->request;
        $param_all     = $req->post();             //All the parameters
        $timestamp     = $req->post("timestamp");  //Timestamp from client
        $token_client  = $req->post("token");      //Token from client
        $str='';
        if(!$timestamp||!$token_client){
            $this->ajaxError("非法请求,您的ip已被记录");
        }
        foreach($param_all as $key=>$val){
            if($key!='token'&&$key!='timestamp'){
                $str.=$param_all[$key];
            }
        }

        $token_server=md5($str.md5('#^@^#[mosng]').$param_all['timestamp']);

        if($token_server!=$token_client){

            $this->ajaxError("非法数据来源");
        }

    }

    // 输出ajax错误
    public function ajaxError($info)
    {
        $this->response(-1, $info, null);
    }

    // 输出ajax成功
    public function ajaxSuccess($data = null,$info = '成功')
    {
        $this->response(1, $info, $data);
    }

    public function response($code, $message = '', $data = array())
    {
        if (!(is_numeric($code))) {
            return '';
        }
        $result = array(
            'code' => $code,
            'msg' => $message,
            'data' => $data
        );
        exit($this->ajaxReturn($result));
    }

    protected function ajaxReturn($data) {
        
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));     
    }
    /**
     * @name 名字
     * @abstract 申明变量/类/方法
     * @access 指明这个变量、类、函数/方法的存取权限
     * @author 函数作者的名字和邮箱地址
     * @category 组织packages
     * @copyright 指明版权信息
     * @const 指明常量
     * @deprecate 指明不推荐或者是废弃的信息
     * @example 示例
     * @exclude 指明当前的注释将不进行分析，不出现在文挡中
     * @final 指明这是一个最终的类、方法、属性，禁止派生、修改。
     * @global 指明在此函数中引用的全局变量
     * @include 指明包含的文件的信息
     * @link 定义在线连接
     * @module 定义归属的模块信息
     * @modulegroup 定义归属的模块组
     * @package 定义归属的包的信息
     * @param 定义函数或者方法的参数信息
     * @return 定义函数或者方法的返回信息
     * @see 定义需要参考的函数、变量，并加入相应的超级连接。
     * @since 指明该api函数或者方法是从哪个版本开始引入的
     * @static 指明变量、类、函数是静态的。
     * @throws 指明此函数可能抛出的错误异常,极其发生的情况
     * @todo 指明应该改进或没有实现的地方
     * @var 定义说明变量/属性。
     * @version 定义版本信息
     */
    public function HashSystem($type = null,$str = null,$param_token='')
    {
        // HashPassword  生成哈希值 HashPassword('password');
        // CheckPassword 对比哈希值 CheckPassword('password', $hashedPassword);  // true
        $PasswordHashs = new \PasswordHash(8, false);  
        if($type=='set'){
            $result = $PasswordHashs->HashPassword($str);    
        }else if($type=='check'){
            $result = $PasswordHashs->CheckPassword($str, $param_token);
        }else{
            $this->ajaxError("参数错误");
        }
        return $result;
    }

}
