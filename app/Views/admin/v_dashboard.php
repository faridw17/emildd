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
  var chartLine = Highcharts.chart('chartLine', {

    title: {
      text: 'Monitoring Lama Nyala Mesin'
    },

    subtitle: {
      text: 'PT X'
    },

    yAxis: {
      title: {
        text: 'Waktu Operasi (jam)'
      }
    },

    // xAxis: {
    // accessibility: {
    //   rangeDescription: 'Range: 2010 to 2017'
    // }
    //   categories: [1, 2, 3, 4, 5, 6, 7, 8]
    // },

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
        // pointStart: 2010
      }
    },

    series: [
      // {
      //   name: 'Installation',
      //   data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
      // }, {
      //   name: 'Manufacturing',
      //   data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
      // }, {
      //   name: 'Sales & Distribution',
      //   data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
      // }, {
      //   name: 'Project Development',
      //   data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
      // }, {
      //   name: 'Other',
      //   data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
      // }
    ],

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
        console.log(res);

        // chartLine.series[0].setData();
        chartLine.xAxis[0].setCategories(res.xaxis);
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