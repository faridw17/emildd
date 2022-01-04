<script src="<?= base_url() ?>/node_modules/highcharts/highcharts.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/series-label.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/exporting.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/export-data.js"></script>
<script src="<?= base_url() ?>/node_modules/highcharts/modules/accessibility.js"></script>
<h1 class="mt-4"><?= $title ?></h1>
<input type="hidden" name="device_id" id="device_id" value="<?= $device_id ?>">
<div class="row">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
              RUNNING TIME (DAILY)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_harian"><?= $total_harian ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
              RUNNING TIME (MONTHLY)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_bulanan"><?= $total_bulanan ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              RUNNING TIME (YEARLY)</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_tahunan"><?= $total_tahunan ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
              TOTAL RUNNING TIME</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total_all"><?= $total_all ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
              STATUS</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="status_mesin">
              <?php
              if ($status == 1) {
                echo 'ON';
              } else if ($status == 0) {
                echo 'OFF';
              } else {
                echo 'MAINTENANCE';
              }
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clock fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
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

  function getGrafikData() {
    $.ajax({
      url: '<?= base_url() ?>/admin/mesin/get_grafik',
      dataType: 'json',
      data: {
        device_id: $("#device_id").val()
      },
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

  function getStatusMesin() {
    const device_id = $("#device_id").val()
    $.ajax({
      url: "<?= base_url() ?>/admin/mesin/realtime_detail/" + device_id,
      dataType: 'json',
      cache: false,
      success: res => {
        $("#total_harian").text(res.total_harian);
        $("#total_bulanan").text(res.total_bulanan);
        $("#total_tahunan").text(res.total_tahunan);
        $("#total_all").text(res.total_all);
        $("#status_mesin").text(res.status == 1 ? 'ON' : res.status == 0 ? 'OFF' : 'MAINTENANCE');
      }
    })
  }

  $(document).ready(function() {
    setInterval(() => {
      getGrafikData()
      getStatusMesin()
    }, 5000);
  })
</script>