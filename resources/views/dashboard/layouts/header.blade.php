<header id="header" class="header fixed-top d-flex align-items-center bg-danger">
    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center" style="color: #fdf9f9;">
            <img src="{{ asset('images/bbb/l.png') }}" alt="">
            <span class="d-none d-lg-block" style="color: #fdf9f9;">Barbeq</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="">
        <nav>
            <ol class="breadcrumb" style="color: white; text-align: center; margin: 0; padding: 0; margin-left: 10px;">
                <li class="breadcrumb-item" style="color: white; display: inline-block; vertical-align: middle;"><a href="" style="color: white;">Home</a></li>
                <li class="breadcrumb-item active" style="color: white; display: inline-block; vertical-align: middle;">{{ $title }}</li>
            </ol>
        </nav>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            {{-- <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li> --}}

            <li>
                <div class="nav-item text-nowrap">
                    @if (auth()->user()->issuperadmin)
                        @csrf
                        <button type="submit" class="nav-link px-3 bg-danger border-0">
                            <span style="color: white;">
                                Selamat datang {{ auth()->user()->name }}
                            </span>
                        </button>
                    @elseif(auth()->user()->isadmin)
                        <form action="{{ route('profil.index') }}" method="get">
                            @csrf
                            <button type="submit" class="nav-link px-3 bg-danger border-0">
                                <span style="color: white;">
                                    Selamat datang {{ auth()->user()->name }}
                                </span>
                                <span style="color: white;">
                                    <img class="rounded-circle"
                                        src="{{ auth()->user()->gambar ? asset('user-images/' . auth()->user()->gambar) : asset('images/bbb/default_profil.WEBP') }}"
                                        alt="gambar" width="30" height="30">
                                </span>
                            </button>




                        </form>
                    @else
                        <form action="{{ route('profil.index') }}" method="get">
                            @csrf
                            <button type="submit" class="nav-link px-3 bg-danger border-0">
                                <span style="color: white;">
                                    Selamat datang {{ auth()->user()->name }}
                                </span>
                                <span style="color: white;">

                                    <img class="rounded-circle"
                                        src="{{ auth()->user()->gambar ? asset('user-images/' . auth()->user()->gambar) : asset('images/default_profil.WEBP') }}"
                                        alt="gambar" width="30" height="30">
                                </span>
                            </button>
                        </form>
                    @endif
                </div>
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
