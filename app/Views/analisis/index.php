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

    <!-- Tahapan Analisis Data -->
    <?= $this->include('/layouts/tahapan') ?>
    <!-- End Tahapan Analisis Data -->

    <div class="card shadow mb-4" id="form-preprocessing">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Preprocessing Data</h6>
      </div>
      <form action="<?= base_url(); ?>/analisis/klaster" method="post">
        <?= csrf_field() ?>
        <div class="card-body">
          <div class="row">
            <div class="col-md-5 text-center">
              <img src="<?= base_url('/vendors/images/database.png') ?>" alt="database" width="26%">
              <small>
                <p>Data di Database :</p>
              </small>
              <p><?= date('d M Y', strtotime($tanggal_awal)) ?> &nbsp;s/d&nbsp; <?= date('d M Y', strtotime($tanggal_akhir)) ?></p>
              <hr>
            </div>
            <div class="col-md-7">
              <div class="from-group text-justify">
                <small><span class="font-weight-bold">info : </span>Pilih tanggal awal dan akhir yang akan dilakukan preprocessing data, proses perhitungan jumlah pembelian per-item produk untuk tahap selanjutnya</small>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-6">
                  <label for="tanggal_awal" class="font-weight-bold">Pilih Tanggal Awal</label>
                  <input class="form-control mb-2" name="tanggal_awal" type="date" value="<?= $tanggal_awal ?>" id="tanggal_awal" placeholder="tanggal awal">
                </div>
                <div class="form-group col-6">
                  <label for="tanggal_akhir" class="font-weight-bold">Pilih Tanggal Akhir</label>
                  <input class="form-control mb-2" name="tanggal_akhir" type="date" value="<?= $tanggal_akhir ?>" id="tanggal_akhir" placeholder="tanggal akhir">
                </div>
              </div>
              <div class="form-group">
                <a href="#" data-toggle="modal" data-target="#modal_proses_tanggal" class="btn btn-success btn-sm mt-md-2 w-100" onclick="proses()">Proses -></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal action -->
        <div class="modal fade" id="modal_proses_tanggal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modal_proses_tanggal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body text-center py-5">
                Apakah tanggal awal dan tanggal akhir sudah sesuai dengan yang dipilih?
                <br><br>
                <span id="tampil_tanggal"></span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Tidak, Kembali</button>
                <button type="submit" onclick="fungsi_tutup_modal()" class="btn btn-sm btn-success">Ya, Proses</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    </br>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
  function proses() {
    var tanggal_awal = document.getElementById("tanggal_awal").value;
    var tanggal_akhir = document.getElementById("tanggal_akhir").value;
    document.getElementById("tampil_tanggal").innerHTML = "<b>" + tanggal_awal +"</b>" + " " + " s/d " +" "+ "<b>" + tanggal_akhir +"</b>";
  }
  function fungsi_tutup_modal() {
    $('#modal_proses_tanggal').modal('hide');
  }
</script>
<?= $this->endSection() ?>