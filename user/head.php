<?php
if ($conf['cdnpublic'] == 1) {
    $cdnpublic = '//lib.baomitu.com/';
} elseif ($conf['cdnpublic'] == 2) {
    $cdnpublic = '//cdn.bootcss.com/';
} elseif ($conf['cdnpublic'] == 3) {
    $cdnpublic = '//tencent.beecdn.cn/libs/';
} elseif ($conf['cdnpublic'] == 4) {
    $cdnpublic = '//s1.pstatp.com/cdn/expire-1-M/';
} else {
    $cdnpublic = '//cdn.staticfile.org/';
}
if ($conf['cdnserver'] == 1) {
    $cdnserver = '//cdn.qqzzz.net/';
} else {
    $cdnserver = null;
}
if ($conf['ui_user'] == 1) {
    $ui_user = array('bg-dark', 'bg-white-only', 'bg-dark');
} else {
    $ui_user = array('bg-primary', 'bg-primary', 'bg-light dker');
}
@header('Content-Type: text/html; charset=UTF-8');
$user_img = '/assets/img/user.png';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link href="<?php echo $cdnpublic ?>twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo $cdnpublic ?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="<?php echo $cdnpublic ?>font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script src="<?php echo $cdnpublic ?>jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo $cdnpublic ?>twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo $cdnserver ? $cdnserver : '../'; ?>assets/user/css/animate.css"
          type="text/css"/>
    <link rel="stylesheet" href="<?php echo $cdnserver ? $cdnserver : '../'; ?>assets/user/css/app.css"
          type="text/css"/>
    <script src="<?php echo $cdnserver ? $cdnserver : '../'; ?>assets/user/js/app.js"></script>
    <!--[if lt IE 9]>
    <script src="<?php echo $cdnpublic ?>html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="<?php echo $cdnpublic ?>respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php if ($islogin2 == 1) {
if (isset($userrow['qq_head_img_url']) && !empty($userrow['qq_head_img_url'])) {
    $user_img = $userrow['qq_head_img_url'];
} else {
    $user_img = $userrow['qq'] ? '//q4.qlogo.cn/headimg_dl?dst_uin=' . $userrow['qq'] . '&spec=100' : '../assets/img/user.png';
}
if (isset($userrow['qq_nickname']) && !empty($userrow['qq_nickname'])) {
    $user_name = $userrow['qq_nickname'] . '(' . $userrow['user'] . ')';
} else {
    $user_name = $userrow['user'];
}
if ($userrow['status'] == 0) {
    showmsg('你的账号已被封禁！', 3);
    exit;
} elseif ($userrow['power'] > 0 && $conf['fenzhan_expiry'] > 0 && $userrow['endtime'] < $date) {
    showmsg('你的账号已到期，请联系管理员续费！', 3);
    exit;
}
if ($userrow['lasttime'] == null) {
    $DB->update('site', ['lasttime' => $date], ['zid' => $userrow['zid']]);
}
?>
<div class="app app-header-fixed  ">
    <header id="header" class="app-header navbar ng-scope" role="menu">
        <div class="navbar-header <?php echo $ui_user[0] ?>">
            <button class="pull-right visible-xs" ui-toggle="off-screen" target=".app-aside" ui-scroll="app">
                <i class="glyphicon glyphicon-align-justify"></i>
            </button>
            <a href="./" class="navbar-brand text-lt">
                <i class="fa fa-desktop hidden-xs"></i>
                <span class="hidden-folded m-l-xs">系统管理中心</span>
            </a>
        </div>

        <div class="collapse pos-rlt navbar-collapse box-shadow <?php echo $ui_user[1] ?>">
            <!-- buttons -->
            <div class="nav navbar-nav hidden-xs">
                <a href="#" class="btn no-shadow navbar-btn" ui-toggle="app-aside-folded" target=".app">
                    <i class="fa fa-dedent fa-fw text"> 菜单</i>
                    <i class="fa fa-indent fa-fw text-active">菜单</i>
                </a>
            </div>
            <!-- / buttons -->

            <!-- nabar right -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="<?php echo $user_img; ?>" alt="user_avatar">
                <i class="on md b-white bottom"></i>
              </span>
                        <span class="hidden-sm hidden-md"><?php echo $user_name; ?></span> <b class="caret"></b>
                    </a>
                    <!-- dropdown -->
                    <ul class="dropdown-menu animated fadeInRight w">
                        <li>
                            <a href="./">
                                <span>用户中心</span>
                            </a>
                        </li>
                        <li>
                            <a href="./uset.php?mod=user">
                                <span>修改资料</span>
                            </a>
                        </li>
                        <li>
                            <a href="../">
                                <span>返回首页</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a ui-sref="access.signin" href="login.php?logout">退出登录</a>
                        </li>
                    </ul>
                    <!-- / dropdown -->
                </li>
            </ul>
            <!-- / navbar right -->
        </div>
        <!-- / navbar collapse -->
    </header>
    <!-- / header -->
    <!-- aside -->
    <aside id="aside" class="app-aside hidden-xs <?php echo $ui_user[2] ?>">
        <div class="aside-wrap">
            <div class="navi-wrap">

                <!-- nav -->
                <nav ui-nav class="navi">
                    <ul class="nav">
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>导航</span>
                        </li>
                        <li class="<?php echo checkIfActive(',index') ?>">
                            <a href="./">
                                <i class="fa fa-user"></i>
                                <span>用户中心</span>
                            </a>
                        </li>
                        <li class="<?php echo checkIfActive('shop') ?>">
                            <a href="<?php echo $userrow['power'] > 0 ? './shop.php' : '../' ?>">
                                <i class="fa fa-cart-plus"></i>
                                <span>自助下单</span>
                            </a>
                        </li>
                        <li class="<?php echo checkIfActive('workorder') ?>">
                            <a href="./workorder.php">
                                <i class="fa fa-check-square-o"></i>
                                <span>我的工单</span>
                            </a>
                        </li>

                        <?php if ($userrow['power'] > 0) { ?>
                            <li class="<?php echo checkIfActive('classlist,shoplist,sitelist,userlist') ?>">
                                <a href class="auto">
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                                    <i class="fa fa-codepen"></i>
                                    <span>网站管理</span>
                                </a>
                                <ul class="nav nav-sub dk">
                                    <li class="<?php echo checkIfActive('classlist') ?>">
                                        <a href="./classlist.php">
                                            <span>分类管理</span>
                                        </a>
                                    </li>
                                    <li class="<?php echo checkIfActive('shoplist') ?>">
                                        <a href="./shoplist.php">
                                            <span>商品管理</span>
                                        </a>
                                    </li>
                                    <?php if ($userrow['power'] == 2) { ?>
                                    <li class="<?php echo checkIfActive('sitelist') ?>">
                                            <a href="./sitelist.php">
                                                <span>分站列表</span>
                                            </a>
                                        </li><?php } ?>
                                    <li class="<?php echo checkIfActive('userlist') ?>">
                                        <a href="./userlist.php">
                                            <span>用户列表</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>查询</span>
                        </li>
                        <li class="<?php echo checkIfActive('list') ?>">
                            <a href="./list.php">
                                <i class="fa fa-list"></i>
                                <span>订单查询</span>
                            </a>
                        </li>
                        <li class="<?php echo checkIfActive('record') ?>">
                            <a href="./record.php">
                                <i class="fa fa-hashtag"></i>
                                <span>收支明细</span>
                            </a>
                        </li>
                        <?php if ($userrow['power'] > 0 && (isset($conf['fenzhan_isShowRank']) ? $conf['fenzhan_isShowRank'] : 1)) { ?>
                            <li class="<?php echo checkIfActive('rank') ?>">
                                <a href="./rank.php">
                                    <i class="fa fa-line-chart"></i>
                                    <span>分站排行</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>其他</span>
                        </li>
                        <li class="<?php echo checkIfActive('uset') ?>">
                            <a href class="auto">
                                  <span class="pull-right text-muted">
                                    <i class="fa fa-fw fa-angle-right text"></i>
                                    <i class="fa fa-fw fa-angle-down text-active"></i>
                                  </span>
                                <i class="fa fa-resistance"></i>
                                <span>系统设置</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="<?php echo checkIfActive('user') ?>">
                                    <a href="./uset.php?mod=user">
                                        <span>用户资料设置</span>
                                    </a>
                                </li>
                                <?php if ($userrow['power'] > 0) { ?>
                                    <li class="<?php echo checkIfActive('site') ?>">
                                        <a href="./uset.php?mod=site">
                                            <span>网站信息设置</span>
                                        </a>
                                    </li>
                                    <li class="<?php echo checkIfActive('logo') ?>">
                                        <a href="./uset.php?mod=logo">
                                            <span>网站Logo设置</span>
                                        </a>
                                    </li>
                                    <li class="<?php echo checkIfActive('skimg') ?>">
                                        <a href="./uset.php?mod=skimg">
                                            <span>收款图设置</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="<?php echo checkIfActive('message') ?>">
                            <a href="./message.php">
                                <i class="fa fa-bullhorn"></i>
                                <span>消息通知</span>
                            </a>
                        </li>
                        <?php if ($userrow['power'] > 0) { ?>
                            <li class="<?php echo checkIfActive('faq') ?>">
                                <a href="./faq.php">
                                    <i class="fa fa-exclamation-circle"></i>
                                    <span>常见问题</span>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a ui-sref="access.signin" href="login.php?logout">
                                <i class="fa fa-power-off"></i>
                                <span>退出登录</span>
                            </a>
                        </li>
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>首页</span>
                        </li>
                        <li class="">
                            <a href="../">
                                <i class=" fa fa-cart-plus"></i>
                                <span>返回首页</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </aside>
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="bg-light lter b-b wrapper-sm ng-scope">
                <ul class="breadcrumb" style="padding: 0;margin: 0;">
                    <li><i class="fa fa-home"></i><a href="./">管理中心</a></li>
                    <li><?php echo $title ?></li>
                </ul>
            </div>
            <!-- / aside -->
            <?php } ?>
