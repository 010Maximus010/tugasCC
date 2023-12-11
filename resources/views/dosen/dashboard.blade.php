@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        <div class="container">
                <div class="row g-4">

                    @include('layouts.sidebar')

                    <div class="vstack gap-4 col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                <div class="card-body" style="margin-top: 0px; background: linear-gradient(to right, #cfdbd5, #778da9);">
                                        <h5 class="card-title">Total Mahasiswa</h5>
                                        <br />
                                        <div class="table-responsive">
                                            <table class="center-aligned-table" align="center">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; width: 70px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Aktif')->count() }}</h5>
                                                            <span class="badge bg-success">Aktif</span>
                                                        </th>
                                                        <th style="text-align: center; width: 70px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Cuti')->count() }}</h5>
                                                            <span class="badge bg-primary">Cuti</span>
                                                        </th>
                                                        <th style="text-align: center; width: 70px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Mangkir')->count() }}</h5>
                                                            <span class="badge bg-warning">Mangkir</span>
                                                        </th>
                                                        <th style="text-align: center; width: 70px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'DO')->count() }}</h5>
                                                            <span class="badge bg-danger">DO</span>
                                                        </th>
                                                        <th style="text-align: center; width: 70px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Undur Diri')->count() }}</h5>
                                                            <span class="badge bg-secondary">Undur Diri</span>
                                                        </th>
                                                        <th style="text-align: center; width: 160px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Meninggal Dunia')->count() }}</h5>
                                                            <span class="badge bg-dark bg-opacity-25">Meninggal Dunia</span>
                                                        </th>
                                                        <th style="text-align: center; width: 40px;">
                                                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Lulus')->count() }}</h5>
                                                            <span class="badge bg-info">Lulus</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body" style="margin-top: 0px;">
                                        <h5 class="card-title">Mahasiswa per Angkatan</h5>
                                        <br />
                                        <div class="chart-container">
                                            <div id="grafik"></div>

                                            @section('script')

                                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                                            <script src="https://code.highcharts.com/highcharts.js"></script>
                                            <script src="https://code.highcharts.com/modules/exporting.js"></script>
                                            <script src="https://code.highcharts.com/modules/export-data.js"></script>
                                            <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    var data = <?php echo json_encode($mahasiswaAll); ?>;
                                                    var tahun = [];
                                                    var aktif = [];
                                                    var cuti = [];
                                                    var mangkir = [];
                                                    var dropout = [];
                                                    var undurdiri = [];
                                                    var meninggal = [];
                                                    var lulus = [];

                                                    // grouping data by year
                                                    for (var i = 0; i < data.length; i++) {
                                                        if (tahun.indexOf(data[i].angkatan) === -1) {
                                                            tahun.push(data[i].angkatan);
                                                        }
                                                    }
                                                    // grouping data by status
                                                    for (var i = 0; i < tahun.length; i++) {
                                                        var aktifCount = 0;
                                                        var cutiCount = 0;
                                                        var mangkirCount = 0;
                                                        var dropoutCount = 0;
                                                        var undurdiriCount = 0;
                                                        var meninggalCount = 0;
                                                        var lulusCount = 0;
                                                        for (var j = 0; j < data.length; j++) {
                                                            if (tahun[i] == data[j].angkatan) {
                                                                if (data[j].status == 'Aktif') {
                                                                    aktifCount++;
                                                                } else if (data[j].status == 'Cuti') {
                                                                    cutiCount++;
                                                                } else if (data[j].status == 'Mangkir') {
                                                                    mangkirCount++;
                                                                } else if (data[j].status == 'DO') {
                                                                    dropoutCount++;
                                                                } else if (data[j].status == 'Undur Diri') {
                                                                    undurdiriCount++;
                                                                } else if (data[j].status == 'Meninggal Dunia') {
                                                                    meninggalCount++;
                                                                } else if (data[j].status == 'Lulus') {
                                                                    lulusCount++;
                                                                }
                                                            }
                                                        }
                                                        aktif.push(aktifCount);
                                                        cuti.push(cutiCount);
                                                        mangkir.push(mangkirCount);
                                                        dropout.push(dropoutCount);
                                                        undurdiri.push(undurdiriCount);
                                                        meninggal.push(meninggalCount);
                                                        lulus.push(lulusCount);
                                                    }
                                                    Highcharts.setOptions({
                                                        exporting: {
                                                            buttons: {
                                                                contextButton: {
                                                                    text: 'Menu Chart',
                                                                    theme: {
                                                                        'stroke-width': 1,
                                                                        stroke: 'silver',
                                                                        r: 5,
                                                                        states: {
                                                                            hover: {
                                                                                fill: '#87c38f',
                                                                                style: {
                                                                                    color: 'white'
                                                                                }
                                                                            },
                                                                            select: {
                                                                                stroke: 'white',
                                                                                fill: '#0d6efd'
                                                                            }
                                                                        }
                                                                    },
                                                                }
                                                            }
                                                        }
                                                    });
                                                    Highcharts.chart('grafik', {
                                                        chart: {
                                                            type: 'column'
                                                        },
                                                        title: {
                                                            text: 'Grafik Mahasiswa',
                                                        },
                                                        colors: ['#80dcc0', '#81b3f5', '#fad879', '#e4707f', '#8f9294', '#c4c5c7', '#3b8aef'],
                                                        xAxis: {
                                                            categories: tahun,
                                                        },
                                                        yAxis: {
                                                            min: 0,
                                                            title: {
                                                                text: 'Jumlah Mahasiswa'
                                                            },
                                                            stackLabels: {
                                                                enabled: true,
                                                                style: {
                                                                    fontWeight: 'bold',
                                                                    color: ( // theme
                                                                        Highcharts.defaultOptions.title.style &&
                                                                        Highcharts.defaultOptions.title.style.color
                                                                    ) || 'gray',
                                                                    textOutline: 'none'
                                                                }
                                                            }
                                                        },
                                                        tooltip: {
                                                            headerFormat: '<b>{point.x}</b><br/>',
                                                            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                                                        },
                                                        plotOptions: {
                                                            column: {
                                                                stacking: 'normal',
                                                                dataLabels: {
                                                                    enabled: false
                                                                },
                                                                shadow: false,
                                                                center: ['50%', '50%'],
                                                                borderWidth: 0
                                                            }
                                                        },
                                                        series: [{
                                                            name: 'Aktif',
                                                            data: aktif
                                                        }, {
                                                            name: 'Cuti',
                                                            data: cuti
                                                        }, {
                                                            name: 'Mangkir',
                                                            data: mangkir
                                                        }, {
                                                            name: 'DO',
                                                            data: dropout
                                                        }, {
                                                            name: 'Undur Diri',
                                                            data: undurdiri
                                                        }, {
                                                            name: 'Meninggal Dunia',
                                                            data: meninggal
                                                        }, {
                                                            name: 'Lulus',
                                                            data: lulus
                                                        }]
                                                    });
                                                });
                                            </script>

                                            @include('sweetalert::alert')

                                            <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
                                            <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                                            <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

                                            <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
                                            <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                                            <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
                                            <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
                                            <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>

                                            <script src="{{ asset('assets/js/javascript-ajax.js') }}"></script>
                                            <script>
                                                var title = 'REKAP STATUS';
                                            </script>
                                            <script src="{{ asset('assets/js/data-table.js') }}"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#table_1").DataTable().buttons().container().appendTo("#table_wrapper");
                                                });
                                                $('#table_1 tbody').on('click', 'tr', function() {
                                                    var data = $('#table_1').DataTable().row(this).data();
                                                    var nim = data[2];
                                                    document.getElementById(nim).click();
                                                });

                                                // change no from 1 if filter
                                                $('#table_1').on('draw.dt', function() {
                                                    $('#table_1').DataTable().column(0, {
                                                        search: 'applied',
                                                        order: 'applied',
                                                        page: 'applied'
                                                    }).nodes().each(function(cell, i) {
                                                        cell.innerHTML = i + 1;
                                                    });
                                                });
                                            </script>
                                            @stop
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-body" style="margin-top: 0px;">
                            <h1 class="card-title h5">Daftar Mahasiswa Informatika</h1>
                            <div class="d-flex flex-column align-items-end mb-4">
                                <div id="table_wrapper"></div>
                            </div>
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div id="filter_col3" data-column="3">
                                        <label class="form-label text-dark">Pilih Angkatan</label>
                                        <select class="form-select column_filter" id="col3_filter">
                                            <option value="">Semua</option>
                                            @for ($i = 2015; $i <= date('Y'); $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="filter_col4" data-column="4">
                                        <label class="form-label text-dark">Pilih Status</label>
                                        <select class="form-select column_filter" id="col4_filter">
                                            <option value="">Semua</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Mangkir">Mangkir</option>
                                            <option value="DO">DO</option>
                                            <option value="Undur Diri">Undur Diri</option>
                                            <option value="Meninggal Dunia">Meninggal Dunia</option>
                                            <option value="Lulus">Lulus</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table_1">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>NIM</th>
                                                    <th>Angkatan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mahasiswaAll as $mhs)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $mhs->nama }}</td>
                                                    <td>{{ $mhs->nim }}</td>
                                                    <td>{{ $mhs->angkatan }}</td>
                                                    <td>{{ $mhs->status }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

                
        