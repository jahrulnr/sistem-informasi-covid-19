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
  <!-- select2 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Heebo:300,400,400i,700&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <!-- Moment -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/locale/id.js') }}"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>

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
        <a href="/" class="nav-link">Home</a>
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
    <a href="/" class="brand-link text-center">
      <span class="brand-text font-weight-light"><sub>Sistem Informasi</sub><br/><b>Covid-19</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Beranda
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
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content pt-3">
      <script type="text/javascript">
        function make_chart(id, json_data){
          var myChart = new Chart(id, {
            type: 'bar',
            options: {
              maintainAspectRatio: false,
              locale: 'id',
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            },
            data: json_data,
          });
        }
      </script>

      <!-- Chart Content -->
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">
                Data Covid-19 dari {{ count($priode) }} priode terakhir
              </h3>
            </div>
          </div>
          <div class="card-body">
            <div class="position-relative mb-4">
              <canvas id="covid-chart" height="200"></canvas>
              <script type="text/javascript">
                make_chart('covid-chart', {
                  labels: [
                    @foreach($priode as $p)
                    "{{$p[1]}}",
                    @endforeach
                    ],
                  datasets: [{ 
                    data: [
                      {{implode(",", $hijau)}}
                    ],
                    label: "Hijau",
                    borderColor: "#0a0",
                    backgroundColor: "#0b0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $kuning)}}
                    ],
                    label: "Kuning",
                    borderColor: "#ee0",
                    backgroundColor: "#ff0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $orange)}}
                    ],
                    label: "Orange",
                    borderColor: "#fa0",
                    backgroundColor:"#fa0",
                    fill: false
                  }, { 
                    data: [
                      {{implode(",", $merah)}}
                    ],
                    label: "Merah",
                    borderColor: "#e00",
                    backgroundColor:"#e00",
                    fill: false
                  }]
                });
              </script>
            </div>
          </div>
        </div>
      </div>
      <!-- Chart Content -->

      <!-- Chart Content -->
      <div class="col-12">
        <div class="card">
          <div class="card-header border-0">
            <div class="col-11 col-md-5 col-lg-4 d-flex">
              <label style="padding-top: 0.2rem;" class="mr-2">Periode</label>
              <select class="form-control form-control-sm" id="periode" name="periode">
                @foreach(array_reverse($priode) as $p)
                <option value="{{ $p[0] }}">{{ $p[1] }}</option>
                @endforeach
              </select>
            </div>      
            <hr class="mb-0" />        
          </div>
          <div class="card-body">
            <div class="row" id="chart_periode"></div>
          </div>
        </div>
      </div>
      <!-- Chart Content -->

    </section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; {{ $_SERVER['HTTP_HOST'] }} All rights
    reserved.
  </footer>

  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <script type="text/javascript">
    $('#periode').select2();

    function getJSON(id){
      $.ajax({url: "/periode/" + id, success: function(result){
        if(result == '[]'){
          $('#chart_periode').html("Belum ada data.");
          return false;
        }
        var data = JSON.parse(result);
        var show_chart = "";
        var j = 1;

        $.each(data, function(i, v){
          var kelurahan = i;
          var c = '<div class="col-md-6"><h5 class="mb-0">Kelurahan '+kelurahan+'</h5><div class="position-relative mb-4"><canvas id="covid-chart-'
          + j
          +'" height="200"></canvas><script>make_chart("covid-chart-'+j+'", '+JSON.stringify(v)+');<\/script></div></div>';
          show_chart += c;
          j++;
        });
        $('#chart_periode').html(show_chart);
      }});
    }

    $(document).ready(function(){
      getJSON($('#periode').val());
      $('#periode').change(function(){
        getJSON($(this).val());
      });
    });
  </script>
</div>
</body>
</html>
