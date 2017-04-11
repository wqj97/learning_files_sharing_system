<?php
require_once 'SQL/Db.php';
$Db = new Db();
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
    .info-box-text {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80px;
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
        <li class="treeview active">
          <a href="#"><i class="fa fa-file"></i> <span>文件管理</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="File-check.php"><i class="fa fa-hand-peace-o"></i>文件审批</a>
            </li>
            <li class="active">
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
        添加文件
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-file"></i> 文件管理</a></li>
        <li class="active">添加文件</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">管理员上传文件</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" id="file_form">
          <div class="box-body">
            <div class="form-group">
              <label>选择文件</label>
              <input type="file" name="file" class="form-control" onchange="FileSelected(this)">
              <p class="help-block" id="fileSize">文件大小: <span>0</span> KB</p>
            </div>
            <div class="form-group">
              <label>文件名</label>
              <input type="text" class="form-control" placeholder="文件名(自动获取)" name="file_name" id="file_name">
            </div>
            <div class="form-group">
              <label>文件分类</label>
              <select class="form-control" name="file_type">
                  <?php
                  $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'file_type'")[0]["S_value"]);
                  foreach ($types as $key => $type) {
                      echo "<option value='$key'>$type</option>";
                  }
                  ?>
              </select>
            </div>
            <div class="form-group">
              <label>文件等级</label>
              <select class="form-control" name="file_level">
                  <?php
                  $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'level'")[0]["S_value"]);
                  foreach ($types as $key => $val) {
                      echo "<option value='$key'>$key 级 [$val 分]</option>";
                  }
                  ?>
              </select>
            </div>
            <div class="info-box" id="success" style="display: none">
              <span class="info-box-icon bg-green"><i class="fa fa-hand-peace-o"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" id="success-message">上传成功</span>
              </div>
            </div>
            <div class="info-box" id="failed" style="display: none">
              <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-remove-sign"></i></span>
              <div class="info-box-content">
                <span class="info-box-text" id="failed-message">Uploads</span>
              </div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="button" class="btn btn-primary" onclick="ajaxUpload()" disabled id="uploadBtn">上传</button>
          </div>
        </form>
      </div>
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">多文件上传</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" id="file_form_multiple">
          <div class="box-body">
            <div class="form-group">
              <label>选择文件</label>
              <input type="file" name="file" multiple class="form-control" id="multiple_files">
            </div>
            <div class="form-group">
              <label>文件分类</label>
              <select class="form-control" name="file_type_multiple">
                  <?php
                  $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'file_type'")[0]["S_value"]);
                  foreach ($types as $key => $type) {
                      echo "<option value='$key'>$type</option>";
                  }
                  ?>
              </select>
            </div>
            <div class="form-group">
              <label>文件等级</label>
              <select class="form-control" name="file_level_multiple">
                  <?php
                  $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'level'")[0]["S_value"]);
                  foreach ($types as $key => $val) {
                      echo "<option value='$key'>$key 级 [$val 分]</option>";
                  }
                  ?>
              </select>
            </div>
            <div class="col-md-12">
              <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-file"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">文件上传</span>
                  <div class="progress">
                    <div class="progress-bar" id="progress-bar" style="width: 0%"></div>
                  </div>
                  <span class="progress-description">
                    当前第 <span id="now">0</span> 个, 共 <span id="total">0</span> 个
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <div class="col-md-12" id="failedList">

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="button" class="btn btn-primary" onclick="ajaxUpload_multiple()" id="uploadBtn_multiple">上传</button>
          </div>
        </form>
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
  function FileSelected (el) {
    let fileInfo = el.files[0];
    if (typeof fileInfo === "undefined") {
      $("#uploadBtn").attr("disabled", "disabled");
      $("#fileSize span").html("0");
      return
    } else {
      $("#uploadBtn").attr("disabled", null);
    }
    let fileSize = Math.round(fileInfo.size / 1000);
    $("#file_name").val(fileInfo.name.split('.')[0])
    $("#fileSize span").html(fileSize);
  }

  function ajaxUpload () {
    let form = new FormData(document.getElementById('file_form'));
    $.ajax({
      url: '/admin/File/add',
      type: 'post',
      data: form,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data.result === "success") {
          $("#failed").hide();
          $("#success").fadeIn();
        } else {
          $("#success").hide();
          $("#failed").fadeIn();
          $("#failed-message").html(data.reason);
        }
        let result = data.result + data.reason ? data.reason : '';
        $("#resultBox").html(result);
      }
    })
  }
  function ajaxUpload_multiple () {
    let files = document.getElementById('multiple_files').files
    let total = files.length
    let now = 0
    $("#total").html(total)
    $.each(files,function (key,val) {
      let form = new FormData();
      form.append('file_type',$("select[name=file_type_multiple]").val())
      form.append('file_level',$("select[name=file_level_multiple]").val())
      form.append('file',val)
      $.ajax({
        url: '/admin/File/add',
        type: 'post',
        data: form,
        processData: false,
        contentType: false,
        success: function () {
          now += 1
          let progress = Math.ceil((now / total) * 100)
          $("#now").html(total)
          $('#progress-bar').css('width',progress + '%')
        },
        error: function (result) {
          $("#failedList").append("<p>"+ result.responseJSON.reason +"</p>")
        }
      })
    })

  }
</script>

</body>
</html>
