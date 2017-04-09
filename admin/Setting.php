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
        <li class="treeview active">
          <a href="Setting.php"><i class="fa fa-gear"></i> <span>设置</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="Banner.php"><i class="fa fa-tv"></i> <span>首页banner设置</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="transform: none"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="Notice.php"><i class="fa fa-volume-up"></i> <span>通知设置</span>
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
        设置
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-gear"></i> 设置</a></li>
        <li class="active">设置</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">设置</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php
            $user = $Db->query("SELECT * FROM Setting WHERE S_key = 'A_user'")[0];
            $pwd = $Db->query("SELECT * FROM Setting WHERE S_key = 'A_pwd'")[0];
            $file_credit = $Db->query("SELECT * FROM Setting WHERE S_key = 'file_credit'")[0];
            $file_type = $Db->query("SELECT * FROM Setting WHERE S_key = 'file_type'")[0];
            $levels = $Db->query("SELECT * FROM Setting WHERE S_key = 'level'")[0];
            $price = $Db->query("SELECT * FROM Setting WHERE S_key = 'price'")[0];
            ?>
          <div class="form-group">
            <label>管理员账号</label>
            <div class="input-group form-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control" name="A_user" value="<? echo $user["S_value"] ?>">
            </div>
            <label>管理员密码</label>
            <div class="input-group form-group">
              <span class="input-group-addon"><i class="fa fa-lock"></i></span>
              <input type="text" class="form-control" name="A_pwd" value="<? echo $pwd["S_value"] ?>">
            </div>
            <label>上传文件所得文件分数</label>
            <div class="input-group form-group">
              <span class="input-group-addon"><i class="fa fa-tag"></i></span>
              <input type="number" class="form-control" name="file_credit" value="<? echo $file_credit["S_value"] ?>">
            </div>
            <div class="form-group">
              <label>文件类型</label>
                <?php
                foreach (json_decode($file_type["S_value"]) as $key => $file) {
                    echo "<div class=\"form-inline input-group\">
                            <span class=\"input-group-addon\" style='min-width:100px;'>编号: $key</span>
                            <input type=\"text\" class=\"form-control\" name=\"file_type\" data-keyNum='$key' value=\"$file\">
                          </div>";
                }
                ?>
            </div>
            <div class="form-group">
              <label>等级所需分数</label>
            </div>
              <?php
              foreach (json_decode($levels["S_value"]) as $key => $level) {
                  echo "<div class=\"form-inline input-group\">
                          <span class=\"input-group-addon\" style='min-width:100px;'>等级: $key</span>
                          <input type=\"text\" class=\"form-control\" name=\"level\" data-keyNum='$key' value=\"$level\">
                        </div>";
              }
              ?>
          </div>
          <div class="form-group">
            <label>等级所需价格</label>
          </div>
            <?php
            foreach (json_decode($price["S_value"]) as $key => $level) {
                echo "<div class=\"form-inline input-group\">
                          <span class=\"input-group-addon\" style='min-width:100px;'>等级: $key</span>
                          <input type=\"text\" class=\"form-control\" name=\"price\" data-keyNum='$key' value=\"$level\">
                        </div>";
            }
            ?>
        </div>
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-block btn-info btn-lg" onclick="save()">保存</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3.2.1 -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<script>
  function save () {
    let file_type = {}
    let level = {}
    let price = {}
    $("input[name=file_type]").each(function () {
      let keyNum = $(this).data('keynum')
      let val = $(this).val()
      file_type[keyNum] = val
    })
    $("input[name=level]").each(function () {
      let keyNum = $(this).data('keynum')
      let val = $(this).val()
      level[keyNum] = val
    })
    $("input[name=price]").each(function () {
      let keyNum = $(this).data('keynum')
      let val = $(this).val()
      price[keyNum] = val
    })
    $.post('/admin/setting',{
      A_user:$("input[name=A_user]").val(),
      A_pwd:$("input[name=A_pwd]").val(),
      file_credit: $("input[name=file_credit]").val(),
      file_type:JSON.stringify(file_type),
      price:JSON.stringify(price),
      level:JSON.stringify(level)
    },function () {
      location.reload()
    })
  }
</script>

</body>
</html>
