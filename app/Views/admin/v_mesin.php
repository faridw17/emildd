<script src="<?= base_url() ?>/node_modules/highcharts/highcharts.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/series-label.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/exporting.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/export-data.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/accessibility.js"></script>
<h1 class="mt-4"><?= $title ?></h1>
<input type="hidden" name="device_id" id="device_id" value="<?= $device_id ?>">
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

  function getGrafikData() {
    $.ajax({
      url: '<?= base_url() ?>/admin/mesin/get_grafik',
      dataType: 'json',
      data: {
        device_id: $("#device_id").val()
      },
      success: res => {
        chartLine.xAxis[0].setCategories(res.xaxis);

        if (isNewChart == 1) {
          $.each(res.series, function(index, i) {
            chartLine.addSeries(i)
          })
          isNewChart = 0;
        } else {
          $.each(res.series, function(index, i) {
            chartLine.series[index].setData(i.data);
          })
        }

        chartLine.redraw()
      }
    })
  }

  $(document).ready(function() {
    setInterval(() => {
      getGrafikData()
    }, 5000);
  })
</script>