<?php
namespace app\index\controller;

use think\Controller;
use think\controller\User;
use think\Image;

defined('InCnbbx') or exit('Access Invalid!');

class Upload extends User
{
    public function __construct(\think\Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        $this->check_user();
        $file = request()->file('filedata');
        $path = 'static/upload/';
        $info = $file->move($path);
        if ($info) {
            $image = Image::open($info->getPathname());
            $image->thumb(800, 800, Image::THUMB_SCALING);
            $image->save($info->getPathname());
            $this->data(str_replace('\\', '/', DS . $info->getPathname()));
        } else {
            $this->error($file->getError());
        }
    }

}