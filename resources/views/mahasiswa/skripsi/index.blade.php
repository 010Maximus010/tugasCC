@extends('layouts.main')

@section('content')

<div class="container-scroller">

    @include('layouts.navbar')

    <main>

        <!-- Container START -->
        <div class="container">
            <div class="row g-4">

                @include('layouts.sidebar')

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
                    <!-- Event alert END -->

                    <!-- Card START -->
                    <div class="card">
                        <!-- Card header START -->
                        <div class="card-header d-sm-flex text-center align-items-center justify-content-between border-0 pb-0">
                            <h1 class="card-title h5">Data Skripsi</h1>
                        </div>
                        <div class="card-body" style="margin-top: 0px;">
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Semester</th>
                                            <th>Nilai</th>
                                            <th>Tanggal Sidang</th>
                                            <th>Status</th>
                                            <th>Scan Skripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skripsi as $item)
                                        <tr>
                                            <td>{{$item->semester_aktif}}</td>
                                            <td>{{$item->nilai != null ? $item->nilai : '-'}}</td>
                                            <td>{{$item->tanggal_sidang != null ? $item->tanggal_sidang : '-'}}</td>
                                            <td>@if ($item->status == 'Lulus')
                                                <span class="badge bg-success">{{$item->status}}</span>
                                                @else
                                                <span class="badge bg-danger">{{$item->status}}</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ asset($item->upload_skripsi) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> Lihat</a></td>
                                            </td>
                                            <td>
                                                @if ($progress->where('nim', Auth::User()->nim_nip)->where('semester_aktif', $item->semester_aktif)->first()->is_verifikasi_skripsi == 1)
                                                <small>Data telah diverifikasi</small>
                                                @elseif ($progress->where('nim', Auth::User()->nim_nip)->where('semester_aktif', $item->semester_aktif)->first()->is_skripsi == 0)
                                                <small>Data ditolak</small>
                                                <a href="" class="btn btn-success btn-sm" id="buttonModalSkripsi" data-bs-toggle="modal" data-bs-target="#editSkripsi" data-attr="{{ route('skripsi.edit', [$item->semester_aktif, $item->nim]) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm" id="buttonConfirmDelete_skripsi" data-bs-toggle="modal" data-bs-target="#confirm_delete_skripsi" data-attr="{{ route('delete_skripsi', [$item->semester_aktif, $item->nim]) }}">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </a>
                                                @else ($progress->where('nim', Auth::User()->nim_nip)->where('semester_aktif', $item->semester_aktif)->first()->is_verifikasi_skripsi == 0)
                                                <a href="" class="btn btn-success btn-sm" id="buttonModalSkripsi" data-bs-toggle="modal" data-bs-target="#editSkripsi" data-attr="{{ route('skripsi.edit', [$item->semester_aktif, $item->nim]) }}">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm" id="buttonConfirmDelete_skripsi" data-bs-toggle="modal" data-bs-target="#confirm_delete_skripsi" data-attr="{{ route('delete_skripsi', [$item->semester_aktif, $item->nim]) }}">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div> <!-- Row END -->
        </div>
        <!-- Container END -->
    </main>
</div>

<!-- modal edit skripsi -->
<div class="modal fade" data-bs-backdrop="static" data-keyboard="false" id="editSkripsi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Skripsi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="btnClose" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="showModalSkripsi">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal confirm delete -->
<div class="modal fade" data-bs-backdrop="static" id="confirm_delete_skripsi" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmDeleteLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="showModalConfirmDelete_skripsi">
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/js/javascript-ajax.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>

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
    FilePond.create(document.getElementById('file'), {
        maxParallelUploads: 1,
        maxFileSize: "15MB",
        acceptedFileTypes: ['application/pdf'],
        labelIdle: '<br/><div class="avatar avatar-xxl"><a class="link"><img class="avatar-img" src="{{ asset("assets/images/upload.png") }}" alt=""></a></div><br/><span class="link">Upload File</span><br/><br><br/>',
        stylePanelAspectRatio: 0.2,
    });

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

<script type="text/javascript">
    // data-bs-dismiss="modal" click reload page
    $('button[data-bs-dismiss="modal"]').click(function() {
        location.reload();
    });

    $(document).on("click", "#buttonModalSkripsi", function() {
        event.preventDefault();
        let href = $(this).attr("data-attr");
        $.ajax({
            url: href,
            // return the result
            success: function(result) {
                $("#editSkripsi").modal("show");
                $("#showModalSkripsi").html(result).show();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
            },
        });
    });
</script>


@stop