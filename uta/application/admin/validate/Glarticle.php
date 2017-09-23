<?php
namespace app\admin\validate;
use think\Validate;
//文章验证
class Glarticle extends Validate
{
    protected $rule =   [
     'title'  => 'require',
     'destination'  => 'require',
     'content'  => 'require',
     'summary'  => 'require',
     'click' => 'number',
    ];

    protected $message  =   [
     'title.require'  => '文章标题不能为空',
     'destination.require'  => '目的地不能为空',
     'content.require'  => '文章内容不能为空',
     'summary.require'  => '文章简介不能为空',
     'click.number' => '点击量为数字'

    ];

    protected $scene = [
        'edit'  =>  ['title','destination','content','summary','click'],
        'add'  =>   ['title','destination','content','summary','click']

    ];

}
