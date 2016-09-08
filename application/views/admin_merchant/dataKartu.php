<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kartu
        <small>Merchant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Kartu</a></li>
      </ol>
    </section>
    <section class="content">
      
      <div class="row">
        <div class="col-md-3">
          <a href="<?php echo $base_url;?>index.php/merchantKartu/addKartu" class="btn btn-warning">Tambah Data</a>
        </div>
      </div>

      <br />

      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Kartu</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
            <form action="<?php echo $base_url;?>index.php/merchantKartu" method="post">
              <label>Cari Berdasarkan</label>
              <select class="form-control" name="searchField">
                <option value="NoKartu">No Kartu</option>
                <option value="Nama">Nama Pelanggan</option>
                <option value="TransDate">TransDate</option>
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
                  echo 'Menampilkan Data Kartu Dengan <strong>'.$searchField.'</strong> <i>"'.$search.'"</i> '; 
                  echo '<br />';
                }
              ?>
            </form>

            <!--  <table id="example1" class="table table-bordered table-striped">
              </table> -->
              <label><?php echo $message; ?></label>
              <br />
              <form action="<?php echo $base_url;?>index.php/merchantKartu/download_pdf" method="get">
                <div class="col-md-6">
                  <input type="submit" id="import" class="btn btn-warnig" value="Export Data yang Dipilih Ke File PDF">
                  <input type="text" id="jumlah" name="jumlah" value=0 size=5 disabled>
                  <a href="<?php echo $base_url;?>index.php/merchantKartu/download_csv" class="btn btn-info">
                    <i class="fa fa-file-excel-o">&nbsp;&nbsp;Export Semua Data Ke File .XLS</i>
                  </a>
                </div>
                </form>
                <form action="<?php echo $base_url;?>index.php/merchantKartu" method="post">
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
                  <div><?php echo $this->db->last_query(); ?></div>
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
        </div>

    </section>
</div>