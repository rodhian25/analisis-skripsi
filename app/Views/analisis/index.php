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
                  <input class="form-control mb-2" name="tanggal_awal" type="date" value="<?= $tanggal_awal ?>">
                </div>
                <div class="form-group col-6">
                  <label for="tanggal_akhir" class="font-weight-bold">Pilih Tanggal Akhir</label>
                  <input class="form-control mb-2" name="tanggal_akhir" type="date" value="<?= $tanggal_akhir ?>">
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success btn-sm mt-md-2 w-100">Proses -></button>
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

<?= $this->endSection() ?>