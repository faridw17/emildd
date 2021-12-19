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
          <input type="hidden" name="group_id" id="group_id">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-3 label-control">Kode</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Kode" id="group_kode" name="group_kode" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Nama</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Nama" id="group_nama" name="group_nama" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Keterangan</label>
              <div class="col-md-5">
                <textarea class="form-control" placeholder="Keterangan" id="group_ket" name="group_ket"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Status</label>
              <div class="col-md-3">
                <select class="form-control" id="group_status" name="group_status">
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
          <div class="col-sm-6">
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
              <th class="text-center">Kode</th>
              <th class="text-center">Nama</th>
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
        <input type="hidden" id="group_id_akses">
        <div class="row">
          <label class="label-control col-md-3">Modul</label>
          <div class="col-md-5">
            <select name="modul_id" id="modul_id" class="form-control">
              <?php foreach ($modul as $v) : ?>
                <option value="<?= $v->modul_id ?>"><?= $v->modul_nama ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div id="listMenu"></div>
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
        searchDelay: 500,
        processing: true,
        serverSide: true,
        // scrollX: true,
        ajax: {
          url: '<?= base_url() ?>/admin/msgroup/get_data',
          type: 'POST',
        },
        columnDefs: [{
          targets: [0, -1],
          orderable: false,
        }, {
          targets: [0, -2, -1],
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
          group_nama: {
            required: true,
          },
          group_kode: {
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
            url: '<?= base_url() ?>/admin/msgroup/save',
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
    $("#group_id").val('')
    $('#btnSave').removeAttr('disabled', 'disabled').text('Save');
  }

  function reload_tbl() {
    $("#tbl_vendor").dataTable().fnDraw();
  }

  function set_val(data) {
    const isi = JSON.parse(decodeURIComponent(data))

    $("#act").val('edit')
    $("#group_id").val(isi.group_id)
    $("#group_nama").val(isi.group_nama)
    $("#group_kode").val(isi.group_kode)
    $("#group_ket").val(isi.group_ket)
    $("#group_status").val(isi.group_status)
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
          url: '<?= base_url() ?>/admin/msgroup/hapus',
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
    $("#modalTitle").text(title);
    $("#modalAkses").modal('show');
    $("#group_id_akses").val(id);
    $("#modul_id").trigger('change')
  }

  function get_menu() {
    $("#listMenu").jstree({
      "checkbox": {
        "keep_selected_style": false
      },
      'core': {
        "check_callback": true,
        'data': {
          'url': function(node) {
            return '<?= base_url() ?>/admin/msgroup/get_menu'
          },
          "dataType": "json",
          cache: false,
          'data': function(node) {
            return {
              'menu_id': node.id != "#" ? node.id : 0,
              'group_id': $("#group_id_akses").val(),
              'modul_id': $("#modul_id").val(),
            };
          }
        }
      },
      "plugins": ["checkbox"]
    }).on('loaded.jstree', function() {
      $("#listMenu").jstree('open_all');
    })
  }

  function saveAkses() {
    let data = "group_id=" + $("#group_id_akses").val() + "&modul_id=" + $("#modul_id").val();

    const listMenu = $("#listMenu")

    if (listMenu.find('a.jstree-clicked').length > 0) {
      listMenu.find('a.jstree-clicked').each(function(index, i) {
        data += '&menu_id[]=' + $(i).attr('menu_id')
      })
    }

    if (listMenu.find('.jstree-undetermined').length > 0) {
      listMenu.find('.jstree-undetermined').each(function(index, i) {
        data += '&menu_id[]=' + $(i).closest('a').attr('menu_id')
      })
    }

    $.ajax({
      url: '<?= base_url() ?>/admin/msgroup/save_akses',
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
    get_menu();

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

    $("#modul_id").change(function() {
      $("#listMenu").jstree(true).refresh(false, true);
    })
  });
</script>