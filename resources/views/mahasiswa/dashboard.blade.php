@include('layouts.sidebar')

<div class="col-md-8 col-lg-6 vstack gap-4">
    <div class="card" style="background: linear-gradient(to right, #cfdbd5, #778da9);">
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
                    <span class="badge btn-warning">{{ $pkl->status }}</span>
                    @else
                    <span class="badge btn-success">{{ $pkl->status }}</span>
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
                    <span class="badge btn-warning">{{ $skripsi->status }}</span>
                    @else
                    <span class="badge btn-success">{{ $skripsi->status }}</span>
                    @endif
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
