@if (Auth::user()->gocap_id_upzis_pengurus != null)

    <div wire:ignore.self class="modal fade" id="modal_pengajuan_konfirmasi" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> UPLOAD BERKAS
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form wire:submit.prevent="upload_berkas">

                    {{-- modal body --}}
                    <div class="modal-body">
                        <div class="form-row">

                            {{-- DIKONFIRMASI OLEH --}}
                            <div class="form-group col-md-8">
                                <label for="inputNama">DIKONFIRMASI OLEH &nbsp;</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->nama }} - ({{ Auth::user()->UpzisPengurus->JabatanPengurus->jabatan }})"
                                    readonly>
                            </div>
                            {{-- end DIKONFIRMASI OLEH --}}

                            {{-- TGL KONFIRMASI --}}
                            <div class="form-group col-md-4">
                                <label for="inputNama">TGL KONFIRMASI &nbsp;</label>
                                <input type="text" class="form-control" value="{{ date('d-m-Y') }}" readonly>
                            </div>
                            {{-- end TGL KONFIRMASI --}}


                            {{-- file --}}
                            <div class="form-group col-md-12">
                                <label for="inputHP">UPLOAD BERKAS BER-TTD & STAMPEL</label>

                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB
                                    (PDF/PNG/JPG/JPEG)</sup>

                                <div wire:loading>
                                    Harap Tunggu, Sedang Loading Berkas
                                </div>

                                <div class="custom-file custom-file-scan">
                                    <input type="file" wire:model="file_scan"
                                        accept="application/pdf, image/png, image/jpg, image/jpeg"
                                        class="custom-file-input" id="file" name="file">
                                    <label class="custom-file-label" for="customFile">Pilih
                                        file</label>
                                </div>
                            </div>
                            {{-- end file --}}


                        </div>


                        {{-- info --}}
                        <div class="card card-body " style="background-color:#cbf2d6;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol Upload, memberikan konfirmasi pengajuan yang telah direncanakan
                                & selanjutnya menunggu respon oleh Lazisnu Cilacap<br>
                            </span>
                        </div>
                        {{-- end info --}}
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                            Batal</button>

                        @if ($file_scan == '')
                            <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Upload</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success tombol-tambah"
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Upload</button>
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
