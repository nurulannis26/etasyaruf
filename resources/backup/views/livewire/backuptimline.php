{{-- card timeline --}}
<div class="card ijo-atas">
    <div class="col-12 ">
        <div class="row ">
            {{-- judul --}}
            <div class="col mt-3 ml-3">
                <b><i class="fas fa-tasks"></i>
                    PROGRES PENGAJUAN</b>
            </div>
            {{-- end judul --}}
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            {{-- timeline 1 --}}
            <div class="col p-1">
                <a wire:click="timeline1" class="text-center" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                    <div class=" kartu bg-success text-light">
                        <span class="badge rounded-pill bg-light ">
                            1
                        </span>
                        <p>
                            Data Pengajuan </p>
                    </div>
                </a>
            </div>
            {{-- end timeline 1 --}}
            <b class="mt-2" style="padding-top: 5px;">
                -------
            </b>
            {{-- timeline 2 --}}
            <div class="col p-1">
                <a wire:click="timeline2 " class="text-center  " data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                    <div class=" kartu {{ $color_tm2 }} text-light">
                        <span class="badge rounded-pill bg-light">
                            2
                        </span>
                        <p>
                            Konfirmasi Pengajuan
                        </p>
                    </div>
                </a>
            </div>
            {{-- end timeline 2 --}}
            <b class="mt-2" style="padding-top: 5px;">
                -------
            </b>
            {{-- timeline 3 --}}
            <div class="col p-1">
                <a wire:click="timeline3" class="text-center @if ($color_tm2 == 'bg-warning') noClick @endif " data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                    <div class=" kartu @if ($color_tm2 == 'bg-warning') bg-secondary @else{{ $color_tm3 }} @endif text-light">
                        <span class="badge rounded-pill bg-light">
                            3
                        </span>
                        <p>
                            Rekomendasi</p>
                    </div>
                </a>
            </div>
            {{-- end timeline 3 --}}
            <b class="mt-2" style="padding-top: 5px;">
                -------
            </b>
            {{-- timeline 4 --}}
            <div class="col p-1">
                <a wire:click="timeline4" class="text-center " data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                    <div class=" kartu bg-secondary text-light">
                        <span class="badge rounded-pill bg-light">
                            4
                        </span>
                        <p>
                            Laporan Kegiatan</p>
                    </div>
                </a>
            </div>
            {{-- end timeline 4 --}}
            <b class="mt-2" style="padding-top: 5px;">
                -------
            </b>
            {{-- timeline 5 --}}
            <div class="col p-1">
                <a wire:click="timeline5" class="text-center  " data-toggle="collapse" data-parent="#accordion" aria-expanded="true">
                    <div class=" kartu bg-secondary text-light">
                        <span class="badge rounded-pill bg-light">
                            5
                        </span>
                        <p>
                            Artikel Berita</p>
                    </div>
                </a>
            </div>
            {{-- end timeline 5 --}}
        </div>
        <br>


        <div class="card " style="background-color:#ececec">
            <div class="card-body">
                <b>
                    {{ $judul_tm }}</b>
                <br>
                {{ $baris1_tm }}<br>
                {{ $baris2_tm }}
            </div>
        </div>
    </div>

</div>
{{-- end card timeline --}}