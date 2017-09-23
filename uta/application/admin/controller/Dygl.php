<?php
namespace app\admin\controller;
use think\Controller;
//导游审核管理控制器
class Dygl extends Controller
{
    public function lst(){
      $dy=db('user')->where('status','=',3)->select();
      $this->assign([
        'dy'=>$dy,
        ]);

      return view('lst');
    }

    public function edit($id){
      if(request()->isPost()){
        $data=input('post.');
        $save=db('user')->update($data);
        if($save){
          $this->success('操作生效','lst');
        }else{
          $this->error('系统出错了!','lst');
        }
      }
      $dyxx=db('user')->where('id',$id)->find();
      $this->assign([
        'dyxx'=>$dyxx,
        ]);

      return view('edit');
    }

}
