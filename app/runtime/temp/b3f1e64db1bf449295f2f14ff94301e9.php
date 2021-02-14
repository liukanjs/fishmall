<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"D:\www\fishmall\public/../app/admin/index\view\forum\thread_index.html";i:1490624576;}*/ ?>
﻿<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>狂野钓鱼总后台</title>

    <link rel="shortcut icon" href="/favicon.ico">
    <link href="../../../../../public/static/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="../../../../../public/static/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">

    <link href="../../../../../public/static/css/animate.min.css" rel="stylesheet">
    <link href="../../../../../public/static/css/style.min.css" rel="stylesheet">
    <link href="../../../../../public/static/js/plugins/sweetalert/sweetalert.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-sm-12">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>帖子列表
                        <small>全部话题列表</small>
                    </h5>
                    <div class="ibox-tools">
                        <a href="/admin/index/forum/thread_add" class="btn btn-primary btn-xs"> 发布新帖 </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" onclick="window.location.reload();" id="loading-example-btn" class="btn btn-white btn-sm"><i
                                    class="fa fa-refresh"></i> 刷新
                            </button>
                        </div>
                        <form action="" method="get">

                            <div class="col-sm-2 m-b-xs">
                                <select class="input-sm form-control input-s-sm inline" name="type">
                                    <option value="">全部</option>
                                    <option value="3">话题</option>
                                    <option value="2">会员名</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="请输入关键词" class="input-sm form-control">
											<span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary"> 搜索</button> 
                                	</span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="project-list">
                        <div class="row list-search">
                            <div class="col-md-3 text-center">
                                <div class="col-md-4 active list-title">全部</div>
                                <!--<div class="col-md-4 list-title">未回复</div>
                        <div class="col-md-4 list-title">已回复</div>-->
                            </div>
                        </div>
                        <table class="table table-hover">
                            <tbody>
                            <?php if(is_array($result['data']) || $result['data'] instanceof \think\Collection): if( count($result['data'])==0 ) : echo "" ;else: foreach($result['data'] as $k=>$vo): ?>
                            <tr>
                                <td>
                                    <img alt="image" class="img-circle" width="60" src="<?php echo $vo['user_icon']; ?>">
                                </td>
                                <td width="79%">
                                    <div class="height clearfix">
                                        <div class="pull-left"><?php echo $vo['user_name']; ?></div>
                                        <div class="pull-right">
                                            <?php if($vo['istop'] == '1'): ?>
                                            <span class="label label-primary">置顶</span> <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="m-t-sm">
                                        <a href="/admin/index/forum/thread_detail/id/<?php echo $vo['id']; ?>"><?php echo str_cut(strip_tags($vo['note']),255,'...'); ?></a>
                                    </div>

                                    <div class="m-t-sm">
                                    </div>
                                    <div class="m-t-sm clearfix">
                                        <div class="pull-left height-big">
                                            <small> <?php echo $vo['create_time']; ?></small>
                                            <span class="fa fa-thumbs-o-up m-l-sm"></span>
                                            <?php echo $vo['top_num']; ?>
                                            <span class="fa fa-commenting-o m-l-sm"></span>
                                            <?php echo $vo['discuss']; ?>
                                        </div>
                                        <div class="pull-right height">
                                            <!--<a href="/admin/index/home/active_nominate/id/<?php echo $vo['id']; ?>" class="btn btn-white btn-sm"><i
                                                    class="fa fa-external-link-square"></i> 推荐 </a>-->
                                            <a href="javascript:;" onclick="$isTop('forum/thread_top','id=<?php echo $vo['id']; ?>');" class="btn btn-white btn-sm"><i
                                                    class="fa fa-toggle-up"></i> 置顶 </a>
                                            <a href="/admin/index/forum/thread_add/id/<?php echo $vo['id']; ?>" class="btn btn-white btn-sm"><i
                                                    class="fa fa-edit"></i> 编辑 </a>
                                            <a href="javascript:;" onclick="$delete('/admin/index/forum/thread_del','id=<?php echo $vo['id']; ?>');" class="btn btn-white btn-sm"><i
                                                    class="fa fa-close"></i> 删除 </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <?php echo $result['show']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../../../public/static/js/jquery.min.js?v=2.1.4"></script>
<script src="../../../../../public/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../../../../../public/static/js/content.min.js"></script>
<script src="../../../../../public/static/js/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        $("#loading-example-btn").click(function () {
            btn = $(this);
            simpleLoad(btn, true);
            simpleLoad(btn, false)
        })
    });

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass("fa-spin");
            btn.contents().last().replaceWith(" Loading")
        } else {
            setTimeout(function () {
                btn.children().removeClass("fa-spin");
                btn.contents().last().replaceWith(" Refresh")
            }, 2000)
        }
    }
    ;
</script>
</body>

</html>