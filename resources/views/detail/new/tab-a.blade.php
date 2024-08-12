 {{-- info --}}
 <div class="d-flex justify-content-between align-items-center">
     <div>
         <b> DAFTAR RENCANA PROGRAM PENTASYARUFAN </b>
             @if ($data->status_rekomendasi == 'Belum Terbit')
                 @if ($data->status_pengajuan == 'Direncanakan')
                     <sup class="badge badge-danger text-white hover bg-secondary mb-2">Sedang
                         Direncanakan</sup>
                 @else
                     <sup class="badge  bg-warning mb-2 hover">Sudah diajukan & dalam proses
                         persetujuan</sup>
                 @endif
             @elseif ($data->status_rekomendasi == 'Ditolak')
                 <sup class="badge  text-white bg-danger mb-2 hover">Rekom Ditolak</sup>
            @else
                <sup class="badge  text-white bg-success mb-2 hover">Sudah Terbit Rekom</sup>
                 <sup class="badge  text-white bg-primary mb-2 hover">Menunggu LPJ & BA</sup>
             @endif
         </p>

     </div>
 </div>

 <div class="card mt-2">
     <div class="m-3 form-row">
         <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
             <div class="d-flex flex-row bd-highlight align-items-center">
                 <div class="p-2 bd-highlight">
                     <i class="fas fa-info-circle"></i>
                 </div>
                 <div class="p-1 bd-highlight ">
                     @if (Auth::user()->gocap_id_pc_pengurus)
                         @if ($data->status_pengajuan == 'Direncanakan')
                             Menunggu
                             Upzis MWCNU {{ \App\Http\Controllers\Helper::getNamaUpzis($data->id_upzis) }}
                             menyelesaikan daftar
                             rencana program pentasyarufan.
                         @else
                             @if ($data->status_rekomendasi == 'Belum Terbit')
                                 Setelah selesai merespon data rencana program, lanjutkan ke langkah nomor 3 !
                             @else
                                 Pengajuan telah selesai, berikan respon pada LPJ & BA pada setiap program
                             @endif
                         @endif
                     @else
                         @if ($data->status_rekomendasi == 'Belum Terbit')

                             @if ($data->tgl_konfirmasi == null)
                                 Setelah selesai input data rencana program & penerima manfaat, lanjutkan ke
                                 langkah nomor 2!
                             @else
                                 Harap tunggu Lazisnu Cilacap merespon semua rencana & menerbitkan
                                 lembar rekomendasi
                             @endif
                         @else
                             Pengajuan telah selesai, inputkan laporan LPJ & Berita Acara serta lampiran pada masing2
                             program
                         @endif
                     @endif
                 </div>
             </div>
         </div>

         @if (Auth::user()->gocap_id_upzis_pengurus != null and $data->status_pengajuan == 'Direncanakan')
             <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                 <button wire:click="resetValue" data-toggle="modal" data-target="#create-edit-rencana"
                     class="btn btn-success btn-block hover"> <i class="fas fa-plus-circle"></i>
                     Tambah</button>
             </div>
         @endif

     </div>
 </div>

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
                     <i class="fas fa-info-circle tooltip-icon" data-toggle="tooltip" data-placement="top"
                         style="cursor: pointer;"
                         title="Jenis Penerima Manfaat By Warna <br/>
                    1. Hitam = Jumlah Penerima Diajukan <br/> 2. Biru = Jumlah Penerima Tersalurkan"
                         data-html="true"></i>
                     <br>
                     JUMLAH<br>
                     PENERIMA<br>
                     MANFAAT
                 </th>
                 <th style="width: 10%;vertical-align:middle;">
                     <i class="fas fa-info-circle tooltip-icon" data-toggle="tooltip" data-placement="top"
                         style="cursor: pointer"
                         title="Jenis Nominal By Warna <br/>
                    1. Hitam = Nominal Diajukan <br/> 2. Hijau = Nominal Disetujui <br/> 3. Kuning = Nominal Dapat Dicairkan"
                         data-html="true"></i>
                     <br>
                     NOMINAL <br> PER PENERIMA
                 </th>
                 <th style="width: 10%;vertical-align:middle;">
                     <i class="fas fa-info-circle tooltip-icon" data-toggle="tooltip" data-placement="top"
                         style="cursor: pointer"
                         title="Jenis Nominal By Warna <br/>
                    1. Hitam = Nominal Diajukan <br/> 2. Hijau = Nominal Disetujui <br/> 3. Kuning = Nominal Dapat Dicairkan </br>
                    4. Biru = Nominal Disalurkan"
                         data-html="true"></i>
                     <br>
                     NOMINAL TOTAL
                 </th>
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
                 <td class="text-right"><b style="font-size: 12pt;">
                         {{ $this->numberFormat($jumlah_nominal_a) }}
                     </b></td>
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
                                 <sup class="badge badge-danger text-white bg-danger">Ditolak/Revisi</sup>
                             @endif
                             @if ($a->pencairan_status == 'Berhasil Dicairkan')
                                 <sup class="badge badge-danger text-white bg-warning">Bisa Dicairkan</sup>
                             @elseif ($a->pencairan_status == 'Ditolak')
                                 <sup class="badge badge-danger text-white bg-danger">Tidak Bisa Dicairkan</sup>
                             @endif
                         @endif

                         @if ($a->file_berita)
                             <sup class="badge badge-danger text-white bg-primary">Sudah LPJ</sup>
                         @else
                             <sup class="badge badge-danger text-white bg-secondary">Belum LPJ</sup>
                         @endif
                         @if ($a->status_berita == 'Sudah Diperiksa')
                             <sup class="badge badge-danger text-white bg-success">Selesai LPJ</sup>
                         @endif
                         @if ($a->status_berita == 'Revisi')
                             <sup class="badge badge-danger text-white bg-danger">Revisi LPJ</sup>
                         @endif
                         <span style="display:flex;text-align:justify">
                             {{ $a->pengajuan_note }}
                         </span>

                         {{-- {{ dd($a) }} --}}

                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}" wire:ignore.self>
                             <a wire:click="detail_rencana('{{ $a->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#detail-rencana" class="toggleCollapseButton">a.
                                 Rincian
                                 &
                                 Status</a> <br>
                             <a wire:click="detail_laporan('{{ $a->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#detail-laporan" class="toggleCollapseButton">b.
                                 LPJ & Berita Acara
                             </a>

                             {{-- <a href="/upzis/print_bacara_ur/{{ $a->id_pengajuan_detail }}">c.
                                 Print Berita Acara
                                 ({{ $this->cek_berita($a->id_pengajuan_detail) }})
                             </a> --}}
                         </div>
                     </td>
                     <td>{{ $a->nama_penerima }}</td>
                     <td class="text-center">
                         {{ $a->jumlah_penerima }}
                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-primary">
                                 {{ $this->getJumlahPenerimaPenyaluran($a->id_pengajuan_detail) }}</span><br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $a->jumlah_penerima_disetujui ?? 0 }}</span>

                         </div>
                     </td>
                     <td class="text-right">
                         {{ $this->numberFormat($a->satuan_pengajuan) }}
                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 {{ $this->numberFormat($a->satuan_disetujui) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $this->numberFormat($a->satuan_pencairan) }}</span>
                         </div>
                     </td>
                     <td class="text-right">
                         {{ $this->numberFormat($a->nominal_pengajuan) }}
                         <div class="collapse" id="collapseExample{{ $a->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 {{ $this->numberFormat($a->nominal_disetujui) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $this->numberFormat($a->nominal_pencairan) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-primary">
                                 @if($data->status_rekomendasi == 'Sudah Terbit')
                                     {{ $this->numberFormat($this->getNominalPenyaluran($a->id_pengajuan_detail)) }}
                                 @else
                                    0
                                 @endif
                            </span>
                         </div>
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($a->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                     </td>
                     <td>
                         @if ($data->tingkat == 'Upzis MWCNU')
                             {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $a->petugas_upzis) }}
                             <br>
                             <span style="font-size: 10pt;">
                                 ( {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $a->petugas_upzis) }}
                                 )</span>
                         @endif
                         @if ($data->tingkat == 'Ranting NU')
                             {{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $a->petugas_ranting) }}
                             <br>
                             <span style="font-size: 10pt;">
                                 (
                                 {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $a->petugas_ranting) }}
                                 )</span>
                         @endif
                     </td>
                     <td class="text-center">
                         {{ $a->tgl_setor ? Carbon\Carbon::parse($a->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                     </td>
                 </tr>
             @endforeach
             {{-- END PROGRAM PENGUATAN KELEMBAGAAN --}}

             {{-- PROGRAM SOSIAL --}}
             <tr style="background-color:#cbf2d6;">
                 <td><b style="font-size: 12pt;">2</b></td>
                 <td colspan="4"><b style="font-size: 12pt;"> PROGRAM SOSIAL </b></td>
                 <td class="text-right"><b style="font-size: 12pt;">
                         {{ $this->numberFormat($jumlah_nominal_b) }}
                     </b></td>
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
                                 <sup class="badge badge-danger text-white bg-danger">Ditolak/Revisi</sup>
                             @endif

                             @if ($b->pencairan_status == 'Berhasil Dicairkan')
                                 <sup class="badge badge-danger text-white bg-warning">Bisa Dicairkan</sup>
                             @elseif ($b->pencairan_status == 'Ditolak')
                                 <sup class="badge badge-danger text-white bg-danger">Tidak Bisa Dicairkan</sup>
                             @endif
                         @endif
                         @if ($b->file_berita)
                             <sup class="badge badge-danger text-white bg-primary">Sudah LPJ</sup>
                         @else
                             <sup class="badge badge-danger text-white bg-secondary">Belum LPJ</sup>
                         @endif
                         @if ($b->status_berita == 'Sudah Diperiksa')
                             <sup class="badge badge-danger text-white bg-success">Selesai LPJ</sup>
                         @endif
                         @if ($b->status_berita == 'Revisi')
                             <sup class="badge badge-danger text-white bg-danger">Revisi LPJ</sup>
                         @endif
                         <span style="display:flex;text-align:justify">
                             {{ $b->pengajuan_note }}
                         </span>
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}" wire:ignore.self>
                             <a wire:click="detail_rencana('{{ $b->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#detail-rencana" class="toggleCollapseButton">a.
                                 Rincian &
                                 Status</a> <br>
                             <a wire:click="detail_laporan('{{ $b->id_pengajuan_detail }}')" href=""
                                 data-toggle="modal" data-target="#detail-laporan" class="toggleCollapseButton">b.
                                 LPJ & Berita Acara
                             </a>
                         </div>
                     </td>
                     <td> {{ $b->nama_penerima }}</td>
                     <td class="text-center">
                         {{ $b->jumlah_penerima }}
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-primary">
                                 {{ $this->getJumlahPenerimaPenyaluran($b->id_pengajuan_detail) }}</span><br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $b->jumlah_penerima_disetujui ?? 0 }}</span>

                         </div>
                     </td>
                     <td class="text-right">
                         {{ $this->numberFormat($b->satuan_pengajuan) }}
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 {{ $this->numberFormat($b->satuan_disetujui) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $this->numberFormat($b->satuan_pencairan) }}</span>
                         </div>
                     </td>
                     <td class="text-right">
                         {{ $this->numberFormat($b->nominal_pengajuan) }}
                         <div class="collapse" id="collapseExample{{ $b->id_pengajuan_detail }}" wire:ignore.self>
                             <span style="font-size:11pt;" class="text-bold text-success">
                                 {{ $this->numberFormat($b->nominal_disetujui) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $this->numberFormat($b->nominal_pencairan) }}</span>
                             <br>
                             <span style="font-size:11pt;" class="text-bold text-primary">
                                 {{ $this->numberFormat($this->getNominalPenyaluran($b->id_pengajuan_detail)) }}</span>
                         </div>
                     </td>
                     <td class="text-center">
                         {{ Carbon\Carbon::parse($b->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                     </td>
                     <td>
                         @if ($data->tingkat == 'Upzis MWCNU')
                             {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $b->petugas_upzis) }}
                             <br>
                             <span style="font-size: 10pt;">
                                 ( {{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $b->petugas_upzis) }}
                                 )</span>
                         @endif
                         @if ($data->tingkat == 'Ranting NU')
                             {{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $b->petugas_ranting) }}
                             <br>
                             <span style="font-size: 10pt;">
                                 (
                                 {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $b->petugas_ranting) }}
                                 )</span>
                         @endif
                     </td>
                     <td class="text-center">
                         {{ $b->tgl_setor ? Carbon\Carbon::parse($b->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                     </td>
                 </tr>
             @endforeach
             {{-- END PROGRAM SOSIAL --}}
             @if ($data->tingkat == 'Upzis MWCNU')
                 {{-- OPERASIONAL UPZIS --}}
                 <tr style="background-color:#cbf2d6;">
                     <td><b style="font-size: 12pt;">3</b></td>
                     <td colspan="4"><b style="font-size: 12pt;"> OPERASIONAL UPZIS </b></td>
                     <td class="text-right"><b style="font-size: 12pt;">
                             {{ $this->numberFormat($jumlah_nominal_c) }}
                         </b></td>
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
                                     <sup class="badge badge-danger text-white bg-danger">Ditolak/Revisi</sup>
                                 @endif

                                 @if ($c->pencairan_status == 'Berhasil Dicairkan')
                                     <sup class="badge badge-danger text-white bg-warning ">Bisa Dicairkan</sup>
                                 @elseif ($c->pencairan_status == 'Ditolak')
                                     <sup class="badge badge-danger text-white bg-danger">Tidak Bisa Dicairkan</sup>
                                 @endif
                             @endif
                             @if ($c->file_berita)
                                 <sup class="badge badge-danger text-white bg-primary">Sudah LPJ</sup>
                             @else
                                 <sup class="badge badge-danger text-white bg-secondary">Belum LPJ</sup>
                             @endif
                             @if ($c->status_berita == 'Sudah Diperiksa')
                                 <sup class="badge badge-danger text-white bg-success">Selesai LPJ</sup>
                             @endif
                             @if ($c->status_berita == 'Revisi')
                                 <sup class="badge badge-danger text-white bg-danger">Revisi LPJ</sup>
                             @endif
                             <span style="display:flex;text-align:justify">
                                 {{ $c->pengajuan_note }}
                             </span>
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}"
                                 wire:ignore.self>
                                 <a wire:click="detail_rencana('{{ $c->id_pengajuan_detail }}')" href=""
                                     data-toggle="modal" data-target="#detail-rencana"
                                     class="toggleCollapseButton">a.
                                     Rincian
                                     &
                                     Status</a>
                                 <br>
                                 <a wire:click="detail_laporan('{{ $c->id_pengajuan_detail }}')" href=""
                                     data-toggle="modal" data-target="#detail-laporan"
                                     class="toggleCollapseButton">b.
                                     LPJ & Berita Acara
                                 </a>
                             </div>
                         </td>
                         <td>{{ $c->nama_penerima }}</td>
                         <td class="text-center">
                             {{ $c->jumlah_penerima }}
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}"
                                 wire:ignore.self>
                                 <span style="font-size:11pt;" class="text-bold text-primary">
                                     {{ $this->getJumlahPenerimaPenyaluran($c->id_pengajuan_detail) }}</span><br>
                                     <span style="font-size:11pt;" class="text-bold text-warning">
                                 {{ $a->jumlah_penerima_disetujui ?? 0 }}</span>

                             </div>
                         </td>
                         <td class="text-right">
                             {{ $this->numberFormat($c->satuan_pengajuan) }}
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}"
                                 wire:ignore.self>
                                 <span style="font-size:11pt;" class="text-bold text-success">
                                     {{ $this->numberFormat($c->satuan_disetujui) }}</span>
                                 <br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                     {{ $this->numberFormat($c->satuan_pencairan) }}</span>
                             </div>
                         </td>
                         <td class="text-right">
                             {{ $this->numberFormat($c->nominal_pengajuan) }}
                             <div class="collapse" id="collapseExample{{ $c->id_pengajuan_detail }}"
                                 wire:ignore.self>
                                 <span style="font-size:11pt;" class="text-bold text-success">
                                     {{ $this->numberFormat($c->nominal_disetujui) }}</span>
                                 <br>
                                 <span style="font-size:11pt;" class="text-bold text-warning">
                                     {{ $this->numberFormat($c->nominal_pencairan) }}</span>
                                 <br>
                                 <span style="font-size:11pt;" class="text-bold text-primary">
                                     {{ $this->numberFormat($this->getNominalPenyaluran($c->id_pengajuan_detail)) }}</span>
                             </div>
                         </td>
                         <td class="text-center">
                             {{ Carbon\Carbon::parse($c->tgl_pelaksanaan)->isoFormat('DD-MM-Y') }}
                         </td>
                         <td>
                             @if ($data->tingkat == 'Upzis MWCNU')
                                 {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $c->petugas_upzis) }}<br>
                                 <span style="font-size: 10pt;">
                                     ({{ \App\Http\Controllers\Helper::getJabatanPengurus('upzis', $c->petugas_upzis) }})
                                 </span>
                             @endif
                             @if ($data->tingkat == 'Ranting NU')
                                 {{ \App\Http\Controllers\Helper::getNamaPengurus('ranting', $c->petugas_ranting) }}<br>
                                 <span style="font-size: 10pt;">
                                     (
                                     {{ \App\Http\Controllers\Helper::getJabatanPengurus('ranting', $c->petugas_ranting) }}
                                     )
                                 </span>
                             @endif
                         </td>
                         <td class="text-center">
                             {{ $c->tgl_setor ? Carbon\Carbon::parse($c->tgl_setor)->isoFormat('DD-MM-Y') : '-' }}
                         </td>
                     </tr>
                 @endforeach
                 {{-- END OPERASIONAL UPZIS --}}
             @endif


         </tbody>
     </table>
 </div>
