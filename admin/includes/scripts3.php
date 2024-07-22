<style>
  /* Personalización del paginador */
  .dataTables_wrapper .dataTables_paginate {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
    font-family: 'Poppins', sans-serif;
  }

  .dataTables_paginate .pagination {
    border-radius: 0.5rem;
  }

  .dataTables_paginate .pagination li {
    margin: 0.1rem;
  }

  .dataTables_paginate .pagination {
    margin-right: 86px !important;
    margin-top: 8px !important;
  }

  .dataTables_paginate .pagination .previous {
    background-color: #54AF0C;
  }

  .dataTables_paginate .pagination .next {
    background-color: #54AF0C;
  }

  .dataTables_paginate .pagination li a {
    background-color: transparent;
    text-decoration: none;
    color: #fff;
    font-size: 12px;
    border: none;
  }

  .dataTables_paginate .pagination li.active {
    background-color: #54AF0C;
    color: #fff;
  }

  .dataTables_paginate .paginate_button {
    border-radius: 17px;
    background-color: #1E4DA9;
    cursor: pointer;
    color: black;
    font-family: "Poppins", sans-serif;
  }

  .dataTables_info {
    font-family: 'Poppins', sans-serif;
  }

  div.dataTables_wrapper div.dataTables_info {
    padding-top: 5px;
    font-size: 14px;
    width: 120px;
  }

  .dataTables_length label {
    font-family: "Poppins", sans-serif;
  }

  .dataTables_filter label {
    font-family: "Poppins", sans-serif;
  }

  .dataTables_length label {
    font-size: 15px;
  }

  .dataTables_filter label {
    font-size: 15px;
  }

  .dataTables_filter input {
    width: 173px !important;
  }

  .pagination li a:focus {
    outline: none;
    box-shadow: none;
  }
</style>

<?php
$year = date('Y');
if (isset($_GET['year'])) {
  $year = $_GET['year'];
}

$and = 'AND YEAR(date) = ' . $year;
$months = array();
$ontime = array();
$late = array();
for ($m = 1; $m <= 12; $m++) {
  $sql = "SELECT * FROM attendance  WHERE MONTH(date) = '$m' AND status = 1 $and";
  $oquery = $conn->query($sql);
  array_push($ontime, $oquery->num_rows);
  $sql = "SELECT * FROM attendance WHERE MONTH(date) = '$m' AND status = 0 $and";
  $lquery = $conn->query($sql);
  array_push($late, $lquery->num_rows);
  $num = str_pad($m, 2, 0, STR_PAD_LEFT);
  $month = date('M', mktime(0, 0, 0, $m, 1));
  array_push($months, $month);
}
$months = json_encode($months);
$late = json_encode($late);
$ontime = json_encode($ontime);
?>

<script>
  var months = <?php echo $months; ?>;
  var lateData = <?php echo $late; ?>;
  var onTimeData = <?php echo $ontime; ?>;

  var ctx = document.getElementById('barChart').getContext('2d');
  var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [
        {
          label: 'Tarde',
          backgroundColor: 'rgba(255, 168, 0, 1)',
          data: lateData
        },
        {
          label: 'A tiempo',
          backgroundColor: 'rgba(45, 160, 69, 1)',
          data: onTimeData
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          display: true,
          position: 'top',
          labels: {
            font: {
              family: "Poppins, sans-serif"
            }
          }
        }
      },
      scales: {
        x: {
          ticks: {
            font: {
              family: "Poppins, sans-serif"
            }
          }
        },
        y: {
          ticks: {
            font: {
              family: "Poppins, sans-serif"
            },
            min: 125,
            max: 2500,
            stepSize: 125,
            callback: function (value) {
              return value.toString();
            }
          }
        }
      }
    }
  });
</script>

<script>
  $('#example1').DataTable({
    pageLength: 7,
    responsive: true,
    lengthMenu: [7, 10, 15, 20]
  })
</script>