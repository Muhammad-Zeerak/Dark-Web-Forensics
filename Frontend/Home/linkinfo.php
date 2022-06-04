<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.html'; ?>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-gradient-primary position-absolute w-100"></div>
  <?php include 'sidebar.html'; ?>
  <main class="main-content position-relative border-radius-lg">
    <?php
    include("navbar.php");
    ?>
    <div class="container-fluid py-4">
      <div class="row">
        <center>
          <div class="col-xl-4 mb-xl-0 mb-4">
            <div class="card bg-transparent shadow-xl">
              <div class="overflow-hidden position-relative border-radius-xl">
                <span class="mask bg-gradient-dark"></span>
                <div class="card-body position-relative z-index-1 p-3">
                  <div class="text-white fs-5 fw-bold">
                    Domain Name
                  </div>
                  <div class="text-white fs-6 pb-2">
                    <?php
                    require 'configure.php';
                    if (isset($_REQUEST['id'])) {
                      $query = mysqli_query($conn, "SELECT * FROM `link` WHERE `id` = '$_REQUEST[id]'");
                      $fetch = mysqli_fetch_array($query);
                    ?>
                      <h5 class="mb-0 fw-bold fst-italic text-danger"><?php echo nl2br($fetch['domain']) ?></h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </center>
      </div>

      <div class="row mt-4">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="mdi mdi-pulse text-md opacity-10" aria-hidden="true"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0 fw-normal">Status</h6>
              <hr class="horizontal dark my-3" />
                <h5 class="mb-0 fw-bold fst-italic"><?php echo nl2br($fetch['status']) ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="ni ni-tag text-md opacity-10" aria-hidden="true"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0 fw-normal">Category</h6>
              <hr class="horizontal dark my-3" />
              <h5 class="mb-0 fw-bold fst-italic"><?php echo $fetch['category'] ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="fas fa-search text-sm opacity-10"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0 fw-normal">Source</h6>
              <hr class="horizontal dark my-3" />
              <h5 class="mb-0 fw-bold fst-italic"><?php echo $fetch['engine'] ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-3 mt-md-0 mt-4">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="fa fa-calendar-o text-md opacity-10" aria-hidden="true"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0 fw-normal">Date Crawled</h6>
              <hr class="horizontal dark my-3" />
              <h5 class="mb-0 fst-italic text-md"><?php echo $fetch['date'] ?></h5>
            </div>
          </div>
        </div>
      </div>

                    
      <div class="row">
      <center>
        <!-- <div class="col-lg-5 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Description</h6>
            </div>
            <hr class="horizontal dark my-3" />
            <div class="card-body p-3 pb-0">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark font-weight-bold text-sm">
                      <?php echo nl2br($fetch['link_detail']) ?>
                    </h6>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
       -->
        <div class="col-md-7 mt-4">
          <div class="card">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Description</h6>
            </div>
            <div class="card-body pt-4 p-3">
              <ul class="list-group">
                <li class="list-group-item border-0 d-flex p-3 mb-2 bg-gray-100 border-radius-lg">
                  <div class="d-flex flex-column">
                    <h6 class="mb-3 text-sm">Title:</h6>
                    <span class="mb-2 text-md">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo($fetch['link_detail'])?></span>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          </center>
        </div>
        
        <?php
                    }
                    ?>
      </div>
      <?php include 'footer.html'; ?>
    </div>
  </main>

  <!--   Core JS Files   -->
  <?php
  include("core.html");
  ?>
</body>

</html>