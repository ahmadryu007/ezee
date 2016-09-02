<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Pelanggan
        <small>ezeelink</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Pelanggan</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Pelanggan</span>
              <span class="info-box-number"><?php echo $jumlahCust; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kota Dengan</span>
              <span class="info-box-text">Pelanggan Terbanyak</span>
              <span class="info-box-number">
                <?php
                  echo $highCity->Kota;
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-male"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Jumlah </span>
              <span class="info-box-text">Pelanggan Pria</span>
              <span class="info-box-number">41</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-female"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah </span>
              <span class="info-box-text">Pelanggan Wanita </span>
              <span class="info-box-number">50</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-3">
          <a href="#analisis" class="btn btn-default">Analisis Data Pelanggan</a>&nbsp;&nbsp;&nbsp;
          <a href="<?php echo $base_url;?>index.php/customers/addCustomer" class="btn btn-warning">Tambah Data</a>
        </div>
      </div>

      <br />

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pelanggan</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/customers" method="post">
              <label>Cari Berdasarkan</label>
              <select class="form-control" name="searchField">
                <option value="Nama">Nama</option>
                <option value="Alamat">Alamat</option>
                <option value="Kota">Kota</option>
              </select>
              <br />
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari">
                  <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
              </div>
              <br />
              <?php 
                if (!empty($search)){
                  echo 'Menampilkan Data Pelanggan Dengan <strong>'.$searchField.'</strong> <i>"'.$search.'"</i> '; 
                  echo '<br />';
                }
              ?>
            </form>

            <!--  <table id="example1" class="table table-bordered table-striped">
              </table> -->
              <label><?php echo $message; ?></label>
              <br />
              <form action="<?php echo $base_url;?>index.php/customers/download_pdf" method="get">
                <div class="col-md-6">
                  <input type="submit" id="import" class="btn btn-warnig" value="Export Data yang Dipilih Ke File PDF">
                  <input type="text" id="jumlah" name="jumlah" value=0 size=5 disabled>
                  <a href="<?php echo $base_url;?>index.php/customers/download_csv" class="btn btn-info">
                    <i class="fa fa-file-excel-o">&nbsp;&nbsp;Export Semua Data Ke File .XLS</i>
                  </a>
                </div>
                </form>
                <form action="<?php echo $base_url;?>index.php/customers" method="post">
                  <div class="col-md-6">
                    <label>Tampilkan Per</label>
                      <select name="limit">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="99999999">Semua</option>
                      </select>
                    <label>Data</label>
                    <input type="submit" class="btn btn-default" value="Ok">
                  </div>
                  <br />
                  <div><?php echo $table;?></div>
                </form>
                
              <script type="text/javascript">
              function clickAll(){
                var checked = false;
                if (document.getElementById("checkMaster").checked == true)
                  checked = true;
                var tbl = document.getElementById("lineItemTable");
                var rowLen = tbl.rows.length;
                for (var idx = 1; idx < rowLen; idx++) {
                  var row = tbl.rows[idx];
                  var cell = row.cells[0];
                  var node = cell.lastChild;
                  node.checked = checked;
                }
                cek();
              }

              function cek(){
                var tbl = document.getElementById("lineItemTable");
                var rowLen = tbl.rows.length;
                var jumlah = 0;
                for (var idx = 1; idx < rowLen; idx++) {
                  var row = tbl.rows[idx];
                  var cell = row.cells[0];
                  var node = cell.lastChild;
                  if (node.checked == true)
                    jumlah++;

                  document.getElementById('jumlah').value = jumlah;
                }
              }
              </script>
              <ul class="pagination pagination-sm">
                <li>
                  <?php
                    if(empty($search)) 
                    echo $pagination; 
                  ?>
                </li>
              </ul>
              <br />
            </div>
        
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <script type="text/javascript" src="<?php echo $base_url;?>assets/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $base_url;?>assets/Chart.js"></script>

        <div class="col-md-6" id="analisis">

          <!-- BAR CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Data Pekerjaan Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="demoChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->


        </div>

        <!-- /.col (LEFT) -->
        <div class="col-md-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Data Transaksi Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="testChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>
          <!-- /.box -->

        <div class="col-md-6">
          <!-- PIE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Data Kota Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="doughnatLegend"></div>
              </div>
              <div class="chart">
                <canvas id="doughnatChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Chart Analisis Rating Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="ratingLegend"></div>
              </div>
              <div class="chart">
                <canvas id="ratingChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <div class="col-md-6">
          <!-- PIE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Data Umur Pelanggan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-3">
                <div id="umurLegend"></div>
              </div>
              <div class="chart">
                <canvas id="umurChart" style="height:250px"></canvas>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        </div>


        <script type="text/javascript" src="<?php echo $base_url;?>assets/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $base_url;?>assets/Chart.js"></script>

        <script type="text/javascript">
              $(document).ready(function(){

                  // bar chart data pekerjaan
                  var data = {
                      labels: <?php echo $contactTitle; ?>,
                      datasets: [
                          {
                              fillColor:  "rgba(220,220,220,0.2)",
                              strokeColor: "rgba(220,220,220,1)",
                              pointColor:  "rgba(220,220,220,1)",
                              pointStrokeColor: "#FFF",
                              pointHighlightFill: "#FFF",
                              pointHighlightStroke: "rgba(220,220,220,1)",
                              data: <?php echo $groupContactTitle; ?> }
                      ]
                  };

                  var ctx = document.getElementById("demoChart").getContext("2d");
                  var chart = new Chart(ctx).Bar(data);

                  // =============================================================
                  // line chart data transaksi pelanggan
                  var data2 = {
                            labels: ["January", "February", "March", "April", "May", "June", "July"],
                            datasets: [
                                {
                                    label: "My First dataset",
                                    fillColor: "rgba(220,220,220,0.2)",
                                    strokeColor: "rgba(220,220,220,1)",
                                    pointColor: "rgba(220,220,220,1)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: [65, 59, 80, 81, 56, 55, 40]
                                }
                            ]
                        };

                  var ctx2 = document.getElementById("testChart").getContext("2d");
                  var chart2 = new Chart(ctx2).Line(data2);

                  // ==============================================================
                  // pie chart data kota pelanggan

                  var data4 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($customerKota as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "'.$c->Kota.'"
                                                    },';
                                        echo $dataPie;
                                      }
                                    }
                                 ?>
                                  {
                                      value: 0,
                                      color: "",
                                      highlight: "",
                                      label: ""
                                  }
                              ]
                // doughnat
                var ctx4 = document.getElementById('doughnatChart').getContext("2d");
                var chart4 = new Chart(ctx4).Doughnut(data4);

                // ====================================================
                // bar chart rating pelanggan
                  var data5 = {
                      labels: ["Bintang 1", "Bintang 2", "Bintang 3", "Bintang 4", "Bintang 5"],
                      datasets: [
                          {
                              fillColor:  "rgb(102, 255, 204)",
                              strokeColor: "#3b8bba",
                              pointColor:  "Blue",
                              pointStrokeColor: "#FFF",
                              pointHighlightFill: "#FFF",
                              pointHighlightStroke: "rgba(220,220,220,1)",
                              data: <?php echo $groupRatingPelanggan; ?> }
                      ]
                  };

                  var ctx5 = document.getElementById("ratingChart").getContext("2d");
                  var chart5 = new Chart(ctx5).Bar(data5);

                  // ===================================================
                  // pie chart data umur pelanggan
                  var data6 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($groupUmur as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "Umur '.$c->Umur.'"
                                                    },';
                                        echo $dataPie;
                                      }
                                    }
                                 ?>
                                  {
                                      value: 0,
                                      color: "",
                                      highlight: "",
                                      label: ""
                                  }
                              ]
                // doughnat
                var ctx6 = document.getElementById('umurChart').getContext("2d");
                var chart6 = new Chart(ctx6).Pie(data6, {
                  //String - A legend template
                  legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span><br /><%}%></ul>"
                });
                document.getElementById("umurLegend").innerHTML = chart6.generateLegend();


              });
        </script>

    <div class="col-sm-9">
      <canvas id="demoChart" width="600" height="350"> </canvas>
    </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>