<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"F:\www\fish_mall\public/../app/admin/index\view\mall\order_info.html";i:1479355741;}*/ ?>
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
    <style type="text/css">
    	.timeline-item .content {min-height: auto;}
    </style>


</head>
<body class="gray-bg">
	<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>订单信息</h5>
                    </div>
                    <div class="ibox-content text-center p-md" style="height: 250px;">
                    	<dl class="dl-horizontal">
                    		<dt>收货人:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['address_info']['username']; ?></dd>
                    	</dl>
                    	<dl class="dl-horizontal">
                    		<dt>电话:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['address_info']['telphone']; ?></dd>
                    	</dl>
                    	<dl class="dl-horizontal">
                    		<dt>地址:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['address_info']['address']; ?></dd>
                    	</dl>
                    	<hr />
                    	<dl class="dl-horizontal">
                    		<dt>订单编号:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['order_sn']; ?></dd>
                    	</dl>
                    	<dl class="dl-horizontal">
                    		<dt>下单时间:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['create_time']; ?></dd>
                    	</dl>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                	<div class="ibox-title">
                        <h5>物流信息</h5>
                    </div>
                    <div class="ibox-content  p-md" style="height: 250px;">
                    	<ol>
                    		<li>买家已成功对订单进行支付，支付单号 “<?php echo $result['order_info']['pay_sn']; ?>”。</li>
                    		<li>订单已提交商家进行备货发货准备。</li>
                    	</ol>
                    	
                    	<hr />

                    	<dl class="dl-horizontal">
                    		<dt>运单号:</dt>
                    		<dd class="text-left"><?php echo $result['order_info']['deliver_sn']; ?> <a class="margin-left" href="https://www.baidu.com/s?ie=utf-8&f=8&rsv_bp=1&rsv_idx=1&tn=zhoujinshi110&wd=%E5%BF%AB%E9%80%<?php echo $result['order_info']['deliver_sn']; ?>" target="_blank">去查询</a></dd>
                    	</dl>
                    </div>
                </div>
            </div>

        </div>
        
        
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content timeline">
                    	
                    	
					<?php switch($result['order_info']['order_state']): case "0": ?>
	                        <div class="timeline-item">
	                            <div class="row">
	                                <div class="col-xs-3 date">
	                                    <i class="fa fa-clock-o"></i> 
	                                    <small class="text-navy"><?php echo $result['order_info']['create_time']; ?></small>
	                                </div>
	                                <div class="col-xs-7 content no-top-border">
	                                    <p class="m-b-xs"><strong>提交订单</strong></p>
	                                    
	                                    <p>用户于<?php echo $result['order_info']['create_time']; ?>提交了订单：<?php echo $result['order_info']['order_sn']; ?></p>
	
	                                </div>
	                            </div>
	                        </div>
					    <?php break; case "10": ?>
					    
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['create_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>提交订单</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['create_time']; ?>提交了订单：<?php echo $result['order_info']['order_sn']; ?></p>

                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['pay_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>支付订单</strong></p>
                                    
                                    <p>支付单号：<?php echo $result['order_info']['pay_sn']; ?></p>

                                </div>
                            </div>
                        </div>

					    <?php break; case "20": ?>
					    
                    
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['create_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>提交订单</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['create_time']; ?>提交了订单：<?php echo $result['order_info']['order_sn']; ?></p>

                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['pay_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>支付订单</strong></p>
                                    
                                    <p>支付单号：<?php echo $result['order_info']['pay_sn']; ?></p>

                                </div>
                            </div>
                        </div>


                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['deliver_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>发货</strong></p>
                                    <p>商家于 <?php echo $result['order_info']['deliver_time']; ?>发货</p>
                                </div>
                            </div>
                        </div>

					    <?php break; case "30": ?>
					    
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['create_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>提交订单</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['create_time']; ?>提交了订单：<?php echo $result['order_info']['order_sn']; ?></p>

                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['pay_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>支付订单</strong></p>
                                    
                                    <p>支付单号：<?php echo $result['order_info']['pay_sn']; ?></p>

                                </div>
                            </div>
                        </div>


                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['deliver_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>发货</strong></p>
                                    
                                    <p>商家于 <?php echo $result['order_info']['deliver_time']; ?>发货</p>

                                </div>
                            </div>
                        </div>


                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['finish_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>确认收货</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['finish_time']; ?>分自动确认收货</p>

                                </div>
                            </div>
                        </div>


					    <?php break; case "40": ?>
					    
                    
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['create_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>提交订单</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['create_time']; ?>提交了订单：<?php echo $result['order_info']['order_sn']; ?></p>

                                </div>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['pay_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>支付订单</strong></p>
                                    
                                    <p>支付单号：<?php echo $result['order_info']['pay_sn']; ?></p>

                                </div>
                            </div>
                        </div>


                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['deliver_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>发货</strong></p>
                                    
                                    <p>商家于 <?php echo $result['order_info']['deliver_time']; ?>发货</p>

                                </div>
                            </div>
                        </div>


                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['finish_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>确认收货</strong></p>
                                    
                                    <p>用户于<?php echo $result['order_info']['finish_time']; ?>自动确认收货</p>

                                </div>
                            </div>
                        </div>



                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-clock-o"></i> 
                                    <small class="text-navy"><?php echo $result['order_info']['finish_time']; ?></small>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <p class="m-b-xs"><strong>订单完成</strong></p>
                                    
                                    <p>订单于<?php echo $result['order_info']['finish_time']; ?>自动完成</p>

                                </div>
                            </div>
                        </div>


					    <?php break; endswitch; ?>
                    	


                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content timeline">
                    
                        <table class="table table-hover">
                        	<tr>
                        		<th>商品</th>
                        		<th>单价</th>
                        		<th>数量</th>
                        		<th>小计</th>
                        	</tr>
                        	<?php if(is_array($result['order_info']['order_goods_list']) || $result['order_info']['order_goods_list'] instanceof \think\Collection): $i = 0; $__LIST__ = $result['order_info']['order_goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        	<tr>
                        		<td>
                        			<img src="<?php echo $vo['img']; ?>" width="30"/>
                        			<?php echo $vo['title']; ?>
                        		</td>
                        		<td>￥<?php echo $vo['rmb_price']; ?>+<?php echo $vo['score_price']; ?>鱼古</td>
                        		<td><?php echo $vo['goods_num']; ?></td>
                        		<td>￥<?php echo $vo['rmb_price']*$vo['goods_num']; ?>+<?php echo $vo['score_price']*$vo['goods_num']; ?>鱼古</td>
                        		</td>
                        	</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
                        	
                        </table>
                        
                        <div class="clearfix">
                        	<div class="pull-right text-right padding-big-right">
                        		<div class="text-small padding-big-right">运费：￥<?php echo $result['order_info']['order_postage']; ?></div>
                        		<div class="text-big height-big text-bold padding-big-right">订单金额：￥<?php echo $result['order_info']['total_pay_price']; ?></div>
                        	</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
	
<script src="/static/js/jquery.min.js?v=2.1.4"></script>
<script src="/static/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/static/js/content.min.js?v=1.0.0"></script>
</body>
</html>
