<?php
/**
 * @Author: 林夕
 * @Date:   2017-05-20 09:44:45
 * @Last Modified time: 2017-06-14 16:28:06
 */
namespace app\admin\model;
use think\Model;
use think\captcha;
/**
 * 后台管理员模型
 */
class Admin extends Model
{
  /*密码加密算法
     *@param string  $password 加密前密码
     *@return string 加密后密码
     **/

     static public function  encryptPassword($password)
     {
        if(!is_string($password)){
            throw new \RuntimeException("传入变量类型字符串,错误码2",2);
        }
        return sha1(md5($password).'zijizhuang');
     }


      //登录方法
     static public function login($username,$password)
    {
     //验证用户名是否存在
         $map=array('username'=>$username);
         $Admin = self::get($map);

         if( !is_null($Admin) && $Admin->checkPassword($password) ){

             session('adminId',$Admin->getData('id'));
                return true;
         }else {
             return false;
         }

     }

   //检验密码
    public function checkPassword($password){
       if($this->getData('password') === $this::encryptPassword($password)){
        return true;
       }else{
        return false;
       }
     }

     /*注销操作
     *成功返回true,失败返回false
     */
    static function loginOut()
    {
        //销毁adminID中的数据
        session('adminId',null);
        return true;

    }


    //判断用户是否登录,
     static public function isLogin()
     {
        $adminId = session('adminId');

        if(isset($adminId)){
            return true ;
        }else
        {
            return false;
        }
     }
}