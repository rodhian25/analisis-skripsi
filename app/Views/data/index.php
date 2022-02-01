<?= $this->extend('/layouts/layout') ?>
<?= $this->section('main-container') ?>

<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb-->
    <?= $this->include('/layouts/breadcrumb') ?>


    <div class="page-header" id="form_upload">
      <form action="<?= base_url() ?>/data/upload" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
          <div class="col-md-6 col-12">
            <div class="title">
              <p>Upload File
                <span class="text-danger">*(wajib csv) </span>
              </p>
            </div>
          </div>
          <div class="col-md-4 col-8 text-right">
            <div class="form-group">
              <input type="file" name="file" class="form-control-file form-control height-auto">
            </div>
          </div>
          <div class="col-md-2 col-2 text-right">
            <div class="form-group">
              <input type="submit" class="btn btn-sm btn-primary">
            </div>
          </div>
        </div>
      </form>
    </div>


    <div class="card-box mb-30">
      <?= view('Myth\Auth\Views\_message_block') ?>
      <div class="pd-20 row">
        <h4 class="text-dark h4 col-6">Data Detail Transaksi</h4>
        <a class="btn btn-sm col-3 text-primary" href="#" id="buka_upload" type="button"><i class="dw dw-table"></i> Import Data</a>
        <a class="btn btn-sm col-3 text-danger" href="#" data-toggle="modal" data-target="#Medium-modal" type="button"><i class="dw dw-trash"></i> Hapus Data</a>
        <a class="btn btn-sm col-3 text-primary" href="#" id="tutup_upload" type="button"><i class="dw dw-exit"></i> tutup</a>
      </div>
      <div class="pb-20">
        <table class="table hover multiple-select-row nowrap" id="tbl-data">
          <thead>
            <tr>
              <th>No</th>
              <th>Receipt Number</th>
              <th>Staff</th>
              <th>Tanggal</th>
              <th>Pukul</th>
              <th>Item Produk</th>
              <th>Jumlah</th>
              <th>Harga</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <br>
  </div>
</div>


<!-- modal untuk hapus data -->
<div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="myLargeModalLabel">Hapus Data</h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url(); ?>/data/hapus" method="post">
          <?= csrf_field() ?>
          <div class="row">
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Tanggal Awal</label>
              <input class="form-control mb-4" name="tanggal_awal" type="date" value="<?= $tanggal_awal ?>">
            </div>
            <div class="form-group col-md-6">
              <label class="font-weight-bold">Tanggal Akhir</label>
              <input class="form-control mb-4" name="tanggal_akhir" type="date" value="<?= $tanggal_akhir ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  var site_url = "<?php echo site_url(); ?>";

  function tampil_data() {
    $('#tbl-data').DataTable({
      dom: 'Blfrtip',
      "lengthMenu": [
        [10, 25, 50, 100, 250, 1000, 5000, 10000, 50000],
        [10, 25, 50, 100, 250, 1000, 5000, 10000, 50000]
      ],
      destroy: true,
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: site_url + "/ajax-load-data",
      },
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'receipt_number',
          name: 'receipt_number'
        },
        {
          data: 'staff',
          name: 'staff'
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'pukul',
          name: 'pukul'
        },
        {
          data: 'item_produk',
          name: 'item_produk'
        },
        {
          data: 'jumlah',
          name: 'jumlah'
        },
        {
          data: 'perharga',
          name: 'perharga'
        },
        {
          data: 'harga',
          name: 'harga'
        }
      ]
    });
  }

  $(document).ready(function() {

    tampil_data();
  });
</script>

<script>
  $(document).ready(function() {
    $("#form_upload").hide();
    $("#tutup_upload").hide();
    $("#buka_upload").click(function() {
      $("#form_upload").show();
      $("#buka_upload").hide();
      $("#tutup_upload").show();
    });
    $("#tutup_upload").click(function() {
      $("#form_upload").hide();
      $("#buka_upload").show();
      $("#tutup_upload").hide();
    });
  });
</script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="<?= base_url(); ?>/vendors/scripts/datatable-setting.js"></script>
<!-- Advance form-->
<script src="<?= base_url(); ?>/vendors/scripts/advanced-components.js"></script>
<?= $this->endSection() ?>