@extends('layouts.main')

@section('content')
    <div class="container-scroller">
        @include('layouts.navbar')
        <main>
            <div class="container">
                <div class="row g-4">
                    @include('layouts.sidebar')
                    <div class="col-md-8 col-lg-6 vstack gap-4">
                        <div class="card">
                            <div class="card-body" style="margin-top: 0px;">
                                <h5 class="card-title" style="text-align: center;">Rekap PKL Mahasiswa Informatika</h5>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_rekap_pkl">
                                        <thead class="thead-dark">
                                            <!-- Data akan diisi oleh JavaScript -->
                                            <tbody id="tableBody"></tbody>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @section('script')
    <!-- Dalam bagian head -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

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
        $(document).ready(function() {
            $.ajax({
                url: '{{ route("rekap.dataPKL") }}',
                type: 'GET',
                success: function(response) {
                    var rekapDataPKL = response.rekap_data;

                    // Menambahkan baris untuk tahun
                    var yearRow = "<tr>";
                    for (var year = 2017; year <= 2023; year++) {
                        yearRow += "<th colspan='2' style='text-align: center;'>" + year + "</th>";
                    }
                    yearRow += "</tr>";

                    // Menambahkan baris untuk Sudah/Belum
                    var statusRow = "<tr>";
                    for (var year = 2017; year <= 2023; year++) {
                        statusRow += "<th>Sudah</th><th>Belum</th>";
                    }
                    statusRow += "</tr>";

                    // Menambahkan baris ke dalam tabel
                    $("#table_rekap_pkl thead").append(yearRow + statusRow);

                    // Menambahkan baris untuk data
                    var dataRow = "<tr>";
                    for (var year = 2017; year <= 2023; year++) {
                        dataRow += "<td><a href='" + generateLink('sudah', year) + "'>" + rekapDataPKL[year]['sudah'] + "</a></td>";
                        dataRow += "<td><a href='" + generateLink('belum', year) + "'>" + rekapDataPKL[year]['belum'] + "</a></td>";
                    }
                    dataRow += "</tr>";

                    // Menambahkan baris ke dalam tabel
                    $("#table_rekap_pkl tbody").append(dataRow);

                    // Inisialisasi DataTable setelah menambahkan data
                    var table = $("#table_rekap_pkl").DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: ':visible'
                                }
            
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            }
                        ]
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function generateLink(status, year) {
            var baseUrl = 'studyfyif';
            var link = '{{ url("/list-pkl") }}' + '/' + status + '/' + year;
            return link;
        }
    </script>
    <script>
        var title = 'Rekap PKL';
    </script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    @stop
@endsection
