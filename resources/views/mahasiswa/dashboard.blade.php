@include('layouts.sidebar')

<div class="col-md-8 col-lg-6 vstack gap-4">
    <div class="card" style="background: linear-gradient(to right, #8fb996, #a1cca5);">
        <div class="card-body" style="margin-top: 0px;">
            <h5 class="card-title">Informasi Mahasiswa</h5>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <div>
                    <h5 class="mb-3">Total SKS</h5>
                    <span>{{ $khs->sks_kumulatif ?? 0 }}</span>
                </div>
                <div class="vr"></div>
                <div>
                    <h5 class="mb-3">PKL</h5>
                    @if ($pkl == null)
                    <span class="badge bg-danger">Belum Ambil</span>
                    @elseif ($pkl->status == 'Belum Ambil')
                    <span class="badge bg-danger">{{ $pkl->status }}</span>
                    @elseif ($pkl->status == 'Sedang Ambil')
                    <span class="badge btn-warning-soft">{{ $pkl->status }}</span>
                    @else
                    <span class="badge btn-success-soft">{{ $pkl->status }}</span>
                    @endif
                </div>
                <div class="vr"></div>
                <div>
                    <h5 class="mb-3">Skripsi</h5>
                    @if ($skripsi == null)
                    <span class="badge bg-danger">Belum Ambil</span>
                    @elseif ($skripsi->status == 'Belum Ambil')
                    <span class="badge bg-danger">{{ $skripsi->status }}</span>
                    @elseif ($skripsi->status == 'Sedang Ambil')
                    <span class="badge btn-warning-soft">{{ $skripsi->status }}</span>
                    @else
                    <span class="badge btn-success-soft">{{ $skripsi->status }}</span>
                    @endif
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class=" col-1">
                </div>
                <div class="col-10">
                    <h6>Semester</h6>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 1]) }}"><br />1</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 2]) }}"><br />2</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 3]) }}"><br />3</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 4]) }}"><br />4</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 5]) }}"><br />5</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 6]) }}"><br />6</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 7]) }}"><br />7</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 8]) }}"><br />8</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 9]) }}"><br />9</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 10]) }}"><br />10</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 11]) }}"><br />11</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 12]) }}"><br />12</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 13]) }}"><br />13</a>
                    <a class="btn avatar-xl mb-3 me-3 text-white" id="buttonModalProgress" data-bs-toggle="modal" data-bs-target="#progress_view" data-attr="{{ route('departemen_progress_detail_semester', ['nim' => $mahasiswa->nim, 'semester' => 14]) }}"><br />14</a>
                    <br />
                    <h6 class="mt-2 mb-2">Keterangan:</h6>
                    <a class="btn btn-danger btn-sm mb-1"></a> <small>Belum diisikan (IRS dan KHS) atau tidak digunakan</small><br />
                    <a class="btn btn-info btn-sm mb-1"></a> <small>Sudah diisikan (IRS dan KHS)</small><br />
                    <a class="btn btn-warning btn-sm mb-1"></a> <small>Sudah Lulus PKL (IRS, KHS, dan PKL)</small><br />
                    <a class="btn btn-success btn-sm mb-1"></a> <small>Sudah Lulus Skripsi</small><br />
                </div>
            </div>
        </div>
        <br>
    </div>
</div>

<div class="modal fade" data-bs-backdrop="static" data-keyboard="false" id="progress_view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-info">
            <div class="modal-header">
                <ul class="nav nav-tabs nav-bottom-line justify-content-center justify-content-md-start">
                    <li class="nav-item"> <a class="text-white nav-link active" data-bs-toggle="tab" href="#tab-1" id="tab1"> IRS </a> </li>
                    <li class="nav-item"> <a class="text-white nav-link" data-bs-toggle="tab" href="#tab-2" id="tab2"> KHS </a> </li>
                    <li class="nav-item"> <a class="text-white nav-link" data-bs-toggle="tab" href="#tab-3" id="tab3"> PKL </a> </li>
                    <li class="nav-item"> <a class="text-white nav-link" data-bs-toggle="tab" href="#tab-4" id="tab4"> Skripsi </a> </li>
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnClose" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="showModalProgress">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
