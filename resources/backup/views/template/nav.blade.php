<style>
    @media (max-width: 550px) {
        .hidden {
            display: none !important;
        }
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>
        </li>
        <div class="d-flex align-items-center hidden">
            {{ $title }}
        </div>
    </ul>
    <ul class="navbar-nav ml-auto align-self-center mr-0">
        <li class="nav-item align-self-center mr-0">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        {{-- <li class="nav-item align-self-center mr-0 card-zero">
            <a class="nav-link" data-widget="kontak" href="#" id="panduan">PANDUAN</a>
        </li> --}}
        <li>
            <a href="https://siftnu.nucarecilacap.id/" class="mr-1">
                <img width="80px" src="{{ asset('images/siftnu.png') }}" alt="">
            </a>
            {{-- <a class="btn btn-logout m-0">
            <button class="btn btn-block btn-danger btn-sm">SIFNU  <i class="fa fa-sign-out-alt"></i></button>
          </a> --}}
        </li>

    </ul>

</nav>
