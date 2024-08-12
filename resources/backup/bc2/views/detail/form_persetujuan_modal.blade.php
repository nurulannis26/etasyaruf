<div class="tab-persetujuan_direktur-detail-umum-pc">

    {{-- alert --}}
    {{-- @if (session()->has('alert_direktur'))
        <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('alert_direktur') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif --}}

    {{-- end alert --}}
    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and
                                ($data_detail->approval_status_divpro == 'Belum Direspon' or
                                    $data_detail->approval_status_divpro == 'Ditolak' or
                                    $data_detail->approval_status_divpro == ''))
        {{-- card acc --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $this->none_block_acc_program }};" >
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-success">RESPON ACC DIV. PROGRAM</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>


            {{-- alert --}}
            {{-- <div wire:ignore.self>
            @if ($id_rekening != null)
                @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" wire:ignore.self>
                        <i class="fas fa-minus-circle"></i>
                        Saldo Tidak Cukup!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            @endif
        </div> --}}
            
            {{-- @if (str_replace('.', '', $satuan_disetujui) > str_replace('.', '', $satuan_pengajuan))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-minus-circle"></i>
                    Nominal disetujui melebihi nominal pengajuan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif --}}
            {{-- end alert --}}

            {{-- form --}}
            <form wire:submit.prevent="acc_program">
                <div class="form-row mt-4">

                    {{-- <div class="form-group col-md-7">
                    <label for="inputNama">YANG MENYETUJUI &nbsp;</label>
                    <input type="input" class="form-control"
                        value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                        readonly>
                </div>

                <div class="form-group col-md-5">
                    <label for="inputNama">TGL DISETUJUI &nbsp;</label>
                    <input wire:model="approval_date" type="date" class="form-control" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">PJ PENCAIRAN DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">
                        <option value="">Pilih Staf Keuangan</option>
                        @foreach ($pengurus_keuangan as $b)
                            <option value="{{ $b->id_pc_pengurus }}">
                                {{ $b->nama . ' - ' . $b->jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label for="inputNama">REKENING SUMBER DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="id_rekening" class="form-control">
                        <option value="">Pilih Rekening</option>
                        @foreach ($rekening as $a)
                            <option value="{{ $a->id_rekening }}">
                                {{ $a->nama_rekening }} -
                                {{ $a->no_rekening }}
                                - Rp{{ number_format($a->saldo, 0, '.', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DIAJUKAN (SATUAN) &nbsp;</label>
                    <input wire:model="satuan_pengajuan" type="input" class="form-control"
                        placeholder="Masukan Nominal Satuan Disetujui" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DISETUJUI (SATUAN) &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2"
                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <input wire:model="satuan_disetujui" type="input" class="form-control " id="satuan_disetujui"
                        placeholder="Masukan Nominal Satuan Disetujui">
                </div>

                <div class="form-group col-md-12">
                    <label for="inputNama">NOMINAL DISETUJUI (TOTAL) (Rp{{ $satuan_disetujui }} x
                        {{ $data_detail->jumlah_penerima }}
                        Penerima Manfaat)</label>
                    <input wire:model="nominal_disetujui" type="input" class="form-control text-bold" readonly
                        id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                </div>
                            --}}




                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end direktur --}}


                    {{-- tgl disetujui --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl Diterima Div. Program</span>
                            </div>
                            <input wire:model="approval_date_divpro" type="date" class="form-control" >
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}

                    {{-- Pj Pencairan Dana --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span
                                    class="input-group-text bor-abu">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PJ
                                    Pencairan
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </div>
                            <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">

                                @foreach ($pengurus_keuangan as $b)
                                    <option value="{{ $b->id_pc_pengurus }}">
                                        {{ $b->nama . ' - ' . $b->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div> --}}
                    {{-- end Pj Pencairan Dana --}}
                    {{-- 
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;&nbsp;Rekening
                                    Sumber
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <select wire:model="id_rekening" class="form-control">
                                <option value="">Pilih Rekening</option>
                                @foreach ($rekening as $a)
                                    <option value="{{ $a->id_rekening }}">

                                        {{ $a->no_rekening }} -
                                        {{ $a->nama_rekening }} -
                                        Rp{{ number_format($a->saldo, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>




                        </div>
                    </div> --}}

                       {{-- sumber dana --}}
                       {{-- <div class="form-group col-md-12" wire:ignore>
                        <div class="input-group" wire:ignore>
                            <select  wire:model="id_rekening" class="form-control" id="inptKabupaten2">
                                <option value="">Rekening Sumber Dana </option>
                                @foreach ($rekening as $a)
                                    <option value="{{ $a->id_rekening }}">
                                        {{ $a->nama_rekening }} -
                                        {{ $a->no_rekening }}
                                        - Rp{{ number_format($a->saldo, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div> --}}

                    

                    {{-- {{ $this->id_rekening }} --}}
                    {{-- end sumber dana --}}




                    {{-- <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp </span>
                        </div>
                        <input wire:model="saldo" type="text" class="form-control" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">Saldo </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nama BMT</span>
                        </div>
                        <input wire:model="nama_bmt" type="text" class="form-control" readonly>
                    </div>
                </div> --}}


                    {{-- satuan pengajuan --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Diajukan (Satuan)</span>
                            </div>
                            <input wire:model="satuan_pengajuan" type="input" class="form-control"
                                placeholder="Masukan Nominal Satuan Disetujui" readonly>

                        </div>
                    </div> --}}
                    {{-- end satuan pengajuan --}}

                    {{-- satuan disetujui --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Disetujui (Satuan)</span>
                            </div>
                            <input wire:model="satuan_disetujui" type="input" class="form-control "
                                id="satuan_disetujui" placeholder="Masukan Nominal Satuan Disetujui">

                        </div>
                    </div> --}}
                    {{-- end satuan disetujui --}}





                    {{-- nominal disetujui --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;Nominal
                                    Disetujui
                                    (Total)&nbsp;&nbsp;</span>
                            </div>
                            <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                                disabled id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                            <div class="input-group-append">
                                <span class="input-group-text">(Rp{{ $satuan_disetujui }} x
                                    {{ $data_detail->jumlah_penerima }}
                                    Penerima) </span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- end satuan disetujui --}}




                    {{-- nominal disetujui --}}
                    {{-- <div class="form-group col-md-10">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">Rp</span>
                        </div>
                        <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                            placeholder="Nominal disetujui" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text ">Nominal
                                Disetujui (Rp{{ $satuan_disetujui }} x {{ $data_detail->jumlah_penerima }}
                                Penerima
                                Manfaat)</span>
                        </div>
                    </div>

                </div> --}}
                    {{-- end nominal disetujui --}}

                    <div class="form-group col-md-7">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
                            </div>
                            <input wire:model="keterangan_acc_divpro" type="input" class="form-control "
                                id="keterangan_acc" placeholder="Masukan Keterangan ACC">
                        </div>
                    </div>

                      {{-- tgl disetujui --}}
                      <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl Diserahkan Ke Direktur</span>
                            </div>
                            <input wire:model="tgl_diserahkan_direktur" type="date" class="form-control" >
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol ACC, Div. Program menerima disposisi penyaluran & menyerahkannya ke Direktur
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol acc --}}
                    <div class="form-group col-md-3">
                        @if ( $keterangan_acc_divpro == '')
                            <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-check-circle"></i>
                                ACC</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success btn-block"
                                wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                ACC</button>
                        @endif
                    </div>
                    {{-- acc --}}

                </div>
            </form>

        </div>
        {{-- end card acc --}}

        {{-- card tolak --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $this->none_block_tolak_program }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-danger">RESPON TOLAK PENGAJUAN DIV. PROGRAM</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <form wire:submit.prevent="tolak_program">

                <div class="form-row mt-4">

                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end rekening --}}

                    {{-- tgl penolakan --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tgl Penolakan</span>
                            </div>
                            <input wire:model="denial_date_divpro" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl penolakan --}}


                    {{-- denial note --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Alasan</span>
                            </div>
                            <input wire:model="denial_note_divpro" type="input" class="form-control"
                                placeholder="Masukan Alasan Penolakan">
                        </div>
                    </div>
                    {{-- end denial note --}}


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol tolak, direktur memberikan penolakan untuk dilakukan pencairan dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol tolak --}}
                    <div class="form-group col-md-3">
                        @if ($denial_note_divpro == '')
                            <button class="btn btn-danger btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-danger btn-block"
                                wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @endif
                    </div>
                    {{-- tolak --}}


                </div>
            </form>
        </div>
        {{-- end card tolak --}}
    @endif


</div>