<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title><?= $this->renderSection('title') ?></title>
  <link href="<?= base_url() ?>/node_modules/startbootstrap-sb-admin-2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= base_url() ?>/node_modules/startbootstrap-sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/jstree/dist/themes/default/style.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>/node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />

  <style>
    .has-error {
      color: #dc3545;
    }

    .has-error .form-control {
      border-color: #dc3545;
    }
  </style>

  <script src="<?= base_url() ?>/node_modules/jquery/dist/jquery.js"></script>
  <script src="<?= base_url() ?>/node_modules/popper.js/dist/popper.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/startbootstrap-sb-admin-2/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/localization/messages_id.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jstree/dist/jstree.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?= $this->renderSection('sidebar') ?>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?= $this->renderSection('navbar') ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <?= $this->renderSection('content') ?>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <?= $this->renderSection('footer') ?>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <script src="<?= base_url() ?>/node_modules/startbootstrap-sb-admin-2/js/sb-admin-2.min.js"></script>

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