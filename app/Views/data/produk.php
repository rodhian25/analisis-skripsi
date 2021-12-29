<?= $this->extend('/layouts/layout') ?>
<?= $this->section('main-container') ?>

<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb-->
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="<?= base_url(); ?>/">Beranda</a></li>
        <li class="breadcrumb-item"><?= $title ?></li>
      </ol>
    </nav>
    <br />
    <!--end breadcrumb-->


    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Data Hasil K-medoids dan FP-Growth</h6>
      </div>
      <div class="card-body">
        <?= view('Myth\Auth\Views\_message_block') ?><br>
        <form action="<?= base_url(); ?>/data/produk/ubah_jenis" method="post">
          <?= csrf_field() ?>
          <table class="data-table table hover multiple-select-row nowrap" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jenis</th>
                <th>Pillih Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($produk as $row) { ?>
                <tr>
                  <td class="text-center"><?= $no++ ?></td>
                  <td><?= $row->item_produk ?></td>
                  <td>Rp. <?= number_format((($row->harga) / $row->jumlah), 0, "", ".") ?></td>
                  <td class="<?php if ($row->jenis == 'minuman') {
                                echo "text-primary";
                              } else {
                                echo "text-warning";
                              } ?>"><?= $row->jenis ?></td>
                  <td class="text-center"><input type="checkbox" name="produk[]" value="<?= $row->id ?>"></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <br>
          <div class="col-3">
            <select class="custom-select col-12" name="jenis" onchange="this.form.submit();">
              <option selected="">Pilih Jenis</option>
              <option value="makanan">Makanan</option>
              <option value="minuman">Minuman</option>
            </select>
        </form>
      </div>
      </span>
    </div>
  </div>
  </br>
  </br>

</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>

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

<?= $this->endSection() ?>