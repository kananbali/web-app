<?php 
require_once "pdo.php";
require_once 'checkaccess.php';
//check the current day
/*
SELECT COUNT(*) AS number_of_events
FROM event_master 
WHERE event_date = '2022-02-22';
 */
date_default_timezone_set('Asia/Kolkata');

if(date('D')!='Mon')
{    
 //take the last monday
  $staticstart = date('Y-m-d',strtotime('last Monday'));    

}else{
    $staticstart = date('Y-m-d');   
}

//always next monday

if(date('D')!='Sun')
{
    $staticfinish = date('Y-m-d',strtotime('next Sunday'));
}else{

        $staticfinish = date('Y-m-d');
}
// echo $staticstart;
// echo $staticfinish;

$begin = new DateTime($staticstart);
$end = new DateTime($staticfinish);
$end->modify('+1 day');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

$chart_data = array();
$no_of_events_this_week = 0;

foreach ($period as $dt) {
    // echo $dt->format("l Y-m-d H:i:s\n");
    $date = $dt->format('Y-m-d');
    $stmt = $pdo->query(
      "SELECT COUNT(*) AS number_of_events
      FROM event_master 
      WHERE event_date = '$date' AND event_approved = 1 ");
  $number = $stmt->fetch(PDO::FETCH_ASSOC);
    array_push($chart_data,$number['number_of_events']);
    $no_of_events_this_week = $no_of_events_this_week + intval($number['number_of_events']);
}

$stmt = $pdo->query(
  "SELECT DATE_FORMAT(event_date, '%d %a') as event_date,COUNT(*) AS number_of_events
  FROM event_master 
  WHERE MONTH(event_date) = MONTH(now()) AND
  YEAR(event_date) = YEAR(now())
  AND event_approved = 1 
  GROUP BY event_date");
$month_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
// $monthCount = count($month_data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Sweet Alert -->
  <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">
</head>
<?php require_once "./sidenav.php"; ?>
<body onload="hide('month_div');">
  <main class="content">
    <?php require_once "./topnav.php";?>
    <div class="py-4">
    </div>
    <div class="row" id="week_div">
      <div class="col-12 mb-4">
        <div class="card bg-yellow-100 border-0 shadow">
          <div class="card-header d-sm-flex flex-row align-items-center flex-0">
            <div class="d-block mb-3 mb-sm-0">
              <div class="fs-5 fw-normal mb-2">Events Happening This Week</div>
              <h2 class="fs-3 fw-extrabold"><?= $no_of_events_this_week?></h2>
              
            </div>
            <div class="d-flex ms-auto">
              <button class="btn btn-primary text-dark btn-sm me-2">Week</button>
              <button onclick="hide('week_div');show('month_div');" class="btn btn-secondary text-dark btn-sm me-2">Month</button>
            </div>
          </div>
          <div class="card-body p-2">
            
            <div class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
            
            
          </div>
        </div>
      </div>
      
    </div>

    <div class="row" id="month_div">
      <div class="col-12 mb-4">
        <div class="card bg-yellow-100 border-0 shadow">
          <div class="card-header d-sm-flex flex-row align-items-center flex-0">
            <div class="d-block mb-3 mb-sm-0">
              <div class="fs-5 fw-normal mb-2">Events Happening This Month</div>
              <h2 class="fs-3 fw-extrabold" id="monthCount"></h2>
              
            </div>
            <div class="d-flex ms-auto">
              <button onclick="hide('month_div');show('week_div');" class="btn btn-secondary text-dark btn-sm me-2">Week</button>
              <button class="btn btn-primary text-dark btn-sm me-2">Month</button>
            </div>
          </div>
          <div class="card-body p-2">

            <div class="ct-chart-sales-month ct-double-octave ct-series-g" style="padding-bottom: 20px;"></div>
            
            
          </div>
        </div>
      </div>
      
    </div>
    </div>

    <?php require_once "./footer.php"; ?>
  </main>

  <!-- Core -->
  <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
  <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Vendor JS -->
  <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

  <!-- Slider -->
  <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

  <!-- Smooth scroll -->
  <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

  <!-- Charts -->
  <script src="../vendor/chartist/dist/chartist.min.js" type="text/javascript"></script>
  <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js" type="text/javascript"></script>

  <!-- Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Sweet Alerts 2 -->
  <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>

  <!-- Moment JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script>

  <!-- Vanilla JS Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Notyf -->
  <script src="../vendor/notyf/notyf.min.js" type="text/javascript"></script>

  <!-- Simplebar -->
  <script src="../vendor/simplebar/dist/simplebar.min.js" type="text/javascript"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js" type="text/javascript"></script>

  <!-- Volt JS -->
  <script src="../assets/js/volt.js" type="text/javascript"></script>

  <script>
    function show(id){
      document.getElementById(id).style.display = "block";
    }
    function hide(id){
      document.getElementById(id).style.display = "none";
    }
    // export const data = [0, 10, 30, 40, 80, 60, 100];
    const data = [];
    <?php foreach($chart_data as $value){
      echo "data.push('$value');";
    }
    ?>

    const monthData = [];
    const monthLabel = [];
    $monthCount = 0;
    <?php foreach($month_data as $value){
      $n = $value['number_of_events'];
      $m = $value['event_date'];
      $monthCount += intval($n);
      echo "monthData.push('$n');";
      echo "monthLabel.push('$m');";
    }
    ?>

    var monthCount = <?=$monthCount?>;

    document.getElementById('monthCount').innerHTML = monthCount;
    // console.log(data);
    d.addEventListener("DOMContentLoaded", function(event) {
      if(d.querySelector('.ct-chart-sales-value')) {

          // const data = [0, 10, 30, 40, 80, 60, 100];
          new Chartist.Line('.ct-chart-sales-value', {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            series: [
                data
            ]
          }, {
            low: 0,
            showArea: true,
            fullWidth: true,
            plugins: [
              Chartist.plugins.tooltip()
            ],
            axisX: {
                // On the x-axis start means top and end means bottom
                position: 'end',
                showGrid: true
            },
            axisY: {
                // On the y-axis start means left and end means right
                onlyInteger: true,
                showGrid: false,
                showLabel: true,
                labelInterpolationFnc: function(value) {
                    // return '$' + (value / 1) + 'k';
                    return value;
                }
            }
        });
    }

    if(d.querySelector('.ct-chart-sales-month')) {

    // const data = [0, 10, 30, 40, 80, 60, 100];
    new Chartist.Line('.ct-chart-sales-month', {
      // labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      labels: monthLabel,
      series: [
          monthData
      ]
    }, {
      low: 0,
      showArea: true,
      fullWidth: true,
      plugins: [
        Chartist.plugins.tooltip()
      ],
      axisX: {
          // On the x-axis start means top and end means bottom
          position: 'end',
          showGrid: true
      },
      axisY: {
          // On the y-axis start means left and end means right
          onlyInteger: true,
          showGrid: false,
          showLabel: true,
          labelInterpolationFnc: function(value) {
              // return '$' + (value / 1) + 'k';
              return value;
          }
      }
    });
    }
    });

  </script>

</body>

</html>