<?php
namespace app\index\controller;
use think\Controller;
//景点推荐控制器控制器
class Jd extends Controller
{
    //景点预览页控制器
    public function jdyly(){
        $jdylyArts=db('jdarticle')->limit(60)->field('id,jdname,address')->order('updatetime desc')->select();
        $this->assign([
            'jdylyArts'=>$jdylyArts,
            ]);
        return view('jdyly');
    }

    //景点详情页控制器
    public function jdzs($id){
        db('jdarticle')->where('id',$id)->setInc('click');
        $jdzsArts=db('jdarticle')->find($id);
        $this->assign([
            'jdzs'=>$jdzsArts,
            ]);
        return view('jdzs');
    }


}
