<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title><?= $this->renderSection('title') ?></title>
  <link href="<?= base_url() ?>/src/css/styles.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/jstree/dist/themes/default/style.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-colreorder-bs5/css/colReorder.bootstrap5.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />

  <style>
    .has-error {
      color: #dc3545;
    }

    .has-error .form-control {
      border-color: #dc3545;
    }
  </style>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <script src="<?= base_url() ?>/node_modules/bootstrap/dist/js/bootstrap.js"></script>
  <script src="<?= base_url() ?>/src/js/scripts.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery/dist/jquery.js"></script>
  <script src="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-colreorder/js/dataTables.colReorder.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/localization/messages_id.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jstree/dist/jstree.min.js"></script>
</head>

<body class="sb-nav-fixed">
  <?= $this->renderSection('navbar') ?>
  <div id="layoutSidenav">
    <?= $this->renderSection('sidebar') ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <?= $this->renderSection('content') ?>
        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <?= $this->renderSection('footer') ?>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script>
    function logout() {
      Swal.fire({
        title: "Peringatan",
        text: "Apakah Anda yakin logout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Iya",
        cancelButtonText: "Tidak",
      }).then(function(result) {
        if (result.value) {
          window.location.replace('<?= base_url() ?>/auth/logout')
        }
      });
    }
  </script>
</body>

</html>