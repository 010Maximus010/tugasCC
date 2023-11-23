@include('layouts.sidebar')

<div id="mahasiswaSection" class="col-md-8 col-lg-6 vstack gap-4">
    <!-- Mahasiswa content -->
    <div class="card shadow-lg" style="background: linear-gradient(to right, #8fb996, #a1cca5);">
        <div class="card-body">
            <h5 class="card-title text-center">Mahasiswa</h5>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Aktif')->count() }}</h5>
                    <span class="badge bg-success">Aktif</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Cuti')->count() }}</h5>
                    <span class="badge bg-primary">Cuti</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Mangkir')->count() }}</h5>
                    <span class="badge bg-warning">Mangkir</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'DO')->count() }}</h5>
                    <span class="badge bg-danger">DO</span>
                </div>
            </div>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Undur Diri')->count() }}</h5>
                    <span class="badge bg-secondary">Undur Diri</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Meninggal Dunia')->count() }}</h5>
                    <span class="badge bg-dark bg-opacity-25">Meninggal Dunia</span>
                </div>
                <div>
                    <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Lulus')->count() }}</h5>
                    <span class="badge bg-info">Lulus</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dosenSection" class="col-md-3 vstack gap-4" style="display:none;">
    <!-- Dosen content -->
    <div class="card shadow-lg" style="background: linear-gradient(to right, #8fb996, #a1cca5);">
        <div class="card-body">
            <h5 class="card-title text-center">Dosen</h5>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <div>
                    <h5 class="mb-0">{{ $dosenAll->where('status', 'Aktif')->count()}}</h5>
                    <span class="badge bg-success">Aktif</span>
                </div>
                <div class="vr"></div>
                <div>
                    <h5 class="mb-0">{{ $dosenAll->where('status', 'Cuti')->count() }}</h5>
                    <span class="badge bg-warning">Cuti</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to toggle between Mahasiswa and Dosen sections
    function toggleSections() {
        var mahasiswaSection = document.getElementById('mahasiswaSection');
        var dosenSection = document.getElementById('dosenSection');

        // Toggle display property
        if (mahasiswaSection.style.display === 'none') {
            mahasiswaSection.style.display = 'block';
            dosenSection.style.display = 'none';
        } else {
            mahasiswaSection.style.display = 'none';
            dosenSection.style.display = 'block';
        }
    }

    // Set interval to toggle sections every 3 seconds
    setInterval(toggleSections, 3000);
</script>