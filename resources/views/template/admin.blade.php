<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Informasi Covid-19</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,400i,700&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ asset('admin') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link text-center">
      <span class="brand-text font-weight-light"><sub>Sistem Informasi</sub><br/><b>Covid-19</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">

          <li class="nav-header">MENU</li>

          <li class="nav-item">
            <a href="{{ asset('admin/data_covid19') }}" class="nav-link">
              <i class="nav-icon fas fa-virus"></i>
              <p>
                Data Covid-19
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('admin/periode') }}" class="nav-link">
              <i class="nav-icon fas fa-calendar-week"></i>
              <p>
                Periode
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ asset('admin/user') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                User
              </p>
            </a>
          </li>

          <li class="nav-header">KELUAR</li>

          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#keluar">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper pt-3">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; {{ $_SERVER['HTTP_HOST'] }} All rights
    reserved.</strong>
  </footer>

  <!-- Modal -->
  <div class="modal fade" id="keluar" tabindex="-1" role="dialog" aria-labelledby="label_keluar" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="label_keluar">
             Konfirmasi Keluar
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin ingin keluar?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
          <a href="{{ asset('/admin/keluar') }}" class="btn btn-danger">Ya</a>
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
</body>
</html>
