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
                            <h1 class="card-title h5">Entry Progress</h1>
                        </div>
                        <div class="card-body" style="margin-top: 0px;">
                            @include('layouts/entryprogress')

                            <div class="tab-content mb-0 pb-0">

                                <!-- Tab Input IRS -->
                                <div class="tab-pane fade show active" id="tab-1">
                                    <!-- Card header START -->
                                    <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                                        <h1 class="card-title h5">Input IRS</h1>
                                        <div class="small italic text-danger">Harap diisi dengan data yang benar.</div>
                                    </div>
                                    <div class="card-body" style="margin-top: 0px;">
                                        <form class="row g-3" action="{{ route('irs.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <!-- Pilih Semester START-->
                                            <div class="col-12">
                                            <label class="form-label text-dark">Semester Aktif</label>
                                               <select class="form-select @error('semester_aktif') is-invalid @enderror" id="semester_aktif" name="semester_aktif" required>
                                                   <option value="">Pilih Semester</option>
                                                      
                                                       @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">Semester {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <!-- Pilih Semester END -->

                                            <!-- Input Jumlah SKS START -->
                                            <div class="col-12">
                                                <label class="form-label text-dark">Jumlah SKS</label>
                                                <input type="number" class="form-control @error('jumlah_sks') is-invalid @enderror" id="jumlah_sks" name="jumlah_sks" placeholder="Jumlah SKS" required>
                                            </div>
                                            <!-- Input Jumlah SKS END-->

                                            <!-- Dropzone START-->
                                            <div class="col-12">
                                                <label class="form-label">Scan IRS</label>
                                                <div class="dropzone">
                                                    <input type="file" class="filepond" id="file1" name="file" data-allow-reorder="true" required>
                                                </div>
                                            </div>

                                            <!-- Dropzone END -->
                                            <div class="text-danger small fst-italic">*Format file [.pdf], pastikan file yang diupload benar.</div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-sm btn-primary mb-0">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div> 
                                <!-- Tab Dosen END -->
                                <!-- Tab Mahasiswa -->
                                <div class="tab-pane fade show active" id="tab-2">
                                    <!-- Card header START -->
                                    <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                                        <h1 class="card-title h5">Input KHS</h1>
                                        <div class="small italic text-danger">Harap diisi dengan data yang benar.</div>
                                    </div>
                                    <div class="card-body" style="margin-top: 0px;">
                                        <form class="row g-3" action="{{ route('khs.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <!-- Pilih Semester START-->
                                            <div class="col-12">
                                            <label class="form-label text-dark">Semester Aktif</label>
                                               <select class="form-select @error('semester_aktif') is-invalid @enderror" id="semester_aktif" name="semester_aktif" required>
                                                   <option value="">Pilih Semester</option>
                                                      
                                                       @for ($i = 1; $i <= 14; $i++) <option value="{{ $i }}">Semester {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <!-- Pilih Semester END -->

                                            <!-- Input IP Semester START -->
                                            <div class="col-6">
                                                <label class="form-label text-dark">IP Semester</label>
                                                <input type="number" step="0.01" class="form-control @error('ip_semester') is-invalid @enderror" id="ip_semester" name="ip_semester" placeholder="IP Semester" required>
                                                <div class="small italic text-danger center mt-1">Contoh: 3.99</div>
                                            </div>

                                            <!-- Input IP Semester END -->

                                            <!-- Input IP Kumulatif START -->
                                            <div class="col-6">
                                                <label class="form-label text-dark">IP Kumulatif</label>
                                                <input type="number" step="0.01" class="form-control @error('ip_kumulatif') is-invalid @enderror" id="ip_kumulatif" name="ip_kumulatif" placeholder="IP Kumulatif" required>
                                                <div class="small italic text-danger center mt-1">Contoh: 3.99</div>
                                            </div>
                                            <!-- Input IP Kumulatif END -->


                                            <!-- Dropzone START-->
                                            <div class="col-12">
                                                <label class="form-label">Scan KHS</label>
                                                <div class="dropzone">
                                                    <input type="file" class="filepond" id="file2" name="file" data-allow-reorder="true" required>
                                                </div>
                                            </div>

                                            <!-- Dropzone END -->
                                            <div class="text-danger small fst-italic">*Format file [.pdf], pastikan file yang diupload benar.</div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-sm btn-primary mb-0">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div> 
                               
                                


                                <!-- Tab Dosen END -->

                                <div class="tab-pane fade show active" id="tab-3">
                                    <!-- Card header START -->
                                    <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                                        <h1 class="card-title h5">PKL</h1>
                                        <div class="text-dark small">Harap diisi dengan data yang benar.</div>
                                    </div>
                                    <div class="card-body" style="margin-top: 0px;">
                                        <form class="row g-3" action="{{ route('pkl.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="semester_aktif" value="{{ $progress != null ? $progress->semester_aktif : '' }}">
                                            <div id="pkl" class="col-12">
                                                <div class="row">
                                                    <!-- Input Pilih Status START -->
                                                    <div class="col-6">
                                                        <label class="form-label text-dark">Status</label>
                                                        <select class="form-select @error('status_pkl') is-invalid @enderror" id="status_pkl" name="status_pkl">
                                                            <option value="">-- Pilih Status --</option>
                                                            <option value="Lulus">Lulus</option>
                                                            <option value="Tidak Lulus">Tidak Lulus</option>
                                                        </select>
                                                        <div class="text-danger small fst-italic">*Pilih status PKL Anda</div>
                                                    </div>
                                                    <!-- Input Pilih Status END -->

                                                    <!-- Pilih Nilai START-->
                                                    <div class="col-6">
                                                        <label class="form-label text-dark">Nilai</label>
                                                        <select class="form-select @error('nilai_pkl') is-invalid @enderror" id="nilai_pkl" name="nilai_pkl">
                                                            <option value="">-- Pilih Nilai --</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                        </select>
                                                        <div class="text-danger small fst-italic">*Pilih Nilai PKL Anda</div>
                                                    </div>
                                                    <!-- Pilih Nilai END -->

                                                    <!-- Dropzone START-->
                                                    <div class="col-12 mt-3">
                                                        <label class="form-label">Scan PKL</label>
                                                        <div class="dropzone">
                                                            <input type="file" class="filepond" id="file3" name="file3" data-allow-reorder="true">
                                                        </div>
                                                    </div>
                                                    <!-- Dropzone END -->
                                                    <div class="text-danger small fst-italic">*Format file [.pdf], pastikan file yang diupload benar.</div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-sm btn-primary mb-0">Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                </div> <!-- Row END -->

                                <div class="tab-pane fade show active" id="tab-4">
                                    <!-- Card header START -->
                                    <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                                        <h1 class="card-title h5">Skripsi</h1>
                                        <div class="text-dark small">Harap diisi dengan data yang benar.</div>
                                    </div>
                                    <div class="card-body" style="margin-top: 0px;">
                                        <form class="row g-3" action="{{ route('skripsi.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="semester_aktif" value="{{ $progress != null ? $progress->semester_aktif : '' }}">

                                            <div id="skripsi" class="col-12">
                                                <div class="row">

                                                    <!-- Pilih Status START-->
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label text-dark">Status</label>
                                                        <select class="form-select @error('status_skripsi') is-invalid @enderror" id="status_skripsi" name="status_skripsi">
                                                            <option value="">-- Pilih Status --</option>
                                                            <option value="Sedang Ambil">Lulus</option>
                                                            <option value="Lulus">Tidak Lulus</option>
                                                        </select>
                                                        <div class="text-danger small fst-italic">*Pilih status Skripsi Anda</div>
                                                    </div>
                                                    <!-- Pilih Status END-->

                                                    <!-- Input Tanggal START -->
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label text-dark">Tanggal Sidang</label>
                                                        <input type="date" class="form-control @error('tanggal_sidang') is-invalid @enderror" id="tanggal_sidang" name="tanggal_sidang">
                                                        <div class="text-danger small fst-italic">*Pilih tanggal sidang Anda</div>
                                                    </div>
                                                    <!-- Input Tanggal END -->

                                                    <!-- Pilih Nilai START-->
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label text-dark">Nilai</label>
                                                        <select class="form-select @error('nilai_skripsi') is-invalid @enderror" id="nilai_skripsi" name="nilai_skripsi">
                                                            <option value="">-- Pilih Nilai --</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                            <option value="E">E</option>
                                                        </select>
                                                        <div class="text-danger small fst-italic">*Pilih nilai Skripsi Anda</div>
                                                    </div>
                                                    <!-- Pilih Nilai END -->

                                                    <!-- Dropzone START-->
                                                    <div class="col-12">
                                                        <label class="form-label">Scan Skripsi</label>
                                                        <div class="dropzone">
                                                            <input type="file" class="filepond" id="file4" name="file4" data-allow-reorder="true">
                                                        </div>
                                                    </div>
                                                    <!-- Dropzone END -->
                                                    <div class="text-danger small fst-italic">*Format file [.pdf], pastikan file yang diupload benar.</div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-sm btn-primary mb-0">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Card body END -->
                                </div>

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

    $(document).ready(function () {
    // Set the active tab to tab-1-link
    var activeTab = 'tab-1-link';
    sessionStorage.setItem('activeTab', activeTab);
    $('#' + activeTab.replace('-link', '')).addClass('show active');

    // Hide content of other tabs
    $('.tab-content .tab-pane').not('#' + activeTab.replace('-link', '')).removeClass('show active');

    // Handle tab change event
    $('.nav-link').on('shown.bs.tab', function (e) {
        var activeTab = e.target.id;

        // Show content of the active tab and hide others
        $('.tab-content .tab-pane').not('#' + activeTab.replace('-link', '')).removeClass('show active');
        $('#' + activeTab.replace('-link', '')).addClass('show active');

        sessionStorage.setItem('activeTab', activeTab);
    });
});



</script>
<!-- Load FilePond library -->
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond@4.17.1/dist/filepond.js"></script>

<!-- Turn all file input elements into ponds -->
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize
    );
    FilePond.create(document.getElementById('file1'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });
    FilePond.create(document.getElementById('file2'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });
    /*FilePond.create(document.getElementById('file3'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });
    FilePond.create(document.getElementById('file4'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });*/

    // Send the files to the Controller
    FilePond.setOptions({
        server: {
            url: '/upload',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    $('#semester_aktif').change(function () {
        var selectedSemester = $(this).val();

        // Make an AJAX request to the entry_progress route
        $.ajax({
            type: 'POST',  // Change the request type to POST
            url: '{{ route("entry_progress") }}',  // Update the URL to the correct route
            data: {
                '_token': '{{ csrf_token() }}',  // Add CSRF token for security
                'semester_aktif': selectedSemester
            },
            success: function (response) {
                // You can handle the response if needed
                console.log('Success:', response);

                // Reload the current page after successful entry progress
                window.location.reload();
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>


@stop