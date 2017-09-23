<?php
namespace app\admin\controller;
use think\Controller;
//攻略文章管理控制器
class Glarticle extends Controller
{
    //攻略文章展示
    public function lst(){
        $glartRes=db('glarticle')->paginate('10');
        $this->assign([
            'glartRes'=>$glartRes,
            ]);
        return view();
    }

        //攻略文章添加
       public function add(){
           if(request()->isPost()){
               $data=input('post.');
               $data['addtime']=time();
               $data['updatetime']=time();
               if($data['tags']){
                  $data['tags']=str_replace('，', ',', $data['tags']);
              }
               $validate=validate('glarticle');
               if(!$validate->scene('add')->check($data)){
                   $this->error($validate->getError());
               }
               $add=db('glarticle')->insert($data);
               if($add){
                   $this->success('添加攻略文章成功','lst');
               }else{
                   $this->error('添加攻略文章失败','add');
               }
               return;
           }
           return view();
       }
        //编辑文章攻略
       public function edit($id){
           if(request()->isPost()){
               $data=input('post.');
               $data['updatetime']=time();
                if($data['tags']){
                   $data['tags']=str_replace('，', ',', $data['tags']);
               }
               $validate=validate('glarticle');
               if(!$validate->scene('edit')->check($data)){
                   $this->error($validate->getError());
               }

               $save=db('glarticle')->update($data);
              if($save !== false){
                   $this->success('修改攻略文章成功','lst');
               }else{
                   $this->error('修改攻略文章失败','add');
               }
               return;
           }

           $glarts=db('glarticle')->find($id);
           $this->assign([
               'glarts'   => $glarts,
               ]);
           return view();
        }

     //删除成功
       public function del($id){
           $del=db('glarticle')->delete($id);
           if($del){
               $this->success('删除成功','lst');
           }else{
               $this->error('删除失败','lst');
           }
      }

}
