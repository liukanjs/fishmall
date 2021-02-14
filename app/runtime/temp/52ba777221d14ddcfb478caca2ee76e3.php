<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"F:\www\fish_mall\public/../app/admin/index\view\forum\board_index.html";i:1476370349;}*/ ?>
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
                    <h5>社区频道
                        <small>设置社区频道分类</small>
                    </h5>
                    <div class="ibox-tools">
                        <a href="/admin/index/forum/board_edit" class="btn btn-primary btn-xs"> 添加分类 </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="project-list">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>序号</th>
                                <th>分类名</th>
                                <th>频道</th>
                                <th>文章类型</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                            <?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['name']; ?></td>
                                <td><?php echo ctype($vo['ctype']); ?></td>
                                <td><?php echo atype($vo['atype']); ?></td>
                                <td><?php echo $vo['sort']; ?></td>
                                <td><a href="board_edit?id=<?php echo $vo['id']; ?>">编辑</a> <a href="#" onclick="$delete('board_del','id=<?php echo $vo['id']; ?>');">删除</a></td>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <div class="btn-group">
                            <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-white">1</button>
                            <button class="btn btn-white  active">2</button>
                            <button class="btn btn-white">3</button>
                            <button class="btn btn-white">4</button>
                            <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i>
                            </button>
                        </div>
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
