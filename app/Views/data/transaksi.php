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
    <!---->
    <?php
    foreach ($data as $row) {
      $tanggal[$row['receipt_number']] = $row['tanggal'];
    }

    function convert($data)
    {
      $arr = array();
      foreach ($data as $row) {
        $v = trim(strtolower($row['item_produk']));
        $arr[$row['receipt_number']][$v] = $v;
      }
      return $arr;
    }

    //mengkonversi data dari bentuk tabel ke bawah menjadi array item per transaksi
    $data = convert($data);

    ?>


    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Data Transaksi</h6>
      </div>
      <div class="card-body">
        <?= view('Myth\Auth\Views\_message_block') ?></br>
        <div class="row">
          <table class="table hover multiple-select-row data-table-export nowrap" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>no</th>
                <th>recepit number</th>
                <th>tanggal</th>
                <th>itemset</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($data as $key => $val) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $key ?></td>
                  <td><?= $tanggal[$key] ?></td>
                  <td><?= implode(', ', $val) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
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