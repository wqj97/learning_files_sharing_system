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
        <li class="treeview active">
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
        通知列表
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-volume-up"></i> 通知列表</a></li>
        <li class="active">通知列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">通知列表</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row col-md-2">
              <button class="btn btn-block btn-info btn-lg" onclick="showNewNotice()">新建通知</button>
            </div>
            <div class="row">
              <div class="pull-right" style="padding-right: 15px;">
                <div>
                  <label>通知标题:
                    <input type="search" class="form-control" onkeydown="if(event.keyCode === 13) search(this.value)"
                           value="<?php echo $keywords ?>">
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                       aria-describedby="example1_info">
                  <thead>
                  <tr role="row">
                    <!--                    <th>文件Id</th>-->
                    <th>通知标题</th>
                    <th>通知链接</th>
                    <th>操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $start = $page * 12;
                  if ($keywords) {
                      $notice_list = $Db->query("select * from Notice_record where N_title like '%$keywords%' ORDER BY N_Id desc LIMIT $start,12");
                  } else {
                      $notice_list = $Db->query("select * from Notice_record ORDER BY N_Id desc LIMIT $start,12");
                  }
                  foreach ($notice_list as $row) {
                      echo "
                      <tr role=\"row\" class=\"even\">
                      <td class=\"sorting_1\">$row[N_title]</td>
                      <td class=\"sorting_1\"><a href='$row[N_url]'>$row[N_url]</a></td>
                      <td class=\"sorting_1\">
                      <div class=\"btn-group\">
                        <button type=\"button\" class=\"btn btn-primary\" onclick='showEdit($row[N_Id])'>修改</button>
                        <button type=\"button\" class=\"btn btn-danger\" onclick='refuse($row[N_Id])'>删除</button>
                      </div>
                      </td>
                      ";
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <!--                    <th>文件Id</th>-->
                    <th>通知标题</th>
                    <th>通知链接</th>
                    <th>操作</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
                    <?php
                    $count = $Db->query("SELECT count(*) FROM File")[0]["count(*)"];
                    $echoCount = $start + 1;
                    echo "当前 $echoCount 到 " . ($echoCount + 11) . ", 共 $count 个文件";
                    ?>
                </div>
              </div>
              <div class="col-sm-12 text-center">
                <div class="dataTables_paginate paging_simple_numbers">
                  <ul class="pagination">
                    <li class="paginate_button previous <?
                    if ($page == 0) {
                        echo "disabled";
                    }
                    ?>">
                      <a href="<?php
                      $prewPage = $page - 1;
                      echo "File-modify.php?page=$prewPage&keyWords=$keywords";
                      ?>">上一页</a>
                    <li class="paginate_button next">
                      <a href="<?php
                      $nextPage = $page + 1;
                      echo "File-modify.php?page=$nextPage&keyWords=$keywords";
                      ?>">下一页</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-12">
                <form class="form-group" action="">
                  <label>跳转到: </label>
                  <input type="number" name="page" class="form-control" value="<?php echo $page ?>">
                  <button type="submit" class="btn btn-info">跳转</button>
                  <input type="hidden" name="keyWords" value="<?php echo $keywords ?>">
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
</div>

<div class="modal fade" id="Notice_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">通知编辑</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>通知标题: </label>
          <input type="text" class="form-control" placeholder="通知标题" id="Notice_title">
        </div>
        <div class="form-group">
          <label>通知链接: </label>
          <input type="url" class="form-control" placeholder="通知链接" id="Noitce_url">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="editBtn">修改</button>
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
  function showEdit (Id) {
    $.get('/admin/notice/get?notice_id=' + Id, function (data) {
      $("#Notice_title").val(data.N_title)
      $("#Noitce_url").val(data.N_url)
      $("#editBtn").attr("onclick", `save(${Id})`)
      $("#Notice_edit").modal()
    })
  }

  function showNewNotice () {
    $("#Notice_title").val('')
    $("#Noitce_url").val('')
    $("#editBtn").attr("onclick", `newNotice()`)
    $("#Notice_edit").modal()
  }

  function save (Id) {
    $.post('/admin/notice/edit', {
      notice_id: Id,
      notice_title: $("#Notice_title").val(),
      notice_url: $("#Noitce_url").val()
    },function () {
      location.reload()
    })
  }

  function newNotice () {
    $.post('/admin/notice/new',{
      notice_title: $("#Notice_title").val(),
      notice_url: $("#Noitce_url").val()
    },function () {
      location.reload()
    })
  }

  function refuse (Id) {
    $.post('/admin/notice/delete',{
      notice_id: Id
    },function () {
      location.reload()
    })
  }
</script>


</body>
</html>
