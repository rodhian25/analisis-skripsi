<?= $this->extend('\layouts\layout') ?>

<!-- rendering tambahan css -->
<?= $this->section('css_scripts') ?>
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>
<!-- end rendering tambahan css -->


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
    <!---->

    <div class="card-box mb-30">
      <?= view('Myth\Auth\Views\_message_block') ?>
      <div class="pd-20 row">
        <h4 class="text-dark h4 col-9">Data User</h4>
        <a class="btn btn-sm col-3 text-primary" data-toggle="modal" data-target="#tambah-akun" href="#" type="button"><i class="dw dw-user1"></i> Tambah Akun</a>
      </div>
      <div class="pb-20">
        <table class="table hover multiple-select-row data-table-export nowrap">
          <thead>
            <tr>
              <th class="table-plus datatable-nosort">No</th>
              <th>Role</th>
              <th>Username</th>
              <th>Email</th>
              <th>No Hp</th>
              <th>Dibuat</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i =1; ?>
            <?php
            foreach ($data as $user) :
            ?>
              <tr>
                <td class="table-plus"><?= $i++ ?></td>
                <td><?= $user->name; ?></td>
                <td><?= $user->username; ?></td>
                <td><?= $user->email; ?></td>
                <td><?= $user->no_hp; ?></td>
                <td><?= $user->created_at; ?></td>
                <td>
                  <a class="dropdown-item text-danger" href="<?= base_url(); ?>/admin/data-user/<?= $user->userid ?>" type="button"><i class="dw dw-trash"></i> Hapus</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- modal tambah akun -->
    <div class="modal fade" id="tambah-akun" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="login-box bg-white border-radius-10">
            <div class="login-title">
              <h2 class="text-center text-primary">Daftar Akun</h2>
            </div>
            <form action="<?= base_url() ?>/admin/data-user/register" method="post">
              <?= csrf_field() ?>
              <div class="select-role text-center">
                <div class="icon"><img src="<?= base_url(); ?>/vendors/images/register-page-img.png" class="svg" alt="" width="50%"></div>
              </div>
              <div class="input-group custom">
                <input type="email" class="form-control form-control-lg <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                <div class="input-group-append custom">
                  <span class="input-group-text"><i class="icon-copy dw dw-email"></i></span>
                </div>
              </div>
              <div class="input-group custom">
                <input type="text" class="form-control form-control-lg <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                <div class="input-group-append custom">
                  <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                </div>
              </div>
              <div class="input-group custom">
                <input type="password" name="password" class="form-control form-control-lg <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                <div class="input-group-append custom">
                  <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
              </div>
              <div class="input-group custom">
                <input type="password" name="pass_confirm" class="form-control form-control-lg <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                <div class="input-group-append custom">
                  <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                </div>
              </div>
              <div class="input-group custom">
                <input type="hidden" name="active" value=1 class="form-control form-control-lg">
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="input-group mb-0">
                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Daftar Akun">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal tambah akun -->
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