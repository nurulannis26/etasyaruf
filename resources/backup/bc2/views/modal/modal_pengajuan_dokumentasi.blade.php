<div wire:ignore.self class="modal fade" id="modal_pengajuan_dokumentasi" data-backdrop="static" tabindex="-1"
    data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DOKUMENTASI
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if (session()->has('alert_dokumentasi'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('alert_dokumentasi') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form wire:submit.prevent="tambah_ubah_dokumentasi">
                    <div class="form-row">

                        {{-- judul dokumentasi --}}
                        <div class="form-group col-md-3">
                            <label for="inputNama">JUDUL DOKUMENTASI &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="judul_dokumentasi" type="text" class="form-control "
                                placeholder="Nama Judul Dokumentasi">
                        </div>
                        {{-- end judul --}}

                        {{-- foto dokumentasi --}}
                        <div class="form-group col-md-5">
                            <label for="inputHP">DOKUMENTASI</label>
                            @if ($id_pengajuan_dokumentasi == null)
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB
                                    (JPG/JPEG/PNG)</sup>
                            @else
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgb(82, 166, 230)">ABAIKAN JIKA TIDAK
                                    ADA
                                    PERUBAHAN (JPG/JPEG/PNG)</sup>
                            @endif

                            <div class="custom-file custom-file-tambah-dokumentasi">
                                <input type="file" wire:model="file_dokumentasi"
                                    accept="image/png, image/jpg, image/jpeg" class="custom-file-input" id="file"
                                    name="file">
                                <label class="custom-file-label" for="customFile">Pilih
                                    file</label>
                            </div>
                        </div>
                        {{-- end foto dokumentasi --}}
                        <div class="form-group col-md-1 mt-2">
                            <br>
                            <a wire:click="reset_dokumentasi" class="btn btn-secondary btn-block tombol-reset"
                                wire:loading.attr="disabled">
                                Clear</a>
                        </div>
                        @if ($id_pengajuan_dokumentasi == null)
                            <div class="form-group col-md-3 mt-2">
                                <br>
                                @if ($judul_dokumentasi == '' or $file_dokumentasi == '')
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
                            <div class="form-group col-md-1 mt-2">
                                <br>
                                <a wire:click="hapus_dokumentasi" class="btn btn-danger btn-block tombol-reset"
                                    wire:loading.attr="disabled">
                                    Hapus
                                </a>
                            </div>

                            <div class="form-group col-md-2 mt-2">
                                <br>
                                @if ($judul_dokumentasi == '')
                                    <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                @else
                                    <button type="submit" name="submit" class="btn btn-success btn-block "
                                        wire:loading.attr="disabled">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered mt-2" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 70%;">Judul</th>
                                <th style="width: 25%;">File</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($dokumentasi as $a)
                                <tr wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')"
                                    style="cursor: pointer;
                                @if ($id_pengajuan_dokumentasi == $a->id_pengajuan_dokumentasi) background-color:#ECECEC; @endif">
                                    <td wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                        {{ $a->judul }} <br>
                                        {{-- <span style="font-size: 10pt">Diinput Oleh :
                                            {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                                            ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                                        </span> --}}
                                    </td>
                                    <td class="text-center"
                                        wire:click="detail_dokumentasi('{{ $a->id_pengajuan_dokumentasi }}')">
                                        <a href="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"
                                            target="_blank">
                                            <img style="border-radius:10px; height: 100px; "
                                                src="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Belum
                                        ada dokumentasi kegiatan</td>
                                </tr>
                            @endforelse


                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {

                window.loadContactDeviceSelect2 = () => {
                    bsCustomFileInput.init();


                    $('.tombol-tambah').click(function() {
                        $(".custom-file-tambah-dokumentasi").html('').change();

                    });

                    $('.tombol-reset').click(function() {
                        $(".custom-file-tambah-dokumentasi").html('').change();

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
