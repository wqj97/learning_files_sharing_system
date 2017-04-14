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
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  <header class="main-header">
    <!-- Logo -->
    <a href="home.php" class="logo">
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
            <li class="active">
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
        文件审批
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-file"></i> 文件管理</a></li>
        <li class="active">文件审批</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">未审批文件</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="example1_info">
                  <thead>
                  <tr role="row">
                    <!--                      <th>文件Id</th>-->
                    <th>文件名</th>
                    <th>文件扩展名</th>
                    <th>文件上传用户</th>
                    <th>文件上传时间</th>
                    <th>操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $unsolve_file = $Db->query("SELECT F_Id,F_name,F_ext,F_user_openid,F_join_time FROM File WHERE `F_type` IS NULL");
                  foreach ($unsolve_file as $row) {
                      $userName = $Db->query("select U_name,(select S_name from School where S_Id = U_school) as 'school_name' from User where U_openid = '$row[F_user_openid]'")[0];
                      echo "
                      <tr role=\"row\" class=\"even\">
                      <td class=\"sorting_1\" id='$row[F_Id]'>$row[F_name]</td>
                      <td class=\"sorting_1\">$row[F_ext]</td>
                      <td class=\"sorting_1\">$userName[U_name] [ $userName[school_name] ]</td>
                      <td class=\"sorting_1\">$row[F_join_time]</td>
                      <td class=\"sorting_1\">
                      <div class=\"btn-group\">
                        <button type=\"button\" class=\"btn btn-info\" onclick='getFile($row[F_Id])'>查看</button>
                        <button type=\"button\" class=\"btn btn-success\" onclick='showAgree($row[F_Id])'>通过</button>
                        <button type=\"button\" class=\"btn btn-danger\" onclick='refuse($row[F_Id])'>删除</button>
                      </div>
                      </td>
                      ";
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <!--                      <th>文件Id</th>-->
                    <th>文件名</th>
                    <th>文件类型</th>
                    <th>文件上传用户</th>
                    <th>文件上传时间</th>
                    <th>操作</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
  </div>
</div>
<div class="modal fade" id="preview">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">文件预览</h4>
      </div>
      <div class="modal-body" style="display: flex"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="agree-btn">通过</button>
        <button type="button" class="btn btn-danger" id="refuse-btn">删除</button>
        <button type="button" class="btn btn-default">关闭</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="file_type">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">文件类型</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>文件名: </label>
          <input type="text" class="form-control" placeholder="文件名" id="file_name">
        </div>
        <div class="form-group">
          <label>文件分类</label>
          <select class="form-control" id="file_type_code">
              <?php
              $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'file_type'")[0]["S_value"]);
              foreach ($types as $key => $type) {
                  echo "<option value='$key'>$type</option>";
              }
              ?>
          </select>
          <label>文件等级</label>
          <select class="form-control" id="file_level">
              <?php
              $types = json_decode($Db->query("SELECT S_value FROM Setting WHERE S_key = 'level'")[0]["S_value"]);
              foreach ($types as $key => $val) {
                  echo "<option value='$key'>$key 级 [$val 分]</option>";
              }
              ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="agreeBtn">通过</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3.2.1 -->
<script src="plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<script>
  function getFile (Id) {
    $.get("/admin/File?file_id=" + Id, function (data) {
      data.F_url = "https://wx.97qingnian.com" + data.F_url;
      if (data.F_ext === "pdf") {
        $("#preview .modal-body").html('').append('<iframe frameborder="0" width="1024px" height="768px" src="' + data.F_url + '"></iframe>');
      } else {
        $("#preview .modal-body").html('').append('<iframe frameborder="0" width="1024px" height="768px" src="https://view.officeapps.live.com/op/view.aspx?src=' + data + '"></iframe>');
      }
      $("#preview").modal();
      $("#agree-btn").attr("onclick", "showAgree(" + Id + ")");
      $("#refuse-btn").attr("onclick", "refuse(" + Id + ")");
    })
  }

  function showAgree (Id) {
    $("#file_type").modal();
    $("#file_name").val($("#" + Id).html());
    $("#agreeBtn").attr("onclick", "agree(" + Id + ")");
  }

  function agree (Id) {
    let type = $("#file_type_code").val();
    let level = $("#file_level").val();
    let file_name = $("#file_name").val();
    $.get('/admin/File/Agree?file_id=' + Id + '&file_type_code=' + type + '&file_level=' + level + '&file_name=' + file_name, function (data) {
      if (data.result === "success") {
        location.reload()
      }
    })
  }

  function refuse (Id) {
    $.get('/admin/File/Refuse?file_id=' + Id, function (data) {
      if (data.result === "success") {
        location.reload()
      }
    })
  }
</script>

</body>
</html>
