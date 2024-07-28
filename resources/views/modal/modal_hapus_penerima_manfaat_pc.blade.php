<div wire:ignore.self class="modal fade" id="modal_hapus_penerima_manfaat_pc" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Konfirmasi Hapus</b></h5>

            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus semua data penerima manfaat?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal"><i
                        class="fas fa-ban"></i> Batal</button>
                <button type="button" wire:click.prevent="hapus_penerima_pc()" class="btn btn-danger"
                    data-dismiss="modal"><i class="fas fa-trash"></i> Iya,
                    Hapus</button>
            </div>
        </div>
    </div>
</div>
