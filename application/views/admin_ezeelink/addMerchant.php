 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Data
        <small>Merchant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Merchant</a></li>
        <li class="active">Tambah Data</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Merchant</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/merchants/addSubmit" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>ID Merchant</label>
                  <input type="text" class="form-control" name="MerchantID" placeholder="ID Merchant">
                </div>
                <div class="form-group">
                  <label>Nama Merchant</label>
                  <input type="text" class="form-control" name="NamaMerchant" placeholder="Nama Merchant">
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="form-control" name="KategoriID">
                    <?php 
                      foreach($kategori as $k){
                        echo '<option value="'.$k->KategoriID.'">'.$k->Nama.'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Facebook</label>
                  <input type="tel" class="form-control" name="AlamatFB" placeholder="Facebook">
                </div>
                <div class="form-group">
                  <label>Twitter</label>
                  <input type="tel" class="form-control" name="AlamatTW" placeholder="Twitter">
                </div>
                <div class="form-group">
                  <label>Website</label>
                  <input type="tel" class="form-control" name="AlamatWWW" placeholder="Website">
                </div>
                <div class="form-group">
                  <label>Tagline</label>
                  <input type="tel" class="form-control" name="Tagline" placeholder="Tagline">
                </div>
                <!-- Date -->
              <div class="form-group">
                <label>Tanggal Input</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="TanggalInput" class="form-control pull-right" id="datepicker" value="<?php echo date('d-m-Y'); ?>" disabled>
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
                <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" name="Catatan" cols="40" rows="5" placeholder="Catatan"></textarea>
                </div>

                <div class="form-group">
                  <label for="Logo">Logo</label>
                  <input type="file" id="Logo">

                  <p class="help-block"></p>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo $base_url; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script>
  $(document).ready(function(){
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
  });
</script>