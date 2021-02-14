<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"F:\www\fish_mall\public/../app/admin/index\view\mall\order_index.html";i:1478599962;}*/ ?>
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
                    <h5>订单管理
                        <small>订单下单、发货处理</small>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" onclick="window.location.reload();" id="loading-example-btn" class="btn btn-white btn-sm"><i
                                    class="fa fa-refresh"></i> 刷新
                            </button>
                        </div>
                        <form method="get">
                            <div class="col-sm-2 m-b-xs">
                                <select class="input-sm form-control input-s-sm inline" name="state" value="<?php echo $_GET['state']; ?>">
                                    <option value="">==订单状态==</option>
                                    <option value="-1">已取消</option>
                                    <option value="10">待付款</option>
                                    <option value="20">待发货</option>
                                    <option value="30">已发货</option>
                                    <option value="40">已完成</option>
                                </select>
                            </div>
                            

                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="订单号搜索" class="input-sm form-control" value="<?php echo $_GET['keyword']; ?>">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="project-list">
                        <div class="row list-search margin-bottom">
                            <div class="col-md-6 text-center">
                                <div class="col-md-2 list-title <?php if($_GET['state'] == ''): ?>active<?php endif; ?>"><a href="?">所有订单</a></div>
                                <div class="col-md-2 list-title <?php if($_GET['state'] == '10'): ?>active<?php endif; ?>"><a href="?state=10">待付款</a></div>
                                <div class="col-md-2 list-title <?php if($_GET['state'] == '20'): ?>active<?php endif; ?>"><a href="?state=20">待发货</a></div>
                                <div class="col-md-2 list-title <?php if($_GET['state'] == '30'): ?>active<?php endif; ?>"><a href="?state=30">已发货</a></div>
                                <div class="col-md-2 list-title <?php if($_GET['state'] == '40'): ?>active<?php endif; ?>"><a href="?state=40">已完成</a></div>
                                <div class="col-md-2 list-title <?php if($_GET['state'] == '-1'): ?>active<?php endif; ?>"><a href="?state=-1">已取消</a></div>
                            </div>
                        </div>
                        <?php if(is_array($result['data']) || $result['data'] instanceof \think\Collection): if( count($result['data'])==0 ) : echo "" ;else: foreach($result['data'] as $k=>$vo): ?>
                        <table class="table order_list table-bordered">
                            <tbody>
                            <tr>
                                <th colspan="7" class="order_title">
                                    <div class="ibox-tools"><a class="btn btn-white btn-sm" href="./order_out/id/<?php echo $vo['id']; ?>" target="_blank">打印发货单</a></div>
                                    <div class="height"><span>订单号：<?php echo $vo['order_sn']; ?></span><span
                                            class="m-l-lg">下单时间：<?php echo $vo['create_time']; ?></span>
                                    </div>
                                </th>
                            </tr>
                            <?php if(is_array($vo['goods_list']) || $vo['goods_list'] instanceof \think\Collection): if( count($vo['goods_list'])==0 ) : echo "" ;else: foreach($vo['goods_list'] as $key=>$goods): ?>
                            <tr>
                                <td class="row" width="40%">
                                    <div class="col-md-3"><img class="img-responsive" src="<?php echo $goods['img']; ?>" width="50" height="50"/></div>
                                    <div class="col-md-9"><a href="/mall/goods.html?goods_id=<?php echo $goods['id']; ?>" target="_blank"><?php echo $goods['title']; ?></a></div>
                                </td>
                                <td>
                                    <div class="">￥<?php echo $goods['rmb_price']; ?> + <?php echo $goods['score_price']; ?>鱼古</div>
                                </td>
                                <td width="100">
                                    <div class="text-center"><?php echo $goods['goods_num']; ?></div>
                                </td>
                                <?php if($key == '0'): ?>
                                <td width="70" rowspan="<?php echo count($vo['goods_list']); ?>"><?php echo $vo['user_info']['user_name']; ?></td>
                                <td width="150" rowspan="<?php echo count($vo['goods_list']); ?>" class="text-center">￥<?php echo $vo['total_rmb_price']+$vo['order_postage']; ?> + <?php echo $vo['total_score_price']; ?>鱼古<br/>（含运费<?php echo $vo['order_postage']; ?>元）<br/>微信+鱼古支付
                                </td>
                                <td  width="100" rowspan="<?php echo count($vo['goods_list']); ?>" class="text-center">
                                	<?php switch($vo['order_state']): case "0": ?><span class=" text-gray ">已取消</span><?php break; case "10": ?><span class=" text-danger ">待付款</span><?php break; case "20": ?><span class=" text-primary ">待发货</span><?php break; case "30": ?><span class=" text-success ">已发货</span><?php break; case "40": ?><span class=" text-success ">已完成</span><?php break; endswitch; ?><br/><a href="./order_info/id/<?php echo $vo['id']; ?>">订单详情</a><br/>
                                    
                                	<?php if($vo['order_state'] == '30'): ?>
                                	    <a target="_blank" href="https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=1&tn=zhoujinshi110&wd=快递<?php echo $vo['deliver_sn']; ?>">查看物流</a>
                                	<?php endif; if($vo['order_state'] == '40'): ?>
                                	    <a target="_blank" href="https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=1&tn=zhoujinshi110&wd=快递<?php echo $vo['deliver_sn']; ?>">查看物流</a>
                                	<?php endif; ?>
                                
                                    
                                </td>
                                <td rowspan="<?php echo count($vo['goods_list']); ?>" width="70">
                                	<?php if($vo['order_state'] == '20'): ?>
                                		<button type="button" class="btn btn-sm  btn-danger"  data-toggle="modal" data-target="#myModal" onclick="$('input[name=id]').val('<?php echo $vo['id']; ?>')">发货</button>
                                	<?php endif; ?>
                                
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <?php echo $result['show']; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <i class="fa fa-laptop modal-icon"></i>
                <h4 class="modal-title">设置发货</h4>
                <small class="font-bold">输入快递单号发货。
                </div>
                <form action="order_send" method="post">
                	
                <div class="modal-body">
                	<p>无需输入快递公司名，直接输入单号即可完成快递单号查询</p。>
                            <div class="form-group"><label>快递单号</label> 
                            	<input type="number" name="deliver_sn" id="deliver_sn" placeholder="请输入快递单号" class="form-control"  required="" aria-required="true"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                    <input type="hidden" name="id" id="id"  />
                </div>
                </form>
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
