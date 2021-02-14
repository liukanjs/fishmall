<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"F:\www\fish_mall\public/../app/admin/index\view\forum\tags_index.html";i:1476370349;}*/ ?>
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
                    <h5>标签列表
                        <small>文章标签、文章分类标签</small>
                    </h5>
                    <div class="ibox-tools">
                        <a href="?" class="btn btn-primary btn-xs"> 添加标签 </a>
                    </div>
                </div>
                <div class="ibox-content" style="padding-left: 40px; padding-right: 40px;">
                    <div class="row list-group">
                        <div class="col-md-6 list-group-item">
                            <div class="row list-search">
                                <div class="col-md-2 active list-title">文章标签</div>
                            </div>
                            <div class="row p-m">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <th>序号</th>
                                        <th width="30%">频道</th>
                                        <th width="30%">分类</th>
                                        <th>操作</th>
                                    </tr>
                            <?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <tr>
                                <td><?php echo $vo['id']; ?></td>
                                <td><?php echo $vo['name']; ?></td>
                                <td><?php echo $vo['tags_name']; ?></td>
                                <td><a href="/admin/index/forum/tags_index/id/<?php echo $vo['id']; ?>">编辑</a>
                                	<a href="javascript:;" onclick="$delete('tags_del','id=<?php echo $vo['id']; ?>');">删除</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 list-group-item col-md-offset-1">
                            <div class="row list-search text-center">
                                <div class="col-md-4 active list-title">添加/修改标签</div>
                            </div>
                            <div class="row">
                            	<form class="form-horizontal m-t" id="commentForm" novalidate="novalidate">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">社区栏目：</label>

                                    <div class="col-sm-8">
                                    <select id="typeid" name="typeid" class="form-control m-b chosen-select" value="<?php echo $info['typeid']; ?>" required="" aria-required="true">
                                        <option value="">==社区栏目==</option>
                                        <?php if(is_array($type) || $type instanceof \think\Collection): if( count($type)==0 ) : echo "" ;else: foreach($type as $k=>$vo): ?>
                                        <option hassubinfo="true" value="<?php echo $vo['id']; ?>"><?php echo $vo['name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">文章分类：</label>

                                    <div class="col-sm-8">
                                        <input id="tags_name" name="tags_name" minlength="2" type="text" class="form-control" value="<?php echo $info['tags_name']; ?>" required="" aria-required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                        <button class="btn btn-primary" type="submit">修改/保存</button>
                                    </div>
                                </div>
                                <input name="id" type="hidden" value="<?php echo $info['id']; ?>">
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../../../public/static/js/jquery.min.js?v=2.1.4"></script>
<script src="../../../../../public/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../../../../../public/static/js/plugins/validate/jquery.validate.min.js"></script>
<script src="../../../../../public/static/js/plugins/validate/messages_zh.min.js"></script>
<script src="../../../../../public/static/js/plugins/demo/form-validate-demo.min.js"></script>
<script src="../../../../../public/static/js/content.min.js?v=1.0.0"></script>
<script src="../../../../../public/static/js/plugins/sweetalert/sweetalert.min.js"></script>
</body>
</html>
