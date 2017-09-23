<?php
namespace app\index\controller;
use think\Controller;
//旅游推荐控制器控制器
class Lygl extends Controller
{

    public function index($id)
    {
        db('glarticle')->where('id',$id)->setInc('click');
        $lygl=db('glarticle')->find($id);

        $rmjdArts=db('jdarticle')->limit(10)->field('id,jdname,address')->order('click desc')->select();
        $rmglArts=db('glarticle')->limit(10)->field('id,title')->order('click desc')->select();


        //上一篇下一篇的实现
        $lastgl=db('glarticle')->where('id','<',$id)->order('id desc')->limit(1)->field('id,title')->find();
        $nextgl=db('glarticle')->where('id','>',$id)->order('id asc')->limit(1)->field('id,title')->find();

        //标签展示



        $this->assign([
            'lygl'=>$lygl,
            'rmjdArts'=>$rmjdArts,
            'rmglArts'=>$rmglArts,
            'lastgl'=>$lastgl,
            'nextgl'=>$nextgl,
            ]);
        return view('lygl');
    }
     //旅游攻略预览页控制器
    public function lyglyl(){
        //推荐旅游攻略
        $tjglArts=db('glarticle')->limit(24)->field('id,title')->order('updatetime desc')->select();
        //游玩攻略
        $ywglArts=db('glarticle')->limit(24)->field('id,title')->where('type','=','1')->order('updatetime desc')->select();
         //美食攻略
        $msglArts=db('glarticle')->limit(24)->field('id,title')->where('type','=','2')->order('updatetime desc')->select();
        //住宿攻略
        $zsglArts=db('glarticle')->limit(24)->field('id,title')->where('type','=','3')->order('updatetime desc')->select();
        //购物攻略
        $gwglArts=db('glarticle')->limit(24)->field('id,title')->where('type','=','4')->order('updatetime desc')->select();


        $this->assign([

            'tjglArts'=>$tjglArts,
            'ywglArts'=>$ywglArts,
            'msglArts'=>$msglArts,
            'zsglArts'=>$zsglArts,
            'gwglArts'=>$gwglArts,

            ]);

        return view('lyglyl');
    }

    public function glyl($type){
        $glylArts=db('glarticle')->field('id,title,type,updatetime')->where('type','=',$type)->order('updatetime desc')->paginate('15');
        $page = $glylArts->render();
        $this->assign([
            'glylArts'=>$glylArts,
            'page'=>$page,
            ]);
          //dump($glylArts);die;
        return view('glyl');
    }
}
