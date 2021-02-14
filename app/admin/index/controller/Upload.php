<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;
use think\Image;

defined('InCnbbx') or exit('Access Invalid!');

class Upload extends Admin
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        $file = request()->file('filedata');
        $path = 'static/upload/';
        $info = $file->move($path);
        if ($info) {
            $image = Image::open($info->getPathname());
            $image->thumb(800, 800, Image::THUMB_SCALING);
            $image->save($info->getPathname());
            $this->ajax->data(str_replace('\\', '/', DS . $info->getPathname()));
        } else {
            $this->ajax->error($file->getError());
        }
    }

}