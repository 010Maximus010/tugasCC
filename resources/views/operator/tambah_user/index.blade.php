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
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!-- Card START -->
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                            <h1 class="card-title h5">Generate Akun</h1>
                        </div>
                        <div class="card-body" style="margin-top: 0px;">
                            <ul class="nav nav-tabs nav-bottom-line justify-content-center justify-content-md-start">
                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#tab-1"> Mahasiswa </a> </li>
                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#tab-2"> Dosen </a> </li>
                            </ul>

                            <div class="tab-content mb-0 pb-0">

                                <!-- Tab Mahasiswa -->
                                <div class="tab-pane fade show active" id="tab-1">
                                    <div class="d-flex flex-column align-items-end mb-4">
                                        <a class="btn btn-sm btn-dark mb-0" style="background-color: #1f363d;" data-bs-toggle="modal" data-bs-target="#bulk_add_mahasiswa">
                                            <i class="bi bi-file-earmark-arrow-up"></i> Tambah Mahasiswa
                                        </a>
                                    </div>
                                    <form class="row g-3" action="/operator/mahasiswa" method="POST">
                                        @csrf
                                        <div class="col-6">
                                            <label class="form-label text-dark">NIM</label>
                                            <input type="number" class="form-control" id="nim" name="nim" placeholder="NIM" value="{{ old('nim') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Nama Mahasiswa</label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Dosen Wali </label>
                                                <select class="form-select @error('dosen_wali') is-invalid @enderror" id="dosen_wali" name="dosen_wali" required>
                                                    <option value="">Pilih Dosen Wali</option>
                                                    @foreach ($dosen_wali as $wali)
                                                        <option value="{{ $wali->nip }}">{{ $wali->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('dosen_wali')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Angkatan</label>
                                            <input type="text" class="form-control" id="angkatan" name="angkatan" placeholder="Angkatan" value="{{ old('angkatan') }}" required>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-sm btn-primary mb-0" style="background-color: #2374ab;" >Generate</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Tab Mahasiswa END -->

                                <!-- Tab Dosen -->
                                <div class="tab-pane fade" id="tab-2">
                                    <div class="d-flex flex-column align-items-end mb-4">
                                        <a class="btn btn-sm btn-dark mb-0" style="background-color: #1f363d;" data-bs-toggle="modal" data-bs-target="#bulk_add_dosen">
                                            <i class="bi bi-file-earmark-arrow-up"></i> Tambah Dosen
                                        </a>
                                    </div>
                                    <form class="row g-3" action="/operator/dosen" method="POST">
                                        @csrf
                                        <div class="col-6">
                                            <label class="form-label text-dark">NIP</label>
                                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP" value="{{ old('nip') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Nama Dosen</label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label text-dark">Status </label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="Aktif" @if (old('status')=="Aktif" ) {{ 'selected' }} @endif>Aktif</option>
                                                <option value="Cuti" @if (old('status')=="Cuti" ) {{ 'selected' }} @endif>Cuti</option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-sm btn-primary mb-0" style="background-color: #2374ab;">Generate</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Tab Dosen END -->

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
</div>

<!-- Modal Bulk Add Mahasiswa -->
<div class="modal fade" data-bs-backdrop="static" data-keyboard="false" id="bulk_add_mahasiswa" tabindex="-1" aria-labelledby="tambah_mahasiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk_add_mahasiswaLabel">Tambah Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    Keterangan:
                    <ul>
                        <li>File harus berformat .xlsx, .xls, .csv</li>
                    </ul>
                </div>
                <form action="/operator/mahasiswa/bulk" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-sm btn-success" style="background-color: #73ba9b;" >Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bulk Add Dosen -->
<div class="modal fade" data-bs-backdrop="static" data-keyboard="false" id="bulk_add_dosen" tabindex="-1" aria-labelledby="bulk_add_dosenLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulk_add_dosenLabel">Tambah Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    Keterangan:
                    <ul>
                        <li>File harus berformat .xlsx, .xls, .csv</li>
                    </ul>
                </div>
                <form action="/operator/dosen/bulk" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-sm btn-success" style="background-color: #73ba9b;">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

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