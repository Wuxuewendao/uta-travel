<?php
namespace app\index\controller;
use think\Controller;
//搜索控制器
class Search extends Controller
{
    public function lst($key)
    {
            if(!$key){
                $this->error('请输入关键字','index/index');
            }
           // $artRes=db('glarticle')->order('updatetime desc')->paginate(10);
            //if($key){
                $map['tags']=['like','%'.$key.'%'];
                 $artRes=db('glarticle')->where($map)->order('updatetime desc')->paginate(10);
            //}
            $page = $artRes->render();
            $this->assign([
                'artRes' => $artRes,
                'page'=>$page,
                ]);
            return view('search');
    }

    public function lst1($jdname)
    {
            if(!$jdname){
                $this->error('请输入景点名称','index/index');
            }
           // $artRes=db('glarticle')->order('updatetime desc')->paginate(10);
            //if($key){
                $map['jdname']=['like','%'.$jdname.'%'];
                 $artRes=db('jdarticle')->where($map)->order('updatetime desc')->paginate(10);
            //}
            $page = $artRes->render();
            $this->assign([
                'artRes' => $artRes,
                'page'=>$page,
                ]);
            return view('search');
    }



}
