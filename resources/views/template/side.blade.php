
<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo_siftnu.png') }}" alt="GOCAP Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-bold">E-TASYARUF</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

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
    
            <a href="/logout" class="btn btn-white btn-sm btn-hilang"><i class="fa fa-sign-out-alt"></i>
                <p> Keluar</p>
            </a>
        </div>
    

        <hr>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                {{-- <li class="nav-item  @yield('dashboard') ">
                    <a href="/{{ $role }}/dashboard" class="nav-link  @yield('dashboard') card-dashboard">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                <li class="nav-header">E-Tasyaruf</li>

                {{-- data pengajuan --}}
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <li class="nav-item  @yield('pengajuan_mo')">
                        <a class="nav-link @yield('pengajuan_ac') card-data-pengajuan">
                            <i class="nav-icon fas fa-file-signature"></i>
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
                                <a href="/{{ $role }}/upzis-ranting" class="nav-link @yield('upzis_ranting')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Upzis & Ranting
                                    </p>
                                </a>
                            </li>
                        </ul>

                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('notifi') }}" class="nav-link @yield('')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                     Keseluruhan
                                    </p>
                                </a>
                            </li>
                        </ul> --}}


                    </li>


                    {{-- DATA LAPORAN PC--}}
                    <li class="nav-item  @yield('laporan_mo')">
                        <a class="nav-link @yield('laporan_ac') card-data-laporan">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Data Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan-internalpc-pc" class="nav-link @yield('lap_internalpc_pc')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Lazisnu Cilacap
                                    </p>
                                </a>
                            </li>
                        </ul>

                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('notifi') }}" class="nav-link @yield('lap_internalpc_pc')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Lazisnu Cilacap
                                    </p>
                                </a>
                            </li>
                        </ul> --}}

                        {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/lap-upzis-ranting" class="nav-link @yield('lap_upzis_ranting')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Upzis & Ranting
                                    </p>
                                </a>
                            </li>
                        </ul> --}}

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan_upzis_ranting" class="nav-link @yield('lap_upzis_ranting')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                       Per Upzis & Ranting
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan_upzis_ranting_keseluruhan" class="nav-link @yield('lap_upzis_ranting_keseluruhan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                     Per Wilayah
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan_gabungan" class="nav-link @yield('lap_gabungan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                     Keseluruhan
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>

                @endif



                @if (Auth::user()->gocap_id_upzis_pengurus != null)
                    <li class="nav-item">
                        <a href="/{{ $role }}/upzis-ranting"
                            class="nav-link @yield('upzis_ranting') card-data-pengajuan">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>
                                Data Pengajuan
                            </p>
                        </a>
                    </li>

                        {{-- DATA LAPORAN UPZIS--}}
                    {{-- <li class="nav-item">
                        <a href="/{{ $role }}/laporan_upzis_ranting"
                            class="nav-link @yield('lap_upzis_ranting') card-data-laporan">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Data Laporan
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/{{ $role }}/laporan_upzis_ranting_keseluruhan" class="nav-link @yield('lap_upzis_ranting_keseluruhan')">
                            <i class="nav-icon fas fa-genderless"></i>
                            <p>
                             Keseluruhan
                            </p>
                        </a>
                    </li>
                     --}}

                    
                    <li class="nav-item  @yield('laporan_mo')">
                        <a class="nav-link @yield('laporan_ac') card-data-laporan">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>
                                Data Laporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan_upzis_ranting"
                                class="nav-link @yield('lap_upzis_ranting') card-data-laporan">
                                <i class="nav-icon fas fa-genderless"></i>
                                <p>
                                  Upzis & Ranting
                                </p>
                            </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/{{ $role }}/laporan_upzis_ranting_keseluruhan" class="nav-link @yield('lap_upzis_ranting_keseluruhan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                     Keseluruhan
                                    </p>
                                </a>
                            </li>
                        </ul>

                    </li>

                    {{-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/{{ $role }}/laporan_upzis_ranting" class="nav-link @yield('lap_upzis_ranting')">
                                <i class="nav-icon fas fa-genderless"></i>
                                <p>
                                    Upzis & Ranting
                                </p>
                            </a>
                        </li>
                    </ul> --}}


                      
                @endif
                {{-- end data pengajuan --}}


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

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
