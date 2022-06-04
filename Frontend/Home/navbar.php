<?php
function breadcrumbs($separator = ' &raquo; ')
{
  $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
  $breadcrumbs = array();
  $pathkeys = array_keys($path);
  $last = end($pathkeys);
  $separator = "<a class = 'text-white' href='javascript:;'>$separator</a>";
  // Build the rest of the breadcrumbs
  foreach ($path as $x => $crumb) {
    $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));

    if ($x != $last)
      $breadcrumbs[] = "
            <a class=' breadcrumb-item text-sm opacity-5 text-white' href='javascript:;'> $title </a>
          ";
    else
      $breadcrumbs[] = "
            <a class='breadcrumb-item text-sm text-sm text-white active' href='javascript:;'> $title </a>
          ";
  }
  return implode($separator, $breadcrumbs);
}

function pagename()
{
  $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
  $pathkeys = array_keys($path);
  $last = end($pathkeys);

  foreach ($path as $x => $crumb) {
    $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));

    if ($x != $last)
      $breadcrumbs[] = "<li class='breadcrumb-item text-sm'>
          <a class='opacity-5 text-white' href='javascript:;'>$title</a>
        </li>";
    else
      $pagename[] = "$title";
  }
  return implode($pagename);
}
?>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <div>
      <?= breadcrumbs(' / ') ?>
      <h6 class="fst-italic fw-lighter text-white text-lg mb-0"><?= pagename() ?></h6>
    </div>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
        </li>
        <li class="nav-item dropdown pe-2 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ni ni-circle-08 text-lg opacity-10"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
            <li class="mb-2">
              <a class="dropdown-item border-radius-md" href="javascript:;">
                <div class="d-flex py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm text-black font-weight-normal mb-1" style="color:blue !important">
                      <?php echo htmlspecialchars($_SESSION["username"]); ?>
                    </h6>
                    <p class="text-xs text-secondary mb-0" style="color:black !important">
                      Username
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="mb-2">
              <a class="dropdown-item border-radius-md" href="logout.php">
                <div class="d-flex py-1">
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm text-black font-weight-normal mb-1" style="color:blue !important">
                      <i class="fa fa-power-off" style="color:black !important"></i>&nbsp;&nbsp;Logout
                    </h6>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>