 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Data
        <small>Pelanggan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Pelanggan</a></li>
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
              <h3 class="box-title">Data Pelanggan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/customers/addSubmit" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>ID Pelanggan</label>
                  <input type="text" class="form-control" name="PelangganID" placeholder="ID Pelanggan">
                </div>
                <div class="form-group">
                  <label>Nama Pelanggan</label>
                  <input type="text" class="form-control" name="Nama" placeholder="Nama Pelanggan">
                </div>
                <div class="form-group">
                  <label>Pekerjaan</label>
                  <input type="text" class="form-control" name="Pekerjaan" placeholder="Pekerjaan">
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
                  <label>Negara</label>
                  <input type="text" class="form-control" name="Negara" placeholder="Negara">
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input type="tel" class="form-control" name="Telepon" placeholder="Telepon">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="Email" placeholder="Email">
                </div>
                <!-- Date -->
              <div class="form-group">
                <label>Tanggal Lahir</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" name="TanggalLahir" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>
              <!-- /.form group -->
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