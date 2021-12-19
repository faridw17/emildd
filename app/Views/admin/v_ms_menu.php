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
          <input type="hidden" name="menu_id" id="menu_id">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-md-3 label-control">Modul</label>
              <div class="col-md-3">
                <select class="form-control" id="modul_id" name="modul_id">
                  <?php foreach ($modul as $v) : ?>
                    <option value="<?= $v->modul_id ?>"><?= $v->modul_nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Parent</label>
              <div class="col-md-5">
                <select class="form-control" id="menu_parent_id" name="menu_parent_id">
                  <option value="0" data-kode="">0 - ROOT</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Kode</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Kode Menu" id="menu_kode" name="menu_kode" />
                <input type="hidden" id="menu_kode_lama" name="menu_kode_lama" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Nama</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Nama Menu" id="menu_nama" name="menu_nama" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Ikon</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="Ikon Menu" id="menu_ikon" name="menu_ikon" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">URL</label>
              <div class="col-md-5">
                <input type="text" class="form-control" placeholder="URL Menu" id="menu_url" name="menu_url" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 label-control">Status</label>
              <div class="col-md-3">
                <select class="form-control" id="menu_status" name="menu_status">
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
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-md-3 label-control">Modul</label>
              <div class="col-md-9">
                <select class="form-control" id="fil_modul">
                  <?php foreach ($modul as $v) : ?>
                    <option value="<?= $v->modul_id ?>"><?= $v->modul_nama ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!--begin::DataTable-->
        <table class="table table-sm table-bordered table-hover table-checkable" id="tbl_vendor" style="margin-top: 13px !important; width: 100%;">
          <thead>
            <tr>
              <th class="text-center">No.</th>
              <th class="text-center">Kode</th>
              <th class="text-center">Nama</th>
              <th class="text-center">Ikon</th>
              <th class="text-center">URL</th>
              <th class="text-center">Parent</th>
              <th class="text-center">Status</th>
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
        responsive: true,
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= base_url() ?>/admin/msmenu/get_data',
          type: 'POST',
          data: function(d) {
            d.fil_modul = $('#fil_modul').val();
          }
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
          menu_nama: {
            required: true,
          },
          menu_kode: {
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
            url: '<?= base_url() ?>/admin/msmenu/save',
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
    $("#menu_id,#menu_kode_lama").val('')
    $('#btnSave').removeAttr('disabled', 'disabled').text('Save');
  }

  function reload_tbl() {
    $("#tbl_vendor").dataTable().fnDraw();
  }

  function set_val(data) {
    const isi = JSON.parse(decodeURIComponent(data))

    $("#act").val('edit')
    $("#modul_id").val(isi.modul_id)
    getMenu(isi.modul_id, isi.menu_parent_id)
    $("#menu_id").val(isi.menu_id)
    $("#menu_nama").val(isi.menu_nama)
    $("#menu_kode").val(isi.menu_kode)
    $("#menu_kode_lama").val(isi.menu_kode)
    $("#menu_ikon").val(isi.menu_ikon)
    $("#menu_url").val(isi.menu_url)
    $("#menu_status").val(isi.menu_status)
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
          url: '<?= base_url() ?>/admin/msmenu/hapus',
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

  function getMenu(modulId, idSelected = '') {
    $("#menu_parent_id [value!=0]").remove();
    $.ajax({
      url: '<?= base_url() ?>/admin/msmenu/get_parent',
      dataType: 'json',
      data: {
        modul_id: modulId
      },
      type: 'post',
      cache: false,
      success: res => {
        let opt = '',
          selected = '';
        if (res.length > 0) {
          $.each(res, function(index, i) {
            selected = idSelected == i.menu_id ? 'selected' : '';
            opt += `<option value="${i.menu_id}" data-kode="${i.menu_kode}" ${selected}>${i.menu_kode} - ${i.menu_nama}</option>`;
          })
          $("#menu_parent_id").append(opt);
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
      getMenu($("#modul_id").val())
      $("#rowForm").slideDown(500)
      $("#rowList").slideUp(500)
    })

    $("#modul_id").change(function() {
      getMenu($(this).val())
    })

    $("#fil_modul").change(function() {
      reload_tbl()
    })
  });
</script>