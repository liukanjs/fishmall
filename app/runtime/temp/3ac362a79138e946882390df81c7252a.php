<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\www\fishmall\public/../app/admin/index\view\home\active_index.html";i:1490624576;}*/ ?>
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
    <link href="../../../../../public/static/js/plugins/sweetalert/sweetalert.css" rel="stylesheet">


</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-sm-12">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>推荐活动列表</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button"  onclick="window.location.reload();"  id="loading-example-btn" class="btn btn-white btn-sm"><i
                                    class="fa fa-refresh"></i> 刷新
                            </button>
                        </div>

                        <form action="" method="get">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" name="keyword"  placeholder="请输入活动名称" class="input-sm form-control"> <span
                                        class="input-group-btn">
                                        <button type="submit" name="keyword"  class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row list-search">
                        <div class="col-md-5 text-center">
                            <div class="col-md-2 active list-title">全部</div>
                            <!--<div class="col-md-2 list-title">待审核</div>
                            <div class="col-md-2 list-title">报名中</div>
                            <div class="col-md-2 list-title">进行中</div>
                            <div class="col-md-2 list-title">已结束</div>-->
                        </div>
                    </div>
                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                            <?php if(is_array($result['data']) || $result['data'] instanceof \think\Collection): $i = 0; $__LIST__ = $result['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td class="project-num">
                                    <?php echo $vo['id']; ?>
                                </td>
                                <td class="project-status">
                                    <?php echo $vo['user_name']; ?>
                                </td>
                                <td class="project-title" width="40%">
                                    <a href="/admin/index/forum/active_detail/id/<?php echo $vo['id']; ?>/"><?php echo $vo['title']; ?></a>
                                    <br/>
                                </td>
                                <td class="project-completion">
                                    <small>开始时间: <br /> <?php echo $vo['start_time']; ?></small>
                                </td>
                                <td class="project-completion">
                                    <small>结束时间： <br /> <?php echo $vo['end_time']; ?></small>
                                </td>
                                <td class="project-actions"><a href="javascript:;"  onclick="$to_index('/admin/index/forum/to_index','id=<?php echo $vo['id']; ?>');"  class="btn btn-white btn-sm"><i
                                        class="fa fa-home"></i> 移除推荐 </a>
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
<script src="../../../../../public/static/js/content.min.js?v=1.0.0"></script>
<script src="../../../../../public/static/js/plugins/sweetalert/sweetalert.min.js"></script>

</body>
</html>
