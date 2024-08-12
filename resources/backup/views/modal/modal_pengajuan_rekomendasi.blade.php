@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_pengajuan_rekomendasi" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> TERBITKAN LEMBAR REKOMENDASI
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form wire:submit.prevent="rekomendasi">

                    {{-- modal body --}}
                    <div class="modal-body">

                        {{-- card --}}
                        <div class="card" style="background-color:#cbf2d6">
                            <div class="card-body">
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    <div class="form-row">

                                        <div class="col-sm-4 invoice-col">
                                            KELEMBAGAAN
                                            <address>
                                                <b> Rp{{ number_format($total_kelembagaan, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            PROGRAM SOSIAL
                                            <address>
                                                <b> Rp{{ number_format($total_program_sosial, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            DANA OPERASIONAL
                                            <address>
                                                <b> Rp{{ number_format($total_operasional_upzis, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>

                                        <div class="col-sm-6 invoice-col ">
                                            <address>
                                                <b>TOTAL :
                                                    Rp{{ number_format($total_kelembagaan + $total_program_sosial + $total_operasional_upzis, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>
                                        <div class="col-sm-6 invoice-col ">
                                            <address class="text-right">
                                                <b>BMT : {{ $nama_bmt }} </b>
                                            </address>
                                        </div>
                                    </div>
                                @endif

                                @if ($data->tingkat == 'Ranting NU')
                                    <div class="form-row">

                                        <div class="col-sm-4 invoice-col">
                                            KELEMBAGAAN
                                            <address>
                                                <b> Rp{{ number_format($total_kelembagaan, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            PROGRAM SOSIAL
                                            <address>
                                                <b> Rp{{ number_format($total_program_sosial, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>


                                        <div class="col-sm-6 invoice-col ">
                                            <address>
                                                <b>TOTAL :
                                                    Rp{{ number_format($total_kelembagaan + $total_program_sosial, 0, '.', '.') }},-</b>
                                            </address>
                                        </div>
                                        <div class="col-sm-6 invoice-col ">
                                            <address class="text-right">
                                                <b>BMT : {{ $nama_bmt }} </b>
                                            </address>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        {{-- end card --}}

                        <div class="form-row">

                            {{-- DIREKOMENDASIKAN OLEH --}}
                            <div class="form-group col-md-8">
                                <label for="inputNama">DIREKOMENDASIKAN OLEH &nbsp;</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->nama }} - ({{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }})"
                                    readonly>
                            </div>
                            {{-- end DIREKOMENDASIKAN OLEH --}}

                            {{--  tgl TERBIT REKOMENDASI  --}}
                            <div class="form-group col-md-4">
                                <label for="inputNama">TGL TERBIT REKOMENDASI &nbsp;</label>

                                <input wire:model="tgl_terbit_rekomendasi" type="date" class="form-control" readonly>
                            </div>
                            {{-- end tgl TERBIT REKOMENDASI --}}



                            {{-- PJ PENGAMBILAN DANA --}}
                            <div class="form-group col-md-12">
                                <label for="inputNama">PJ PENGAMBILAN DANA&nbsp;</label>

                                @if ($data->tingkat == 'Upzis MWCNU')
                                    <input type="text" class="form-control" readonly
                                        value="{{ $this->nama_pengurus_upzis($data->pj_upzis) }} - ({{ $this->jabatan_pengurus_upzis($data->pj_upzis) }})">
                                @endif

                                @if ($data->tingkat == 'Ranting NU')
                                    <input type="text" class="form-control" readonly
                                        value="{{ $this->nama_pengurus_upzis($data->pj_ranting) }} - ({{ $this->jabatan_pengurus_upzis($data->pj_ranting) }})">
                                @endif

                            </div>
                            {{-- end PJ PENGAMBILAN DANA --}}


                            {{-- file --}}
                            {{-- <div class="form-group col-md-12">
                                <label for="inputHP">UPLOAD SCAN BERKAS BER-TTD & STAMPEL</label>

                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB
                                    (PDF)</sup>
                                <div class="custom-file custom-file-scan">
                                    <input type="file" wire:model="file_scan_rekomendasi" accept="application/pdf"
                                        class="custom-file-input" id="file" name="file">
                                    <label class="custom-file-label" for="customFile">Pilih
                                        file</label>
                                </div>
                            </div> --}}
                            {{-- end file --}}



                        </div>
                        {{-- info --}}
                        <div class="card card-body " style="background-color:#cbf2d6;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol Terbitkan, rekomendasi
                                diterbitkan ke
                                Direktur dan PJ Pengambilan Dana<br>
                            </span>
                        </div>
                        {{-- end info --}}
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                            Batal</button>

                        @if ($tgl_terbit_rekomendasi == '')
                            <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Terbitkan</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success tombol-tambah"
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Terbitkan</button>
                        @endif
                    </div>
                    {{-- endfooter --}}

                </form>
                {{-- end form --}}



            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {

                window.loadContactDeviceSelect2 = () => {
                    bsCustomFileInput.init();

                    $('.tombol-tambah').click(function() {
                        $(".custom-file-scan").html('').change();
                    });

                    $('.custom-file-scan').on('change', function(e) {
                        @this.set('file_scan', e.val());
                    });

                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>
    @endpush

@endif
