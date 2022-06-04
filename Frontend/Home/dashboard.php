<?php
include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.html'; ?>
<?php
require_once('configure.php');

$query = "SELECT engine, count(engine) No_Of_sources
  FROM link 
  GROUP BY engine 
  ORDER BY No_Of_sources DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $sources[] = $row["engine"];
  $no_of_sources[] = $row["No_Of_sources"];
}
$data = json_encode($sources);
$data1 = json_encode($no_of_sources);
?>
<?php
require_once('configure.php');

$query = "SELECT category, count(category) No_Of_category
  FROM link 
  GROUP BY category 
  ORDER BY No_Of_category DESC";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $category[] = $row["category"];
  $no_of_categories[] = $row["No_Of_category"];
}
$data2 = json_encode($category);
$data3 = json_encode($no_of_categories);
?>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-gradient-primary position-absolute w-100"></div>
  <?php include 'sidebar.html'; ?>
  <main class="main-content position-relative border-radius-lg">
    <?php
    include("navbar.php");
    ?>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-lg mb-0">
                      Total URLs
                    </p>
                    <?php
            require 'configure.php';
            $query = "SELECT domain, count(domain) No_Of_links
                      FROM `link`";

            $result = mysqli_query($conn, $query);
            while($fetch = mysqli_fetch_array($result)){
            ?>
                    <h5 class="font-weight-bolder"><?php echo $fetch["No_Of_links"]; ?></h5>
                   <?php } ?>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="mdi mdi-poll text-md opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-lg mb-0">
                      Total Online
                    </p>
                    <?php
            require 'configure.php';
            $query = "SELECT count(status) No_Of_active
                      FROM `link` where status = 'Active' ";

            $result = mysqli_query($conn, $query);
            while($fetch = mysqli_fetch_array($result)){
            ?>
                    <h5 class="font-weight-bolder"><?php echo $fetch["No_Of_active"]; ?></h5>
                   <?php } ?>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="mdi mdi-pulse text-md opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-lg mb-0" style = "letter-spacing:0.2px !important">
                      Total Offline
                    </p>
                    <?php
            require 'configure.php';
            $query = "SELECT count(status) No_Of_inactive
                      FROM `link` where status = 'InActive' ";

            $result = mysqli_query($conn, $query);
            while($fetch = mysqli_fetch_array($result)){
            ?>
                    <h5 class="font-weight-bolder"><?php echo $fetch["No_Of_inactive"]; ?></h5>
                   <?php } ?>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="mdi mdi-power-settings text-md opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="fs-6 mb-0">
                      Total Categories
                    </p>
                    <?php 
            require 'configure.php';
            $query = "SELECT count(distinct category) No_Of_category
            FROM link";

            $result = mysqli_query($conn, $query);
            while($fetch = mysqli_fetch_array($result)){
            ?>
                    <h5 class="font-weight-bolder"><?php echo $fetch["No_Of_category"]; ?></h5>
                   <?php } ?>
                   
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-tag text-md opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Links gathered from Dark Web sources overview</h6>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card card-carousel overflow-hidden h-100 p-0">
            <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
              <div class="carousel-inner border-radius-lg h-100">
                <div class="carousel-item h-100 active bg-primary opacity-7" style="
                      background-size: cover;
                    ">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <h5 class="mb-1 fst-italic" style="color:blue">Get started with Oni-Gator</h5>
                    <p>
                      Platform to see trends of illegal activities taking place on Dark Web.
                    </p>
                  </div>
                </div>
                <div class="carousel-item h-100 bg-primary opacity-6" style="
                      background-size: cover;
                    ">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <h5 class="mb-1 fst-italic" style="color:blue">
                      Dark Web Analysis
                    </h5>
                    <p>
                      Data Gathering using dark web crawler and displaying it on dashboard after categorization.
                    </p>
                  </div>
                </div>
                <div class="carousel-item h-100 bg-primary opacity-5" style="
                      background-size: cover;
                    ">
                  <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                    <h5 class="mb-1 fst-italic" style="color:blue">
                      Dark Web Fornsics
                    </h5>
                    <p>
                      Tracking change in Domain using file matching
                    </p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-header pb-0 p-3 bg-transparent">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">Links by Categories</h6>
              </div>
              <div class="card-body p-3">
                <div class="chart">
                  <canvas id="chartpolar" class="chart-canvas" height="300"></canvas>
                </div>
                <!-- <div id="chart"></div> -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 border-radius-lg">
          <div class="card" style = "overflow-y:scroll; height:400px;">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Categories Searched with Results</h6>
            </div>
            <?php
            require 'configure.php';
            $query = "SELECT category, count(category) No_Of_category
                      FROM `link` 
                      GROUP BY category 
                      ORDER BY No_Of_category DESC";

            $result = mysqli_query($conn, $query);
            foreach ($result as $keys => $values) {
            ?>
              <div class="card-body" style="padding:5px 15px 5px 15px !important">
                <ul class="list-group border-radius-lg  bg-gradient-primary shadow-primary">
                  <a href="category_detail.php?category=<?php echo $values["category"]; ?>" class="text-white icon-move-right my-auto border-radius-lg modalLink">
                    <li class="list-group-item  align-items-center  bg-gradient-primary shadow-primary border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                      <div class="d-flex p-3 align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="mb-1 text-white text-capitalize"><?php echo $values["category"]; ?></h6>
                          <span class="text-sm">Total Links:
                            <span class="font-weight-bold"><?php echo $values["No_Of_category"]; ?></span></span>
                        </div>
                      </div>
                      <div class="d-flex btn-link btn-icon-only btn-rounded text-white">
                        <i class="ni ni-bold-right" aria-hidden="true"></i>
                      </div>
                    </li>
                  </a>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php include 'footer.html'; ?>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="assets/js/plugins/chartjs.min.js"></script>

  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");
    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, "rgba(94, 114, 228, 0.2)");
    gradientStroke1.addColorStop(0.2, "rgba(94, 114, 228, 0.0)");
    gradientStroke1.addColorStop(0, "rgba(94, 114, 228, 0)");
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: <?php echo ($data) ?>,
        datasets: [{
          label: "Links Crawled",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: <?php echo ($data1) ?>,
          maxBarThickness: 6,
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#0000FF",
              font: {
                size: 11,
                family: "Raleway",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#0000FF",
              padding: 20,
              font: {
                size: 11,
                family: "Raleway",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    });
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- <script>
    var colorPalette = ["#3B5998", "#000000", "#ffb22b", "#99abb4", "#bd081c", "#fc4b6c", '#775DD0', "#1da1f2", '#008FFB'];
    var options = {
      maintainAspectRatio: false,
      series: <?php echo ($data3) ?>,
      chart: {
        width: 450,
        type: 'polarArea'
      },
      labels: <?php echo ($data2) ?>,
      fill: {
        opacity: 1
      },
      stroke: {
        width: 1,
        colors: "#ffffff",
      },
      colors: colorPalette,
      yaxis: {
        show: true
      },
      legend: {
        position: 'left'
      },
      plotOptions: {
        polarArea: {
          rings: {
            strokeWidth: 0
          },
          spokes: {
            strokeWidth: 0
          },
        }
      },
      // theme: {
      //   monochrome: {
      //     enabled: true,
      //     shadeTo: 'light',
      //     shadeIntensity: 0.6
      //   }
      // }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  </script> -->
  <script>
    const ctx = document.getElementById('chartpolar').getContext('2d');
    const chartpolar = new Chart(ctx, {
      type: 'polarArea',
      data: {
        labels: <?php echo ($data2) ?>,
        datasets: [{
          label: 'Link related to category:',
          data: <?php echo ($data3) ?>,
          backgroundColor: [
            "#ffb22b",
            '#775DD0',
            "#3B5998",
            "#a6b1b7",
            "#1da1f2",
            "#bd081c",
            "#7460ee",
            "#fc4b6c",
            "#000000",
            "#ffb22b",
            "#99abb4",
          ],
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: true,
            position: "left",
          },

        },
      }
    });
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/argon-dashboard.min.js?v=2.0.1"></script>
</body>

</html>