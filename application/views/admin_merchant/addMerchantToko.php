 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Data
        <small>Toko</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Toko</a></li>
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
              <h3 class="box-title">Data Toko</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/merchantToko/addSubmit" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Toko ID</label>
                  <input type="text" class="form-control" name="TokoID" value="<?php echo $newId; ?>" disabled>
                </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" class="form-control" name="Alamat" placeholder="Alamat">
                </div>
                <div class="form-group">
                  <label>Kota</label>
                  <input type="text" class="form-control" name="Kota" placeholder="Kota">
                </div>
                <div class="form-group">
                  <label>Provinsi</label>
                  <input type="text" class="form-control" name="Provinsi" placeholder="Provinsi">
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="text" class="form-control" name="Telepon" placeholder="Telepon" data-mask>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" name="Email" placeholder="Email">
                </div>
                <br />
                <div class="form-group">
                  <label>Tanggal Input : <?php echo date('Y-d-m h:m:s'); ?></label>
                  <input type="hidden" class="form-control" name="TanggalInput" value="<?php echo date('Y-m-d h:m:s'); ?>">
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
  <!-- InputMask -->
  <script src="<?php echo $base_url; ?>plugins/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo $base_url; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo $base_url; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script>
  $(document).ready(function(){
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //$('#number').inputmask("integer", {"placeholder": ""});
    $("[data-mask]").inputmask(({ mask: "[9][9][9][9][9][9][9][9][9][9][9][9][9][9][9][9]", greedy: false }));
  });
</script>