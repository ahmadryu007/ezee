<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Transaksi
        <small>ezeelink</small>
      </h1>
      <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Transaksi</a></li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Transaksi</span>
              <span class="info-box-text">Bulan Sekarang</span>
              <span class="info-box-number"><?php echo $jumlahTransaksiBulanIni->Jumlah; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Kota Dengan</span>
              <span class="info-box-text">Transaksi Terbanyak</span>
              <span class="info-box-number"><?php //echo $highKota; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-send"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Jumlah Collect</span>
              <span class="info-box-text">Point</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-reply"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Radeem </span>
              <span class="info-box-text">Point </span>
              <span class="info-box-number"></span>
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
          <a href="#analisis" class="btn btn-default">Analisis Data Transaksi</a>
        </div>
      </div>
      <br />

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Transaksi</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/transaksi" method="post">
              <label>Cari Berdasarkan</label>
              <select class="form-control" name="searchField">
                <option value="TransaksiID">ID Transaksi</option>
                <option value="TokoID">ID Toko Merchant</option>
                <option value="NoKartu">No Kartu</option>
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
                  echo 'Menampilkan Data Transaksi Dengan <strong>'.$searchField.'</strong> <i>"'.$search.'"</i> '; 
                  echo '<br />';
                }
              ?>
            </form>

            <!--  <table id="example1" class="table table-bordered table-striped">
              </table> -->
              <label><?php //echo $message; ?></label>
              <br />
              <form action="<?php echo $base_url;?>index.php/transaksi/download_pdf" method="get">
                <div class="col-md-6">
                  <input type="submit" id="import" class="btn btn-warnig" value="Export Data yang Dipilih Ke File PDF">
                  <input type="text" id="jumlah" name="jumlah" value=0 size=5 disabled>
                  <a href="<?php echo $base_url;?>index.php/transaksi/download_csv" class="btn btn-info">
                    <i class="fa fa-file-excel-o">&nbsp;&nbsp;Export Semua Data Ke File .XLS</i>
                  </a>
                </div>
                </form>
                <form action="<?php echo $base_url;?>index.php/transaksi" method="post">
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

              <ul class="pagination pagination-sm"><li><?php echo $pagination;?></li></ul>
              <br />
            </div>
        
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-6" id="analisis">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Jumlah Transaksi Per-bulan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/transaksi#analisis" method="post">
              <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control" name="s">
                    <?php 
                      foreach ($tahun as $t) {
                        echo '<option value="'.$t->Tahun.'">'.$t->Tahun.'</option>';
                      }
                    ?>
                  </select>
                  <br />
                  <input class="btn btn-success" type="submit" value="Submit" />
                </div>
            </form>

              <div class="chart">
                <canvas id="testChart" style="height:250px"></canvas>
                <div class="col-sm-3">
                  <div id="testLegend" style="font-size:25px"></div>
                </div>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

        <div class="col-md-6" id="analisis">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Analisis Jumlah Transaksi Per-hari</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/transaksi#analisis" method="post">
              <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control" name="sTahunHari">
                    <?php 
                      foreach ($tahun as $t) {
                        echo '<option value="'.$t->Tahun.'">'.$t->Tahun.'</option>';
                      }
                    ?>
                  </select>
                  <br />
                  <select class="form-control" name="sBulanHari">
                    <option value="0">- Semua -</option>
                    <option value="1">Januari</option>
                    <option value="2">February</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Okotober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                  <br />
                  <input class="btn btn-success" type="submit" value="Submit" />
                </div>
            </form>

              <div class="chart">
                <canvas id="hariChart" style="height:250px"></canvas>
                <div class="col-sm-6">
                  <div id="hariLegend" style="font-size:25px"></div>
                </div>
              </div>
            </div>
            </div>
          <!-- /.box -->  
        </div>

      </div>


          <!-- /.box -->

      <script type="text/javascript" src="<?php echo $base_url;?>assets/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $base_url;?>assets/Chart.js"></script>

        <script type="text/javascript">
              $(document).ready(function(){

                  // =============================================================
                  // line chart data jumlah transaksi per bulan
                  var data = {
                            labels: <?php echo $labelPerBulan; ?>,
                            datasets: [
                                {
                                    label: <?php echo '"'.$selectTahun.'"' ?>,
                                    fillColor: "rgb(102, 153, 255)",
                                    strokeColor: "rgb(102, 153, 255)",
                                    pointColor: "rgb(102, 153, 255)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo $transaksiPerBulan; ?>
                                }
                            ]
                        };

                  var ctx = document.getElementById("testChart").getContext("2d");
                  var chart = new Chart(ctx).Line(data);
                  document.getElementById("testLegend").innerHTML = chart.generateLegend();

                  // =============================================================
                  // line chart data jumlah transaksi
                  var data2 = {
                            labels: <?php echo $hari; ?>,
                            datasets: [
                                {
                                    label: <?php echo '"'.$selectTahun2.' Bulan Ke-'.$selectBulanHari.'"' ?>,
                                    fillColor: "rgb(194, 194, 163)",
                                    strokeColor: "rgb(194, 194, 163)",
                                    pointColor: "rgb(194, 194, 163)",
                                    pointStrokeColor: "#fff",
                                    pointHighlightFill: "#fff",
                                    pointHighlightStroke: "rgba(220,220,220,1)",
                                    data: <?php echo $hariJumlah; ?>
                                }
                            ]
                        };

                  var ctx2 = document.getElementById("hariChart").getContext("2d");
                  var chart2 = new Chart(ctx2).Bar(data2);
                  document.getElementById("hariLegend").innerHTML = chart2.generateLegend();

                  /*

                  // ==============================================================
                  // pie chart jumlah merchant per kota
                  var data3 = [ <?php
                                    $i = 0;
                                    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                                    foreach($kotaTransaksi as $c){
                                      {
                                        $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
                                        $i++;
                                        $dataPie = '{
                                                      value: '.$c->Jumlah.',
                                                      color:"'.$color.'",
                                                      highlight: "'.$color.'",
                                                      label: "'.$c->Nama.'"
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

                var ctx3 = document.getElementById("kotaChart").getContext("2d");
                var chart3 = new Chart(ctx3).Pie(data3, {
                  //String - A legend template
                  legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><span style=\"background-color:<%=segments[i].fillColor%>\"><%if(segments[i].label){%><%=segments[i].label%><%}%></span><%}%></ul>"
                });
                // document.getElementById("pieLegendKategori").innerHTML = chart3.generateLegend();

                // ====================================================
                // bar chart jumlah transaksi perkategori merchant
                  var data4 = {
                      labels: <?php echo $transaksiKategori ?>,
                      datasets: [
                          {
                              fillColor:  "rgb(102, 255, 204)",
                              strokeColor: "#3b8bba",
                              pointColor:  "Blue",
                              pointStrokeColor: "#FFF",
                              pointHighlightFill: "#FFF",
                              pointHighlightStroke: "rgba(220,220,220,1)",
                              data: <?php echo $transaksiKategoriJumlah; ?> }
                      ]
                  };

                  var ctx4 = document.getElementById("transaksiKategoriChart").getContext("2d");
                  var chart4 = new Chart(ctx4).Bar(data4);

              */
              });
        </script>

    </section>
  </div>