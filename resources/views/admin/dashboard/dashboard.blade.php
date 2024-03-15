<x-admin.admin-layout :page="$page">
    <x-slot name="customCss">
        <Style></Style>
    </x-slot>
    <x-slot name="title">
        Admin Dashboard
    </x-slot>
    <x-slot name="pageTitle">
        Dashboard
    </x-slot>
    <x-slot name="subPageTitle">
        <li class="breadcrumb-item f-w-400">Dashboard</li>
    </x-slot>

    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">

                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="card">

                        <div class="card-body">
                            <canvas id="ip_charts"></canvas>
                        </div>
                    </div>

                </div>
                <!-- Multiple table control elements  Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-3">Recent Shorted Links</h4>
                        </div>
                        <div class="card-body">


                            <div class="table-responsive theme-scrollbar user-datatable">
                                <table class="display" id="data_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">Id</th>
                                            <th>Orginal Url</th>
                                            <th>Short Url </th>
                                            <th>Clicks</th>



                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Multiple table control elements Ends-->
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    <x-slot name="customJs">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',

                data: {
                    datasets: [{
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        label: 'Browser Clicks Analysis',
                        data: @json($browser_clicks)
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctx1 = document.getElementById('ip_charts');

            new Chart(ctx1, {
                type: 'bar',

                data: {
                    datasets: [{
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        label: 'Ip Address Clicks Analysis',
                        data: @json($ip_clicks)
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        <script>
            $(function() {


                var data_table = $('#data_table').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX: true,
                    ajax: '{{ url()->current() }}',

                    columns: [{
                            data: 'id',
                            name: 'id'
                        }, {
                            data: 'original_url',
                            name: 'original_url'
                        },

                        {
                            data: 'short_url',
                            name: 'short_url'
                        },
                        {
                            data: 'clicks',
                            name: 'clicks'
                        },


                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],


                });

            })
        </script>
    </x-slot>
</x-admin.admin-layout>
