<?php
namespace app\api\validate;


use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request =Request::instance();
        $param=$request->param();

        $result=$this->check($param);

        if(!$result){

            throw new \Exception($this->error);
        }else{
            return true;
        }
    }

    protected function is_user($value,$rule="",$data="",$field="")
    {
        if(!preg_match("/^[a-zA-Z0-9_]*$/", $value)){
            return false;
        }else{
            return true;
        }
    }

}