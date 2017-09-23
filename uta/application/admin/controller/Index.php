<?php
/**
 * @Author: 林夕
 * @Date:   2017-05-20 09:44:45
 * @Last Modified time: 2017-06-14 16:28:22
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;


class Index extends Controller
{
    public function index()
    {

        return $this->fetch();
    }


    /*验证用户是否登录,
    *未登录跳转到登录界面
    */
      public function __construct()
    {

      //调用父类构造函数
      parent::__construct();


      //验证用户是否登录

     if(!Admin::isLogin()){
      return $this->error('请先登录',url('Login/index'));
     }
    }






}
