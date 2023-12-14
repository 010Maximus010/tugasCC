    <!-- Header START -->
    <header class="navbar-light fixed-top header-static" style="background-color: #0b3954;">

        <!-- Logo Nav START -->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo START -->
                <a class="navbar-brand" href="/">
                    <img class="light-mode-item navbar-brand-item" src="{{ asset('assets/images/logo2.png') }}" alt="logo">
                </a>
                <a class="text-light desktop" href="/" style="margin-left: 20px;">
                    <strong>STUDYFYIF</strong>
                </a>
                <!-- Logo END -->

                <!-- Main navbar START -->
                <div class="collapse navbar-collapse" id="navbarCollapse">

                    <!-- <ul class="navbar-nav navbar-nav-scroll ms-auto">
                        <li class="nav-item ms-2">
                            <a class="icon-md btn btn-primary p-0" href="">
                                <i class="bi bi-chat-left-text-fill fs-6"> </i>
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="icon-md btn btn-primary p-0" href="">
                                <i class="bi bi-gear-fill fs-6"> </i>
                            </a>
                        </li>
                    </ul> -->

                </div>
                <!-- Main navbar END -->

                <!-- Nav right START -->
                <ul class="nav-right flex-nowrap align-items-center list-unstyled">
                    <!-- Notification dropdown END -->
                    <a class="text-light desktop"><strong>Selamat Datang, {{ Auth::user()->nama }}!</strong></a>
                    <li class="nav-item ms-2 dropdown">
                        <a class="avatar avatar-l p-0" href="" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (Auth::user()->role == 'mahasiswa')
                            <img class="avatar-img rounded-circle border border-white border-0" src="{{ $mahasiswa->foto == null ? asset('assets/profil/default.jpg') : asset($mahasiswa->foto) }}" alt="">
                            @elseif (Auth::user()->role == 'dosen')
                            <img class="avatar-img rounded-circle border border-white border-0" src="{{ $dosen->foto == null ? asset('assets/profil/default.jpg') : asset($dosen->foto) }}" alt="">
                            @else
                            <img class="avatar-img rounded-circle border border-white border-0" src="{{ asset('assets/profil/operator.jpg') }}" alt="">
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-animation dropdown-menu-end pt-3 small me-md-n3" aria-labelledby="profileDropdown">
                            <!-- Profile info -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item bg-danger-soft-hover"><i class="bi bi-power fa-fw me-2"></i>Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- Profile START -->

                </ul>
                <!-- Nav right END -->
            </div>
        </nav>
        <!-- Logo Nav END -->
    </header>