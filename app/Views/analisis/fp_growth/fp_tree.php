<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <!-- Site favicon -->
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/vendors/images/favicon-16x16.png">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/styles/fptree.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/style.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/core.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/icon-font.min.css">
</head>

<body>
  <br><br>
  <?= $this->section('main-container') ?>
  <div class="main-container">
    <div class="pd-ltr-20">
      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> FP-Tree</h6>
        </div>
        <div class="card-body">
          <div class="row px-4">
            <?= $display ?>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
  </div>
  <?= $this->endSection() ?>
  <br><br>
</body>

</html>