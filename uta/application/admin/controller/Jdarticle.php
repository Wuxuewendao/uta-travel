<?php
namespace app\admin\controller;
use think\Controller;
//景点推荐文章管理控制器
class Jdarticle extends Controller
{
    //景点推荐文章展示
    public function lst(){
        $jdartRes=db('jdarticle')->paginate('10');
        $this->assign([
            'jdartRes'=>$jdartRes,
            ]);
        return view();
    }

        //景点推荐文章添加
       public function add(){
           if(request()->isPost()){
               $data=input('post.');
               $data['addtime']=time();
               $data['updatetime']=time();
               $dataFile=$_FILES;
               foreach ($dataFile as $k => $v) {
                if($v['name'] != ""){
                    $data[$k] = $this->upload($k);
                }
              }
               $validate=validate('jdarticle');
               if(!$validate->scene('add')->check($data)){
                   $this->error($validate->getError());
               }
               $add=db('jdarticle')->insert($data);
               if($add){
                   $this->success('添加景点推荐文章成功','lst');
               }else{
                   $this->error('添加景点推荐文章失败','add');
               }
               return;
           }
           return view();
       }
        //景点推荐文章编辑
       public function edit($id){
           if(request()->isPost()){
               $data=input('post.');
               $data['updatetime']=time();

               $dataFile=$_FILES;
               foreach ($dataFile as $k => $v) {
                if($v['name'] != ""){
                    $data[$k] = $this->upload($k);
                }
              }

               $validate=validate('jdarticle');
               if(!$validate->scene('edit')->check($data)){
                   $this->error($validate->getError());
               }

               $save=db('jdarticle')->update($data);
              if($save !== false){
                   $this->success('修改攻略文章成功','lst');
               }else{
                   $this->error('修改攻略文章失败','add');
               }
               return;
           }

           $jdarts=db('jdarticle')->find($id);
           $this->assign([
               'jdarts'   => $jdarts,
               ]);
           return view();
        }

     //景点推荐文章删除
       public function del($id){
           $del=db('jdarticle')->delete($id);
           if($del){
               $this->success('删除成功','lst');
           }else{
               $this->error('删除失败','lst');
           }
      }

      //重大bug,,程序原因,对上传的文件大小有要求,具体待定
    public function upload($imgName){
      // 获取表单上传文件 例如上传了001.jpg
      $file = request()->file($imgName);
      // 移动到框架应用根目录/public/static/index/uploads/ 目录下
      $info = $file->move(ROOT_PATH . 'public' . DS . 'static/jdtjpictures');
      if($info){
        // 成功上传后 获取上传信息
        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
        return $info->getSaveName();
      }else{
        // 上传失败获取错误信息
       return '';
      }
    }

}
