<div class="modal-body">

    @if (session()->has('alert_barang'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('alert_barang') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit.prevent="tambah_ubah_barang">


        <div class="row">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="form-group col-md-2 ">
                        <label for="inputNama">JUMLAH BARANG &nbsp;</label>
                        <input wire:model="jumlah_barang" type="text" class="form-control"
                            placeholder="1 Sak / 1 Unit / 1 Paket">
                    </div>
                    {{-- berupa --}}
                    <div class="form-group col-md-4 ">
                        <label for="inputNama">URAIAN/JENIS BARANG &nbsp;</label>
                        <input wire:model="jenis_barang" type="text" class="form-control"
                            placeholder="Masukan Uraian/Jenis Barang">
                    </div>

                    {{-- senilai --}}
                    <div class="form-group col-md-3 ">
                        <label for="inputNama">NILAI BARANG (Rp)&nbsp;</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu">Rp</span>
                            </div>
                            <input wire:model="nominal_barang" id="nominalBarang" type="text" class="form-control"
                                placeholder="Masukan Nilai Barang">
                        </div>
                    </div>

                    <div class="form-group col-md-1 mt-2">
                        <br>
                        <a wire:click="reset_barang" class="btn btn-secondary btn-block tombol-reset"
                            wire:loading.attr="disabled">
                            Clear</a>
                    </div>

                    @if ($id_lpj_uraian_barang == null)
                        <div class="form-group col-md-2 mt-2">
                            <br>
                            @if ($jenis_barang == '' or $jumlah_barang == '' or $nominal_barang == '')
                                <button class="btn btn-success btn-block tombol-reset" disabled
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success btn-block tombol-reset"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </button>
                            @endif
                        </div>
                    @else
                        <style>
                            .custom-btn {
                                height: 60%;
                                /* Sesuaikan tinggi sesuai kebutuhan Anda */
                            }

                            .btn-group {
                                align-items: center;
                                /* Menyebabkan tombol-tombol dimulai dari bagian atas */
                            }
                        </style>
                        <br>
                        <br>
                        <div class="btn-group col-md-2 mt-3">
                            <button wire:click="hapus_barang" class="btn btn-outline-danger custom-btn" type="button"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                            @if ($jenis_barang == '' or $nominal_barang == '' or $nominal_barang == '')
                                <button class="btn btn-outline-success custom-btn" type="button" disabled
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>
                            @else
                                <button type="submit" name="submit" class="btn btn-outline-success custom-btn"
                                    type="button" wire:loading.attr="disabled">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered mt-3" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20ch;">Jumlah Barang</th>
                            <th style="width: 55%;">Uraian/Jenis Barang</th>
                            <th style="width: 20%;">Nominal Barang</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($barang as $a)
                            <tr wire:click="detail_barang('{{ $a->id_lpj_uraian_barang }}')"
                                style="cursor: pointer;
                                @if ($id_lpj_uraian_barang == $a->id_lpj_uraian_barang) background-color:#ECECEC; @endif">
                                <td wire:click="detail_barang('{{ $a->id_lpj_uraian_barang }}')">
                                    {{ $loop->iteration }}
                                </td>
                                <td wire:click="detail_barang('{{ $a->id_lpj_uraian_barang }}')">
                                    {{ $a->jumlah_barang }} <br>
                                <td wire:click="detail_barang('{{ $a->id_lpj_uraian_barang }}')">
                                    {{ $a->jenis_barang }} <br>
                                <td wire:click="detail_barang('{{ $a->id_lpj_uraian_barang }}')">
                                    Rp. {{ number_format($a->nominal_barang, 0, ',', '.') }},- <br>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum
                                    ada uraian barang</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </form>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            window.loadContactDeviceSelect2 = () => {
                $('#nominalBarang').on('input', function(e) {
                    $('#nominalBarang').val(formatRupiah($('#nominalBarang').val(),
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
