<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
        <link rel="stylesheet" href="{{ asset('css/card.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        <script src="{{ asset('js/sidebar.js') }}"></script>
        <script src="{{ asset('js/filter.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Statis Karir Alumni</title>
    </head>
    <style>
        .head-content{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            align-items: center;
        }
        .read-btn {
            background-color: #0A7FE6;
            /* color: #2B2B2B; */
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 5px 10px rgba(148, 0, 255, 0.1);
        }

        .read-btn:hover, .read-btn:active {
            background-color: #0c70c7;
            cursor: pointer;
        }
        form{
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
        }
        .nama {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
            margin: 0px 10px 0px 10px;
            /* margin: 5px; */
        }

        .nama label {
            font-size: 14px;
            font-weight: bold;
            width: auto;
            z-index: 10;
            margin-right: 10px;
        }
        .nama select{
            border-radius: 8px;
            border: 1px solid rgba(60, 15, 85, 0.2);
            box-shadow: 2px 2px 3px rgba(60, 15, 85, 0.1);
            padding: 5px 3px 5px 5px;
            cursor: pointer;
        }
    </style>
    <body class="main-content">
        @include('components.navAdmin')
        @include('components.sidebarAdmin')
        <div class="container-body" id="container-body">
            <div id="konten">
                <div class="content">
                    <h2>Data Karir Alumni</h2><hr>
                    <div id="karir-data-container">
                        @include('superadmin.partials.karir')
                    </div>
                </div>
                <div class="chart-card">
                    <h3>Data Grafik Bidang Karier Alumni per Tahun Lulus </h3><hr>
                    <canvas id="grafikKarier" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </body>
    <script>
        var ctx = document.getElementById('grafikKarier').getContext('2d');
        var grafikData = @json($grafikData);
        var grafikKarier = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: grafikData.labels,
                datasets: grafikData.datasets
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tahun Lulus'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Maksimal Data Karir per Bidang'
                        }
                    }
                },
                plugins: {
                    legend : {
                        display: true,
                        position: 'right'
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.addEventListener("click", function (e) {
                if (e.target.tagName === "A" && e.target.closest(".pagination-links")) {
                    e.preventDefault();
                    const url = e.target.getAttribute("href");

                    fetch(url, {
                        headers: { "X-Requested-With": "XMLHttpRequest" },
                    })
                        .then((response) => response.text())
                        .then((html) => {
                            document.querySelector("#karir-data-container").innerHTML = html;
                        })
                        .catch((error) => console.error("Error:", error));
                }
            });
        });
    </script>
</html>