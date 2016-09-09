 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Data
        <small>Produk</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Produk</a></li>
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
              <h3 class="box-title">Data Produk</h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" action="<?php echo $base_url;?>index.php/merchantProduk/addSubmit" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label>Produk ID</label>
                  <input type="text" class="form-control" name="ProdukID" value="<?php //echo ?>" disabled>
                </div>
                <div class="form-group">
                  <label>Kategori</label>
                  <select name="KategoriID" class="form-control">
                    <?php

                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nama Produk</label>
                  <input type="text" class="form-control" name="NamaProduk" placeholder="Nama Produk">
                </div>
                <div class="form-group">
                  <label>Kuantitas Per-Unit</label>
                  <input type="text" class="form-control" name="KuantitasPerUnit" placeholder="Kuantitas Per-Unit">
                </div>
                <div class="form-group">
                  <label>Harga Per-Unit</label>
                  <input type="text" class="form-control" id="number" name="HargaPerUnit" placeholder="Kuantitas Per-Unit">
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

    $('#number').inputmask("integer", {"placeholder": ""});
  });
</script>