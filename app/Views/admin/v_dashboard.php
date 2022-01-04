<script src="<?= base_url() ?>/node_modules/highcharts/highcharts.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/series-label.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/exporting.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/export-data.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/accessibility.js"></script>
<h1 class="mt-4"><?= $title ?></h1>
<div class="row">
  <div class="col-md-12">
    <h3>Mesin</h3>
  </div>
</div>
<div class="row" id="listMesin">
</div>
<div class="row">
  <div class="offset-lg-1 col-lg-10 col-md-12">
    <div class="card">
      <div class="card-header text-white bg-dark mb-3">Monitoring nyala Mesin (jam)</div>
      <div class="card-body">
        <div id="chartLine"></div>
      </div>
    </div>
    <div id="chartLine"></div>
  </div>
</div>
<script>
  var isNewChart = 1;
  var chartLine = Highcharts.chart('chartLine', {

    title: {
      text: 'Monitoring Lama Nyala Mesin'
    },

    subtitle: {
      text: '<?= $nama_pt ?>'
    },

    yAxis: {
      title: {
        text: 'Waktu Operasi (jam)'
      }
    },

    xAxis: {
      title: {
        text: 'Tanggal'
      }
    },

    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
    },

    plotOptions: {
      series: {
        label: {
          connectorAllowed: false
        },
      }
    },

    series: [],

    responsive: {
      rules: [{
        condition: {
          maxWidth: 500
        },
        chartOptions: {
          legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom'
          }
        }
      }]
    }

  });

  function getDashboardMesin() {
    $.ajax({
      url: '<?= base_url() ?>/admin/dashboard/get_mesin',
      dataType: 'json',
      success: res => {
        $("#listMesin").html('')
        if (res.length > 0) {
          let list = '',
            kondisiText = '',
            kondisi = '';
          $.each(res, function(index, i) {
            switch (i.device_kondisi) {
              case '1':
                kondisi = 'fas fa-check fa-2x text-success';
                kondisiText = 'Menyala';
                break;
              case '0':
                kondisi = 'fas fa-times fa-2x text-danger';
                kondisiText = 'Mati';
                break;
              default:
                kondisi = 'fas fa-cogs fa-2x text-warning';
                kondisiText = 'Maintenance';
                break;
            }
            list +=
              `<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">${i.device_kode}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${i.device_nama}</div>
                      </div>
                      <div class="col-auto" data-toggle="tooltip" data-placement="top" title="${kondisiText}">
                        <i class="${kondisi}"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>`
          })
          $("#listMesin").html(list)
        }
      }
    })
  }

  function getGrafikData() {
    $.ajax({
      url: '<?= base_url() ?>/admin/dashboard/get_grafik',
      dataType: 'json',
      success: res => {
        chartLine.xAxis[0].setCategories(res.xaxis);

        let dataGrafik = {
          data: [],
          name: "",
        };
        if (isNewChart == 1) {
          if (res.series.length > 0) {
            $.each(res.series, function(index, i) {
              dataGrafik.data = i.data.map((item, idx) => {
                if (item == null) {
                  return null;
                } else {
                  return parseFloat(item.toFixed(2));
                }
              })
              dataGrafik.name = i.name
              chartLine.addSeries(dataGrafik);
            })
          }
          isNewChart = 0;
        } else {
          if (res.series.length > 0) {
            $.each(res.series, function(index, i) {
              dataGrafik.data = i.data.map((item, idx) => {
                if (item == null) {
                  return null;
                } else {
                  return parseFloat(item.toFixed(2));
                }
              })
              chartLine.series[index].setData(dataGrafik.data);
            })
          }
        }


        chartLine.redraw()
      }
    })
  }

  $(document).ready(function() {
    setInterval(() => {
      getDashboardMesin()
      getGrafikData()
    }, 5000);
  })
</script>