<?php
namespace app\index\controller;
use think\Controller;
//首页控制器
class Index extends Controller
{
    //调取数据到首页
    public function index()
    {
        //主体部分景点推荐,推荐最新添加的景点
        $jdArts=db('jdarticle')->limit(8)->field('id,jdname,address,imgurl')->order('id desc')->select();
        //底部旅游攻略推荐,推荐点击最多攻略
        $glArts=db('glarticle')->limit(8)->field('id,title,destination,type')->order('click desc')->select();
        //底部热门旅游景点推荐,推荐点击最多的
        $dbjdArts=db('jdarticle')->limit(4)->field('id,jdname,address')->order('click desc')->select();
        //调取导游数据(目前按点击量调取导游信息)
        $dyArts=db('user')->limit(3)->order('click desc')->where('status',2)->select();
        $this->assign([
            'jdArts'=>$jdArts,
            'glArts'=>$glArts,
            'dbjdArts'=>$dbjdArts,
              'dyArts'=>$dyArts,
            ]);
        return view();
    }
}
