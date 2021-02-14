<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\www\fishmall\public/../app/admin/index\view\home\home_index.html";i:1490624576;}*/ ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>狂野钓鱼总后台</title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="../../../../../public/static/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="../../../../../public/static/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="../../../../../public/static/css/animate.min.css" rel="stylesheet">
    <link href="../../../../../public/static/css/style.min.css?v=4.1.0" rel="stylesheet">


</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-sm-12">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>首页管理
                        <small>网站首页内容设置</small>
                    </h5>
                    <!--<div class="ibox-tools">-->
                        <!--<a href="/admin/index/home/home_edit" class="btn btn-primary btn-xs"> 添加模板 </a>-->
                    <!--</div>-->
                </div>
                <div class="ibox-content">

                    <div class="project-list">
                        <div class="row list-search">
                            <div class="col-md-3 text-center">
                                <div class="col-md-4 active list-title">首页编辑</div>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>排序</th>
                                <th>版块名称</th>
                                <th>板块样式</th>
                                <th>尺寸大小/数量</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>首页轮播大图</td>
                                <td>轮播图</td>
                                <td>640*240*4</td>
                                <td>启用</td>
                                <td><a href="/admin/index/home/index_edit/?item_type=banner&id=1">编辑</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>热门推荐</td>
                                <td>等分网格</td>
                                <td>120*120*5</td>
                                <td>启用</td>
                                <td><a href="/admin/index/home/index_edit/?item_type=iconlist&id=2">编辑</a></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>商品推荐</td>
                                <td>广告版式</td>
                                <td>320*260+320*130+320*130</td>
                                <td>启用</td>
                                <td><a href="/admin/index/home/index_edit/?item_type=3pics&id=3">编辑</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>推荐活动</td>
                                    <td>活动推荐</td>
                                    <td>显示条数</td>
                                    <td>启用</td>
                                    <td><a href="/admin/index/home/index_edit/?item_type=active&id=4">编辑</a></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>推荐攻略</td>
                                    <td>文章推荐</td>
                                    <td>显示条数</td>
                                    <td>启用</td>
                                    <td><a href="/admin/index/home/index_edit/?item_type=active&id=5">编辑</a></td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../../../public/static/js/jquery.min.js?v=2.1.4"></script>
<script src="../../../../../public/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../../../../../public/static/js/content.min.js?v=1.0.0"></script>
</body>
</html>
