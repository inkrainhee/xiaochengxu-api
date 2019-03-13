<?php
namespace app\api\validate;


class LoginValidate extends BaseValidate
{
    protected $rule = [
        'username'  => 'require|min:4|max:20|is_user',
        'password'   => 'require|min:4|max:20'
    ];

    protected $message  =   [
        'username.require' => '用户名不能为空',
        'password.require' => '用户名不能为空',
        'username.min' => '用户名的长度不能小于4',
        'username.max' => '用户名的长度不能大于20',
        'password.min' => '密码的长度不能小于4',
        'password.max' => '密码的长度不能大于20',
        'username.is_user' => '用户名必须包含字母、数字、下划线!'
    ];


}