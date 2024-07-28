<div wire:ignore.self class="modal fade" id="edit_berita_pengajuan" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Isi Data Berita Acara
                </h5>
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-4 col-md-12  col-sm-12 ">
                    <ul class="nav nav-tabs mt-4 ml-3 mr-3 mb-3" id="myTab1" role="tablist">
                        <style>
                            div>ul>li>a.active {
                                color: #28a745 !important;
                                font-weight: bold;
                            }

                            div>ul>li>a.active:hover {
                                color: #28a745 !important;
                                font-weight: bold;
                            }

                            div>ul>li>a.nav-link:hover {
                                font-weight: bold;
                            }
                        </style>

                        <li class="nav-item tab-berita1" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary active" id="b1-tab" data-toggle="tab"
                                data-target="#b1" type="button" role="tab" aria-controls="b1"
                                aria-selected="true">1. Detail Penyaluran</a>
                        </li>
                        <li class="nav-item tab-berita2" role="presentation">
                            <a wire:ignore.self class="nav-link text-secondary " id="b2-tab" data-toggle="tab"
                                data-target="#b2" type="button" role="tab" aria-controls="b2"
                                aria-selected="false">2.
                                Uraian Barang</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="myTab1">
                <div wire:ignore.self class="tab-pane fade show active " id="b1" role="tabpanel"
                    aria-labelledby="b1-tab">
                    @include('modal.modal_detail_penyaluran')
                </div>

                <div wire:ignore.self class="tab-pane fade" id="b2" role="tabpanel" aria-labelledby="b2-tab">
                    @include('modal.modal_detail_barang')
                </div>
            </div>
        </div>
    </div>
</div>
