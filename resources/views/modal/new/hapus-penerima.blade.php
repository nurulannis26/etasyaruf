{{-- modal  --}}
<div wire:ignore.self class="modal fade" id="hapus-penerima" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Konfirmasi Hapus Penerima Manfaat</b></h5>

            </div>
            <div class="modal-body">
                <p>Yakin Ingin Menghapus Penerima Manfaat?
                </p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" onclick="modalHapus()"
                    data-dismiss="modal"><i class="fas fa-ban"></i> Batal</button>
                <button type="button" wire:click="delete_penerima('{{ $id_pengajuan_penerima }}')"
                    class="btn btn-danger close-modal" onclick="modalHapus()" data-dismiss="modal"><i
                        class="fas fa-trash"></i> Iya,
                    Hapus</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}
