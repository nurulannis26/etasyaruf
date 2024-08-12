{{-- modal  --}}
<div wire:ignore.self class="modal fade" id="modal_pilar_hapus" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Konfirmasi Hapus Pilar</b></h5>

            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus data?</p>
                <div class="card card-body p-2 pl-4" style="background-color:#f5b9b9;">
                    <div class="row">
                        <b>INFORMASI!</b>
                        Pilar tidak dapat dihapus apabila memiliki keterkaitan dengan pentasyarufan yang telah
                        dilaksanakan!
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal"><i
                        class="fas fa-ban"></i> Batal</button>
                <button type="button" wire:click.prevent="hapus_pilar()" class="btn btn-danger close-modal"
                    data-dismiss="modal"><i class="fas fa-trash"></i> Iya, Hapus</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}
