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

    <?= $this->include('/layouts/loading') ?>
    <!-- Tahapan Analisis Data -->
    <?= $this->include('/layouts/tahapan') ?>
    <!-- End Tahapan Analisis Data -->
    <?= view('Myth\Auth\Views\_message_block') ?>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Masukkan Jumlah Klaster, Nilai Support dan Confidence</h6>
      </div>
      <br>
      <?php $validation = \Config\Services::validation(); ?>
      <form action="<?= base_url(); ?>/analisis/iterasi_klaster" method="post">
        <?= csrf_field() ?>
        <div class="card-body row">
          <div class="col-md-5 text-center">
            <label class="font-weight-bold">Data Preprocessing</label>
            <br>
            <img src="<?= base_url('/vendors/images/calendar.jpg') ?>" alt="calendar" width="50%">
            <p class="my-3"><?php echo date('d F Y', strtotime($tgl_awal)) . ' - ' . date('d F Y', strtotime($tgl_akhir)); ?></p>
          </div>
          <div class="col-md-7">
            <span class="text-justify">
              <small><span class="font-weight-bold">info : </span> Jumlah Klaster adalah banyaknya kelompok produk yang akan dianalisis. <em>Support</em> (nilai penunjang) adalah persentase kombinasi item produk tersebut dalam database, sedangkan <em>confidence</em> (nilai kepastian) adalah kuatnya hubungan antar- item produk dalam aturan asosiasi.</small>
              <small><span class="text-danger">*</span> wajib diisi.</small>
            </span>
            <hr>
            <span class="row">
              <div class="form-group col-md-6">
                <label class="font-weight-bold">Jumlah Klaster <span class="text-danger">*</span></label>
                <input type="tel" pattern="[2-9]{1}" name="jumlah" autocomplete="off" id="klaster" class="form-control" required="required" placeholder="Jumlah Klaster Harus > 1" onkeypress="return Angkasaja(event)" maxlength="2" minlength="1" onchange="myFunction()">
                <!-- Error -->
                <?php if ($validation->getError('jumlah')) { ?>
                  <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('jumlah'); ?>
                  </div>
                <?php } ?>
              </div>
              <div class="form-group col-md-6">
                <label class="font-weight-bold mb-4">Data hasil klaster akan di Asosiasi <span class="text-danger">*</span></label>
                <br>
                <input type="radio" name="data_analisis" id="data_analisis" placeholder="sedikit" value="sedikit" checked>
                <label for="sedikit">Sedikit di Beli</label>&nbsp;&nbsp;
                <input type="radio" name="data_analisis" id="data_analisis" placeholder="banyak" value="banyak">
                <label for="banyak">Banyak di Beli</label><br>
              </div>
              <div class="form-group col-md-6">
                <span id="pilihan_centroid">
                  <label class="font-weight-bold mb-4">Centroid Klaster</label>
                  <br>
                  <input type="radio" name="centroid" value="random" checked placeholder="random">
                  <label for="html">Random</label>&nbsp;&nbsp;
                  <input type="radio" name="centroid" value="akurasi" placeholder="akurasi">
                  <label for="css">Pilih</label><br>
                </span>
              </div>
            </span>
            <span class="row">
              <div class="form-group col-md-6">
                <label class="font-weight-bold">Nilai Minimum Support % <span class="text-danger">*</span></label>
                <input type="text" name="support" autocomplete="off" id="supp" class="form-control" required="required" placeholder="contoh: 0.1" onkeypress="return Angkadesimal(event)">
                <?php if ($validation->getError('support')) { ?>
                  <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('support'); ?>
                  </div>
                <?php } ?>
              </div>
              <div class="form-group col-md-6">
                <label class="font-weight-bold">Nilai Minimum Confidence % <span class="text-danger">*</span></label>
                <input type="text" name="confidence" autocomplete="off" id="conf" class="form-control" required="required" placeholder="contoh: 20" onkeypress="return Angkadesimal(event)">
                <?php if ($validation->getError('confidence')) { ?>
                  <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('confidence'); ?>
                  </div>
                <?php } ?>
              </div>
            </span>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="#" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modal_proses_klaster"><i class="fa fa-save"></i> Proses</a>
          <button type="reset" class="btn btn-info btn-sm mb-2"><i class="fa fa-refresh"></i> Reset</button>
          <button type="reset" class="btn btn-warning text-light btn-sm mb-2" id="lihat4"><i class="fa fa-eye"></i> Lihat Preprocesing</button>
        </div>
        <!-- Modal action -->
        <div class="modal fade" id="modal_proses_klaster" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_proses_klaster" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body text-center py-5">
                Apakah data yang di inputkan sudah sesuai dengan yang diinginkan?
                <br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Tidak, Kembali</button>
                <button type="submit" onclick="fungsi_tutup_modals()" class="btn btn-sm btn-success">Ya, Proses</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <br>


    <div class="card shadow mb-4" id="lihat_data">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Hasil Processing </h6>
      </div>
      <div class="card-body">
        <button id="tutup4" class="mb-4 btn btn-secondary btn-sm">tutup</button>
        <div class="table-responsive">
          <table class="data-table table hover multiple-select-row nowrap" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>No</th>
                <th>Item Produk</th>
                <th>Jumlah</th>
                <th>Harga (*1000)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($cek as $row) { ?>
                <tr>
                  <td class="text-center"><?= $row->id_processing ?></td>
                  <td><?= $row->item_produk ?></td>
                  <td class="text-center"><?= $row->jumlah ?></td>
                  <td class="text-center"><?= $row->harga ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="card shadow my-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Waktu Proses</h6>
      </div>
      <div class="card-body">
        <div class="row px-4">
          <?php
          //menyimpan waktu selesai
          $time_end = microtime(true);
          //waktu eksemusi dalam detik
          $time = $time_end - $time_start;
          //memory yang digunakan dalam kilo byte
          $memory = round(memory_get_usage() / 1024, 2);
          //menampilkan waktu eksekusi dan memory yang digunakan
          echo '<pre>';
          echo "\nExecution Time: $time seconds";
          echo "\nMemory Usage: " . $memory . ' kb';
          echo '</pre>';
          ?>
        </div>
      </div>
    </div>

    </br>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script type="text/javascript">
  function Angkadesimal(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }

  function Angkasaja(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }
</script>
<script>
  $(document).ready(function() {
    $("#pilihan_centroid").hide();
    $("#lihat_data").hide();
  });

  function myFunction() {
    var x = document.getElementById("klaster").value;
    if (x == 3) {
      $("#pilihan_centroid").show();
    } else {
      $("#pilihan_centroid").hide();
    }
  }
  $("#tutup4").hide();
  $("#lihat4").click(function() {
    $("#lihat_data").show();
    $("#lihat4").hide();
    $("#tutup4").show();
  });
  $("#tutup4").click(function() {
    $("#lihat_data").hide();
    $("#lihat4").show();
    $("#tutup4").hide();
  });
</script>
<script>
  $(document).ready(function() {
    $(".preloader").fadeOut();
  })
</script>
<script>
  function fungsi_tutup_modals() {
    $('#modal_proses_klaster').modal('hide');
    $(".preloader").fadeIn();
  }
</script>
<!-- Datatable Setting js -->
<script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/vendors/scripts/datatable-setting.js"></script>
<?= $this->endSection(); ?>