<?php
include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">
<?php
include("head.html");
?>

<head>
  <link href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

  <style>
    div.dataTables_wrapper div.dataTables_length select {
      width: 60px !important;
    }

    li a {
      border: none !important;
    }

    .page-item {
      margin: 10px !important
    }
  </style>

</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-gradient-primary position-absolute w-100"></div>
  <?php
  include("sidebar.html");
  ?>
  <main class="main-content position-relative border-radius-lg">
    <?php
    include("navbar.php");
    ?>
    <div class="container-fluid py-4">
      <h5 class="text-white text-center">Search Category</h5>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">
            <form class="card card-sm contact-form1" method="POST" action="search.php">
              <div class="card-body row no-gutters align-items-center">
                <div class="col-auto">
                  <i class="fas fa-search h4 text-body" style="margin:0"></i>
                </div>
                <!--end of col-->
                <div class="col">
                  <input type="text" class="form-control form-control-lg form-control-borderless" placeholder="Search here..." name="keyword" required="required" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" />

                </div>
                <!--end of col-->
                <div class="col-auto">
                  <button class="btn btn-primary" style="margin:0" name="search" type="submit">Search</button>
                </div>
                <!--end of col-->
              </div>
            </form>
          </div>
          <!--end of col-->
        </div>
      </div>
  </div>
      <br /><br />
      <div class="container-fluid py-4">
        <div class="card table-responsive m-t-40 p-3">
        <h4 class="text-center">Category: <span class="text-capitalize text-normal fst-italic">"<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>"</span>
        </h4>
            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Domain
                        </th>
                        <th class="th-sm">Status
                        </th>
                        <th class="th-sm">Source
                        </th>
                        <th class="th-sm">
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    if (isset($_POST['search'])) {
                      $keyword = $_POST['keyword'];
                    $keyword = $_GET['category'];
                    require 'configure.php';
                    $query = mysqli_query($conn, "SELECT * FROM `link` WHERE `category` LIKE '%$keyword%'");
                    foreach ($query as $keys => $values) {
                    ?>
                        <tr>
                            <td><?php echo $values["domain"]; ?></td>
                            <td><?php echo $values["status"]; ?></td>
                            <td><?php echo $values["engine"]; ?></td>
                            <td><a class='btn btn-primary' href='linkinfo.php?id=<?php echo $values["id"]; ?>' class='text-white font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                                    More Info
                                </a></td>
                        </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script>$(function(){$("#myTable").DataTable(),$(function(){var e=$("#example").DataTable({columnDefs:[{visible:!1,targets:2}],order:[[2,"asc"]],displayLength:25,drawCallback:function(a){var e=this.api(),r=e.rows({page:"current"}).nodes(),t=null;e.column(2,{page:"current"}).data().each(function(a,e){t!==a&&($(r).eq(e).before('<tr class="group"><td colspan="5">'+a+"</td></tr>"),t=a)})}});$("#example tbody").on("click","tr.group",function(){var a=e.order()[0];2===a[0]&&"asc"===a[1]?e.order([2,"desc"]).draw():e.order([2,"asc"]).draw()})})}),$("#example23").DataTable({dom:"Bfrtip",scrollX: true,buttons:["copy","csv","excel","pdf","print"]});</script>

  <!--   Core JS Files   -->
  <?php
  include("core.html");
  ?>
</body>

</html>
              
