@extends('layouts.main')

@section('content')
    <div class="container-scroller">
        @include('layouts.navbar')
        <main>
            <div class="container">
                <div class="row g-4">
                    @include('layouts.sidebar')
                    <div class="col-md-8 col-lg-6 vstack gap-4">
                        @section('script')
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
                                var title = 'PKL';
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
                                            $("#tableBody").append(yearRow + statusRow);

                                            // Menambahkan baris untuk data
                                            var dataRow = "<tr>";
                                            for (var year = 2017; year <= 2023; year++) {
                                                dataRow += "<td><a href='" + generateLink('sudah', year) + "'>" + rekapDataPKL[year]['sudah'] + "</a></td>";
                                                dataRow += "<td><a href='" + generateLink('belum', year) + "'>" + rekapDataPKL[year]['belum'] + "</a></td>";
                                            }
                                            dataRow += "</tr>";

                                            // Menambahkan baris ke dalam tabel
                                            $("#tableBody").append(dataRow);

                                            // Inisialisasi DataTable setelah menambahkan data
                                            var table = $("#table_3").DataTable({
                                                buttons: [
                                                    'copy', 'excel', 'pdf', 'print'
                                                ]
                                            });

                                            // Inisialisasi DataTable setelah menambahkan data
                                            table.buttons().container().appendTo("#table_wrapper");
                                        },
                                        error: function(error) {
                                            console.log(error);
                                        }
                                    });
                                });

                                function generateLink(status, year) {
                                    // Gantilah 'your_base_url' dengan URL dasar aplikasi Anda
                                    var baseUrl = 'studyfyif';

                                    // Gantilah 'list_sudah_pkl' dan 'list_belum_pkl' dengan nama rute atau URL yang sesuai
                                    var link = '{{ url("/list-pkl") }}' + '/' + status + '/' + year;

                                    return link;
                                }
                            </script>
                        @stop

                        
                        <div class="card">
                            <div class="card-body" style="margin-top: 0px;">
                                <h5 class="card-title" style="text-align: center;">Rekap PKL Mahasiswa Informatika</h5>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_3">
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
@endsection