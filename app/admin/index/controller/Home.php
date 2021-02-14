<?php
namespace app\index\controller;

use think\controller\Admin;
use think\Request;

defined('InCnbbx') or exit('Access Invalid!');

class Home extends admin
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
        return $this->home_index();
    }

    public function home_index()
    {
        return $this->fetch('home_index');
    }

    public function ad_index()
    {
        if (chksubmit()) {
            $this->ajax->data(1);
        }
        return $this->fetch();
    }

    public function index_edit($id = 0)
    {
        if (chksubmit()) {
            $poster = input('post.');
            $datas = [];
            switch ($poster['item_type']) {
                case 'banner':
                    if (isset($poster['url1'])) $datas[] = ['image' => $poster['image1'], 'url' => $poster['url1']];
                    if (isset($poster['url2'])) $datas[] = ['image' => $poster['image2'], 'url' => $poster['url2']];
                    if (isset($poster['url3'])) $datas[] = ['image' => $poster['image3'], 'url' => $poster['url3']];
                    if (isset($poster['url4'])) $datas[] = ['image' => $poster['image4'], 'url' => $poster['url4']];
                    break;
                case 'iconlist':
                    if (isset($poster['url1'])) $datas[] = ['image' => $poster['image1'], 'url' => $poster['url1']];
                    if (isset($poster['url2'])) $datas[] = ['image' => $poster['image2'], 'url' => $poster['url2']];
                    if (isset($poster['url3'])) $datas[] = ['image' => $poster['image3'], 'url' => $poster['url3']];
                    if (isset($poster['url4'])) $datas[] = ['image' => $poster['image4'], 'url' => $poster['url4']];
                    if (isset($poster['url5'])) $datas[] = ['image' => $poster['image5'], 'url' => $poster['url5']];
                    break;
                case '3pics':
                    if (isset($poster['url1'])) $datas['left'] = ['image' => $poster['image1'], 'url' => $poster['url1']];
                    if (isset($poster['url2'])) $datas['right_top'] = ['image' => $poster['image2'], 'url' => $poster['url2']];
                    if (isset($poster['url3'])) $datas['right_sub'] = ['image' => $poster['image3'], 'url' => $poster['url3']];
                    break;
                case 'active':
                    if (isset($poster['title'])) $datas['title'] = $poster['title'];
                    if (isset($poster['len'])) $datas['len'] = $poster['len'];
                    break;
            }
            model('special_item')->save(['special_id' => 1, 'item_type' => $poster['item_type'], 'item_data' => serialize($datas), 'item_usable' => 1], ['item_id' => $poster['id']]);
            $this->ajax->data(1);
        }
        $item = model('special_item')->get($id);
        $item['item_data'] = unserialize($item['item_data']);
        $this->assign('info', $item);
        return $this->fetch();
    }

    public function active_index($curpage = 1, $page_size = 12)
    {
        $search = input('get.');
        $search['ishome'] = 1;
        $result = $this->model_Fal->getArticleList(0, 0, 3, $curpage, $page_size, $search);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch();
    }

    public function active_nominate()
    {
        return $this->fetch();
    }

    public function raiders_index($curpage = 1, $page_size = 12)
    {
        $search = input('get.');
        $search['ishome'] = 1;
        $result = $this->model_Fal->getArticleList(0, 0, 2, $curpage, $page_size, $search);
        $result['show'] = $this->page->show($curpage, $result['page']);
        $this->assign('result', $result);
        return $this->fetch();
    }
}