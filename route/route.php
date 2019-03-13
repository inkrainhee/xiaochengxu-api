<?php
//Login interface version v1 登录接口版本v1
use think\facade\Route;
Route::post('api/login', 'api/v1.Login/login');

