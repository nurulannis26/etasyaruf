 {{-- info --}}
 <div class="d-flex justify-content-between align-items-center">
     <div>
         <b> DAFTAR RENCANA PROGRAM
             PENTASYARUFAN
             <p class="intro-detail-data-pengajuan-status-rencana-program d-inline">
                 @if ($data->status_rekomendasi == 'Belum Terbit')
                     @if ($data->status_pengajuan == 'Direncanakan')
                         <sup class="badge badge-danger text-white bg-secondary mb-2">Sedang
                             Direncanakan</sup>
                     @else
                         <sup class="badge  text-white bg-warning mb-2">Sudah diajukan & dalam proses
                             persetujuan</sup>
                     @endif
                 @else
                     <sup class="badge  text-white bg-success mb-2">Selesai</sup>
                 @endif
             </p>
         </b>
     </div>
 </div>
 <div class="card mt-2">
     <div class="card-body form-row">

         <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
             <div class="d-flex flex-row bd-highlight align-items-center">
                 <div class="p-2 bd-highlight">
                     <i class="fas fa-info-circle"></i>
                 </div>
                 <div class="p-1 bd-highlight ">
                     @if (Auth::user()->gocap_id_pc_pengurus)
                         @if ($data->status_pengajuan == 'Direncanakan')
                             Menunggu {{ $this->nama_upzis($data->id_upzis) }} menyelesaikan daftar
                             rencana program pentasyarufan.
                         @else
                             @if ($data->status_rekomendasi == 'Belum Terbit')
                                 Setelah selesai merespon data rencana program, lanjutkan ke langkah nomor 3 !
                             @else
                                 Pengajuan telah selesai, terbitkan artikel berita untuk ditampilkan pada aplikasi GOCAP
                             @endif
                         @endif
                     @else
                         @if ($data->status_rekomendasi == 'Belum Terbit')

                             @if ($data->tgl_konfirmasi == null)
                                 Setelah selesai input data rencana program & penerima manfaat, lanjutkan ke
                                 langkah nomor 2!
                             @else
                                 Harap tunggu {{ $this->nama_pc($data->id_pc) }} merespon semua rencana & menerbitkan
                                 lembar rekomendasi
                             @endif
                         @else
                             Pengajuan telah selesai, inputkan laporan kegiatan & pengeluaran pada setiap program
                             pentasyarufan
                         @endif
                     @endif
                 </div>
             </div>
         </div>

         @if (Auth::user()->gocap_id_upzis_pengurus != null)
             @if ($data->status_pengajuan == 'Direncanakan')
                 <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                     <button wire:click="modal_rencana_tambah" data-toggle="modal" data-target="#modal_rencana_tambah"
                         class="btn btn-success btn-block intro-tombol-tambah-rencana-program"> <i
                             class="fas fa-plus-circle"></i>
                         Tambah</button>
                 </div>
             @endif
         @endif





     </div>
 </div>
 {{-- end info --}}


 {{-- {{ $id_pengajuan }} --}}
 {{-- end alert --}}

 {{-- tabel a --}}
 <div class="table-responsive">
     <table class="table table-bordered " style="width:100%">

         <thead>
             <tr class="text-center">
                 <th style="width: 10px;vertical-align:middle;">No</th>
                 <th style="width: 25%;vertical-align:middle;">
                     NAMA PROGRAM <br>
                     (KETERANGAN JENIS BANTUAN)
                 </th>
                 <th style="width: 15%;vertical-align:middle;">
                     TARGET PENERIMA <br>
                     MANFAAT
                 </th>
                 <th style="width: 5%;vertical-align:middle;">
                     JUMLAH<br>
                     PENERIMA<br>
                     MANFAAT </th>
                 <th style="width: 10%;vertical-align:middle;">NOMINAL <br> PER PENERIMA </th>
                 <th style="width: 10%;vertical-align:middle;">NOMINAL TOTAL</th>
                 <th style="width: 8%;vertical-align:middle;">
                     TGL PELAKSANAAN <br>
                     PENTASYARUFAN
                 </th>
                 <th style="width: 15%;vertical-align:middle;">
                     PETUGAS <br>
                     PENTASYARUFAN
                 </th>
                 <th style="width: 10%;vertical-align:middle;">
                     TGL SETOR
                     LPJ
                 </th>
             </tr>
         </thead>

         <tbody>
             {{-- PROGRAM PENGUATAN KELEMBAGAAN --}}
             <tr style="background-color:#cbf2d6;">
                 <td><b style="font-size: 12pt;">1</b></td>
                 <td colspan="4"><b style="font-size: 12pt;"> PROGRAM PENGUATAN KELEMBAGAAN </b></td>
                 <td class="text-right"><b
                         style="font-size: 12pt;">Rp{{ number_format($jumlah_nominal_a, 0, '.', '.') }},-</b></td>
                 <td colspan="3" class="text-center"></td>
             </tr>
             @foreach ($rencana_a as $a)
                 <tr data-toggle="collapse" href="#collapseExample{{ $a->id_pengajuan_detail }}" role="button"
                     aria-expanded="false" aria-controls="collapseExample"
                     style=" cursor: pointer;   @if ($id_pengajuan_detail == $a->id_pengajuan_detail) background-color:#ECECEC; @endif">
                     <td>1.{{ $loop->iteration }}</td>
                     <td><b style="font-size: 12pt">{{ $a->nama_program }}</b>

                         <br>
                         @if ($data->status_pengajuan == 'Direncanakan')
                             <sup class="badge badge-danger text-white bg-secondary">Direncanakan</sup>
                         @else
                             @if ($a->approval_status == 'Belum Direspon')
                                 <sup class="badge badge-danger text-white bg-secondary">Belum Direspon</sup>
                             @elseif($a->approval_status == 'Disetujui')
                                 <sup class="badge badge-danger text-white bg-success">Disetujui</sup>
                             @elseif($a->approval_status == 'Ditolak')
                                 <sup class="badge badge-danger text-white bg-danger">Ditolak</sup>
                             @endif

                             @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                 <sup class="badge badge-danger text-white bg-warning">Bisa Dicairkan</sup>
                             @endif
                         @endif
                         <span style="display:flex;text-align:justify">
                             {{ $a->pengajuan_note }}
                         </span>

                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}">
                             <a wire:click="modal_rencana_detail('{{ $a->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_detail">a. Rincian & Status</a> <br>
                             <a wire:click="modal_rencana_kegiatan('{{ $a->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_kegiatan">b.
                                 LPJ & Berita Acara
                                 @if ($this->cek_kegiatan($a->id_pengajuan_detail) == '1')
                                     (Sudah Diisi)
                                 @else
                                     (Belum Diisi)
                                 @endif
                             </a> <br>

                             <a wire:click="modal_rencana_berita('{{ $a->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_berita">c.
                                 Artikel Pentasyarufan
                                 ({{ $this->cek_berita($a->id_pengajuan_detail) }})
                             </a>

                             {{-- <a href="/upzis/print_bacara_ur/{{ $a->id_pengajuan_detail }}">c.
                                 Print Berita Acara
                                 ({{ $this->cek_berita($a->id_pengajuan_detail) }})
                             </a> --}}

                         </div>
                     </td>
                     <td>{{ $a->nama_penerima }}</td>
                     <td class="text-center">{{ $a->jumlah_penerima }}</td>
                     <td class="text-right">
                         Rp{{ number_format($a->satuan_pengajuan, 0, '.', '.') }},-
                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}">
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 Rp{{ number_format($a->satuan_disetujui, 0, '.', '.') }},-</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 Rp{{ number_format($a->satuan_pencairan, 0, '.', '.') }},-</span>
                         </div>
                     </td>
                     <td class="text-right">
                         Rp{{ number_format($a->nominal_pengajuan, 0, '.', '.') }},-
                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}">
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 Rp{{ number_format($a->nominal_disetujui, 0, '.', '.') }},-</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 Rp{{ number_format($a->nominal_pencairan, 0, '.', '.') }},-</span>
                         </div>
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($a->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                     </td>
                     <td>

                         @if ($data->tingkat == 'Upzis MWCNU')
                             {{ $this->nama_pengurus_upzis($a->petugas_upzis) }}
                             <span
                                 style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($a->petugas_upzis) }})</span>
                         @endif
                         @if ($data->tingkat == 'Ranting NU')
                             {{ $this->nama_pengurus_upzis($a->petugas_ranting) }}
                             <span
                                 style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($a->petugas_ranting) }})</span>
                         @endif
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($a->tgl_setor)->isoFormat('DD-MM-Y') }}
                     </td>
                 </tr>
             @endforeach
             {{-- END PROGRAM PENGUATAN KELEMBAGAAN --}}

             {{-- PROGRAM SOSIAL --}}
             <tr style="background-color:#cbf2d6;">
                 <td><b style="font-size: 12pt;">2</b></td>
                 <td colspan="4"><b style="font-size: 12pt;"> PROGRAM SOSIAL </b></td>
                 <td class="text-right"><b
                         style="font-size: 12pt;">Rp{{ number_format($jumlah_nominal_b, 0, '.', '.') }},-</b></td>
                 <td colspan="3" class="text-center"></td>
             </tr>

             @foreach ($rencana_b as $b)
                 <tr data-toggle="collapse" href="#collapseExample{{ $b->id_pengajuan_detail }}" role="button"
                     aria-expanded="false" aria-controls="collapseExample"
                     style=" cursor: pointer;   @if ($id_pengajuan_detail == $b->id_pengajuan_detail) background-color:#ECECEC; @endif">
                     <td>2.{{ $loop->iteration }}</td>
                     <td><b style="font-size: 12pt">{{ $b->nama_program }}</b>
                         <br>
                         @if ($data->status_pengajuan == 'Direncanakan')
                             <sup class="badge badge-danger text-white bg-secondary">Direncanakan</sup>
                         @else
                             @if ($b->approval_status == 'Belum Direspon')
                                 <sup class="badge badge-danger text-white bg-secondary">Belum Direspon</sup>
                             @elseif($b->approval_status == 'Disetujui')
                                 <sup class="badge badge-danger text-white bg-success">Disetujui</sup>
                             @elseif($b->approval_status == 'Ditolak')
                                 <sup class="badge badge-danger text-white bg-danger">Ditolak</sup>
                             @endif

                             @if ($b->pencairan_status == 'Berhasil Dicairkan')
                                 <sup class="badge badge-danger text-white bg-warning">Bisa Dicairkan</sup>
                             @endif
                         @endif

                         <span style="display:flex;text-align:justify">
                             {{ $b->pengajuan_note }}
                         </span>
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}">
                             <a wire:click="modal_rencana_detail('{{ $b->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_detail">a. Rincian & Status</a> <br>
                             <a wire:click="modal_rencana_kegiatan('{{ $b->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_kegiatan">b.
                                 LPJ & Berita Acara
                                 @if ($this->cek_kegiatan($b->id_pengajuan_detail) == '1')
                                     (Sudah Diisi)
                                 @else
                                     (Belum Diisi)
                                 @endif
                             </a> <br>

                             <a wire:click="modal_rencana_berita('{{ $b->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#modal_rencana_berita">c.
                                 Artikel Pentasyarufan
                                 ({{ $this->cek_berita($b->id_pengajuan_detail) }})
                             </a>

                         </div>
                     </td>
                     <td> {{ $b->nama_penerima }}</td>
                     <td class="text-center">{{ $b->jumlah_penerima }}</td>
                     <td class="text-right">
                         Rp{{ number_format($b->satuan_pengajuan, 0, '.', '.') }},-
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}">
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 Rp{{ number_format($b->satuan_disetujui, 0, '.', '.') }},-</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 Rp{{ number_format($b->satuan_pencairan, 0, '.', '.') }},-</span>
                         </div>
                     </td>
                     <td class="text-right">
                         Rp{{ number_format($b->nominal_pengajuan, 0, '.', '.') }},-
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}">
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 Rp{{ number_format($b->nominal_disetujui, 0, '.', '.') }},-</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 Rp{{ number_format($b->nominal_pencairan, 0, '.', '.') }},-</span>
                         </div>
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($b->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                     </td>
                     <td>
                         @if ($data->tingkat == 'Upzis MWCNU')
                             {{ $this->nama_pengurus_upzis($b->petugas_upzis) }}
                             <span
                                 style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($b->petugas_upzis) }})</span>
                         @endif
                         @if ($data->tingkat == 'Ranting NU')
                             {{ $this->nama_pengurus_upzis($b->petugas_ranting) }}
                             <span
                                 style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($b->petugas_ranting) }})</span>
                         @endif
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($b->tgl_setor)->isoFormat('DD-MM-Y') }}
                     </td>
                 </tr>
             @endforeach
             {{-- END PROGRAM SOSIAL --}}


             @if ($data->tingkat == 'Upzis MWCNU')
                 {{-- OPERASIONAL UPZIS --}}
                 <tr style="background-color:#cbf2d6;">
                     <td><b style="font-size: 12pt;">3</b></td>
                     <td colspan="4"><b style="font-size: 12pt;"> OPERASIONAL UPZIS </b></td>
                     <td class="text-right"><b
                             style="font-size: 12pt;">Rp{{ number_format($jumlah_nominal_c, 0, '.', '.') }},-</b></td>
                     <td colspan="3" class="text-center"></td>
                 </tr>

                 @foreach ($rencana_c as $c)
                     <tr data-toggle="collapse" href="#collapseExample{{ $c->id_pengajuan_detail }}" role="button"
                         aria-expanded="false" aria-controls="collapseExample"
                         style=" cursor: pointer;   @if ($id_pengajuan_detail == $c->id_pengajuan_detail) background-color:#ECECEC; @endif">
                         <td>3.{{ $loop->iteration }}</td>
                         <td><b style="font-size: 12pt">{{ $c->nama_program }}</b>
                             <br>

                             @if ($data->status_pengajuan == 'Direncanakan')
                                 <sup class="badge badge-danger text-white bg-secondary ">Direncanakan</sup>
                             @else
                                 @if ($c->approval_status == 'Belum Direspon')
                                     <sup class="badge badge-danger text-white bg-secondary ">Belum Direspon</sup>
                                 @elseif($c->approval_status == 'Disetujui')
                                     <sup class="badge badge-danger text-white bg-success ">Disetujui</sup>
                                 @elseif($c->approval_status == 'Ditolak')
                                     <sup class="badge badge-danger text-white bg-danger ">Ditolak</sup>
                                 @endif

                                 @if ($c->pencairan_status == 'Berhasil Dicairkan')
                                     <sup class="badge badge-danger text-white bg-warning ">Bisa Dicairkan</sup>
                                 @endif
                             @endif


                             <span style="display:flex;text-align:justify">
                                 {{ $c->pengajuan_note }}
                             </span>
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}">
                                 <a wire:click="modal_rencana_detail('{{ $c->id_pengajuan_detail }}')" href=""
                                     data-toggle="modal" data-target="#modal_rencana_detail">a. Rincian & Status</a>
                                 <br>
                                 <a wire:click="modal_rencana_kegiatan('{{ $c->id_pengajuan_detail }}')"
                                     href="" data-toggle="modal" data-target="#modal_rencana_kegiatan">b.
                                     LPJ & Berita Acara
                                     @if ($this->cek_kegiatan($c->id_pengajuan_detail) == '1')
                                         (Sudah Diisi)
                                     @else
                                         (Belum Diisi)
                                     @endif
                                 </a> <br>

                                 <a wire:click="modal_rencana_berita('{{ $c->id_pengajuan_detail }}')" href=""
                                     data-toggle="modal" data-target="#modal_rencana_berita">c.
                                     Artikel Pentasyarufan
                                     ({{ $this->cek_berita($c->id_pengajuan_detail) }})
                                 </a>
                             </div>
                         </td>
                         <td>{{ $c->nama_penerima }}</td>
                         <td class="text-center">{{ $c->jumlah_penerima }}</td>
                         <td class="text-right">
                             Rp{{ number_format($c->satuan_pengajuan, 0, '.', '.') }},-
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}">
                                 <span style="font-size:11pt;" class="text-bold text-success">
                                     Rp{{ number_format($c->satuan_disetujui, 0, '.', '.') }},-</span>
                                 <br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                     Rp{{ number_format($c->satuan_pencairan, 0, '.', '.') }},-</span>
                             </div>
                         </td>
                         <td class="text-right">
                             Rp{{ number_format($c->nominal_pengajuan, 0, '.', '.') }},-
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}">
                                 <span style="font-size:11pt;" class="text-bold text-success">
                                     Rp{{ number_format($c->nominal_disetujui, 0, '.', '.') }},-</span>
                                 <br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                     Rp{{ number_format($c->nominal_pencairan, 0, '.', '.') }},-</span>
                             </div>
                         </td>
                         <td class="text-center">
                             {{ Carbon\Carbon::parse($c->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                         </td>
                         <td>
                             @if ($data->tingkat == 'Upzis MWCNU')
                                 {{ $this->nama_pengurus_upzis($c->petugas_upzis) }}
                                 <span
                                     style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($c->petugas_upzis) }})</span>
                             @endif
                             @if ($data->tingkat == 'Ranting NU')
                                 {{ $this->nama_pengurus_upzis($c->petugas_ranting) }}
                                 <span
                                     style="font-size: 10pt;">({{ $this->jabatan_pengurus_upzis($c->petugas_ranting) }})</span>
                             @endif
                         </td>
                         <td class="text-center">
                             {{ Carbon\Carbon::parse($c->tgl_setor)->isoFormat('DD-MM-Y') }}
                         </td>
                     </tr>
                 @endforeach
                 {{-- END OPERASIONAL UPZIS --}}
             @endif


         </tbody>
     </table>
 </div>


 {{-- tabel b --}}

 @push('script')
     <script>
         $(document).ready(function() {

             window.loadContactDeviceSelect2 = () => {

                 $('#ini').on('input', function(e) {
                     $('#ini').val(formatRupiah($('#ini').val(),
                         'Rp. '));
                 });
             }

             loadContactDeviceSelect2();
             window.livewire.on('loadContactDeviceSelect2', () => {
                 loadContactDeviceSelect2();
             });

         });
     </script>
 @endpush
