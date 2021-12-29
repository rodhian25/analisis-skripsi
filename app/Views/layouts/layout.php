<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <!-- Site favicon -->
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/vendors/images/favicon-16x16.png" alt="icon">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- file css -->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/core.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/style.css">
  <!-- untuk penambahan css di file lainnya -->
  <?= $this->renderSection('css_scripts') ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>

<body class="login-page">
  <!---bagian header-->
  <?= $this->include('/layouts/header') ?>
  <!---bagian menu left sidebar-->
  <?= $this->include('/layouts/left_sidebar') ?>

  <main>
    <!---konten-->
    <?= $this->renderSection('main-container') ?>

  </main>
  <!-- file javascript -->
  <script src="<?= base_url(); ?>/vendors/scripts/core.js"></script>
  <script src="<?= base_url(); ?>/vendors/scripts/script.min.js"></script>
  <!-- untuk penambahan javascript di file lainnya -->
  <?= $this->renderSection('pageScripts') ?>
</body>

</html>