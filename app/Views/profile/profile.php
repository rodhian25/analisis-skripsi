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
    <!--end breadcrumb-->

    <div class="row">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-5">
        <div class="pd-20 card-box height-100-p">
          <div class="profile-photo">
            <img src="vendors/images/banner-img.png" alt="" class="avatar-photo">
          </div>
          <h5 class="text-center h5 mb-0"><?= user()->username; ?></h5>
          <p class="text-center text-muted font-14"><?= $data->name; ?></p>
          <div class="profile-info">
            <ul>
              <li>
                <span>Username:</span>
                <?= user()->username; ?>
              </li>
              <li>
                <span>Email Address:</span>
                <?= user()->email; ?>
              </li>
              <li>
                <span>Alamat:</span>
                <?= user()->alamat; ?>
              </li>
              <li>
                <span>No WA:</span>
                <?= user()->no_hp; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-5">
        <div class="card-box height-100-p overflow-hidden">
          <div class="profile-tab height-100-p">
            <div class="tab height-100-p">
              <?= view('Myth\Auth\Views\_message_block') ?>
              <ul class="nav nav-tabs customtab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Ubah Data</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#password" role="tab">Ubah Password</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
                  <div class="profile-setting">
                    <form method="post" action="<?= base_url('profile/update/') ?>">
                      <?= csrf_field(); ?>
                      <ul class="profile-edit-list row">
                        <li class="weight-500 col-md-6">
                          <div class="form-group">
                            <input type="hidden" name="id" value="<?= user()->id ?>">
                            <label>Username</label>
                            <input class="form-control form-control-lg" value="<?= user()->username; ?>" type="readonly" readonly name="username">
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input class="form-control form-control-lg" value="<?= user()->email; ?>" type="readonly" readonly name="email">
                          </div>
                        </li>
                        <li class="weight-500 col-md-6 mb-5">
                          <div class="form-group">
                            <label>No WA</label>
                            <input class="form-control form-control-lg" value="<?= user()->no_hp; ?>" type="text" name="no_hp">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat"><?= user()->alamat; ?></textarea>
                          </div>
                          <div class="form-group mb-0">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                          </div>
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade show active height-100-p" id="password" role="tabpane1">
                  <div class="profile-setting">
                    <form method="post" action="<?= base_url('profile/update/password') ?>">
                      <?= csrf_field(); ?>
                      <ul class="profile-edit-list row">
                        <input type="hidden" name="id" value="<?= user()->id ?>">
                        <li class="weight-500 col-md-6 mb-5">
                          <div class="form-group">
                            <label>Password Baru</label>
                            <input class="form-control form-control-lg" type="password" placeholder="Password Baru" name="password_baru">
                          </div>
                          <div class="form-group">
                            <label>Ulangi password baru</label>
                            <input class="form-control form-control-lg" type="password" placeholder="Ulangi Password" name="ulangi_password">
                          </div>
                          <div class="form-group mb-0">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                          </div>
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>