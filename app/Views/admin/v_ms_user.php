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
          <input type="hidden" name="user_id" id="user_id">
          <div class="form-group row">
            <label class="col-md-3 label-control">Nama Lengkap</label>
            <div class="col-md-5">
              <input type="text" class="form-control" placeholder="Nama Lengkap" id="user_fullname" name="user_fullname" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 label-control">Username</label>
            <div class="col-md-5">
              <input type="text" class="form-control" placeholder="Username" id="user_name" name="user_name" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 label-control">Password</label>
            <div class="col-md-5">
              <input type="text" class="form-control" placeholder="Password" id="password" name="password" />
            </div>
            <div class="col-md-3 label-control" id="actGantiPassword">
              <div class="checkbox-inline">
                <label class="checkbox">
                  <input type="checkbox" name="ganti_password" id="ganti_password"><span></span> Ganti Password</label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 label-control">Konfirmasi Password</label>
            <div class="col-md-5">
              <input type="text" class="form-control" placeholder="Konfirmasi Password" id="confirm_password" name="confirm_password" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 label-control">Email</label>
            <div class="col-md-5">
              <input type="text" class="form-control" placeholder="Email" id="user_email" name="user_email" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 label-control">Status</label>
            <div class="col-md-3">
              <select class="form-control" id="user_status" name="user_status">
                <option value="1">Aktif</option>
                <option value="0">Non Aktif</option>
              </select>
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
          <div class="col-sm-6">
            <button type="button" id="btnAdd" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Data</button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <!--begin::DataTable-->
        <table class="table table-bordered table-sm table-hover table-checkable" id="tbl_vendor" style="margin-top: 13px !important; width: 100%;">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Fullname</th>
              <th class="text-center">Username</th>
              <th class="text-center">Status</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <!--end::DataTable-->
      </div>
    </div>
  </div>
</div>

<!-- Modal-->
<div class="modal fade" id="modalAkses" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="user_id_akses">
        <div class="checkbox-list" id="listGroup"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="saveAkses" onclick="saveAkses()">Simpan</button>
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
        responsive: true,
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= base_url() ?>/admin/msuser/get_data',
          type: 'POST',
          // data: {
          //   // parameters for custom backend script demo
          //   columnsDef: [
          //     'OrderID', 'Country',
          //     'ShipAddress', 'CompanyName', 'ShipDate',
          //     'Status', 'Type', 'Actions'
          //   ],
          // },
        },
        columnDefs: [{
          targets: [0, -1],
          orderable: false,
        }, {
          targets: [0, -2, -1],
          className: 'text-center',
        }, ],
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
          user_name: {
            required: true,
          },
          user_fullname: {
            required: true,
          },
          password: {
            required: {
              depends: function(element) {
                return (($("#act").val() == 'edit' && $("#ganti_password").prop('checked')) || $("#act").val() == 'add') ? true : false;
              }
            },
          },
          confirm_password: {
            required: {
              depends: function(element) {
                return (($("#act").val() == 'edit' && $("#ganti_password").prop('checked')) || $("#act").val() == 'add') ? true : false;
              }
            },
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

          if ($("#act").val() == 'edit' && $("#ganti_password").prop('checked')) {
            data += '&is_ganti=1'
          } else {
            data += '&is_ganti=0'
          }

          $.ajax({
            url: '<?= base_url() ?>/admin/msuser/save',
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
    $("#user_id").val('')
    $("#actGantiPassword").hide()
    $("#ganti_password").attr('disabled', 'disabled')
    $('#btnSave').removeAttr('disabled', 'disabled').text('Save');
  }

  function reload_tbl() {
    $("#tbl_vendor").dataTable().fnDraw();
  }

  function set_val(data) {
    const isi = JSON.parse(decodeURIComponent(data))

    $("#act").val('edit')
    $("#user_id").val(isi.user_id)
    $("#user_name").val(isi.user_name)
    $("#user_fullname").val(isi.user_fullname)
    $("#user_email").val(isi.user_email)
    $("#user_status").val(isi.user_status)
    $("#password").attr('disabled', 'disabled')
    $("#confirm_password").attr('disabled', 'disabled')
    $("#actGantiPassword").show()
    $("#ganti_password").removeAttr('disabled', 'disabled')
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
          url: '<?= base_url() ?>/admin/msuser/hapus',
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

  function akses(id, title = '') {
    $("#modalTitle").text(title)
    $("#modalAkses").modal('show')
    $("#user_id_akses").val(id)
    $("#listGroup label").remove()
    $.ajax({
      url: '<?= base_url() ?>/admin/msuser/get_akses',
      data: {
        id: id
      },
      dataType: 'json',
      type: 'post',
      cache: false,
      success: res => {
        if (res.length > 0) {
          let list = '';
          let isChecked = '';
          $.each(res, (index, i) => {
            isChecked = i.akses == '1' ? 'checked' : '';
            list +=
              `<label class="checkbox">
                <input type="checkbox" name="group_akses" class="group_akses" value="${i.group_id}" ${isChecked}>
                <span></span>${i.group_nama}
              </label><br>`;
          })

          $("#listGroup").html(list);
        }
      }
    })
  }

  function saveAkses() {
    const data = {
      user_id: $("#user_id_akses").val(),
      group_id: []
    };

    if ($('.group_akses:checked').length > 0) {
      $.each($('.group_akses:checked'), (index, i) => {
        data.group_id.push($(i).val());
      });
    }

    $.ajax({
      url: '<?= base_url() ?>/admin/msuser/save_akses',
      type: 'post',
      dataType: 'json',
      data: data,
      success: res => {
        if (res.status) {
          $("#modalAkses").modal('hide')
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

    $("#ganti_password").change(function() {
      if ($(this).prop('checked')) {
        $("#password").removeAttr('disabled', 'disabled')
        $("#confirm_password").removeAttr('disabled', 'disabled')
      } else {
        $("#password").attr('disabled', 'disabled')
        $("#confirm_password").attr('disabled', 'disabled')
      }
    })
  });
</script>