<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Point Of Sale</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  
  
  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


  <!-- Datatable Jquery -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>

  
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi,</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="/ubah-password" class="dropdown-item has-icon">
                <i class="fa fa-sharp fa-solid fa-lock"></i> Ubah Password
              </a>
              <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                Swal.fire({
                                    title: 'Konfirmasi Keluar',
                                    text: 'Apakah Anda yakin ingin keluar?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Keluar!'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      document.getElementById('logout-form').submit();
                                    }
                                  });">
                               <i class="fas fa-sign-out-alt"></i> {{ __('Keluar') }}
                              </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">

          <div class="sidebar-brand">
            <a href="/">Point Of Sale</a>
          </div>

          <ul class="sidebar-menu"> 
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="/">
                  <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                </a>
              </li>
              
              <li class="menu-header">Master Data</li>
              <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-boxes"></i> <span>Master Produk</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link {{ Request::is('/produk') || Request::is('produk') ? 'active' : '' }}" href="/produk">Produk</a></li>
                  <li><a class="nav-link {{ Request::is('/kategori') || Request::is('kategori') ? 'active' : '' }}" href="/kategori">Kategori</a></li>
                  <li><a class="nav-link {{ Request::is('/supplier') || Request::is('supplier') ? 'active' : '' }}" href="/supplier">Supplier</a></li>
                  <li><a class="nav-link {{ Request::is('/satuan') || Request::is('satuan') ? 'active' : '' }}" href="/satuan">Satuan</a></li>
                </ul>
              </li>

              <li class="menu-header">Transaksi</li>
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/produk-masuk') || Request::is('produk-masuk') ? 'active' : '' }}" href="/produk-masuk">
                  <i class="fa fa-sharp fa-file-import"></i> <span class="align-middle">Barang Masuk</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/produk-keluar') || Request::is('produk-keluar') ? 'active' : '' }}" href="/produk-keluar">
                  <i class="fa fa-sharp fa-file-export"></i> <span class="align-middle">Barang Keluar</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/menu-penjualan') || Request::is('menu-penjualan') ? 'active' : '' }}" href="/menu-penjualan">
                  <i class="fa fa-solid fa-cart-arrow-down"></i> <span class="align-middle">Menu Penjualan</span>
                </a>
              </li>

              <li class="menu-header">Laporan</li>
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/stok-produk') || Request::is('stok-produk') ? 'active' : '' }}" href="/stok-produk">
                  <i class="fa fa-sharp fa-solid fa-calculator"></i> <span class="align-middle">Stok Produk</span>
                </a>
                <a class="nav-link {{ Request::is('/laporan-produk-masuk') || Request::is('laporan-produk-masuk') ? 'active' : '' }}" href="/laporan-produk-masuk">
                  <i class="fa fa-sharp fa-light fa-file-import"></i> <span class="align-middle">Report Produk Masuk</span>
                </a>
                <a class="nav-link {{ Request::is('/laporan-produk-keluar') || Request::is('laporan-produk-keluar') ? 'active' : '' }}" href="/laporan-produk-keluar">
                  <i class="fa fa-sharp fa-light fa-file-export"></i> <span class="align-middle">Report Produk Keluar</span>
                </a>
                <a class="nav-link {{ Request::is('/laporan-penjualan') || Request::is('laporan-penjualan') ? 'active' : '' }}" href="/laporan-penjualan">
                  <i class="fa fa-sharp fa-solid fa-file-invoice"></i><span class="align-middle">Sales Report</span>
                </a>
              </li>

              <li class="menu-header">Settings</li>
              <li class="sidebar-item">
                <a class="nav-link {{ Request::is('/setting-penjualan') || Request::is('setting-penjualan') ? 'active' : '' }}" href="/setting-penjualan">
                  <i class="fas fa-store"></i> <span class="align-middle">Diskon & PPn</span>
                </a>
              </li>
              
          </ul>

        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

            @yield('content')
          <div class="section-body">
          </div>
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2023 
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>


  
  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  
  <!-- Select2 Jquery -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- Datatables Jquery -->
  <script type="text/javascript" src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  

  <!-- Sweet Alert -->
  @include('sweetalert::alert')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- Day Js Format -->
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

  
  @stack('scripts')

  
  <script>
    $(document).ready(function() {
      var currentPath = window.location.pathname;
  
      $('.nav-link a[href="' + currentPath + '"]').addClass('active');
    });
  </script>
  
</body>
</html>
