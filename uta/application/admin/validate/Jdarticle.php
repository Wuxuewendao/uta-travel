<?php
namespace app\admin\validate;
use think\Validate;
//文章验证
class Jdarticle extends Validate
{
    protected $rule =   [
     'jdname'  => 'require',
     'jibie'  => 'require',
     'address'  => 'require',
     'summary'  => 'require',
     'click' => 'number',
    ];

    protected $message  =   [
     'jdname.require'  => '景点名不能为空',
     'jibie.require'  => '景点级别不能为空',
     'address.require'  => '景点地址不能为空',
     'summary.require'  => '景点简介不能为空',
     'click.number' => '点击量为数字'

    ];

    protected $scene = [
        'edit'  =>  ['jdname','jibie','address','summary','click'],
        'add'  =>   ['jdname','jibie','address','summary','click']

    ];

}
