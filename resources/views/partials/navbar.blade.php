      <nav class="navbar navbar-expand-lg main-navbar">
          <form class="form-inline mr-auto">
              <input type="text" class="form-control" value="Login Sebagai : {{ auth()->user()->role->role }}" readonly>
          </form>

          <ul class="navbar-nav navbar-right">
              <li class="dropdown"><a href="#" data-toggle="dropdown"
                      class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                      <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                      <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right">
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
