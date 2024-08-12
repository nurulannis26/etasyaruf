<div wire:ignore.self class="modal fade" id="modal_pengajuan_berita" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">BERITA PENTASYARUFAN</h5>
                <div class="col-auto float-right">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

            </div>

            <form wire:submit.prevent="tambah_ubah_berita">

                <div class="modal-body mt-2">


                    <div id="form-baru">

                        <div class="form-row">

                            {{-- foto berita --}}
                            <div class="form-group col-md-5">
                                <label for="inputHP">FOTO BERITA</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgb(82, 166, 230)">ABAIKAN JIKA TIDAK ADA
                                    PERUBAHAN (JPG/JPEG/PNG)</sup>
                                <div class="custom-file custom-file-berita2">
                                    <input type="file" wire:model="file_berita_baru"
                                        accept="application/pdf , image/png" class="custom-file-input" id="foto_berita"
                                        name="foto_berita">
                                    <label class="custom-file-label" for="customFile">Pilih
                                        foto berita</label>
                                </div>
                            </div>

                            {{-- pewarta --}}
                            <div class="form-group col-md-7">
                                <label for="inputTempat">PEWARTA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->nama }} - ({{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }})"
                                    readonly>
                            </div>

                            {{-- judul berita --}}
                            <div class="form-group col-md-12">
                                <label for="inputTempat">JUDUL BERITA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" wire:model.defer="judul_berita"
                                    placeholder="Masukan judul berita">
                            </div>

                            {{-- narasi berita --}}
                            <div wire:ignore class="form-group col-md-12">
                                <label for="inputTempat">NARASI BERITA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <textarea wire:model.defer="narasi_berita" class="my-editor form-control" id="my-editor" cols="30" rows="10">
   
                                </textarea>
                            </div>

                            CATATAN <br>
                            <ul>
                                <li>Berita yang diterbitkan akan tampil pada aplikasi GOCAP</li>
                                <li>Berita pentasyarufan tingkat UPZIS akan tampil hanya pada user aplikasi
                                    berwilayah
                                    UPZIS tersebut</li>
                            </ul>

                        </div>

                    </div>
                </div>


                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>
                    <button type="button" name="submit" class="btn btn-success" id="simpan-berita"><i
                            class="fas fa-save"></i>
                        Simpan</button>

                    <button type="submit" name="submit" class="btn btn-success  d-none" id="simpan-berita2"><i
                            class="fas fa-save"></i>
                        Simpan2</button>

                </div>

            </form>
        </div>

    </div>



    @push('script')
        {{-- ckeditor --}}
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script>
            var options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('my-editor', options);
        </script>

        <script>
            $(document).ready(function() {


                $('#simpan-berita').click(function() {

                    @this.set('narasi_berita2', CKEDITOR.instances['my-editor'].getData());
                    document.getElementById("simpan-berita2").click();
                    // bsCustomFileInput.init();
                });

                window.loadContactDeviceSelect2 = () => {


                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });


            });
        </script>
    @endpush

</div>
