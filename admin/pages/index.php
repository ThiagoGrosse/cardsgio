<?php

require_once 'database/login.php';

session_start();

if (!$_SESSION['usuario']) {
    header('Location: ' . URL::getBase() . "login");
    exit();
}

/*
    Datas
*/

$timestamp = strtotime("-30 days");


/*
    Querys
*/
$conn = dbON();

// Total de produtos
$produtos = $conn->query('SELECT COUNT(sku) AS total FROM produto_cadastro');
// Total de produtos raros
$raras = $conn->query('SELECT COUNT(sku) AS total FROM produto_cadastro WHERE condicao = "rara"');
// Total de produtos semi raros
$semiRara = $conn->query('SELECT COUNT(sku) AS total FROM produto_cadastro WHERE condicao = "semi-raro"');
// Total de produtos comuns
$comum = $conn->query('SELECT COUNT(sku) AS total FROM produto_cadastro WHERE condicao = "comum"');
// Total com estoque
$estoque = $conn->query('SELECT COUNT(sku) AS total FROM produto_preco_estoque WHERE estoque > 0');
// Ticket médio
$media = $conn->query('SELECT AVG(preco) AS total FROM produto_preco_estoque WHERE estoque > 0');

$totalProdutos = mysqli_fetch_assoc($produtos);
$totalRaras = mysqli_fetch_assoc($raras);
$totalSemiRaras = mysqli_fetch_assoc($semiRara);
$totalComum = mysqli_fetch_assoc($comum);
$totalEstoque = mysqli_fetch_assoc($estoque);
$ticketMedio = mysqli_fetch_assoc($media);

$conn->close();

$convert = number_format((int)$ticketMedio['total'], 2);

require_once 'views/head.php';

?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php require_once 'views/menu-lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php require_once 'views/menu-top.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row container-cards">

                        <div class="card bg-gradient-black">
                            <div class="card-body">
                                <h4 class="card-title">Produtos cadastrados</h4>
                                <p class="card-text"><?php if ($totalProdutos['total']) {
                                                            echo $totalProdutos['total'];
                                                        } ?></p>
                            </div>
                        </div>

                        <div class="card bg-gradient-black">
                            <div class="card-body">
                                <h4 class="card-title">Produtos com estoque</h4>
                                <p class="card-text"><?php if ($totalEstoque['total']) {
                                                            echo $totalEstoque['total'];
                                                        } ?></p>
                            </div>
                        </div>

                        <div class="card bg-gradient-black">
                            <div class="card-body">
                                <h4 class="card-title">Ticket médio</h4>
                                <p class="card-text"><?php if ($convert) {
                                                            echo 'R$ ' . str_replace(".", ",", $convert);
                                                        } ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Pedidos dos ultimos 30 dias
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Quantidade de pedidos por status
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="chartBar"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php require_once 'views/footer.php'; ?>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
            <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
            <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

            <script>
                var date = new Date();
                var inicial = new Date()

                inicial.setDate(inicial.getDate() - 30);

                var obj = {
                    dataInicial: inicial.toLocaleDateString(),
                    dataFinal: date.toLocaleDateString(),
                }

                $.ajax({
                    url: 'controller/dash.php',
                    type: 'POST',
                    data: obj,
                    dataType: 'json',
                    success: function(data) {
                        var labels = data.datas
                        var valores = data.valores
                        var status = data.status
                        var quantia = data.quantidade

                        chart(labels, valores)
                        chartBar(status, quantia)
                    }
                })

                $(function() {
                    $(".calendario").datepicker();
                });

                function chart(labels, valores) {

                    // Area Chart Example
                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Earnings",
                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: valores,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return 'R$' + number_format(value);
                                        }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': R$' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            }
                        }
                    });
                }

                function chartBar(status, quantia) {
                    // Bar Chart Example
                    var ctx = document.getElementById("chartBar");
                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: status,
                            datasets: [{
                                label: "Revenue",
                                backgroundColor: "#4e73df",
                                hoverBackgroundColor: "#2e59d9",
                                borderColor: "#4e73df",
                                data: quantia,
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'month'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 6
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                        max: 10,
                                        maxTicksLimit: 10,
                                        padding: 10,
                                        // Include a dollar sign in the ticks
                                        // callback: function(value, index, values) {
                                        //     return '$' + number_format(value);
                                        // }
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                        return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                    }
                                }
                            },
                        }
                    });
                }


                function number_format(number, decimals, dec_point, thousands_sep) {
                    // *     example: number_format(1234.56, 2, ',', ' ');
                    // *     return: '1 234,56'
                    number = (number + '').replace(',', '').replace(' ', '');
                    var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function(n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                    if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                    }
                    if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                    }
                    return s.join(dec);
                }
            </script>