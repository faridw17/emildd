<h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
<div class="row" id="rowForm" style="display: none;">
  <div class="col-md-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col-sm-6 align-self-center">
            <h5 class="card-title mb-0">
              Form <?= $title ?>
            </h5>
          </div>
          <div class="col-sm-6">
            <button class="btn btn-primary float-right" type="button" onclick="$('#btnCancel').click()"><i class="fa fa-database"></i> List</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!--begin::Form-->
        <form class="form" id="form_vendor">
          <input type="hidden" name="act" id="act" value="add">
          <input type="hidden" name="setting_id" id="setting_id">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-3 label-control">Nama</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Nama" readonly id="setting_nama" name="setting_nama" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Nilai</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Nilai" id="setting_value" name="setting_value" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Keterangan</label>
              <div class="col-md-5">
                <textarea class="form-control" placeholder="Keterangan" id="setting_ket" name="setting_ket"></textarea>
              </div>
            </div>
            <div class="form-group row" style="display: none;">
              <label class="col-md-3 label-control">Status</label>
              <div class="col-md-3">
                <select class="form-control" id="setting_status" name="setting_status">
                  <option value="1">Aktif</option>
                  <option value="0">Non Aktif</option>
                </select>
              </div>
            </div>
          </div>
        </form>
        <!--end::Form-->
      </div>
      <div class="card-footer text-center">
        <button type="button" id="btnSave" class="btn btn-primary">Save</button>
        <button type="button" id="btnCancel" class="btn btn-secondary">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="row" id="rowList">
  <div class="col-md-12">
    <div class="card shadow mb-4">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-6 align-self-center">
            <h5 class="card-title mb-0">
              Data <?= $title ?>
            </h5>
          </div>
          <div class="col-sm-6" style="display: none;">
            <button type="button" id="btnAdd" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Data</button>
          </div>
        </div>
      </div>
      <div class="card-body">

        <!--begin::DataTable-->
        <table class="table table-sm table-bordered table-hover table-checkable" id="tbl_vendor" style="margin-top: 13px !important; width:100%">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Nilai</th>
              <th class="text-center">Keterangan</th>
              <!-- <th class="text-center">Status</th> -->
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
        </table>
        <!--end::DataTable-->
      </div>
    </div>
  </div>
</div>

<script>
  var TableAdvanced = function() {

    var initTable1 = function() {
      var table = $('#tbl_vendor');

      // begin first table
      table.DataTable({
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= base_url() ?>/admin/ms_setting/get_data',
          type: 'POST',
        },
        columnDefs: [{
          targets: [0, -1],
          orderable: false,
          className: 'text-center',
        }, ],
        responsive: true,
        "order": [
          [1, 'asc']
        ]
      });
    };

    var initForm = function() {
      const btnSave = $('#btnSave');
      const formVendor = $("#form_vendor")

      btnSave.click(function() {
        formVendor.submit();
      })

      // Validation Rules
      formVendor.validate({
        rules: {
          setting_nama: {
            required: true,
          },
          setting_value: {
            required: true,
          },
        },
        errorClass: 'help-block',
        errorElement: 'span',
        ignore: 'input[type=hidden]',
        highlight: function(el, errorClass) {
          $(el).closest('.form-group').first().addClass('has-error');
        },
        unhighlight: function(el, errorClass) {
          var $parent = $(el).closest('.form-group').first();
          $parent.removeClass('has-error');
          $parent.find('.help-block').hide();
        },
        errorPlacement: function(error, el) {
          error.appendTo(el.closest('.form-group').find('div:first'));
        },
        submitHandler: function(form) {
          btnSave.attr('disabled', 'disabled').text('Loading...');
          let data = formVendor.serialize()

          $.ajax({
            url: '<?= base_url() ?>/admin/ms_setting/save',
            data: data,
            type: 'post',
            dataType: 'json',
            complete: function() {
              btnSave.removeAttr('disabled', 'disabled').text('Save');
            },
            error: function() {
              btnSave.removeAttr('disabled', 'disabled').text('Save');
            },
            success: res => {
              if (res.status) {
                $("#btnCancel").click()
                Swal.fire({
                  icon: "success",
                  title: "Success",
                  html: res.message,
                  showConfirmButton: false,
                  timer: 1500
                })
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
        initTable1();
        initForm();
      },

    };

  }();

  function resetForm() {
    $("#form_vendor")[0].reset()
    $("#form_vendor").validate().resetForm()
    $(".has-error").removeClass('has-error')
    $("#act").val('add')
    $("#setting_id").val('')
    $('#btnSave').removeAttr('disabled', 'disabled').text('Save');
  }

  function reload_tbl() {
    $("#tbl_vendor").dataTable().fnDraw();
  }

  function set_val(data) {
    const isi = JSON.parse(decodeURIComponent(data))

    $("#act").val('edit')
    $("#setting_id").val(isi.setting_id)
    $("#setting_nama").val(isi.setting_nama)
    $("#setting_value").val(isi.setting_value)
    $("#setting_ket").val(decodeURIComponent(isi.setting_ket))
    $("#setting_status").val(isi.setting_status)
    $("#rowForm").slideDown(500)
    $("#rowList").slideUp(500)

  }

  function set_del(id) {
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data yang dihapus tidak dapat dikembalikan!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Iya",
      cancelButtonText: "Tidak",
    }).then(function(result) {
      if (result.value) {
        $.ajax({
          url: '<?= base_url() ?>/admin/ms_setting/hapus',
          type: 'post',
          dataType: 'json',
          data: {
            id: id
          },
          cache: false,
          success: res => {
            if (res.status) {
              Swal.fire({
                icon: "success",
                title: "Success",
                html: res.message,
                showConfirmButton: false,
                timer: 1500
              })
              reload_tbl()
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

  jQuery(document).ready(function() {
    TableAdvanced.init();

    $("#btnCancel").click(function() {
      resetForm()
      reload_tbl()
      $("#rowForm").slideUp(500)
      $("#rowList").slideDown(500)
    })

    $("#btnAdd").click(function() {
      resetForm()
      $("#rowForm").slideDown(500)
      $("#rowList").slideUp(500)
    })
  });
</script>