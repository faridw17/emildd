<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>
  <style type="text/css">
    .has-error {
      color: #dc3545;
    }

    .has-error .form-control {
      border-color: #dc3545;
    }
  </style>
  <link href="<?= base_url() ?>/src/css/styles.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <link href="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
</head>

<body style="background-color: #8b14c1;">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main style="height: 100vh;">
        <div class="container">
          <div class="row justify-content-center align-content-center" style="height: 100vh;">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                  <form method="POST" id="form_vendor">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="username" name="username" type="text" placeholder="Username">
                      <label for="username">Username</label>
                      <div class="text-error"></div>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                      <label for="password">Password</label>
                      <div class="text-error"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                      <button type="submit" class="btn btn-primary" id="btnSubmit">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

  </div>
  <script src="<?= base_url() ?>/node_modules/bootstrap/dist/js/bootstrap.js"></script>
  <script src="<?= base_url() ?>/src/js/scripts.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery/dist/jquery.js"></script>
  <script src="<?= base_url() ?>/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="<?= base_url() ?>/node_modules/jquery-validation/dist/localization/messages_id.min.js"></script>
  <script>
    var AdvancedPage = function() {

      var initForm = function() {
        const btnSubmit = $('#btnSubmit');
        const formVendor = $("#form_vendor")

        btnSubmit.click(function() {
          formVendor.submit();
        })

        // Validation Rules
        formVendor.validate({
          rules: {
            username: {
              required: true,
            },
            password: {
              required: true
            },
          },
          errorClass: 'help-block',
          errorElement: 'span',
          ignore: 'input[type=hidden]',
          highlight: function(el, errorClass) {
            $(el).closest('.form-floating').first().addClass('has-error');
          },
          unhighlight: function(el, errorClass) {
            var $parent = $(el).closest('.form-floating').first();
            $parent.removeClass('has-error');
            $parent.find('.help-block').hide();
          },
          errorPlacement: function(error, el) {
            error.appendTo(el.closest('.form-floating').find('.text-error'));
          },
          submitHandler: function(form) {
            btnSubmit.attr('disabled', 'disabled').text('Loading...');
            let data = formVendor.serialize()

            $.ajax({
              url: '<?= base_url() ?>/auth/login',
              data: data,
              type: 'post',
              dataType: 'json',
              complete: function() {
                btnSubmit.removeAttr('disabled', 'disabled').text('Login');
              },
              error: function() {
                btnSubmit.removeAttr('disabled', 'disabled').text('Login');
              },
              success: res => {
                if (res.status) {
                  Swal.fire({
                    icon: "success",
                    title: "Success",
                    html: res.message,
                    showConfirmButton: false,
                    timer: 1500
                  })
                  window.location.replace(res.url)
                } else {
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: res.message,
                  })
                }
              }
            })
          }
        });
      }

      return {

        //main function to initiate the module
        init: function() {
          initForm();
        },

      };

    }();

    $(document).ready(function() {
      AdvancedPage.init()
    })
  </script>
</body>

</html>