       {{-- card berita --}}
                                {{-- diinput oleh --}}
                                <div class="card mt-2 ">
                                    <div class="card-body ">
                                        <div class="form-row ">

                                            <div class="col-12 col-md-9 col-sm-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row bd-highlight align-items-center">

                                                    <div class="p-1 bd-highlight">
                                                        <span>
                                                            <i class="fas fa-info-circle"></i>
                                                            Diinput oleh Divisi IT dan Media
                                                            ({{ $this->nama_pengurus_pc($id_staf_media) }})
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                </div>

                                {{-- end diinput oleh --}}
                                <div class="card card-body">
                                    <div class="row">
                                        {{-- card detail berita --}}
                                        <div class="col col-md-12 col-sm-12 tab-detail-berita-umum-pc">
                                            {{-- detail --}}

                                            {{-- form --}}


                                            {{-- judul --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-clipboard-check"></i><b class="ml-2">
                                                        BERITA</b>
                                                    @if ($berita)

                                                        @if ($berita->tanggal_terbit == null)
                                                            <sup class="badge badge-danger text-white bg-warning mb-2">Belum
                                                                Terbit</sup>
                                                        @else
                                                            <sup class="badge badge-danger text-white bg-success mb-2">Sudah
                                                                Terbit</sup>
                                                        @endif
                                                    @else
                                                        <sup class="badge badge-danger text-white bg-warning mb-2">Belum
                                                            Terbit</sup>
                                                    @endif
                                                </div>
                                                <div>
                                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'ef77ea4b-725b-11ed-ad27-e4a8df91d8b3')
                                                        @if ($berita)


                                                            @if ($berita->tanggal_terbit == null)
                                                                @if ($berita->judul_berita == '' or $berita->narasi_berita == '')
                                                                    <button class="btn btn-outline-success btn-sm mr-2"
                                                                        data-toggle="tooltip" data-placement="bottom"
                                                                        disabled
                                                                        title="Tidak dapat menerbitkan berita, karena detail berita belum lengkap">
                                                                        <i class="fas fa-upload"></i>
                                                                        Terbitkan Berita
                                                                    </button>
                                                                @else
                                                                    <a wire:click="tombol_terbit"
                                                                        class="btn btn-outline-success btn-sm mr-2">
                                                                        <i class="fas fa-upload"></i>
                                                                        Terbitkan berita
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @else
                                                            <button class="btn btn-outline-success btn-sm mr-2"
                                                                data-toggle="tooltip" data-placement="bottom" disabled
                                                                title="Tidak dapat menerbitkan berita, karena detail berita belum lengkap">
                                                                <i class="fas fa-upload"></i>
                                                                Terbitkan Berita
                                                            </button>


                                                        @endif


                                                        @if ($kegiatan == null)
                                                            <button
                                                                class="btn btn-outline-secondary btn-sm float-right tombol-ubah"
                                                                role="button" data-toggle="tooltip"
                                                                data-placement="bottom" disabled
                                                                title="Tidak bisa membuat berita, karena laporan kegiatan belum diisi"><i
                                                                    class="fas fa-edit"></i>
                                                                Detail</button>
                                                        @else
                                                            <a wire:click="tambah_ubah_berita_pc"
                                                                class="btn btn-outline-secondary btn-sm float-right tombol-ubah"
                                                                role="button"><i class="fas fa-edit"></i>
                                                                Detail</a>
                                                        @endif

                                                    @endif



                                                </div>
                                            </div>
                                            {{-- end judul --}}


                                            @if (session()->has('alert_berita'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                    role="alert">
                                                    <i class="far fa-check-circle"></i>
                                                    {{ session('alert_berita') }}
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif


                                            {{-- card acc --}}
                                            <div class="card card-body mt-2"
                                                style="background-color:#cbf2d6;display: none;{{ $none_block_terbit }};">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <b class="text-success">KONFIRMASI TERBIT BERITA</b>
                                                    <div>
                                                        <a wire:click="close" type="button"
                                                            class="btn btn-danger btn-sm"><i class="fas fa-ban"></i>
                                                            Batalkan</a>
                                                        <a wire:click="terbit_berita" type="button"
                                                            class="btn btn-success btn-sm"><i
                                                                class="fas fa-check"></i>
                                                            Iya Terbitkan</a>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end card acc --}}

                                            <table class="table table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%">Foto</th>
                                                        <td>
                                                            @if ($berita)
                                                                @if ($berita->foto_background_berita == null)
                                                                    <a href="#" type="button">Belum
                                                                        Memiliki
                                                                        Foto
                                                                    </a>
                                                                @else
                                                                    <a target="_blank"
                                                                        href="{{ asset('uploads/foto_background_berita/' . $berita->foto_background_berita) }}">{{ $berita->foto_background_berita }}</a>
                                                                @endif
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Tanggal Terbit</th>
                                                        <td>
                                                            @if ($berita)
                                                                @if ($berita->tanggal_terbit == null)
                                                                    -
                                                                @else
                                                                    {{ Carbon\Carbon::parse($berita->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif


                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Pewarta</th>

                                                        <td>
                                                            @if ($berita)

                                                                @if ($berita->id_pengguna == null)
                                                                    -
                                                                @else
                                                                    @php
                                                                        $b = config('app.database_siftnu');
                                                                        $a = DB::table($b . '.pengguna')
                                                                            ->where('id_pengguna', $berita->id_pengguna)
                                                                            ->first();
                                                                        
                                                                    @endphp
                                                                    {{ $a->nama }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif

                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th class="text-center" colspan="2">Judul Berita
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-justify text-center" colspan="2">
                                                            @if ($berita)

                                                                @if ($berita->judul_berita == null)
                                                                    -
                                                                @else
                                                                    {{ $berita->judul_berita }}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center" colspan="2">Narasi Berita
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-justify" colspan="2">
                                                            @if ($berita)

                                                                @if ($berita->narasi_berita == null or $berita->narasi_berita == '')
                                                                    -
                                                                @else
                                                                    {!! $berita->narasi_berita !!}
                                                                @endif
                                                            @else
                                                                -
                                                            @endif

                                                        </td>
                                                    </tr>

                                                </thead>
                                            </table>
                                            </form>


                                            {{-- end detail --}}

                                        </div>
                                        {{-- end detail kegiatan --}}



                                    </div>








                                </div>
                                {{-- end card berita --}}