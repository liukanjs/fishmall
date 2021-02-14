<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"F:\www\fish_mall\public/../app/admin/index\view\forum\board_edit.html";i:1476370349;}*/ ?>
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
                    <h5>社区频道
                        <small>设置社区频道分类</small>
                    </h5>
                    <div class="ibox-tools">
                        <a href="#" class="btn btn-primary btn-xs win-back"> 返回 </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t" id="commentForm">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">频道名称：</label>

                            <div class="col-sm-9">
                                <input id="name" name="name" minlength="2" type="text" class="form-control" required=""   aria-required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">频道类型：</label>

                            <div class="col-sm-9"><select id="ctype" name="ctype" class="form-control m-b" required=""   aria-required="true">
                                <?php if(is_array($ctype_list) || $ctype_list instanceof \think\Collection): $i = 0; $__LIST__ = $ctype_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['value']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">文章类型：</label>

                            <div class="col-sm-9"><select id="atype" name="atype" class="form-control m-b" required=""  aria-required="true">
                                <?php if(is_array($atype_list) || $atype_list instanceof \think\Collection): $i = 0; $__LIST__ = $atype_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo $vo['value']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">排序：</label>

                            <div class="col-sm-9">
                                <input id="sort" name="sort" type="digits" class="form-control" required="" aria-required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-3">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                        <input name="id" type="hidden">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../../../../public/static/js/jquery.min.js?v=2.1.4"></script>
<script src="../../../../../public/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="../../../../../public/static/js/content.min.js?v=1.0.0"></script>
<script src="../../../../../public/static/js/plugins/validate/jquery.validate.min.js"></script>
<script src="../../../../../public/static/js/plugins/validate/messages_zh.min.js"></script>
<script src="../../../../../public/static/js/plugins/demo/form-validate-demo.min.js"></script>
<script>
    $(function ($) {
        $('form').setForm(<?php echo $info; ?>);
    })
</script>
</body>
</html>
