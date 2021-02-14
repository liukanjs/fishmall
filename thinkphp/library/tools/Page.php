<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/13
 * Time: 17:37
 */

namespace tools;

class Page
{
    /**
     * 获取分页列表
     * @param $curpage
     * @param $totalpage
     * @return string
     */
    public function show($curpage = 0, $totalpage = 0)
    {
        $get = input('get.');
        unset($get['curpage']);
        $start_page = $curpage - 5;
        if ($start_page < 1) $start_page = 1;
        $end_page = $curpage + 5;
        if ($end_page > $totalpage) $end_page = $totalpage;
        $html = '<div class="clearfix">';
        $html .= '    <div class="pull-left">';
        $html .= '        <div style="line-height: 34px">显示 ' . $start_page . ' 到 ' . $end_page . ' 页，共 ' . $totalpage . ' 页</div>';
        $html .= '    </div>';
        $html .= '    <div class="btn-group pull-right">';
        $html .= '        <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>';
        for ($p = $start_page; $p <= $end_page; $p++) {
            $html .= '        <button class="btn btn-white ' . ($curpage == $p ? 'active' : '') . '" onclick="location.href=\'?curpage=' . $p . '&' . http_build_query($get) . '\';">' . $p . '</button>';
        }
        $html .= '        <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i></button>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
}