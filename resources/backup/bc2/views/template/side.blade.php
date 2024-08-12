{{-- <style>
    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }
    }
</style> --}}
<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo_siftnu.png') }}" alt="GOCAP Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-bold">E-TASYARUF</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center"> --}}
        {{-- <div class="text-center">


            <h5 class="btn-hilang mt-4">
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <p>PC LAZISNU CILACAP</p>
                @else
                    @php
                        $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
                        $log = 'UPZIS ' . strtoupper($wilayah);
                    @endphp
                    {{ $log }}
                @endif

            </h5>
            <span class="btn-hilang">{{ Auth::user()->nama }}</span><br>

            <span class="m-0 btn btn-success btn-sm btn-hilang" style="border-radius: 10px">
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    {{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }}
                @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                    {{ Auth::user()->UpzisPengurus->JabatanPengurus->jabatan }}
                @endif
            </span>

            <br>
            <a class="btn btn-white btn-sm btn-hilang"><i class="fas fa-cog"></i>
                <p> Pengaturan</p>
            </a>
            <a href="/logout" class="btn btn-white btn-sm btn-hilang"><i class="fa fa-sign-out-alt"></i>
                <p> Keluar</p>
            </a>
        </div> --}}
        {{-- </div> --}}

        <div class="text-center">
            @if (Auth::user()->gocap_id_pc_pengurus != '')
                <h5 class="btn-hilang mt-4">PC <p>LAZISNU CILACAP</p>
                </h5>
            @endif
            @if (Auth::user()->gocap_id_upzis_pengurus != '')
                <h5 class="btn-hilang mt-4">UPZIS <p>{{ strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama) }}
                    </p>
                </h5>
            @endif
            <span class="btn-hilang">{{ Auth::user()->nama }}</span><br>
            <span class="m-0 badge badge-success badge-sm badge-hilang" style="border-radius: 10px">
                {{-- {{ $Auth::user()->gocap_id_pc_pengurus==""?Auth::user()->UpzisPengurus->Pengurusjabatan->jabatan:Auth::user()->PcPengurus->Pengurusjabatan->jabatan }} --}}
                @if (Auth::user()->gocap_id_pc_pengurus != '')
                    <marquee behavior="" scrolldelay="300" direction="" class="pt-1">
                        {{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }}
                    </marquee>
                @endif
                @if (Auth::user()->gocap_id_upzis_pengurus != '')
                    {{ Auth::user()->UpzisPengurus->JabatanPengurus->jabatan }}
                @endif
            </span><br>
            <a class="btn btn-white btn-sm btn-hilang"><i class="fas fa-cog"></i>
                <p> Pengaturan</p>
            </a>
            {{-- <a class="btn btn-white btn-sm btn-hilang" href="https://siftnu.nucarecilacap.id/"><i
                    class="fa fa-sign-out-alt"></i>
                <p> Keluar</p> --}}
            <a href="/logout" class="btn btn-white btn-sm btn-hilang"><i class="fa fa-sign-out-alt"></i>
                <p> Keluar</p>
            </a>
        </div>
        {{-- </div> --}}


        <hr>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item  @yield('dashboard') ">
                    <a href="/{{ $role }}/dashboard" class="nav-link  @yield('dashboard') card-dashboard">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-header mt-1">E-Tasyaruf</li>



                {{-- data pengajuan --}}
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <li class="nav-item  @yield('pengajuan_mo')">
                        <a class="nav-link @yield('pengajuan_ac') card-data-pengajuan">
                            <i class="nav-icon fas fa-hands-helping"></i>
                            <p>
                                Data Pengajuan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/internalpc-pc" class="nav-link @yield('internalpc_pc')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Lazisnu Cilacap
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                {{-- <a href="/{{ $role }}/upzis-ranting" class="nav-link @yield('upzis_ranting')"> --}}
                                <a href="/{{ $role }}/upzis-ranting" class="nav-link @yield('upzis_ranting')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Upzis & Ranting
                                    </p>
                                </a>
                            </li>
                        </ul>


                    </li>

                    <li class="nav-item">
                        <a href="/{{ $role }}/arsip/berita"
                            class="nav-link @yield('arsip_berita') card-data-pengajuan">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                Arsip Berita
                            </p>
                        </a>
                    </li>
                @endif



                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                    <li class="nav-item">
                        {{-- <a href="/{{ $role }}/upzis-ranting" --}}
                        <a href="/{{ $role }}/upzis-ranting"
                            class="nav-link @yield('upzis_ranting') card-data-pengajuan">
                            <i class="nav-icon fas fa-hands-helping"></i>
                            <p>
                                Data Pengajuan
                            </p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="/{{ $role }}/upzis-ranting" class="nav-link @yield('upzis_ranting')">
                            <i class="nav-icon fas fa-genderless"></i>
                            <p>
                                Upzis & Ranting (Laravel)
                            </p>
                        </a>
                    </li> --}}

                    {{-- <li class="nav-header mt-1">Laporan</li> --}}

                    {{-- <li class="nav-item">
                        <a href="/{{ $role }}/laporankeu" class="nav-link @yield('laporankeu')">
                            <i class="nav-icon fas fa-money-check-alt"></i>
                            <p>
                                Keuangan
                            </p>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a href="/{{ $role }}/laporanpenyaluran" class="nav-link @yield('laporanpenyaluran')">
                            <i class="nav-icon fas fa-people-arrows"></i>
                            <p>
                                Penyaluran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/{{ $role }}/laporanperudana" class="nav-link @yield('laporanperudana')">
                            <i class="nav-icon fas fa-exchange-alt"></i>
                            <p>
                                Perubahan Dana
                            </p>
                        </a>
                    </li> --}}
                @endif
                {{-- end data pengajuan --}}





                {{-- 
                <li class="nav-item">
                    <a href="#" class="nav-link @yield('berita')">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Arsip Berita
                        </p>
                    </a>
                </li> --}}


                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <li class="nav-header mt-1">Data Master</li>
                    {{-- pc (program) --}}
                    <li class="nav-item">
                        <a href="/{{ $role }}/program" class="nav-link @yield('program')">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Program
                            </p>
                        </a>
                    </li>
                @endif


                {{-- <li class="nav-item">
                    <a href="/{{ $role }}/pemohon" class="nav-link @yield('pemohon')">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pemohon
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/{{ $role }}/penerima" class="nav-link @yield('penerima')">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Penerima
                        </p>
                    </a>
                </li> --}}

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
