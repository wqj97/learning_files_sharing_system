<?php
require_once 'SQL/Db.php';
$Db = new Db();
$page = isset($_GET['page']) ? $_GET["page"] : 0;
$keywords = isset($_GET['keyWords']) ? $_GET['keyWords'] : '';
$start = $page * 12;
function getLevel ($credit)
{
    global $Db;
    $level = json_decode($Db->query("SELECT * FROM Setting WHERE S_key = 'level'")[0]["S_value"], true);//0,9,24,45
    foreach ($level as $levelKey => $levelVal) {
        if ($credit - $levelVal <= 0) {
            if ($credit - $levelVal == 0) {
                return $levelKey;
            }
            return $levelKey - 1;
        }
    }
    return 3;
}

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
        <li class="treeview active">
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
        用户管理
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> 用户管理</a></li>
        <li class="active">用户管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">用户列表</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="pull-right" style="padding-right: 15px;">
                <div>
                  <label>用户名/学校名称:
                    <input type="search" class="form-control" onkeydown="if(event.keyCode === 13) search(this.value)"
                           value="<?php
                           if (!empty($keywords)) {
                               echo $keywords;
                           }
                           ?>">
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
                    <!--                      <th>文件Id</th>-->
                    <th>用户名</th>
                    <th>文件上传数</th>
                    <th>积分 [ 等级 ]</th>
                    <th>加入时间</th>
                    <th>操作</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $user = $Db->query("SELECT
  U_Id,
  U_name,
  (SELECT S_name
   FROM School
   WHERE S_Id = U_school)          AS 'school_name',
  (SELECT COUNT(*)
   FROM File
   WHERE F_user_openid = U_openid) AS File_count,
  U_credit,
  U_join_date
FROM User
where U_name like '%$keywords%'
ORDER BY U_Id DESC
LIMIT $start, 12;");
                  $school_user = $Db->query("select S_Id from School where S_name like '%$keywords%'");
                  foreach ($school_user as $school) {
                      $user_list = $Db->query("SELECT
  U_Id,
  U_name,
  (SELECT S_name
   FROM School
   WHERE S_Id = U_school)          AS 'school_name',
  (SELECT COUNT(*)
   FROM File
   WHERE F_user_openid = U_openid) AS File_count,
  U_credit,
  U_join_date
FROM User
where U_school = {$school["S_Id"]}
ORDER BY U_Id DESC
LIMIT $start, 12;");
                      foreach ($user_list as $item) {
                        $user[] = $item;
                      }
                  }
                  foreach ($user as $row) {
                      $user_level = getLevel($row["U_credit"]);
                      echo "
                      <tr role=\"row\" class=\"even\">
                      <td class=\"sorting_1\">$row[U_name] [ $row[school_name] ]</td>
                      <td class=\"sorting_1\">$row[File_count]</td>
                      <td class=\"sorting_1\">$row[U_credit] [ $user_level 级 ]</td>
                      <td class=\"sorting_1\">$row[U_join_date]</td>
                      <td class=\"sorting_1\">
                      <div class=\"btn-group\">
                        <button type=\"button\" class=\"btn btn-info\" onclick='showUserEdit($row[U_Id])'>修改</button>
                      </div>
                      </td>
                      ";
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <!--                      <th>文件Id</th>-->
                    <th>用户名</th>
                    <th>文件上传数</th>
                    <th>积分 [ 等级 ]</th>
                    <th>加入时间</th>
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
                    $count = $Db->query("SELECT count(*) FROM User")[0]["count(*)"];
                    $echoCount = $start + 1;
                    echo "当前 $echoCount 到 " . ($echoCount + 11) . ", 共 $count 个用户";
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
                      echo "User-control.php?page=$prewPage&keyWords=$keywords";
                      ?>">上一页</a>
                    <li class="paginate_button next">
                      <a href="<?php
                      $nextPage = $page + 1;
                      echo "User-control.php?page=$nextPage&keyWords=$keywords";
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
          <!-- /.box-body -->
        </div>
    </section>
    <!-- /.content -->
  </div>
</div>

<div class="modal fade" id="user_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">用户信息</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>用户名: </label>
          <input type="text" class="form-control" placeholder="用户名" id="user_name">
        </div>
        <div class="form-group">
          <label>所在学校</label>
          <select class="form-control" id="user_school">
              <?php
              $schools = $Db->query("SELECT * FROM School");
              foreach ($schools as $key => $school) {
                  echo "<option value='$school[S_Id]'>$school[S_name]</option>";
              }
              ?>
          </select>
        </div>
        <div class="form-group">
          <label>积分: </label>
          <input type="number" class="form-control" placeholder="积分" id="user_credit">
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
	function search (keyWords) {
		window.location.href = 'User-control.php?page=0' + '&keyWords=' + keyWords;
	}

	function showUserEdit (Id) {
		$.get(`/admin/user?user_id=${Id}`, function (data) {
			$("#user_school").val(data.U_school)
			$("#user_credit").val(data.U_credit)
			$("#user_name").val(data.U_name)
			$("#user_edit").modal()
			$("#editBtn").attr("onclick", `save(${Id})`)
		})
	}

	function save (Id) {
		$.post('/admin/User/save', {
			user_id: Id,
			user_name: $("#user_name").val(),
			user_school: $("#user_school").val(),
			user_credit: $("#user_credit").val()
		}, function () {
			location.reload()
		})
	}
</script>

</body>
</html>
