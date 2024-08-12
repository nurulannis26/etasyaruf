@if (session()->has('alert_pengeluaran'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('alert_pengeluaran') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row ">
    {{-- penyaluran --}}
    <div class="col col-md-12 col-sm-12 ">

        <div class="card modal-detail-kegiatan-pengeluaran_panduan" style="background-color:#cbf2d6">
            <div class="card-body">

                <div class="form-row">

                    <div class="col-sm-4 invoice-col">
                        Nominal Pengajuan Yang Dicairkan
                        <address>
                            <b>
                                Rp{{ number_format($pengeluaran_nominal_pencairan, 0, '.', '.') }},-</b>
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        Dana Digunakan
                        <address>
                            <b> Rp{{ number_format($dana_digunakan, 0, '.', '.') }},-</b>

                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        Dana Tersisa
                        <address>
                            <b>Rp{{ number_format($pengeluaran_nominal_pencairan - $dana_digunakan, 0, '.', '.') }},-</b>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->gocap_id_upzis_pengurus != null)

            @if ($pencairan_status == 'Belum Dicairkan' and $status_rekomendasi == 'Belum Terbit')
                {{-- alert --}}
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-minus-circle"></i> Tidak bisa menambahkan penyaluran, karena dana pengajuan belum
                    dicairkan
                </div>
                {{-- end alert --}}
            @endif

            @if ($pencairan_status == 'Berhasil Dicairkan' and $status_rekomendasi == 'Belum Terbit')
                {{-- alert --}}
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-minus-circle"></i> Tidak bisa menambahkan penyaluran, karena lembar rekomendasi
                    belum
                    terbit
                </div>
                {{-- end alert --}}
            @endif

            @if (str_replace('.', '', $nominal_pengeluaran) > $pengeluaran_nominal_pencairan - $dana_digunakan)
                {{-- alert --}}
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-minus-circle"></i> Nominal Melebihi Dana Tersisa
                </div>
                {{-- end alert --}}
            @endif
        @endif


        {{-- form --}}
        @if (Auth::user()->gocap_id_upzis_pengurus != null and
                $pencairan_status == 'Berhasil Dicairkan' and
                $status_rekomendasi == 'Sudah Terbit')
            <form wire:submit.prevent="tambah_ubah_pengeluaran">
                <div class="form-row">

                    {{-- Judul Pengeluaran --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Judul</span>
                            </div>
                            <input wire:model="judul_pengeluaran" type="text" class="form-control"
                                placeholder="Masukan Judul Pengeluaran">
                        </div>
                    </div>
                    {{-- end judul pengeluaran --}}

                    {{-- jumlah --}}
                    <div class="form-group col-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Jumlah Unit/Barang</span>
                            </div>
                            <input wire:model="jumlah_pengeluaran" type="text" class="form-control"
                                placeholder="Jumlah Unit/Barang">
                        </div>
                    </div>
                    {{-- end jumlah pengeluaran --}}


                    {{-- NOMINAL pengeluaran --}}
                    <div class="form-group col-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Rp</span>
                            </div>
                            <input wire:model="nominal_pengeluaran" id="nominal_pengeluaran" type="text"
                                class="form-control" placeholder="Nominal Pengeluaran">
                        </div>
                    </div>
                    {{-- end NOMINAL pengeluaran --}}

                    {{-- tanggal pengeluaran --}}
                    <div class="form-group col-md-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Tgl</span>
                            </div>
                            <input wire:model="tgl_pengeluaran" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl pengeluaran --}}

                    {{-- nota --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Nota</span>
                            </div>


                            <div class="custom-file custom-nota-pengeluaran">
                                <input type="file" wire:model="nota_pengeluaran"
                                    accept="image/png, image/jpg, image/jpeg" class="custom-file-input" id="file2"
                                    name="file2">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>
                    </div>
                    {{-- end nota --}}


                    {{-- tombol --}}
                    <div class="form-group col-md-1">
                        <a wire:click="reset_pengeluaran" class="btn btn-secondary btn-block tombol-reset"
                            wire:loading.attr="disabled">
                            Reset</a>
                    </div>

                    @if ($id_pengajuan_pengeluaran == null)
                        <div class="form-group col-md-3 ">
                            @if (
                                $judul_pengeluaran == '' or
                                    $jumlah_pengeluaran == '' or
                                    $nominal_pengeluaran == '' or
                                    $tgl_pengeluaran == '' or
                                    $nota_pengeluaran == '')
                                <button class="btn btn-success btn-block tombol-tambah" wire:loading.attr="disabled"
                                    disabled>
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success btn-block tombol-tambah"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                            @endif

                        </div>
                    @else
                        <div class="form-group col-md-1 ">
                            <a wire:click="hapus_pengeluaran" class="btn btn-danger btn-block tombol-reset"
                                wire:loading.attr="disabled">
                                Hapus
                            </a>
                        </div>

                        <div class="form-group col-md-2 ">
                            @if ($judul_pengeluaran == '' or $jumlah_pengeluaran == '' or $nominal_pengeluaran == '' or $tgl_pengeluaran == '')
                                <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success btn-block tombol-reset"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            @endif
                        </div>
                    @endif
                    {{-- end tombol --}}



                </div>
            </form>
        @endif
        {{-- end form --}}




        <div class="card">
            <div class="card-body">


                <div class="form-row ">

                    <div class="col-12 col-md-6 col-sm-12 mb-2 mb-xl-0">
                        <div class="d-flex flex-row bd-highlight align-items-center">
                            <div class="p-2 bd-highlight">
                                <i class="fas fa-money-check"></i>
                            </div>
                            <div class="p-1 bd-highlight">
                                <b> PENYALURAN</b>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-2  col-sm-12 mb-2 mb-xl-0  ">
                        <span class="mt-1 mr-2 float-right">
                            Format Lampiran :
                        </span>
                    </div>

                    <div
                        class="col-12 col-md-2  col-sm-12 mb-2 mb-xl-0 modal-detail-kegiatan-pengeluaran_penyaluran_kwitansi_panduan ">
                        {{-- <a href="" target="_blank"
                            class="btn btn-sm btn-outline-success float-right  ml-2 btn-block" role="button"
                            style="border-radius:10px; ">
                            Kwitansi</a> --}}
                        <button type="button" class="btn btn-sm btn-outline-success float-right btn-block" disabled
                            data-toggle="tooltip" data-placement="top" title="Dalam Pengembangan">
                            Kwitansi
                        </button>
                    </div>

                    <div
                        class="col-12 col-md-2  col-sm-12 mb-2 mb-xl-0 modal-detail-kegiatan-pengeluaran_penyaluran_berita_acara_panduan ">
                        {{-- <a href="/{{ $role }}/berita_acara/{{ $id_pengajuan_detail }}" target="_blank"
                            class="btn btn-sm btn-outline-success float-right btn-block" role="button"
                            style="border-radius:10px; ">Berita
                            Acara</a> --}}
                        <button type="button" class="btn btn-sm btn-outline-success float-right btn-block" disabled
                            data-toggle="tooltip" data-placement="top" title="Dalam Pengembangan">
                            Berita Acara
                        </button>
                    </div>
                </div>


                {{-- tabel --}}
                {{-- tabel pengeluaran --}}
                <div class="table-responsive modal-detail-kegiatan-pengeluaran_penyaluran_panduan">
                    <table class="table table-bordered mt-2" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 4%;">No</th>
                                <th style="width: 35%;">Judul</th>
                                <th style="width: 15%;">Tgl Pengeluaran</th>
                                <th style="width: 10%;">Jumlah</th>
                                <th>Nominal</th>
                                <th>Saldo Akhir </th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $saldo_akhir = 0;
                                
                                $v = 1;
                            @endphp
                            @forelse ($pengeluaran as $a)
                                <tr wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')"
                                    style="cursor: pointer;
                                    @if ($id_pengajuan_pengeluaran == $a->id_pengajuan_pengeluaran) background-color:#ECECEC; @endif">
                                    <td wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')">
                                        {{ $loop->iteration }}</td>
                                    <td wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')">
                                        <a href="{{ asset('uploads/nota_pengeluaran/' . $a->nota) }}" target="_blank">
                                            {{ $a->judul }} </a><br> <span style="font-size: 10pt">Diinput Oleh
                                            :
                                            {{ $this->nama_pengurus_upzis($a->maker_tingkat_upzis) }}
                                            ({{ $this->jabatan_pengurus_upzis($a->maker_tingkat_upzis) }})
                                        </span>
                                    </td>
                                    <td wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')"
                                        style="text-align: center">
                                        {{ Carbon\Carbon::parse($a->tgl_pengeluaran)->isoFormat('DD-MM-Y') }}</td>
                                    <td wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')"
                                        style="text-align: center">
                                        {{ $a->jumlah }}</td>
                                    <td wire:click="detail_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}')"
                                        style="text-align: center">
                                        Rp{{ number_format($a->nominal_pengeluaran, 0, '.', '.') }},-</td>
                                    <td class="text-center">
                                        @php
                                            if ($v == 1) {
                                                $saldo_akhir = $pengeluaran_nominal_pencairan - $dana_digunakan;
                                                // $saldo_akhir = $saldo_akhir + $pengeluaran->nominal_pengeluaran;
                                            }
                                        @endphp

                                        Rp{{ number_format($saldo_akhir, 0, '.', '.') }},-

                                        @php
                                            $saldo_akhir = $saldo_akhir + $a->nominal_pengeluaran;
                                            // $b =  $dana_digunakan - ($dana_digunakan - $pengeluaran->nominal_pengeluaran );
                                            
                                            $v++;
                                            
                                        @endphp
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum
                                        ada pengeluaran</td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>
                {{-- end tabel --}}

            </div>
        </div>
    </div>
    {{-- end penyaluran --}}





    @push('script')
        <script>
            $(document).ready(function() {


                window.loadContactDeviceSelect2 = () => {
                    bsCustomFileInput.init();

                    // pemohon
                    // select2_id_pemohon
                    // $('#select2-dropdown').select2().on('change', function() {
                    //     livewire.emitTo('tenant.contact-component', 'devicesSelect', $(this).val());
                    //     var data = $('#select2-dropdown').select2("val");
                    //     @this.set('id_program_kegiatan', data);
                    // });


                    $('#nominal_pengeluaran').on('input', function(e) {
                        $('#nominal_pengeluaran').val(formatRupiah($('#nominal_pengeluaran').val(),
                            'Rp. '));
                    });

                    $('.tombol-reset').click(function() {
                        $("#file").val('');
                        $("#file2").val('');
                        $(".custom-file-label").html('Pilih file');
                    });

                    $('.tombol-tambah').click(function() {
                        $("#file2").val('');
                        $(".custom-file-label").html('Pilih file');
                    });

                    $('.custom-file-nota-pengeluaran').on('change', function(e) {
                        @this.set('nota_pengeluaran', e.val());
                    });


                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>
    @endpush
</div>
