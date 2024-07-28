@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_pengajuan_penerima_manfaat2" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($id_pengajuan_penerima == null)
                            TAMBAH DATA PENERIMA MANFAAT
                        @else
                            UBAH DATA PENERIMA MANFAAT
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form
                    @if ($id_pengajuan_penerima == null) wire:submit.prevent="tambah_penerima"
                @else
                wire:submit.prevent="ubah_penerima" @endif>

                    {{-- modal body --}}
                    <div class="modal-body">

                        <div class="form-row">

                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">TGL PENYALURAN &nbsp;</label>
                                <!--<sup class="badge badge-danger text-white mb-2"-->
                                <!--    style="background-color:rgba(230,82,82)">WAJIB</sup>-->
                                <input wire:model="tgl_penyaluran" type="date" class="form-control">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}

                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">NAMA PENERIMA MANFAAT &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="nama" placeholder="Masukkan Nama Penerima Manfaat" type="text"
                                    class="form-control">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}



                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">NIK &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="nik" type="text" class="form-control" placeholder="Masukkan NIK">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}

                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">NO KK &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="nokk" type="text" class="form-control"
                                    placeholder="Masukkan No KK">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}



                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">NO HP &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="nohp" type="text" class="form-control"
                                    placeholder="Masukkan No HP">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}


                            {{-- NAMA PENERIMA MANFAAT --}}
                            <div class="form-group col-md-6">
                                <label for="inputNama">JENIS PERMOHONAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="jenis_bantuan" type="text" class="form-control"
                                    placeholder="Jenis Permohonan">
                            </div>
                            {{-- end NAMA PENERIMA MANFAAT --}}

                            

                                <div class="form-group col-md-6">
                                    <label for="inputNama">NOMINAL BANTUAN &nbsp;</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bor-abu">Rp</span>
                                        </div>
                                        <input wire:model="nominal_bantuan" id="nominal_bantuan" type="text"
                                            class="form-control">
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                <label for="inputNama">JENIS BANTUAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="jns_bantuan" type="text" class="form-control"
                                    placeholder="Bantuan yang Diajukan">
                            </div>

                            {{-- ALAMAT --}}
                            <div class="form-group col-md-12">
                                <label for="inputNama">ALAMAT &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="alamat" type="text" class="form-control"
                                    placeholder="Masukkan Alamat">
                            </div>
                            {{-- end ALAMAT --}}

                            {{-- KETERANGAN --}}
                            <div class="form-group col-md-12">
                                <label for="inputNama">KETERANGAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="keterangan" type="text" class="form-control"
                                    placeholder="Masukkan Keterangan">
                            </div>
                            {{-- end KETERANGAN --}}

                        </div>
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>

                        @if ($nama == '' or $alamat == '' or $nominal_bantuan == '' or $keterangan == '')
                            <button class="btn btn-success " disabled wire:loading.attr="disabled">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success "
                                wire:loading.attr="disabled">
                                <i class="fas fa-save"></i> Simpan
                            </button>
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


                    $('#nominal_bantuan').on('input', function(e) {
                        $('#nominal_bantuan').val(formatRupiah($('#nominal_bantuan').val(),
                            'Rp. '));
                    });
                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>

<script>
    Livewire.on('dataTersimpan', () => {
         $('#modal_pengajuan_penerima_manfaat2').modal('hide');
        });

</script>

    @endpush


@endif
