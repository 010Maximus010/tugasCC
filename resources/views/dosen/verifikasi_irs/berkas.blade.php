@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        <div class="container">
            <div class="row g-4">

                <!-- Main content START -->
                <div class="col-md-12 col-lg-6 vstack gap-4">
                    <!-- Card START -->
                    <div class="card">
                        <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-backspace"></i>
                                Kembali
                            </a>
                            @if ($progress->is_verifikasi == 0)
                            <div class="badge bg-danger">Belum diverifikasi</div>
                            @elseif ($progress->is_verifikasi == 1)
                            <div class="badge bg-success">Sudah diverifikasi</div>
                            @else ($progress->is_verifikasi == 2)
                            <div class="badge bg-dark">Ditolak</div>
                            @endif

                        </div>
                        <div class="text-center h5 mt-3">Berkas Mahasiswa</div>
                        <div class="text-center h6">Semester {{ $progress->semester_aktif }}</div>
                        <div class="card-body">
                            <div class="row g-3 mb-3 table-responsive">
                                <div class="col-1">
                                </div>
                                <div class="col-11">
                                    <table cellpadding="5" width="100%">
                                        <tr>
                                            <td class="col-2 mb-3">
                                                <p class="mb-3 border-bottom border-2 border-white"> <strong> Nama: </strong> </p>
                                            </td>
                                            <td width="550px">
                                                <p class="mb-3 border-bottom border-2"> {{ $mahasiswa->nama }} </p>
                                            </td>
                                            <td rowspan="5">
                                                <div class="avatar avatar-xxxl">
                                                    <a href="#!"><img class="avatar-img border border-white border-3 rounded-circle" src="{{ $mahasiswa->foto == null ? asset('assets/images/avatar/default.jpg') : asset($mahasiswa->foto) }}" alt=""></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2 mb-3">
                                                <p class="mb-3 border-bottom border-2 border-white"> <strong> NIM: </strong> </p>
                                            </td>
                                            <td>
                                                <p class="mb-3 border-bottom border-2"> {{ $mahasiswa->nim }} </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2 mb-3">
                                                <p class="mb-3 border-bottom border-2 border-white"> <strong> Angkatan: </strong> </p>
                                            </td>
                                            <td>
                                                <p class="mb-3 border-bottom border-2"> {{ $mahasiswa->angkatan }} </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2 mb-3">
                                                <p class="mb-3 border-bottom border-2 border-white"> <strong> Dosen Wali: </strong> </p>
                                            </td>
                                            <td>
                                                <p class="mb-3 border-bottom border-2"> {{ $dosen->nama }} </p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h6 class="text-center">Data IRS</h6>
                            <div class="row g-3 mb-3 table-responsive">
                                <div class="col-1">
                                </div>
                                <div class="col-11">
                                    <table cellpadding="10" width="100%">
                                        <tr>
                                            <td class="col-2 mb-3"> <strong> Jumlah SKS: </strong> </td>
                                            <td> {{ $irs->sks }} </td>
                                        </tr>
                                        <tr>
                                            <td class="col-2 mb-3"> <strong> File IRS: </strong> </td>
                                            <td> <iframe src="{{ asset($irs->upload_irs) }}" width="600" height="500"></iframe></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            @if (Auth::user()->role == 'dosen')
                                <div class="text-end">
                                    <!-- Form untuk Batalkan Verifikasi atau Verifikasi Berkas -->
                                    <form action="{{ route('verifikasi_update') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="nim" value="{{ $progress->nim }}">
                                        <input type="hidden" name="semester" value="{{ $progress->semester_aktif }}">
                                        
                                        @if ($progress->is_verifikasi == 1)
                                            <input type="hidden" name="id" value="0">
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-x-circle"></i> Batalkan Verifikasi Berkas
                                            </button>
                                        @elseif ($progress->is_verifikasi == 0 || $progress->is_verifikasi == 2)
                                            <input type="hidden" name="id" value="1">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check2-circle"></i> Verifikasi Berkas
                                            </button>
                                        @endif
                                    </form>

                                    <!-- Form untuk Menolak Berkas -->
                                    <form action="{{ route('verifikasi_update') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="nim" value="{{ $progress->nim }}">
                                        <input type="hidden" name="semester" value="{{ $progress->semester_aktif }}">
                                        <input type="hidden" name="id" value="2">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Tolak Berkas
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                        <!-- Card body END -->
                    </div>
                    <!-- Card END -->
                </div>

            </div> <!-- Row END -->
        </div>
        <!-- Container END -->
    </main>
</div>
@endsection

@section('script')

@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/js/javascript-ajax.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>

<script>
    // disable all input and button after submit
    $('form').submit(function() {
        // show spinner on button
        $(this).find('button[type=submit]').html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`
        );
        $('button').attr('disabled', 'disabled');
    });
</script>

@stop