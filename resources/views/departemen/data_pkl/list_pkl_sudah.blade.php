@extends('layouts.main')

@section('content')
    <div class="container-scroller">
        @include('layouts.navbar')
        <main>
            <div class="container">
                <div class="row g-4">
                  
                    <div class="col-md-8 col-lg-6 vstack gap-4">
                        <div class="card">
                            <div class="card-body" style="margin-top: 0px;">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-backspace"></i>
                                    Kembali
                                </a>
                                <h5 class="card-title" style="text-align: center;">List Sudah PKL Mahasiswa Informatika - Angkatan {{ $year }}</h5>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table_sudah_pkl">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Angkatan</th>
                                                <th>Nilai</th> <!-- Sesuaikan dengan nama kolom nilai pada model PKL -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mahasiswaPKL as $index => $mahasiswa)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $mahasiswa->nim }}</td>
                                                    <td>{{ $mahasiswa->nama }}</td>
                                                    <td>{{ $mahasiswa->angkatan }}</td>
                                                    <td>{{ $mahasiswa->nilai }}</td> <!-- Sesuaikan dengan nama kolom nilai pada model PKL -->
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
        </main>
    </div>
    @section('script')
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
        var title = 'List Sudah PKL';
    </script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
        
        <!-- Your DataTable Initialization Script -->
        <script>
            $(document).ready(function() {
                var table = $("#table_sudah_pkl").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf', 'print'
                    ]
                });
            });
        </script>
    @stop
@endsection
