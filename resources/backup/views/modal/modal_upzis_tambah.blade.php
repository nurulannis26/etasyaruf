@if (Auth::user()->gocap_id_upzis_pengurus != null)
    {{--  tambah pengajuan upzis --}}
    <div wire:ignore.self class="modal fade" id="modal_upzis_tambah" data-backdrop="static" tabindex="-1"
        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> TAMBAH PERMOHONAN PENTASYARUFAN
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- form --}}
                <form wire:submit.prevent="tambah_pengajuan_upzis">

                    {{-- modal body --}}
                    <div class="modal-body">
                        <div class="form-row">

                            {{-- upzis --}}
                            <div class="form-group col-md-4">
                                <label for="inputNama">UPZIS MWCNU &nbsp;</label>
                                <input type="text" class="form-control"
                                    value="{{ Auth::user()->UpzisPengurus->Upzis->Wilayah->nama }}" readonly>
                            </div>
                            {{-- end upzis --}}

                            {{-- nomor pengajuan --}}
                            <div class="form-group col-md-8">
                                <label for="inputNama">NOMOR PENGAJUAN &nbsp;</label>
                                <input type="text" class="form-control" value="{{ $nomor_surat }}" readonly>
                            </div>
                            {{-- end nomor pengajuan --}}

                            {{--  tgl pengajuan  --}}
                            <div class="form-group col-md-4">
                                <label for="inputNama">TGL PENGAJUAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="tgl_pengajuan" type="date" class="form-control">
                            </div>
                            {{-- end tgl pengajuan --}}

                            {{-- pj pengambilan dana --}}
                            <div class="form-group col-md-8">
                                <label for="inputNama">PJ PENGAMBILAN DANA&nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select wire:model="pj" wire:loading.attr="disabled" class="form-control">
                                    <option value="">Pilih Pengurus Upzis</option>
                                    @foreach ($daftar_pj as $a)
                                        <option value="{{ $a->id_upzis_pengurus }}">{{ $a->jabatan . ' - ' . $a->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- end pj pengambilan dana --}}


                            {{-- info --}}
                            <div class="card card-body " style="background-color:#cbf2d6;">
                                <b>INFORMASI!</b>
                                <span>
                                    Setelah berhasil menambahkan pengajuan pentasyarufan, anda wajib melengkapi data
                                    rencana
                                    program & daftar penerima manfaat
                                </span>
                            </div>
                            {{-- end info --}}

                        </div>
                    </div>
                    {{-- end modal body --}}

                    {{-- footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                            Batal</button>

                        @if ($tgl_pengajuan == '' or $pj == '')
                            <button class="btn btn-success" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-save"></i>
                                Tambah</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-success"
                                wire:loading.attr="disabled"><i class="fas fa-save"></i>
                                Tambah</button>
                        @endif
                    </div>
                    {{-- endfooter --}}

                </form>
                {{-- end form --}}

            </div>
        </div>
    </div>
    {{-- end tambah program_penguatan_kelembagaan --}}
@endif