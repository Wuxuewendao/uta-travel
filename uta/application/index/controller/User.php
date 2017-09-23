<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
//用户注册的登录控制器
//$rl用来控制跳转登录界面还是注册界面
//前期数据量较小,没有严格采用MVC模式
class user extends Controller
{

    //检查用户是否登录
    public function checkLogin(){
        if(!session('email')){
            $this->error('请先登录!','User/login');
        }
    }

    //用户注册
    public function reg(){
        if(session('email')){
            $this->error('你已经注册了','index/index');
        }
        if(request()->isPost()){
            $data=input('post.');
            // dump($data);die;
           // $validate=validate('user');
            $res=$this->validate($data,'User.reg');//验证器验证数据
            //dump($res);die;
            if(true !== $res){
                $this->error($res);
            }
            $datas=array();
             $datas['regtime']=time();
           $datas['email']=$data['email'];
           $datas['password']=sha1(md5($data['password']).'uta');//密码加密
            $datas['uname']='new';
           $result=db('user')->field('password,email,regtime,uname')->insert($datas);
           //$id1=db('user')->field('id','email')->find($datas['email']);
           // $session1=session('id',$id1['id']);
           session('email',$datas['email']);
           session('uname',$datas['uname']);
            if($result ){
                $this->success('注册成功','xxxgy');
            }else{
                $this->error('注册失败','reg');
            }
            return;
        }
        $rl[0]=1;
        $this->assign([
            'rl'=>$rl,
            ]);

        return view('login');
    }


    //用户登录
    public function login(){
        if(session('email')){
            $this->error('你已经登录了!','index/index');
        }

        if(request()->isPost()){
            $data=input('post.');
            $email=$data['email'];
            $user=db('user')->where(array('email'=>$email))->find();
            if($user){
                    $password=sha1(md5($data['password']).'uta');
                    $_password=$user['password'];
                    if($password == $_password){
                        session('email',$email);
                        session('uname',$user['uname']);
                        $this->success('登录成功','index/index');
                    }else{
                        $this->error('用户名密码错误','User/login');
                    }

            }else{
                $this->error('你还未注册','User/reg');
            }
        }
        $rl[0]=2;
        $this->assign([
            'rl'=>$rl,
            ]);
        return view('login');
    }

    //退出登录操作
    public function logout(){
        session(null);
        $this->success('退出成功!','index/index');

    }


    //用户信息展示页
    public function xxxgy(){
        $this->checkLogin();
        $email=session('email');
        if(request()->isPost()){
            $data=input('post.');
            $result=db('user')->where('email',$email)->update($data);
            if($result !== false){
                $this->success('保存成功!','User/xxxgy');
            }else{
                $this->error('保存失败!','User/xxxgy');
            }

        }
        //dump( $email);die;
        $userinfos=db('user')->where('email',$email)->find();
        //dump($userinfos);die;
        $this->assign([
            'userinfos'=>$userinfos,
            ]);
        return view('xxxgy');
    }

    //更换头像
    public function ghtx(){
        $this->checkLogin();
        $email=session('email');
        if(request()->isPost()){
              // $dataFile=$_FILES;
              // //dump($dataFile);die;
               $data=array();
              // $imgName=$dataFile['portrait']['name'];
              // //dump($imgName);die;
              // $data['portrait'] = $this->upload($imgName);
              $dataFile=$_FILES;
                foreach ($dataFile as $k => $v) {
                    if($v['name'] != ""){
                        $data[$k] = $this->upload($k);
                    }
                }
              $add=db('user')->where('email',$email)->update($data);
              if($add){
                $this->success('头像上传成功!','ghtx');
              }else{
                $this->error('头像上传失败','ghtx');
              }
        }
        //dump( $email);die;
        $userinfos=db('user')->where('email',$email)->find();
        //dump($userinfos);die;
        $this->assign([
            'userinfos'=>$userinfos,
            ]);


        return view('ghtx');
    }



      //重大bug,,程序原因,对上传的文件大小有要求,具体待定
    public function upload($imgName){
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file($imgName);
      // 移动到框架应用根目录/public/static/index/uploads/ 目录下
      $info = $file->move(ROOT_PATH . 'public' . DS . 'static/index/uploads');
      if($info){
        // 成功上传后 获取上传信息
        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
        return $info->getSaveName();
      }else{
        // 上传失败获取错误信息
       return '';
      }
    }

    //修改密码
    public function change(){
        $this->checkLogin();
        $email=session('email');
        if(request()->isPost()){
            $data=input('post.');

            $oldpassword=sha1(md5($data['oldpassword']).'uta');
            //dump($oldpassword);
            $_oldpassword=db('user')->field('password')->where('email',$email)->find();
             //dump($_oldpassword);die;
            if($oldpassword == $_oldpassword['password']){
                $res=$this->validate($data,'User.change');
                    //dump($res);die;
                if($res){

                    $datas=sha1(md5($data['password']).'uta');
                    $results=db('user')->where('email',$email)->setField('password',$datas);
                    session(null);
                    //dump($results);die;
                    if($results){
                        session(null);
                        $this->success('修改密码成功,请重新登录!','login');
                    }else{
                        $this->error('密码修改失败','User/change');
                    }

                }else{
                    $this->error($validate->getError());

                }

                return;
            }


        }
         $userinfos=db('user')->where('email',$email)->find();
        //dump($userinfos);die;
        $this->assign([
            'userinfos'=>$userinfos,
            ]);
        return view('change');
    }


    //申请成为导游页面
    public function sqym(){
        $this->checkLogin();
        $email=session('email');
        if(request()->isPost()){
            $data=input('post.');
            $data['status']=3;
            $data['sqtime']=time();
            $add=db('user')->where('email',$email)->update($data);
            if($add){
                $this->success('提交成功!','xxxgy');
            }else{
                $this->error('提交失败!','sqym');
            }
        }
        return view('sqym');
    }

    //导游详情展示页面
    public function dyxqzsy($id){
        db('user')->where('id',$id)->setInc('click');
        $dyxqzsy=db('user')->where('id',$id)->find();
         //底部旅游攻略推荐,推荐点击最多攻略
        $glArts=db('glarticle')->limit(8)->field('id,title,destination,type')->order('click desc')->select();
        //底部热门旅游景点推荐,推荐点击最多的
        $dbjdArts=db('jdarticle')->limit(4)->field('id,jdname,address')->order('click desc')->select();
        $this->assign([
            'dyxqzsy'=>$dyxqzsy,
            'glArts'=>$glArts,
            'dbjdArts'=>$dbjdArts,
            ]);


        return view('dyxqzsy');
    }

    //导游预览展示页
    public function dyzsy(){

        $dyzsy=db('user')->limit(9)->order('click desc')->where('status',2)->select();
        $this->assign([
            'dyzsy'=>$dyzsy,

            ]);
        return view('dyzsy');
    }

}
