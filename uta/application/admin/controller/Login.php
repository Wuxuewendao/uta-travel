<?php
/**
 * @Author: 林夕
 * @Date:   2017-06-13
 * @Last Modified time: 2017-06-14 19:12:49
 */
namespace app\admin\controller;
use think\Controller;
use think\Request;
use app\admin\model\Admin;


class Login extends Controller
{


    // 测试代码,生成默认密码
     // public function test(){
     //     echo Admin::encryptPassword('18018961046');
     // }



    //显示用户登录界面
    public function index()
    {
        return $this->fetch();
    }

    //登录逻辑
    public function doLogin()
   {
       //接受用户登录信息
       $postData = Request::instance()->post();



       if(Admin::login($postData['username'],$postData['password'])){

            return $this->success('登陆成功',url('/admin/index'));
        }else{
            return $this->error('用户名密码错误',url('/admin/login'));
        }

   }

    //注销操作
    public function loginOut()
    {
        if(Admin::loginOut())
        {
            return $this->success('注销成功',url('/admin/login'));
        }else{
            return $this->error('注销失败',url('/admin/index'));
        }
    }




}