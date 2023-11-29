@include('layouts.sidebar')

<div id="mahasiswaSection" class="col-md-8 col-lg-6 vstack gap-4">
    <!-- Mahasiswa content -->
    <div class="card shadow-lg" >
        <div class="card-body">
            <h5 class="card-title text-center">Mahasiswa</h5>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <!--Aktif-->
                <div class="col-md-2">
                    <div class="card" style="background: linear-gradient(to right, #6a994e, #a7c957);">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Aktif')->count() }}</h5>
                            <h6>Aktif</h6>
                        </div>
                    </div>
                </div>
                <!-- Cuti -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #00bbf9;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Cuti')->count() }}</h5>
                            <h6>Cuti</h6>
                        </div>
                    </div>
                </div>
                <!-- Mangkir -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #ffc43d;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Mangkir')->count() }}</h5>
                            <h6>Mangkir</h6>
                        </div>
                    </div>
                </div>
                <!-- DO -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #9a031e;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'DO')->count() }}</h5>
                            <h6>DO</h6>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="hstack gap-2 gap-xl-3 justify-content-center text-center">
                <!-- Undur Diri -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #8e9aaf;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Undur Diri')->count() }}</h5>
                            <h6>Undur Diri</h6>
                        </div>
                    </div>
                </div>
                <!-- Meninggal Dunia -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #dad7cd;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Meninggal Dunia')->count() }}</h5>
                            <h6>Meninggal</h6>
                        </div>
                    </div>
                </div>
                <!-- Meninggal Dunia -->
                <div class="col-md-2">
                    <div class="card" style="background-color: #5fa8d3;">
                        <div class="card-body">
                            <h5 class="mb-0">{{ $mahasiswaAll->where('status', 'Lulus')->count() }}</h5>
                            <h6>Lulus</h6>
                        </div>
                    </div>
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

<!--<script>
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
</script>-->