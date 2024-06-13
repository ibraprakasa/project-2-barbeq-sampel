<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <aside id="sidebar" class="sidebar bg-danger d-flex flex-column">
        <ul class="sidebar-nav flex-grow-1" id="sidebar-nav">


            <li class="nav-item ">
                <a class="nav-link text-black {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page"
                    href="/dashboard">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>



            @can('superadmin')
                <li class="nav-item">
                    <a class="nav-link text-black {{ Request::is('user*') ? 'active' : '' }}" href="/user">
                        <span data-feather="archive" class="align-text-bottom"></span>
                        Manage Admin
                    </a>
                </li>
            @endcan


            <li class="nav-item">
                <a class="nav-link text-black {{ Request::is('produk*') ? 'active' : '' }}" href="/produk">
                    <span data-feather="archive" class="align-text-bottom"></span>
                    Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-black {{ Request::is('kategori*') ? 'active' : '' }}" href="/categori">
                    <span data-feather="folder-plus" class="align-text-bottom"></span>
                    Kategori Produk
                </a>
            </li>


            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('user*') ? 'active' : '' }}" href="/penjual">
                        <span data-feather="user" class="align-text-bottom"></span>
                        Penjual
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('pembeli*') ? 'active' : '' }}" href="/pembeli">
                        <span data-feather="users" class="align-text-bottom"></span>
                        Pembeli
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('all*') ? 'active' : '' }}" href="/all">
                        <span data-feather="clipboard" class="align-text-bottom"></span>
                        All Pesanan
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('pesanan*') ? 'active' : '' }}" href="/pesanan">
                    <span data-feather="check-circle" class="align-text-bottom"></span>
                    @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                        Verifikasi Pesanan
                    @else
                        Pesanan
                    @endif
                </a>
            </li>


            @cannot('admin')
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('pengiriman*') ? 'active' : '' }}" href="/pengiriman">
                        <span data-feather="send" class="align-text-bottom"></span>
                        Pengiriman
                    </a>
                </li>
            @endcannot

            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('keuangan*') ? 'active' : '' }}" href="/keuangan">
                    <span data-feather="dollar-sign" class="align-text-bottom"></span>
                    @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                        Verifikasi Money
                    @else
                        Pemasukan
                    @endif
                </a>
            </li>

            @if (auth()->user()->isadmin || auth()->user()->issuperadmin)
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('expedisi*') ? 'active' : '' }}" href="/expedisi">
                        <span data-feather="send" class="align-text-bottom"></span>
                        Expedisi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark {{ Request::is('banner*') ? 'active' : '' }}" href="/banner">
                        <span data-feather="image" class="align-text-bottom"></span>
                        Banner
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link text-dark {{ Request::is('setting*') ? 'active' : '' }}" href="/setting">
                    <span data-feather="settings" class="align-text-bottom"></span>
                    Setting
                </a>
            </li>
        </ul>

        <ul class="sidebar-nav mt-auto">
            <li class="nav-item">
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="nav-link collapsed text-dark" style="border: none;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <script>
        // Ambil semua elemen dengan kelas 'nav-link'
        var navLinks = document.querySelectorAll('.nav-link');

        // Loop melalui setiap elemen dan tambahkan event listener
        navLinks.forEach(function(navLink) {
            navLink.addEventListener('click', function() {
                // Setel warna teks menjadi merah saat tautan diklik
                this.style.color = 'red';

                // Setel kembali warna teks menjadi hitam setelah 1 detik
                setTimeout(function() {
                    navLink.style.color = 'black';
                }, 1000);
            });
        });
    </script>

</body>

</html>
