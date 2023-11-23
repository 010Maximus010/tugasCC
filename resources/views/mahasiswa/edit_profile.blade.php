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
                    <!-- Event alert START -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                        <strong>Warning!</strong> Password tidak boleh sama dengan nama dan nim.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <!-- Event alert END -->

                    <!-- Card START -->
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                            <h1 class="card-title h5">Profile</h1>
                            <div class="small italic text-danger">Lengkapi data diri anda dengan benar</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('edit_profile_mahasiswa.update', $mahasiswa->nim) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mt-1 mb-1">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <div class="avatar avatar-xxxl">
                                                <img class="avatar-img border border-white border-3 rounded-circle" src="{{ $mahasiswa->foto == null ? asset('assets/images/avatar/default.jpg') : asset($mahasiswa->foto) }}" alt="...">
                                            </div>
                                            <input type="file" class="filepond" id="fileProfile" name="fileProfile" data-allow-reorder="true">
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Nama -->
                                <div class="row mt-1 mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
                                        @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Form NIM -->
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">NIM</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" placeholder="NIM" value="{{ $mahasiswa->nim }}" readonly required>
                                    </div>
                                </div>

                                {{-- Form Angkatan --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Angkatan </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" placeholder="Angkatan" value="{{ $mahasiswa->angkatan }}" readonly required>
                                    </div>
                                </div>

                                {{-- Form Status --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Status </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status" placeholder="Status" value="{{ $mahasiswa->status }}" readonly required>
                                    </div>
                                </div>

                                {{-- Form Jalur Masuk --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Jalur Masuk </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('jalur_masuk') is-invalid @enderror" id="jalur_masuk" name="jalur_masuk" placeholder="Jalur Masuk" value="{{ $mahasiswa->jalur_masuk }}" readonly required>
                                    </div>
                                </div>

                                {{-- Form Nomor HP --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Nomor HP </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('handphone') is-invalid @enderror" id="handphone" name="handphone" placeholder="Nomor HP" value="{{ old('handphone', $mahasiswa->handphone) }}" required>
                                        @error('handphone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Form Email SSO --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Email </label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email', $mahasiswa->email) }}" required>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Form Alamat --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Alamat </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Alamat" required>{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                                        @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Select Provinsi --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Provinsi </label>
                                    <div class="col-sm-9">
                                        <select class="form-select @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach ($provinsi as $prov)
                                            <option value="{{ $prov->kode_prov }}" {{ $mahasiswa->kode_prov == $prov->kode_prov ? 'selected="true"' : '' }}>{{ $prov->nama_prov }}</option>
                                            @endforeach
                                        </select>
                                        @error('provinsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Select Kota/Kab --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Kabupaten/Kota </label>
                                    <div class="col-sm-9">
                                        <select class="form-select @error('kabupatenkota') is-invalid @enderror" id="kabupatenkota" name="kabupatenkota" required>
                                            <option value="">Pilih Kabupaten/Kota</option>
                                            @foreach ($kabupaten as $kab)
                                            <option value="{{ $kab->kode_kab }}" {{ $mahasiswa->kode_kab == $kab->kode_kab ? 'selected="true"' : '' }}>{{ $kab->nama_kab }}</option>
                                            @endforeach
                                        </select>
                                        @error('kabupatenkota')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Form Dosen Wali --}}
                                <div class="row mb-1">
                                    <label class="col-sm-3 col-form-label text-dark">Dosen Wali </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('dosen_wali') is-invalid @enderror" id="dosen_wali" name="dosen_wali" placeholder="Dosen Wali" value="{{ $mahasiswa->dosen_wali }}" readonly required>
                                    </div>
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2 mb-0">Save</button>
                                </div>
                            </form>
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

<script type="text/javascript">
    $(document).ready(function() {
        var url = $('meta[name="url"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#provinsi').change(function() {
            var id = document.getElementById("provinsi").value;
            $.ajax({
                url: '/wilayah/' + id,
                type: 'GET',
                success: function(val) {
                    $('#kabupatenkota').html(val);
                }
            });
        });
    });
</script>

<!-- Load FilePond library -->
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@4.17.1/dist/filepond.js"></script>

<!-- Turn all file input elements into ponds -->
<script>
    var fileProfile = document.getElementById('fileProfile');
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
    var pondProfile = FilePond.create(fileProfile, {
        labelIdle: '<span class="link small text-dark"><i class="bi bi-pencil-square"></i> Perbarui Foto Profil</span>',
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
        allowFileSizeValidation: true,
        maxFileSize: '15MB',
    });

    FilePond.setOptions({
        server: {
            url: '/upload',
            process: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            }
        }
    });

    // show image profile after upload
    pondProfile.on('processfile', (error, file) => {
        if (error) {
            return;
        }
        var url = $('meta[name="url"]').attr('content');
        var public = window.location.origin;
        var image = public + '/files/temp/' + file.filename;
        $('.avatar-img').attr('src', image);
    });
</script>


@stop