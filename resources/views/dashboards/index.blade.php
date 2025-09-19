@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    <!-- Load external libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Dashboard Title -->
                <h2 class="fw-bold mb-3"> Dashboard </h2>
            </div>

            <div class="col-md-12">
                <!-- Table Dropdown Form -->
                <form action="/dashboard/table" method="POST">
                    @csrf
                    <label for="table" class="mb-2">Select a Table</label>
                    <div class="row">
                        <div class="col-sm-4">
                            <!-- Dropdown with table names -->
                            <select name="select_table" id="table" class="form-select p-2">
                                @foreach($tableNames as $table)
                                    <option value="{{ $table }}">{{ $table }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Button to fetch table data -->
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary p-2"> Fetch Data </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Overview Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- Total Rows -->
            <div class="col-md-3">
                <div class="alert alert-info h-100" role="alert">
                    <h5 class="text-center">Total Row</h5>
                    <div class="text-center lead fw-semibold fs-5 mt-3 text-dark">
                        {{ $countRow ? $countRow : "0" }}
                    </div>
                </div>
            </div>

            <!-- Column List -->
            <div class="col-md-3">
                <div class="alert alert-danger h-100" role="alert">
                    <h5 class="text-center">Column List</h5>
                    <select name="columnList" class="form-select mt-2 bg-danger-subtle border-0 fw-semibold fs-5 text-dark">
                        @foreach($countColumn as $col)
                            <option class="text-center">{{ $col }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- User List -->
            <div class="col-md-3">
                <div class="alert alert-warning h-100" role="alert">
                    <h5 class="text-center">User List</h5>
                    <div class="text-center lead fw-semibold fs-5 mt-3">
                        {{ $countUser ? $countUser : "0" }}
                    </div>
                </div>
            </div>

            <!-- User View Count -->
            <div class="col-md-3">
                <div class="alert alert-success h-100" role="alert">
                    <h5 class="text-center">User View</h5>
                    <div class="text-center lead fw-semibold fs-5 mt-3">
                        {{ $countView ? $countView : "0" }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Title -->
                <h4>Select group by columns</h4>

                <!-- Chart Settings Dropdowns -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Dropdown for selecting DB column -->
                        <select id="select_column" class="form-select me-2">
                            @foreach($filteredColumns as $col)
                                <option value="{{ $col }}">{{ $col }}</option>
                            @endforeach
                            <!-- Special option for view counter -->
                            <option value="viewCounter"> view count </option>
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

            <!-- Debug output -->
            <p>{{ $dataViewCounter }}</p>

            <!-- Chart Canvas -->
            <canvas id="visitsChart" width="600" height="300"></canvas>
        </div>
    </div>
    <!-- End Chart -->

    <!-- JavaScript for Chart Rendering -->
    <script>
        let visitsChart; 
        // declare visitsChart globally so it can be reused

        // Function to create a chart with given type, labels, and data
        function createChart(type, labels, data) {
            return new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'จำนวนเข้าชมเว็บไซต์ล่าสุด 12 เดือน',
                        data: data,
                        backgroundColor: 'rgba(247, 156, 183, 0.7)',
                        borderColor: 'rgba(247, 156, 183, 1)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true, position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: { y: { beginAtZero: true } }
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

        // Event: when user selects a column
        $('#select_column').on('change', function () {
            let selectedColumn = $(this).val();

            if (selectedColumn === 'viewCounter') {
                // use Blade data directly
                visitsChart.data.labels = {!! json_encode($label) !!};
                visitsChart.data.datasets[0].data = {!! json_encode($dataViewCounter) !!};
                visitsChart.update();
            } else {
                // fetch new data using AJAX
                $.ajax({
                    url: '/dashboard/chart-data',
                    type: 'GET',
                    data: { column: selectedColumn },
                    dataType: 'json',
                    cache: false, // prevent caching
                    success: function (response) {
                        if (response.labels && response.data) {
                            visitsChart.data.labels = response.labels;
                            visitsChart.data.datasets[0].data = response.data;
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
            }
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

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection
