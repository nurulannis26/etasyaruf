<div class="modal fade" id="modal_laporan_saldo_awal{{ $data['bulan'] }}" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{ app\Helpers\BasicHelper::getNamaBulan($data['bulan']) }}
                    {{ $tahun }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- form --}}
            <form method="POST" action="/{{ $role }}/laporan/ubah_laporankeu">
                @csrf

                <input type="hidden" name="bulan" value="{{ $data['bulan'] }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                {{-- modal body --}}
                <div class="modal-body">

                    <div class="form-row">

                        <div class="card p-2 text-bold text-center mb-3 col-md-12"
                            style="border-radius: 10px;background-color:#cbf2d6;">
                            SALDO AWAL BANK
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">SOSIAL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sab_sosial" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sab_sosial']), 0, '.', '.') }}">

                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">KELEMBAGAAN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sab_kelembagaan" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sab_kelembagaan']), 0, '.', '.') }}">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">OPERASIONAL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sab_operasional" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sab_operasional']), 0, '.', '.') }}">
                            </div>
                        </div>

                        <div class="card p-2 text-bold text-center mb-3 col-md-12"
                            style="border-radius: 10px;background-color:#cbf2d6;">
                            SALDO AWAL KAS
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">SOSIAL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sak_sosial" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sak_sosial']), 0, '.', '.') }}">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">KELEMBAGAAN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sak_kelembagaan" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sak_kelembagaan']), 0, '.', '.') }}">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputNama">OPERASIONAL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bor-abu">Rp</span>
                                </div>
                                <input type="text" class="form-control" name="sak_operasional" type-currency='IDR'
                                    value="{{ number_format(floatval($data['sak_operasional']), 0, '.', '.') }}">
                            </div>
                        </div>

                        {{-- <div class="card p-2 text-bold text-center mb-3 col-md-12"
                            style="border-radius: 10px;background-color:#cbf2d6;">
                            KETERANGAN
                        </div> --}}
                        <div class="form-group col-md-12">
                            <label for="inputNama">KETERANGAN</label>

                            <input type="text" class="form-control" name="keterangan"
                                value="{{ $data['keterangan'] }}">

                        </div>


                    </div>
                </div>
                {{-- end modal body --}}

                {{-- footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                        Tambah</button>

                </div>
                {{-- endfooter --}}

            </form>
            {{-- end form --}}

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.input-currency').maskMoney({
                prefix: 'Rp',
                thousands: '.',
                decimal: ','
            });
        });
    </script>
</div>
