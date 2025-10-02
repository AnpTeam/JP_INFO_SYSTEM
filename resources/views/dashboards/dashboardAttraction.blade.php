@extends('home')

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    @include('sweetalert::alert')

    <!-- Load external libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Title -->
                <h2 class="fw-bold mb-2 text-danger"> Dashboard </h2>
            </div>

            <!-- Chart Section -->
            <div class="container mt-4">
                <div class="row">

                    <!-- Chart Canvas -->
                    <canvas id="visitsChart" width="600" height="200"></canvas>

                    <div class="col-md-12 mt-4">
                        <!-- Title -->
                        <h5 class="mb-3">Select group by columns</h5>

                        <!-- Chart Settings Dropdowns -->
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <!-- Dropdown for selecting DB column -->
                                <select id="select_column" class="form-select me-2">
                                    @foreach($filteredColumns as $col)
                                        <option value="{{ $col }}">{{ $col }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <!-- Dropdown for selecting chart type -->
                                <select id="select_bartype" class="form-select me-2">
                                    <option value="line">Line Chart</option>
                                    <option value="bar">Bar Chart</option>
                                    <option value="pie">Pie Chart</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Chart -->

            <!-- Data Overview -->
            <div class="row">
                <h4 class="mb-4 fw-bold text-danger">Data Overview</h4>

                <!-- Total Rows -->
                <div class="col-6 col-md-2">
                    <!-- Custom Style Card -->
                    <div class="custom-card-inline" id="totalRowCard">
                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                            <div class="row">
                                <!-- Value -->
                                <div id="cardValue" class="card-value  justify-content-center fs-2 fw-bold">
                                    {{ $countRow ?? "0" }}
                                </div>

                                <!-- Labels -->
                                <div class="card-label mt-2 fs-6 text-muted justify-content-center">Total Rows.</div>

                                <!-- Indicator -->
                                <div
                                    class="card-change justify-content-center {{ $percentRowDiff >= 0 ? 'text-success' : 'text-danger' }} d-flex align-items-center gap-1 fs-5 mt-1">
                                    {!! $percentRowDiff >= 0 ? '<i class="fas fa-arrow-up"></i>' : '<i class="fas fa-arrow-down"></i> ' !!}
                                    {{ number_format(abs($percentRowDiff), 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total City -->
                <div class="col-6 col-md-2">
                    <!-- Custom Style Card -->
                    <div class="custom-card-inline" id="totalRowCard">
                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                            <div class="row">
                                <!-- Value -->
                                <div id="cardValue" class="card-value  justify-content-center fs-2 fw-bold">
                                    {{ $countCity ?? "0" }}
                                </div>

                                <!-- Labels -->
                                <div class="card-label mt-2 fs-6 text-muted justify-content-center">Total Citys.</div>

                                <!-- Indicator -->
                                <div
                                    class="card-change justify-content-center text-white d-flex align-items-center gap-1 fs-5 mt-1">
                                    {!! $percentRowDiff >= 0 ? '<i class="fas fa-arrow-up"></i>' : '<i class="fas fa-arrow-down"></i> ' !!}
                                    {{ number_format(abs($percentRowDiff), 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Region -->
                <div class="col-6 col-md-2">
                    <!-- Custom Style Card -->
                    <div class="custom-card-inline" id="totalRowCard">
                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                            <div class="row">
                                <!-- Value -->
                                <div id="cardValue" class="card-value  justify-content-center fs-2 fw-bold">
                                    {{ $countRegion ?? "0" }}
                                </div>

                                <!-- Labels -->
                                <div class="card-label mt-2 fs-6 text-muted justify-content-center">Total Region.</div>

                                <!-- Indicator -->
                                <div
                                    class="card-change justify-content-center text-white d-flex align-items-center gap-1 fs-5 mt-1">
                                    {!! $percentRowDiff >= 0 ? '<i class="fas fa-arrow-up"></i>' : '<i class="fas fa-arrow-down"></i> ' !!}
                                    {{ number_format(abs($percentRowDiff), 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Category -->
                <div class="col-6 col-md-2">
                    <!-- Custom Style Card -->
                    <div class="custom-card-inline" id="totalRowCard">
                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                            <div class="row">
                                <!-- Value -->
                                <div id="cardValue" class="card-value  justify-content-center fs-2 fw-bold">
                                    {{ $countCategory ?? "0" }}
                                </div>

                                <!-- Labels -->
                                <div class="card-label mt-2 fs-6 text-muted justify-content-center">Total Category.</div>

                                <!-- Indicator -->
                                <div
                                    class="card-change justify-content-center text-white d-flex align-items-center gap-1 fs-5 mt-1">
                                    {!! $percentRowDiff >= 0 ? '<i class="fas fa-arrow-up"></i>' : '<i class="fas fa-arrow-down"></i> ' !!}
                                    {{ number_format(abs($percentRowDiff), 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- JavaScript for Chart Rendering -->
                <script>
                    let visitsChart;
                    // declare visitsChart globally so it can be reused

                    // Function to create a chart with given type, labels, and data
                    function createChart(type, labels, data) {
                        // สร้างสีสวยๆ แบบ Gradient หรือใช้สีสดใสจากพาเลตต์
                        const backgroundColors = [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#E7E9ED', '#76B041',
                            '#FF6F91', '#845EC2', '#00C9A7', '#FF9671'
                        ];

                        return new Chart(ctx, {
                            type: type,
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: labels,
                                    data: data,
                                    backgroundColor: backgroundColors.slice(0, data.length),
                                    borderColor: '#fff',
                                    borderWidth: 2,
                                    hoverOffset: 30,     // เวลาชี้ slice จะเด้งออกมานิดๆ สวยดี
                                    borderRadius: 8,      // มุมกราฟโค้งมน
                                    fill: 'origin'
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'right',
                                        labels: {
                                            padding: 20,
                                            font: {
                                                size: 14,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        backgroundColor: 'rgba(0,0,0,0.8)',
                                        titleFont: { size: 16, weight: 'bold' },
                                        bodyFont: { size: 14 }
                                    }
                                }
                            }
                        });
                    }


                    // Initialize the chart with default data from Blade
                    const ctx = document.getElementById('visitsChart').getContext('2d');
                    visitsChart = createChart(
                        'line',
                        {!! json_encode($label) !!},   // labels from DB
                        {!! json_encode($dataViewCounter) !!} // data from DB
                    );

                    $('#select_column').on('change', function () {
                        let selectedColumn = $(this).val();

                        // Always fetch data dynamically via AJAX
                        $.ajax({
                            url: '/dashboard/chart-data',
                            type: 'GET',
                            data: { column: selectedColumn },
                            dataType: 'json',
                            cache: false,
                            success: function (response) {
                                if (response.labels && response.data) {
                                    visitsChart.data.labels = response.labels;
                                    visitsChart.data.datasets[0].data = response.data;
                                    visitsChart.data.datasets[0].label = selectedColumn;
                                    visitsChart.update();
                                } else {
                                    alert('Invalid response format');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX Error:", error);
                                alert('Error fetching chart data');
                            }
                        });
                    });

                    // Event: when user changes chart type
                    $('#select_bartype').on('change', function () {
                        let selectedBarType = $(this).val();

                        // save current data and options
                        const currentData = JSON.parse(JSON.stringify(visitsChart.data));
                        const currentOptions = JSON.parse(JSON.stringify(visitsChart.options));

                        // destroy and recreate chart
                        visitsChart.destroy();
                        visitsChart = createChart(selectedBarType, currentData.labels, currentData.datasets[0].data);
                    });
                </script>
                <!-- End JavaScript -->

                <!-- JavaScript for number flex card -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const cardValueEl = document.getElementById('cardValue');
                        if (!cardValueEl) {
                            console.error("Element with id 'cardValue' not found.");
                            return;
                        }
                        const valueStr = cardValueEl.textContent.replace(/,/g, '').trim();
                        const value = parseInt(valueStr, 10);

                        if (value >= 1000000) {
                            cardValueEl.classList.add('large');
                            cardEl.classList.add('large');

                        } else if (value >= 1000) {
                            cardValueEl.classList.add('medium');
                        } else {
                            cardValueEl.classList.add('small');
                        }
                    });

                </script>
                <!-- End JavaScript -->

@endsection

            @section('footer')
            @endsection

            @section('js_before')
            @endsection

            @section('js_before')
            @endsection