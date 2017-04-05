<?php
require_once 'SQL/Db.php';
$Db = new Db();
$page = isset($_GET['page']) ? $_GET["page"] : 0;
$keywords = isset($_GET['keyWords']) ? $_GET['keyWords'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>爱优医管理后台</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-black.min.css">
  <style>
    .timeline-body img {
      width: 300px;
    }
  </style>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>医</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>爱</b>优医</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"></a>
      <!-- Navbar Right Menu -->
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>爱优医管理员</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">菜单</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview">
          <a href="#"><i class="fa fa-file"></i> <span>文件管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="File-check.php"><i class="fa fa-hand-peace-o"></i>文件审批</a>
            </li>
            <li>
              <a href="File-add.php"><i class="fa fa-plus"></i>文件添加</a>
            </li>
            <li>
              <a href="File-modify.php"><i class="fa fa-frown-o"></i>文件修改/删除</a>
            </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="Comment.php"><i class="fa fa-commenting-o"></i> <span>评论管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="User-control.php"><i class="fa fa-user"></i> <span>用户管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="Setting.php"><i class="fa fa-gear"></i> <span>设置</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
        <li class="treeview active">
          <a href="Banner.php"><i class="fa fa-tv"></i> <span>首页banner设置</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Banner设置
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gear"></i> 设置</a></li>
        <li class="active">Banner设置</li>
      </ol>
    </section>
      <?php
      $banner = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'banner'")[0]["S_value"]);
      ?>
    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <div class="box box-info">
        <div class="box-header">
          <div class="box-title">
            Banner设置 (点击图片修改)
          </div>
        </div>
        <div class="box-body">
          <ul class="timeline">
            <li>
              <i class="fa fa-tv bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"></h3>
                <div class="timeline-body">
                  <img src="<?php echo $banner[0] ?>" onclick="changeBanner(0)">
                </div>
                <div class="timeline-footer">
                </div>
              </div>
            </li>
            <li>
              <i class="fa fa-tv bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"></h3>
                <div class="timeline-body">
                  <img src="<?php echo $banner[1] ?>" onclick="changeBanner(1)">
                </div>
                <div class="timeline-footer">
                </div>
              </div>
            </li>
            <li>
              <i class="fa fa-tv bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"></h3>
                <div class="timeline-body">
                  <img src="<?php echo $banner[2] ?>" onclick="changeBanner(2)">
                </div>
                <div class="timeline-footer">
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>
<input type="file" id="imgUpload" style="display: none">
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3.2.1 -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<script>
  function changeBanner (Key) {
    $("#imgUpload").attr("onchange", `sendChange(${Key})`).click()
  }
  function sendChange (key) {
    let form = new FormData()
    form.append('file', $("#imgUpload")[0].files[0])
    form.append('key', key)
    $.ajax({
      url: "/admin/setting/banner",
      type: "post",
      data: form,
      contentType: false,
      processData: false,
      success: function () {
        location.reload()
      }
    })
  }
</script>

</body>
</html>
