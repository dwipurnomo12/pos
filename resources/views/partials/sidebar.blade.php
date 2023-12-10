        <aside id="sidebar-wrapper">

            <div class="sidebar-brand">
                <a href="/">Point Of Sale</a>
            </div>

            <ul class="sidebar-menu">
                @if (auth()->user()->role->role === 'admin')
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}"
                            href="/">
                            <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-header">Master Data</li>
                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-boxes"></i> <span>Master Produk</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link {{ Request::is('/produk') || Request::is('produk') ? 'active' : '' }}"
                                    href="/produk">Produk</a></li>
                            <li><a class="nav-link {{ Request::is('/kategori') || Request::is('kategori') ? 'active' : '' }}"
                                    href="/kategori">Kategori</a></li>
                            <li><a class="nav-link {{ Request::is('/supplier') || Request::is('supplier') ? 'active' : '' }}"
                                    href="/supplier">Supplier</a></li>
                            <li><a class="nav-link {{ Request::is('/satuan') || Request::is('satuan') ? 'active' : '' }}"
                                    href="/satuan">Satuan</a></li>
                        </ul>
                        <a class="nav-link {{ Request::is('/setting-penjualan') || Request::is('setting-penjualan') ? 'active' : '' }}"
                            href="/setting-penjualan">
                            <i class="fas fa-store"></i> <span class="align-middle">Diskon & PPn</span>
                        </a>
                        <a class="nav-link {{ Request::is('/karyawan') || Request::is('karyawan') ? 'active' : '' }}"
                            href="/karyawan">
                            <i class="fa fa-sharp fa-solid fa-users"></i> <span class="align-middle">Karyawan</span>
                        </a>
                    </li>

                    <li class="menu-header">Transaksi</li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/produk-masuk') || Request::is('produk-masuk') ? 'active' : '' }}"
                            href="/produk-masuk">
                            <i class="fa fa-sharp fa-file-import"></i> <span class="align-middle">Produk Masuk</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/produk-keluar') || Request::is('produk-keluar') ? 'active' : '' }}"
                            href="/produk-keluar">
                            <i class="fa fa-sharp fa-file-export"></i> <span class="align-middle">Produk Keluar</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/menu-penjualan') || Request::is('menu-penjualan') ? 'active' : '' }}"
                            href="/menu-penjualan">
                            <i class="fa fa-solid fa-cart-arrow-down"></i> <span class="align-middle">Menu
                                Penjualan</span>
                        </a>
                    </li>

                    <li class="menu-header">Laporan</li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/stok-produk') || Request::is('stok-produk') ? 'active' : '' }}"
                            href="/stok-produk">
                            <i class="fa fa-sharp fa-solid fa-calculator"></i> <span class="align-middle">Stok
                                Produk</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-produk-masuk') || Request::is('laporan-produk-masuk') ? 'active' : '' }}"
                            href="/laporan-produk-masuk">
                            <i class="fa fa-sharp fa-light fa-file-import"></i> <span class="align-middle">Report Produk
                                Masuk</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-produk-keluar') || Request::is('laporan-produk-keluar') ? 'active' : '' }}"
                            href="/laporan-produk-keluar">
                            <i class="fa fa-sharp fa-light fa-file-export"></i> <span class="align-middle">Report Produk
                                Keluar</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-penjualan') || Request::is('laporan-penjualan') ? 'active' : '' }}"
                            href="/laporan-penjualan">
                            <i class="fa fa-sharp fa-solid fa-file-invoice"></i> <span class="align-middle">Laporan
                                Penjualan</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-arus-kas') || Request::is('laporan-arus-kas') ? 'active' : '' }}"
                            href="/laporan-arus-kas">
                            <i class="fa fa-sharp fa-solid fa-wallet"></i> <span class="align-middle">Arus Kas</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-laba-kotor') || Request::is('laporan-laba-kotor') ? 'active' : '' }}"
                            href="/laporan-laba-kotor">
                            <i class="fa fa-sharp fa-solid fa-money-bill"></i> <span class="align-middle">Laba
                                Kotor</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role->role === 'kepala toko')
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}"
                            href="/">
                            <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-header">Data Master</li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/setting-penjualan') || Request::is('setting-penjualan') ? 'active' : '' }}"
                            href="/setting-penjualan">
                            <i class="fas fa-store"></i> <span class="align-middle">Diskon & PPn</span>
                        </a>
                    </li>

                    <li class="menu-header">Laporan</li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/stok-produk') || Request::is('stok-produk') ? 'active' : '' }}"
                            href="/stok-produk">
                            <i class="fa fa-sharp fa-solid fa-calculator"></i> <span class="align-middle">Stok
                                Produk</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-produk-masuk') || Request::is('laporan-produk-masuk') ? 'active' : '' }}"
                            href="/laporan-produk-masuk">
                            <i class="fa fa-sharp fa-light fa-file-import"></i> <span class="align-middle">Report Produk
                                Masuk</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-produk-keluar') || Request::is('laporan-produk-keluar') ? 'active' : '' }}"
                            href="/laporan-produk-keluar">
                            <i class="fa fa-sharp fa-light fa-file-export"></i> <span class="align-middle">Report Produk
                                Keluar</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-penjualan') || Request::is('laporan-penjualan') ? 'active' : '' }}"
                            href="/laporan-penjualan">
                            <i class="fa fa-sharp fa-solid fa-file-invoice"></i> <span class="align-middle">Laporan
                                Penjualan</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-arus-kas') || Request::is('laporan-arus-kas') ? 'active' : '' }}"
                            href="/laporan-arus-kas">
                            <i class="fa fa-sharp fa-solid fa-wallet"></i> <span class="align-middle">Arus Kas</span>
                        </a>
                        <a class="nav-link {{ Request::is('/laporan-laba-kotor') || Request::is('laporan-laba-kotor') ? 'active' : '' }}"
                            href="/laporan-laba-kotor">
                            <i class="fa fa-sharp fa-solid fa-money-bill"></i> <span class="align-middle">Laba
                                Kotor</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role->role === 'kasir')
                    <li class="menu-header">Transaksi</li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}"
                            href="/">
                            <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="nav-link {{ Request::is('/menu-penjualan') || Request::is('menu-penjualan') ? 'active' : '' }}"
                            href="/menu-penjualan">
                            <i class="fa fa-solid fa-cart-arrow-down"></i> <span class="align-middle">Menu
                                Penjualan</span>
                        </a>
                    </li>
                @endif

            </ul>

        </aside>
