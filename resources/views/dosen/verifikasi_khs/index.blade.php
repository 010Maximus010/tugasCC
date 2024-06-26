@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        <div class="container">
            <div class="row g-4">

                @include('layouts.sidebar')

                <!-- Main content START -->
                <div class="col-md-8 col-lg-6 vstack gap-4">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        <li>{{session('error')}}</li>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                        <li>{{session('success')}}</li>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!-- Card START -->
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                            <h1 class="card-title h5">Verifikasi Berkas KHS</h1>
                        </div>
                        <div class="card-body" style="margin-top: 0px;">
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div id="filter_col0" data-column="0">
                                        <label class="form-label text-dark">Pilih Semester</label>
                                        <select class="form-select column_filter" id="col0_filter">
                                            <option value="">Semua</option>
                                            @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
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
                            </div>
                            <form action="{{ route('berkas_detail_khs') }}" method="GET">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="table-responsive justify-content-center">
                                            <table class="table table-bordered table-hover" id="table_1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Semester</th>
                                                        <th>Nama</th>
                                                        <th>NIM</th>
                                                        <th>Angkatan</th>
                                                        <th>Verifikasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($progress as $data)
                                                        @if ($data->is_khs == 1)
                                                            <tr style="cursor: pointer;">
                                                                <td>{{ $data->semester_aktif }}</td>
                                                                <td>{{ $mahasiswa->where('nim', $data->nim)->first()->nama }}</td>
                                                                <td>{{ $mahasiswa->where('nim', $data->nim)->first()->nim }}</td>
                                                                <td>{{ $mahasiswa->where('nim', $data->nim)->first()->angkatan }}</td>
                                                                <td>
                                                                    @if ($data->is_verifikasi_khs == 1)
                                                                        <span class="badge bg-success">Sudah diverifikasi</span>
                                                                    @elseif ($data->is_verifikasi_khs == 0)
                                                                        <span class="badge bg-danger">Belum diverifikasi</span>
                                                                    @else
                                                                        <span class="badge bg-dark">Ditolak</span>
                                                                    @endif
                                                                </td>
                                                                <button type="submit" id="{{ $data->nim }}_{{ $data->semester_aktif }}" name="nim_semester" value="{{ $data->nim }}_{{ $data->semester_aktif }}" hidden> Detail</button>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Card body END -->
                </div>
                <!-- Card END -->
            </div>

        </div> <!-- Row END -->
</div>
<!-- Container END -->
</main>
@endsection

@section('script')

@include('sweetalert::alert')

<script src=" https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/js/javascript-ajax.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
<script>
    $('#table_1 tbody').on('click', 'tr', function() {
        var data = $('#table_1').DataTable().row(this).data();
        var semester = data[0];
        var nim = data[2];
        document.getElementById(nim + '_' + semester).click();
    });
</script>

@stop