<?php
namespace app\index\validate;
use think\Validate;
//用户注册验证
class User extends Validate
{
    protected $rule = [

        'email' =>  'require|email|unique:user',
        //'accept'=>'accepted',
        'password'=>'require|min:6',
        'dopassword'=>'require|min:6|confirm:password',

        'uname'=>'require',
        'sex'=>'require',
    ];

    protected $message = [
        'email.require' =>  '邮箱不能为空',
        'email.email' =>  '邮箱格式错误',
        'email.unique' =>  '该邮箱已注册过',
        'accept.accepted'=>'请先阅读服务协议',
        'password.require' =>  '密码不能为空',
        'password.min' =>  '密码不能少于6位',
        'dopassword.min' =>  '确认密码不能少于6位',
        'dopassword.require' =>  '确认密码不能为空',
        'dopassword.confirm' =>  '两次输入的密码不同',
        'uname.require'=>'昵称不能为空',
        'uname.unique'=>'该昵称已被使用',

    ];

    protected $scene = [
        'reg'  =>  ['email','password','dopassword'],
        'change'  =>  ['password','dopassword'],
    ];

}
