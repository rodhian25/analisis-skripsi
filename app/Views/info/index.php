<?= $this->extend('/layouts/layout') ?>

<?= $this->section('css_scripts') ?>
  <link rel="stylesheet" type="text/css" href="<?= base_url('src/plugins/jquery-steps/jquery.steps.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('main-container') ?>
<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb -->
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="<?= base_url(); ?>/">Beranda</a></li>
        <li class="breadcrumb-item"><?= $title ?></li>
      </ol>
    </nav>
    <br>
    <!-- end breadcrumb -->


    <div class="row">
      <div class="col-md-4">
        <div class="pd-20 card-box mb-30">
          <h4 class="text-dark h4">Pengembang Aplikasi</h4>
          <hr>
          <br>
          <table class="table-responsive">
            <tbody>
              <tr>
                <td>NIM</td>
                <td class="px-3"> : </td>
                <td>17031111318</td>
              </tr>
              <tr>
                <td>Nama</td>
                <td class="px-3"> : </td>
                <td>Muhammad Rodhian Syabri</td>
              </tr>
              <tr>
                <td>Prodi</td>
                <td class="px-3"> : </td>
                <td>Sistem Informasi S1</td>
              </tr>
              <tr>
                <td>Jurusan</td>
                <td class="px-3"> : </td>
                <td>Ilmu Komputer</td>
              </tr>
              <tr>
                <td>Universitas</td>
                <td class="px-3"> : </td>
                <td>Universitas Riau</td>
              </tr>
            </tbody>
          </table>
          <br>
        </div>
        <div class="pd-20 card-box mb-30">
          <h4 class="text-dark h4">Info Aplikasi</h4>
          <hr>
          <br>
          <table class="table-responsive">
            <tbody>
              <tr>
                <td>Basis Sistem</td>
                <td class="px-3"> : </td>
                <td>Web</td>
              </tr>
              <tr>
                <td>Versi PHP</td>
                <td class="px-3"> : </td>
                <td>7.4</td>
              </tr>
              <tr>
                <td>Framework PHP</td>
                <td class="px-3"> : </td>
                <td>CodeIgneter <?= CodeIgniter\CodeIgniter::CI_VERSION ?></td>
              </tr>
              <tr>
                <td>Framework CSS</td>
                <td class="px-3"> : </td>
                <td>Bootstrap v4.6</td>
              </tr>
              <tr>
                <td>Database</td>
                <td class="px-3"> : </td>
                <td>Mysql v5.7.35</td>
              </tr>
            </tbody>
          </table>
          <br>
        </div>
      </div>

      <div class="col-md-8">
        <div class="pd-20 card-box mb-30">
          <div class="clearfix">
            <h4 class="text-dark h4">Petunjuk Pemakaian Aplikasi</h4>
            <hr>
            <p>Aplikasi ini dibuat untuk mendapatkan rule asosiasi antar produk dalam transaksi konsumen sebagai promosi paket penjualan sehingga barang yang kurang minat dapat dibeli oleh konsumen melalui klaster k-medoids untuk mengelompokkan produk yang laris, sedang, dan, kurang laris.</p>
            <p>Berikut ini adalah cara penggunaaan aplikasi :</p>
          </div>
          <div class="wizard-content">
            <form class="tab-wizard wizard-circle wizard vertical">
              <h5>Import Data</h5>
              <section>
                <div class="text-center">
                  <a href="<?= base_url() ?>/vendors/images/csv.jpg" target="_blank">
                    <img src="<?= base_url() ?>/vendors/images/csv.jpg" alt="csv" class="csv" width="78%">
                  </a>
                </div>
                <br>
                <p class="text-center">Import Data Transaksi <span class="text-danger">*(wajib csv) </span> jika belum ada data pada menu <a class="text-primary" href="<?= base_url() ?>/data">Data</a></p>
              </section>
              <!-- Step 2 -->
              <h5>Klaster</h5>
              <section>
                <div class="text-center">
                  <img src="<?= base_url(); ?>/vendors/images/banner-img.png" alt="test" width="36%">
                </div>
                <br>
                <p>Melakukan Analisis pada menu <a class="text-primary" href="<?= base_url() ?>/analisis">Analisis</a></p>
                <p>Pada halamaan analisis, pilih data yang akan digunakan dengan memilih tanggal awal dan akhirnya, dan akan otomatis sistem akan melakukan preprocessing data untuk tahap selanjutnya</p>
                <p>Selanjutnya Pilih jumlah klaster, minimum support(%) dan minimum confidence (%)</p>
              </section>
              <!-- Step 3 -->
              <h5>Asosiasi</h5>
              <section>
                <div class="text-center">
                  <img src="<?= base_url(); ?>/vendors/images/banner-img.png" alt="test" width="36%">
                </div>
                <br>
                <p>Sistem akan memproses dan akan menghasilkan pengelompokkan produk yang laris, sedang, dan yang kurang laris, beserta pengujian pengelompokkan klasternya, sistem akan otomatis mencari kelompok yang kurang laris untuk tahap selanjutnya. Pengguna bisa melakukan klaster ulang <a class="text-primary" href="<?= base_url() ?>/analisis">Analisis</a>, jika tidak sesuai yang diinginkan atau menggunakan pengelompokkan tersebut untuk tahap asosiasi/terakhir</p>
                <p>
                  Selanjutnya sistem akan memproses hasil pengelompokkan yang kurang laris untuk dilakukan asosiasi untuk medapatkan rule, jika masih belum menemukan rule dapat edit min.support atau min.confidence lebih rendah
                </p>
              </section>
              <!-- Step 4 -->
              <h5>Hasil</h5>
              <section>
                <div class="text-center">
                  <img src="<?= base_url(); ?>/vendors/images/banner-img.png" alt="test" width="36%">
                </div>
                <br>
                <p>
                  Hasil asosiasi akan dihasilkan dalam bentuk laporan report yang berisi semua detail analisis dan paket rekomendasi produk sebagai promosi.
                </p>
              </section>
            </form>
          </div>
        </div>
      </div>
    </div>
    </br>



    <!-- success Popup html Start -->
    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body text-center font-18">
            <h3 class="mb-20">Selesai</h3>
            <div class="mb-30 text-center"><img src="vendors/images/success.png"></div>
            Silahkan melakukan analisis!
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
    <!-- success Popup html End -->

  </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('pageScripts') ?>
<script src="<?= base_url('src/plugins/jquery-steps/jquery.steps.js') ?>"></script>
<script src="<?= base_url('vendors/scripts/steps-setting.js') ?>"></script>
<?= $this->endSection() ?>