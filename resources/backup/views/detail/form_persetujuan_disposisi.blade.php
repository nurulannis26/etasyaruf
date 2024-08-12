<div class="tab-persetujuan_direktur-detail-umum-pc">

    {{-- end alert --}}
    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and
                                ($data->approval_status_divpro == 'Belum Direspon' or
                                    $data->approval_status_divpro == 'Ditolak' or
                                    $data->approval_status_divpro == ''))
        {{-- card acc --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $this->none_block_acc_program }};" >
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-success">RESPON ACC DIV. PROGRAM</b>
                <a wire:click="close_internal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            {{-- form --}}
            <form wire:submit.prevent="acc_internal">
                <div class="form-row mt-4">

                    {{-- Direktur --}}
                    <div class="form-group col-md-12">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end direktur --}}


                    {{-- tgl disetujui --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl Diterima Div. Program</span>
                            </div>
                            <input wire:model="approval_date_divpro" type="date" class="form-control" >
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}

                      {{-- tgl disetujui --}}
                      <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl Diserahkan Ke Direktur</span>
                            </div>
                            <input wire:model="tgl_diserahkan_direktur" type="date" class="form-control" >
                        </div>
                    </div>
                    {{-- end tgl disetujui --}}

                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
                            </div>
                            <input wire:model="keterangan_acc_divpro" type="input" class="form-control "
                                id="keterangan_acc" placeholder="Masukan Keterangan ACC">
                        </div>
                    </div>


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
    @endif


</div>