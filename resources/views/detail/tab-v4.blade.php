<style>
    .btn-sinkronisasi {
        position: relative;
        z-index: 1;
        /* Atur tumpukan z untuk tombol */
    }

    .hover-text {
        position: absolute;
        top: 45px;
        /* Atur jarak vertikal dari teks tombol */
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 8px;
        /* Atur lebar dan tinggi hover */
        border-radius: 10px;
        font-size: 15px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
        white-space: nowrap;
        /* Pastikan teks tidak terlalu panjang dan terpotong */
        z-index: 2;
        /* Atur tumpukan z untuk teks hover agar berada di atas tombol */
    }

    .btn-sinkronisasi:hover .hover-text {
        opacity: 1;
        visibility: visible;
    }

    @media (max-width: 576px) {
        .hover-text {
            left: 50%;
            top: 60px;
            /* Atur ulang jarak vertikal dari teks tombol */
            transform: translateX(-50%);
            font-size: 15px;
        }
    }
</style>

{{-- Disetujui oleh Direktur Eksekutif --}}
<div class="card mt-3 ml-2 mr-2">
    <div class="card-body">
        @php
            $dp = App\Models\Pengajuan::where('id_pengajuan', $data_detail->id_pengajuan)->first();
        @endphp
        {{-- <p class="tab-tab-status-detail-pengajuan-umum-pc d-inline">
            @if ($dp->status_pengajuan == 'Direncanakan')
                <sup class="text-light badge badge-warning">Data pengajuan belum selesai </sup>
            @endif

            @if ($dp->status_pengajuan == 'Diajukan')
                <sup class="text-light badge badge-success">Data pengajuan selesai </sup>
            @endif

            @if ($dp->survey_pc == 'Perlu')
                @if ($dp->status_survey == 'Direncanakan')
                    <sup class="text-light badge badge-warning">Survey belum selesai </sup>
                @endif

                @if ($dp->status_survey == 'Diajukan')
                    <sup class="text-light badge badge-success">Survey selesai </sup>
                @endif
            @else
                <sup class="text-light badge badge-secondary">Tanpa Survey </sup>
            @endif

            @if ($data_detail->approval_status == 'Belum Direspon')
                <sup class="text-light badge badge-warning">Menunggu persetujuan KC </sup>
            @elseif($data_detail->approval_status == 'Disetujui')
                <sup class="text-light badge badge-success">Disetujui direktur</sup>
                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                    <sup class="text-light badge badge-warning">Menunggu pencairan keuangan </sup>
                @elseif($data_detail->pencairan_status == 'Berhasil Dicairkan')
                    <sup class="text-light badge badge-success">Disetujui div. keuangan
                    </sup>
                @else
                    <sup class="text-light badge badge-danger">Ditolak div. keuangan
                    </sup>
                @endif
            @elseif($data_detail->approval_status == 'Ditolak')
                <sup class="text-light badge badge-danger">Ditolak/revisi direktur</sup>
            @endif
            <br>

            @if ($data_detail->approval_status == 'Disetujui')

                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Keuangan')
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Berikan respon persetujuan pencairan div. keuangan
                        </span>
                        <div class="spinner-border" role="status" wire:loading>
                          <span class="sr-only">Loading...</span>
                        </div>
                    @else
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Menunggu respon persetujuan div. keuangan
                            ({{ $this->nama_pengurus_pc($data_detail->staf_keuangan_pc) }})
                        </span>
                    @endif
                @elseif($data_detail->pencairan_status == 'Berhasil Dicairkan')
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan != 'Divisi Keuangan')
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Telah disetujui div. keuangan
                            ({{ $this->nama_pengurus_pc($data_detail->staf_keuangan_pc) }})
                        </span>
                    @else
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Berikan respon persetujuan pencairan div. keuangan
                        </span>
                    @endif
                @else
                    <span>
                        <i class="fas fa-info-circle"></i>
                        Tidak bisa dicairkan/ditolak
                    </span>
                @endif
            @else
                <span>
                    <i class="fas fa-info-circle"></i>
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Keuangan')
                        Berikan respon persetujuan pencairan div. keuangan
                    @else
                        Menunggu respon persetujuan div. keuangan (Belum Dipilih Oleh Direktur)
                    @endif
                </span>
            @endif
        </p> --}}


        <p class="tab-tab-status-detail-pengajuan-umum-pc d-inline">
            {{-- START badge --}}

            @if ($dp->status_pengajuan == 'Direncanakan')
                <sup class="text-light badge badge-warning">Pengajuan Blm Selesai Diinput FO</sup>
            @endif

            @if ($dp->status_pengajuan == 'Diajukan')
                <sup class="text-light badge badge-success">Pengajuan Selesai Diinput FO</sup>
            @endif


            @if ($data_detail->approval_status_divpro == 'Disetujui')
                <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
            @else
                <sup class="text-light badge badge-warning">Disposisi Blm Diterima Div. Program
                </sup>
            @endif

            @if ($data_detail->approval_status_divpro == 'Disetujui')
                @if ($data_detail->approval_status == 'Disetujui')
                    <sup class="text-light badge badge-success">Disposisi Disetujui KC</sup>
                @elseif($data_detail->approval_status == 'Ditolak')
                    <sup class="text-light badge badge-danger">Disposisi Ditolak KC
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">Disposisi Blm Disetujui KC
                    </sup>
                @endif
            @endif

            @if ($data_detail->approval_status_divpro == 'Disetujui')
                @if ($data_detail->status_ketua == 'Disetujui')
                    <sup class="text-light badge badge-success">Ketua Mengetahui</sup>
                @elseif($data_detail->respon_ketua != 'Tidak Perlu' and $data_detail->status_ketua == 'Belum Direspon')
                    <sup class="text-light badge badge-warning">Ketua Blm Merespon
                    </sup>
                @elseif ($data_detail->status_ketua == 'Ditolak')
                    <sup class="text-light badge badge-danger">Ditolak Ketua</sup>
                @endif
            @endif

            @if ($data_detail->approval_status_divpro == 'Disetujui')
                @if ($data_detail->respon_ketua == 'Tidak Perlu')
                    <sup class="text-light badge badge-secondary">Tanpa Respon Ketua</sup>
                @else
                @endif
            @endif


            @if ($data_detail->approval_status == 'Disetujui')
                @if ($data_detail->pil_survey == 'Perlu')
                    @if ($dp->status_survey == 'Direncanakan')
                        <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
                    @elseif($dp->status_survey == 'Diajukan')
                        <sup class="text-light badge badge-success">Survey Selesai
                        </sup>
                    @endif
                @elseif($data_detail->pil_survey == 'Tidak Perlu')
                    <sup class="text-light badge badge-secondary">Tanpa Survey
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">Survey Blm Selesai</sup>
                @endif
            @endif

            @if ($data_detail->pil_survey == 'Tidak Perlu')
                @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
                    <sup class="text-light badge badge-success">Pencairan Disetujui KC
                    </sup>
                @elseif ($data_detail->approval_status_pencairan_direktur == 'Ditolak')
                    <sup class="text-light badge badge-danger">Pencairan Ditolak KC
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">Pencairan Blm Disetujui KC
                    </sup>
                @endif
            @elseif($data_detail->pil_survey == 'Perlu' && $dp->status_survey == 'Diajukan')
                @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
                    <sup class="text-light badge badge-success">Pencairan Disetujui KC
                    </sup>
                @elseif ($data_detail->approval_status_pencairan_direktur == 'Ditolak')
                    <sup class="text-light badge badge-danger">Pencairan Ditolak KC
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">Pencairan Blm Disetujui KC
                    </sup>
                @endif
            @endif


            @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui')
                @if ($data_detail->pencairan_status == 'Berhasil Dicairkan')
                    <sup class="text-light badge badge-success">Pencairan Disetujui Div. Keuangan
                    </sup>
                @elseif ($data_detail->pencairan_status == 'Ditolak')
                    <sup class="text-light badge badge-danger">Pencairan Ditolak Div. Keuangan
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">Pencairan Blm Disetujui Div. Keuangan
                    </sup>
                @endif
            @endif
            {{-- {{ dd($data_detail) }} --}}


            @if ($data_detail->approval_status == 'Disetujui')
                @if ($data_detail->berita_konfirmasi_pc)
                    <sup class="text-light badge badge-success">LPJ Dikonfirmasi Div. Penyaluran
                    </sup>
                @else
                    <sup class="text-light badge badge-warning">LPJ Blm Dikonfirmasi Div. Penyaluran
                    </sup>
                @endif


                @if ($data_detail->konfirmasi_lpj_div_prog != 'Dikonfirmasi')
                    <sup class="text-light badge badge-warning">LPJ Blm Diperiksa Div. Program
                    </sup>
                @else
                    <sup class="text-light badge badge-success">LPJ Diperiksa Div. Program
                    </sup>
                @endif
            @endif


            {{-- END badge --}}


            <br>
            {{-- @if ($data_detail->approval_status == 'Disetujui')

                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Keuangan')
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Berikan respon persetujuan pencairan div. keuangan
                        </span>
                    @else
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Menunggu respon persetujuan div. keuangan
                            ({{ $this->nama_pengurus_pc($data_detail->staf_keuangan_pc) }})
                        </span>
                    @endif
                @elseif($data_detail->pencairan_status == 'Berhasil Dicairkan')
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan != 'Divisi Keuangan')
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Telah disetujui div. keuangan
                            ({{ $this->nama_pengurus_pc($data_detail->staf_keuangan_pc) }})
                        </span>
                    @else
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Berikan respon persetujuan pencairan div. keuangan
                        </span>
                    @endif
                @else
                    <span>
                        <i class="fas fa-info-circle"></i>
                        Tidak bisa dicairkan/ditolak
                    </span>
                @endif
            @else
                <span>
                    <i class="fas fa-info-circle"></i>
                    @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Keuangan')
                        Berikan respon persetujuan pencairan div. keuangan
                    @else
                        Menunggu respon persetujuan div. keuangan (Belum Dipilih Oleh KC)
                    @endif
                </span>
            @endif --}}

            <span>
                <i class="fas fa-info-circle"></i>
                @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Kepala Cabang')
                    Berikan persetujuan pencairan Kepala Cabang
                @elseif(Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Keuangan')
                    Berikan persetujuan pencairan Div. Keuangan
                @else
                    Persetujuan pencairan dana oleh Kepala Cabang & Div.Keuangan
                @endif
            </span>

        </p>


    </div>
</div>
<div class="row ml-2 mr-2">


    <div class="d-flex float-left" style="margin-bottom: 10px; margin-top: 0px; ">
        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
        <svg height="35px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <title>file_type_pdf2</title>
            <path d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072" style="fill:#909090" />
            <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2" style="fill:#f4f4f4" />
            <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655" style="fill:#7a7b7c" />
            <path d="M22.472,10.211H2.395V3.379H22.472v6.832" style="fill:#dd2025" />
            <path
                d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                style="fill:#464648" />
            <path
                d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                style="fill:#464648" />
            <path d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538" style="fill:#464648" />
            <path
                d="M21.781,20.255s3.188-.578,3.188.511S22.994,21.412,21.781,20.255Zm-2.357.083a7.543,7.543,0,0,0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216,14.216,0,0,0,1.658,2.252,13.033,13.033,0,0,0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787,10.787,0,0,1-.517,2.434A4.426,4.426,0,0,1,18.161,13.841ZM13.513,24.354c-.978-.585,2.051-2.386,2.6-2.444C16.11,21.911,14.537,24.966,13.513,24.354ZM25.9,20.895c-.01-.1-.1-1.207-2.07-1.16a14.228,14.228,0,0,0-2.453.173,12.542,12.542,0,0,1-2.012-2.655,11.76,11.76,0,0,0,.623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933,2.013a9.309,9.309,0,0,0,.665,2.338s-.425,1.323-.987,2.639-.946,2.006-.946,2.006a9.622,9.622,0,0,0-2.725,1.4c-.824.767-1.159,1.356-.725,1.945.374.508,1.683.623,2.853-.91a22.549,22.549,0,0,0,1.7-2.492s1.784-.489,2.339-.623,1.226-.24,1.226-.24,1.629,1.639,3.2,1.581,1.495-.939,1.485-1.035"
                style="fill:#dd2025" />
            <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z" style="fill:#909090" />
            <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
            <path
                d="M8.975,4.457h-.03l-.207,0H7.668v4.8H8.7V7.639l.228.013a2.042,2.042,0,0,0,.647-.117,1.428,1.428,0,0,0,.493-.291A1.224,1.224,0,0,0,10.4,6.79a2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65,2.149,2.149,0,0,0-.411-.105,2.232,2.232,0,0,0-.319-.026M8.785,6.751l-.089,0V5.271H8.89a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                style="fill:#fff" />
            <path
                d="M12.456,4.444c-.111,0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.315h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                style="fill:#fff" />
            <path d="M17.353,4.461h-2.43v4.8h1.028V7.357h1.3V6.465h-1.3V5.353h1.4V4.461" style="fill:#fff" />
        </svg> <a href="{{ route('print_penyaluran_dana', ['id_pengajuan' => $data_detail->id_pengajuan]) }}"
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Lembar Disposisi Penyaluran.pdf</a>


    </div>

    <div class="d-flex float-left" style="margin-bottom: 10px; margin-top: 0px; margin-left: 10px;">
        <?xml version="1.0" encoding="utf-8"?><!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
        <svg height="35px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <title>file_type_pdf2</title>
            <path d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072" style="fill:#909090" />
            <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2" style="fill:#f4f4f4" />
            <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655" style="fill:#7a7b7c" />
            <path d="M22.472,10.211H2.395V3.379H22.472v6.832" style="fill:#dd2025" />
            <path
                d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                style="fill:#464648" />
            <path
                d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                style="fill:#464648" />
            <path d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538" style="fill:#464648" />
            <path
                d="M21.781,20.255s3.188-.578,3.188.511S22.994,21.412,21.781,20.255Zm-2.357.083a7.543,7.543,0,0,0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216,14.216,0,0,0,1.658,2.252,13.033,13.033,0,0,0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787,10.787,0,0,1-.517,2.434A4.426,4.426,0,0,1,18.161,13.841ZM13.513,24.354c-.978-.585,2.051-2.386,2.6-2.444C16.11,21.911,14.537,24.966,13.513,24.354ZM25.9,20.895c-.01-.1-.1-1.207-2.07-1.16a14.228,14.228,0,0,0-2.453.173,12.542,12.542,0,0,1-2.012-2.655,11.76,11.76,0,0,0,.623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933,2.013a9.309,9.309,0,0,0,.665,2.338s-.425,1.323-.987,2.639-.946,2.006-.946,2.006a9.622,9.622,0,0,0-2.725,1.4c-.824.767-1.159,1.356-.725,1.945.374.508,1.683.623,2.853-.91a22.549,22.549,0,0,0,1.7-2.492s1.784-.489,2.339-.623,1.226-.24,1.226-.24,1.629,1.639,3.2,1.581,1.495-.939,1.485-1.035"
                style="fill:#dd2025" />
            <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z" style="fill:#909090" />
            <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
            <path
                d="M8.975,4.457h-.03l-.207,0H7.668v4.8H8.7V7.639l.228.013a2.042,2.042,0,0,0,.647-.117,1.428,1.428,0,0,0,.493-.291A1.224,1.224,0,0,0,10.4,6.79a2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65,2.149,2.149,0,0,0-.411-.105,2.232,2.232,0,0,0-.319-.026M8.785,6.751l-.089,0V5.271H8.89a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                style="fill:#fff" />
            <path
                d="M12.456,4.444c-.111,0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.315h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                style="fill:#fff" />
            <path d="M17.353,4.461h-2.43v4.8h1.028V7.357h1.3V6.465h-1.3V5.353h1.4V4.461" style="fill:#fff" />
        </svg> <a href="{{ route('print_pencairan_dana', ['id_pengajuan' => $data_detail->id_pengajuan]) }}"
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Lembar Pencairan.pdf</a>

    </div>
</div>
{{-- end Disetujui oleh Direktur Eksekutif --}}
{{-- alert --}}


{{-- alert --}}

{{-- @if ($id_rekening != null)
    @if (str_replace('.', '', $nominal_disetujui) > str_replace('.', '', $saldo))
        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
            <i class="fas fa-minus-circle"></i>
            Saldo Tidak Cukup!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endif

@if (str_replace('.', '', $satuan_disetujui) > str_replace('.', '', $satuan_pengajuan))
    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
        <i class="fas fa-minus-circle"></i>
        Nominal disetujui melebihi nominal pengajuan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif --}}


{{-- end alert --}}




{{-- alert --}}
@if (session()->has('alert_keuangan'))
    <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="far fa-check-circle"></i>
        {{ session('alert_keuangan') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



@if (
    $this->metode_pencairan != null &&
        $this->sumber_dana_opsi_keuangan == 'Dana Zakat' &&
        $data_detail->id_asnaf == null)
    <div class="alert alert-danger alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
        <i class="fas fa-times-circle"></i> Asnaf masih kosong! Silahkan ACC ulang pencairan Kepala Cabang dan pilih
        asnaf jika belum.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


<div class="row">


    {{-- end alert --}}
    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
        {{-- card acc --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_acc_direktur_keuangan }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-success">ACC PENCAIRAN KEPALA CABANG</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>



            {{-- form --}}
            <form wire:submit.prevent="acc_direktur_keuangan">
                <div class="form-row mt-4">

                    {{-- <div class="form-group col-md-7">
                    <label for="inputNama">YANG MENYETUJUI &nbsp;</label>
                    <input type="input" class="form-control"
                        value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                        readonly>
                </div>

                <div class="form-group col-md-5">
                    <label for="inputNama">TGL DISETUJUI &nbsp;</label>
                    <input wire:model="approval_date" type="date" class="form-control" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">PJ PENCAIRAN DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">
                        <option value="">Pilih Staf Keuangan</option>
                        @foreach ($pengurus_keuangan as $b)
                            <option value="{{ $b->id_pc_pengurus }}">
                                {{ $b->nama . ' - ' . $b->jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group col-md-6">
                    <label for="inputNama">REKENING SUMBER DANA &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <select wire:model="id_rekening" class="form-control">
                        <option value="">Pilih Rekening</option>
                        @foreach ($rekening as $a)
                            <option value="{{ $a->id_rekening }}">
                                {{ $a->nama_rekening }} -
                                {{ $a->no_rekening }}
                                - Rp{{ number_format($a->saldo, 0, '.', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DIAJUKAN (SATUAN) &nbsp;</label>
                    <input wire:model="satuan_pengajuan" type="input" class="form-control"
                        placeholder="Masukan Nominal Satuan Disetujui" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNama">NOMINAL DISETUJUI (SATUAN) &nbsp;</label>
                    <sup class="badge badge-danger text-white mb-2"
                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                    <input wire:model="satuan_disetujui" type="input" class="form-control " id="satuan_disetujui"
                        placeholder="Masukan Nominal Satuan Disetujui">
                </div>

                <div class="form-group col-md-12">
                    <label for="inputNama">NOMINAL DISETUJUI (TOTAL) (Rp{{ $satuan_disetujui }} x
                        {{ $data_detail->jumlah_penerima }}
                        Penerima Manfaat)</label>
                    <input wire:model="nominal_disetujui" type="input" class="form-control text-bold" readonly
                        id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                </div>
            --}}




                    {{-- Direktur --}}
                    <div class="form-group col-md-6">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end direktur --}}


                    {{-- tgl disetujui --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Disetujui</span>
                            </div>
                            <input wire:model="approval_date_pencairan_direktur" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl disetujui direktur --}}

                    {{-- Pj Pencairan Dana direktur --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">PJ
                                    Pencairan
                                    Dana</span>
                            </div>
                            <select wire:model="staf_keuangan" wire:loading.attr="disabled" class="form-control">

                                @foreach ($pengurus_keuangan as $b)
                                    <option value="{{ $b->id_pc_pengurus }}">
                                        {{ $b->nama . ' - ' . $b->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    {{-- end Pj Pencairan Dana direktur --}}


                    {{-- Pj Pencairan Dana direktur --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Sumber
                                    Dana</span>
                            </div>
                            <select wire:model="sumber_dana_opsi" wire:loading.attr="disabled" class="form-control">
                                <option value="" selected>Pilih Sumber Dana</option>
                                <option value="Dana Zakat">Dana Zakat</option>
                                <option value="Dana Infak Umum">Dana Infak Umum</option>
                                <option value="Dana Infak Terikat">Dana Infak Terikat</option>
                                <!--<option value="Lainnya">Lainnya</option>-->


                            </select>
                        </div>

                    </div>
                    {{-- end Pj Pencairan Dana direktur --}}

                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Asnaf</span>
                            </div>
                            <select wire:model="id_asnaf_d" class="select2dulus form-control ">
                                <option value="">Pilih Asnaf</option>
                                @php
                                    $asnaf_get_edit = DB::table('asnaf')->get();
                                @endphp
                                @foreach ($asnaf_get_edit as $as)
                                    <option value="{{ $as->id_asnaf }}">{{ $as->nama_asnaf }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    {{-- {{ dd($this->id_program_kegiatan_d) }} --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Pilar</span>
                            </div>
                            <select wire:model="id_pilar_d" class="select2dulus form-control ">
                                <option value="">Pilih Pilar</option>
                                @php
                                    $pilar_get_edit = DB::table('program_pilar')->orderBy('pilar', 'ASC')->get();
                                @endphp
                                @foreach ($pilar_get_edit as $as)
                                    <option value="{{ $as->id_program_pilar }}">{{ $as->pilar }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <select wire:model="id_program_kegiatan_d" class="form-control"
                                data-placeholder="Pilih Pilar Terlebih Dahulu" id="inptKegiatan">
                                @php
                                    $daftar_kegiatan_edit = App\Models\ProgramKegiatan::where(
                                        'id_program_pilar',
                                        $this->id_pilar_d,
                                    )
                                        ->whereRaw('LENGTH(no_urut) = 3')
                                        ->orderBy('no_urut', 'ASC')
                                        ->get();

                                    $daftar_kegiatan2_edit = App\Models\ProgramKegiatan::where(
                                        'id_program_pilar',
                                        $this->id_pilar_d,
                                    )
                                        ->whereRaw('LENGTH(no_urut) = 4')
                                        ->orderBy('no_urut', 'ASC')
                                        ->get();
                                @endphp
                                @if ($this->id_pilar_d == '')
                                    <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                                @else
                                    @foreach ($daftar_kegiatan_edit as $aa)
                                        <option value="{{ $aa->id_program_kegiatan }}">{{ $aa->no_urut }}
                                            {{ $aa->nama_program }}</option>
                                    @endforeach
                                    @foreach ($daftar_kegiatan2_edit as $bb)
                                        <option value="{{ $bb->id_program_kegiatan }}">{{ $bb->no_urut }}
                                            {{ $bb->nama_program }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    {{-- sumber dana direktur --}}
                    <!--<div class="form-group col-md-12">-->
                    <!--    <div class="input-group" wire:ignore>-->
                    <!--        <select wire:model="id_rekening" class="form-control" id="inptKabupaten2">-->
                    <!--            <option value="">Rekening Sumber Dana </option>-->
                    <!--            @foreach ($rekening_direktur as $a)
-->
                    <!--                <option value="{{ $a->id_rekening ?? '' }}">-->
                    <!--                    {{ $a->nama_rekening ?? '' }} --->
                    <!--                    {{ $a->no_rekening ?? '' }}-->
                    <!--                    - Rp{{ number_format($a->saldo, 0, '.', '.') }}-->
                    <!--                </option>-->
                    <!--
@endforeach-->
                    <!--        </select>-->
                    <!--    </div>-->

                    <!--</div>-->

                    {{-- end sumber dana --}}


                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">&nbsp;&nbsp;&nbsp;Rekening
                                    Sumber
                                    Dana&nbsp;&nbsp;&nbsp;&nbsp;
                                </span>
                            </div>
                            <select wire:model="id_rekening" class="form-control">
                                <option value="">Pilih Rekening</option>
                                @foreach ($rekening as $a)
                                    <option value="{{ $a->id_rekening }}">

                                        {{ $a->no_rekening }} -
                                        {{ $a->nama_rekening }} -
                                        Rp{{ number_format($a->saldo, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>




                        </div>
                    </div> --}}
                    {{-- <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp </span>
                        </div>
                        <input wire:model="saldo" type="text" class="form-control" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">Saldo </span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nama BMT</span>
                        </div>
                        <input wire:model="nama_bmt" type="text" class="form-control" readonly>
                    </div>
                </div> --}}


                    {{-- satuan pengajuan --}}
                    {{-- <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nominal
                                    Diajukan (Satuan)</span>
                            </div>
                            <input wire:model="satuan_pengajuan" type="input" class="form-control"
                                placeholder="Masukan Nominal Satuan Disetujui" readonly>

                        </div>
                    </div> --}}
                    {{-- end satuan pengajuan direktur --}}

                    {{-- satuan disetujui direktur --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Nominal
                                    Disetujui (Satuan)</span>
                            </div>
                            <input wire:model="satuan_disetujui" type="input" class="form-control "
                                id="satuan_disetujui" placeholder="Masukan Nominal Satuan Disetujui">

                        </div>
                    </div>
                    {{-- end satuan disetujui direktur --}}





                    {{-- nominal disetujui direktur --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Nominal
                                    Disetujui
                                    (Total)</span>
                            </div>
                            <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                                disabled id="nominal_disetujui" placeholder="Masukan Nominal Satuan Disetujui">
                            <div class="input-group-append">
                                <span class="input-group-text">(Rp{{ $satuan_disetujui }} x
                                    {{ $data_detail->jumlah_penerima }}
                                    Penerima) </span>
                            </div>
                        </div>
                    </div>
                    {{-- end satuan disetujui --}}




                    {{-- nominal disetujui --}}
                    {{-- <div class="form-group col-md-10">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-bold">Rp</span>
                        </div>
                        <input wire:model="nominal_disetujui" type="input" class="form-control text-bold"
                            placeholder="Nominal disetujui" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text ">Nominal
                                Disetujui (Rp{{ $satuan_disetujui }} x {{ $data_detail->jumlah_penerima }}
                                Penerima
                                Manfaat)</span>
                        </div>
                    </div>

                </div> --}}
                    {{-- end nominal disetujui --}}

                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
                            </div>
                            <input wire:model="keterangan_acc_pencairan_direktur" type="input"
                                class="form-control " id="keterangan_acc_pencairan_direktur"
                                placeholder="Masukan Keterangan ACC">

                        </div>
                    </div>


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol ACC, Kepala Cabang memberikan persetujuan untuk dilakukan pencairan
                                dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol acc --}}
                    <div class="form-group col-md-3">
                        @if ($sumber_dana_opsi == 'Dana Zakat')
                            @if (
                                $staf_keuangan == '' or
                                    $satuan_disetujui == '' or
                                    $keterangan_acc_pencairan_direktur == '' or
                                    $sumber_dana_opsi == '' or
                                    $id_asnaf_d == '')
                                <button class="btn btn-success btn-block btn-sinkronisasi" disabled
                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                    ACC<span class="hover-text">Jika Sumber Dana adalah Dana Zakat
                                        <br>maka Asnaf wajib diisi.
                                    </span></button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success btn-block "
                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                    ACC
                                </button>
                            @endif
                        @else
                            @if (
                                $staf_keuangan == '' or
                                    $satuan_disetujui == '' or
                                    $keterangan_acc_pencairan_direktur == '' or
                                    $sumber_dana_opsi == '')
                                <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                        class="fas fa-check-circle"></i>
                                    ACC</button>
                            @else
                                <button type="submit" name="submit" class="btn btn-success btn-block"
                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                    ACC</button>
                            @endif
                        @endif
                    </div>
                    {{-- acc --}}

                </div>
            </form>

        </div>
        {{-- end card acc --}}

        {{-- card tolak --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_tolak_direktur_keuangan }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-danger">TOLAK PENCAIRAN KEPALA CABANG</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <form wire:submit.prevent="tolak_direktur_keuangan">

                <div class="form-row mt-4">

                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end rekening --}}

                    {{-- tgl penolakan --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Penolakan</span>
                            </div>
                            <input wire:model="denial_date_pencairan_direktur" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl penolakan --}}


                    {{-- denial note --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Alasan</span>
                            </div>
                            <input wire:model="denial_note_pencairan_direktur" type="input" class="form-control"
                                placeholder="Masukan Alasan Penolakan">
                        </div>
                    </div>
                    {{-- end denial note --}}


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol tolak, Kepala Cabang memberikan penolakan untuk dilakukan pencairan
                                dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol tolak --}}
                    <div class="form-group col-md-3">
                        @if ($denial_note_pencairan_direktur == '')
                            <button class="btn btn-danger btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-danger btn-block"
                                wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @endif
                    </div>
                    {{-- tolak --}}


                </div>
            </form>
        </div>
        {{-- end card tolak --}}
    @endif


    {{-- end alert --}}
    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3')

        {{-- card pencairan --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_acc }};">

            <div class="d-flex justify-content-between align-items-center">
                <b class="text-success">ACC PENCAIRAN DIV. KEUANGAN</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            {{-- alert --}}
            {{-- @if ($id_rekening2 != null)
             @if (str_replace('.', '', $total_pencairan) > str_replace('.', '', $saldo))
                 <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                     <i class="fas fa-minus-circle"></i>
                     Saldo Tidak Cukup!
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
             @endif
         @endif --}}
            {{-- @if (str_replace('.', '', $satuan_disetujui2) > str_replace('.', '', $data_detail->satuan_pengajuan))
             <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                 <i class="fas fa-minus-circle"></i>
                 Nominal pencairan melebihi nominal yang pengajuan
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
         @endif --}}
            {{-- end alert --}}


            {{-- form --}}
            <form wire:submit.prevent="pencairan">
                <div class="form-row mt-4">

                    {{-- tgl_pencairan keuangan --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Dicairkan</span>
                            </div>

                            <input wire:model="tgl_pencairan" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl_pencairan keuangan --}}

                    {{-- Pj Pencairan Dana keunagan --}}
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bor-abu"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Sumber
                                    Dana</span>
                            </div>
                            <select wire:model="sumber_dana_opsi_keuangan" wire:loading.attr="disabled"
                                class="form-control">
                                <option value="" selected>Pilih Sumber Dana</option>
                                <option value="Dana Zakat">Dana Zakat</option>
                                <option value="Dana Infak Umum">Dana Infak Umum</option>
                                <option value="Dana Infak Terikat">Dana Infak Terikat</option>


                            </select>
                        </div>

                    </div>
                    {{-- end Pj Pencairan Dana direktur --}}

                    {{-- satuan disetujui keuangan --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Nominal
                                    Disetujui (Satuan)</span>
                            </div>
                            <input wire:model="satuan_disetujui2" type="input" class="form-control "
                                id="satuan_disetujui2" placeholder="Masukan Nominal Satuan Disetujui">

                        </div>
                    </div>
                    {{-- end satuan disetujui keuangan --}}


                    {{-- nominal disetujui keuangan --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Nominal
                                    Pencairan (Total)</span>
                            </div>
                            <input wire:model="nominal_disetujui2" type="input" class="form-control text-bold"
                                disabled id="nominal_disetujui2" placeholder="Masukan Nominal Satuan Disetujui">
                            <div class="input-group-append">
                                <span class="input-group-text">(Rp{{ $satuan_disetujui2 }} x
                                    {{ $data_detail->jumlah_penerima }}
                                    Penerima) </span>
                            </div>
                        </div>
                    </div>
                    {{-- end satuan disetujui keuangan --}}


                    <div class="form-group @if ($this->metode_pencairan == 'Transfer' or $this->metode_pencairan == 'Langsung') col-md-6 @else col-md-12 @endif">
                        <div class="input-group" wire:ignore>

                            <select wire:model="metode_pencairan" class="form-control">
                                <option value="" selected>Pilih Metode Pencairan</option>
                                <option value="Langsung">Cash</option>
                                <option value="Transfer">Transfer</option>
                            </select>

                        </div>

                    </div>

                    {{-- sumber dana keuangan --}}
                    <div class="form-group @if ($this->metode_pencairan == 'Transfer' or $this->metode_pencairan == 'Langsung') col-md-6 @else d-none @endif">
                        <div class="input-group">
                            <select wire:model="id_rekening2" class="form-control" id="inptKabupaten">
                                <option value="" selected>Pilih rekening</option>
                                @foreach ($rekeningKeuanganList as $ab)
                                    <option value="{{ $ab->id_rekening ?? '' }}">
                                        {{ $ab->nama_rekening ?? '' }} -
                                        {{ $ab->no_rekening ?? '' }} -
                                        Rp{{ number_format($ab->saldo ?? 0, 0, '.', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- end sumber dana keuangan --}}

                    @if ($this->metode_pencairan == 'Transfer')
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        style="width: 200px; display: flex; justify-content: center; align-items: center;">Nomor
                                        Rekening</span>
                                </div>

                                <input wire:model="no_rek_penerima" type="text" class="form-control"
                                    placeholder="Masukan nomor rekening">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        style="width: 200px; display: flex; justify-content: center; align-items: center;">Nama
                                        Bank</span>
                                </div>

                                <input wire:model="nama_bank_penerima" type="text" class="form-control"
                                    placeholder="Masukan nama bank">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        style="width: 200px; display: flex; justify-content: center; align-items: center;">Atas
                                        Nama</span>
                                </div>

                                <input wire:model="atas_nama_penerima" type="text" class="form-control"
                                    placeholder="Masukan atas nama">
                            </div>
                        </div>
                    @endif

                    {{-- keterangan keuangan --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Keterangan</span>
                            </div>
                            <input wire:model="keterangan_pencairan" type="input" class="form-control "
                                placeholder="Masukan keterangan">




                        </div>
                    </div>
                    {{-- end keterangan keuangan --}}



                    {{-- kwitansi keuangan --}}
                    {{-- <div class="form-group col-md-12">
                 <div class="input-group">
                     <div class="input-group-prepend">
                         <span class="input-group-text bor-abu">Nota</span>
                     </div>
                     <div class="custom-file custom-file-kwitansi">
                         <input type="file" wire:model="kwitansi" accept="image/png, image/jpg, image/jpeg"
                             class="custom-file-input" id="file" name="file">
                         <label class="custom-file-label" for="customFile">Pilih
                             file kwitansi (PDF/PNG/JPG/JPEG)</label>
                     </div>
                 </div>
             </div> keuangan --}}
                    {{-- end kwitansi keuangan --}}

                    {{-- info keuangan --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol Cairkan, divisi keuangan memberikan konfirmasi pencairan dana &
                                mutasi
                                pada rekening terpilih
                            </span>
                        </div>
                    </div>
                    {{-- end info keuangan --}}

                    <div class="form-group col-md-9">
                    </div>
                    {{-- tombol acc --}}
                    <div class="form-group col-md-3">
                        @if ($this->sumber_dana_opsi_keuangan == 'Dana Zakat' && $data_detail->id_asnaf == null)
                            <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-check-circle"></i>
                                Cairkan</button>
                        @endif
                        @if ($this->metode_pencairan == 'Transfer')
                            @if ($id_rekening2 && $this->metode_pencairan && $this->tgl_pencairan != null)
                                <button type="submit" name="submit" class="btn btn-success btn-block tombol-cair"
                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                    Cairkan</button>
                            @else
                                <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                        class="fas fa-check-circle"></i>
                                    Cairkan</button>
                            @endif
                        @elseif ($this->metode_pencairan == 'Langsung' && $this->tgl_pencairan != null && $id_rekening2 != '')
                            <button type="submit" name="submit" class="btn btn-success btn-block tombol-cair"
                                wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                Cairkan</button>
                        @else
                            <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-check-circle"></i>
                                Cairkan</button>

                        @endif
                    </div>
                    {{-- acc --}}


                </div>
            </form>

        </div>
        {{-- end card pencairan --}}

        {{-- card tolak --}}
        <div class="card card-body mt-3 mr-2 ml-2" style="display: {{ $none_block_tolak }};">
            <div class="d-flex justify-content-between align-items-center">
                <b class="text-danger">TOLAK PENCAIRAN</b>
                <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>

            <form wire:submit.prevent="tolak_pencairan">

                <div class="form-row mt-4">

                    {{-- Direktur --}}
                    <div class="form-group col-md-7">
                        <input type="input" class="form-control"
                            value="{{ Auth::user()->PcPengurus->JabatanPengurus->jabatan }} - {{ Auth::user()->nama }}"
                            readonly>
                    </div>
                    {{-- end rekening --}}

                    {{-- tgl penolakan --}}
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Tgl
                                    Penolakan</span>
                            </div>
                            <input wire:model="tgl_tolak_pencairan" type="date" class="form-control">
                        </div>
                    </div>
                    {{-- end tgl penolakan --}}


                    {{-- denial note --}}
                    <div class="form-group col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"
                                    style="width: 200px; display: flex; justify-content: center; align-items: center;">Alasan</span>
                            </div>
                            <input wire:model="keterangan_tolak_pencairan" type="input" class="form-control"
                                placeholder="Masukan Alasan Penolakan">
                        </div>
                    </div>
                    {{-- end denial note --}}


                    {{-- info --}}
                    <div class="form-group col-md-12">
                        <div class="card card-body " style="background-color:#e0e0e0;">
                            <b>INFORMASI!</b>
                            <span>
                                Dengan klik tombol tolak, Kepala Cabang memberikan penolakan untuk dilakukan pencairan
                                dana
                                oleh
                                divisi keuangan
                            </span>
                        </div>
                    </div>
                    {{-- end info --}}

                    <div class="form-group col-md-9">
                    </div>

                    {{-- tombol tolak --}}
                    <div class="form-group col-md-3">
                        @if ($tgl_tolak_pencairan == '')
                            <button class="btn btn-danger btn-block" disabled wire:loading.attr="disabled"><i
                                    class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @else
                            <button type="submit" name="submit" class="btn btn-danger btn-block"
                                wire:loading.attr="disabled"><i class="fas fa-minus-circle"></i>
                                Tolak</button>
                        @endif
                    </div>
                    {{-- tolak --}}


                </div>
            </form>
        </div>
        {{-- end card tolak --}}

    @endif




    <div class="col-sm-6 col-md-6 col-lg-6 tab-persetujuan_direktur-detail-umum-pc">
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                <b> A. PERSETUJUAN KEPALA CABANG</b>
            </div>

            @if (Auth::user()->gocap_id_pc_pengurus != null)
                {{-- {{ $data_detail->approval_status. $data_detail->pil_survey. $data_detail->approval_status_pencairan_direktur }} --}}
                @if (
                    ($data_detail->approval_status == 'Disetujui' && $dp->status_survey == 'Diajukan') ||
                        ($data_detail->approval_status == 'Disetujui' && $data_detail->pil_survey == 'Tidak Perlu'))
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and
                            $data_detail->approval_status == 'Disetujui')
                        @if ($data_detail->status_ketua != null and $data_detail->status_ketua != 'Ditolak')
                            <!--<div class="ml-2" style="padding-left: 250px;">-->
                            <div class="btn-group">
                                <div class="btn-group float-right">

                                    <button type="button" class="btn" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        style="background-color: #cccccc">Respon</button>
                                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        style="background-color: #cccccc">
                                        <span class="sr-only">Toggle
                                            Dropdown</span>
                                    </button>

                                    <div class="dropdown-menu ">
                                        <a wire:click="tombol_acc_direktur_keuangan"
                                            onMouseOver="this.style.color='green'"
                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                            data-toggle="modal" data-target="#modal_acc" type="button"><i
                                                class="fas fa-user-check"></i>
                                            @if (
                                                $data_detail->approval_status_pencairan_direktur == 'Disetujui' &&
                                                    $data_detail->pencairan_status == 'Belum Dicairkan' or
                                                    $data_detail->approval_status_pencairan_direktur == 'Ditolak')
                                                ACC Ulang
                                            @elseif ($data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan')
                                                ACC
                                            @endif
                                        </a>
                                        <a wire:click="tombol_tolak_direktur_keuangan"
                                            onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item" data-toggle="modal" data-target="#modal_tolak"
                                            type="button"><i class="fas fa-ban"></i>
                                            Tolak</a>
                                    </div>
                                </div>

                            </div>
                        @endif

                    @endif
                @endif
            @endif

            {{-- @if (Auth::user()->gocap_id_pc_pengurus != null)
            @if ($this->cek_survey($id_pengajuan) == 'Perlu')

                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and $data_detail->approval_status == 'Belum Direspon' and $survey != null)
                    <div class="mr-2">
                        <div class="btn-group float-right">

                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="background-color: #cccccc">Respon</button>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #cccccc">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>

                            <div class="dropdown-menu ">
                                <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                    @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan' or $data_detail->approval_status_pencairan_direktur == 'Ditolak')
                                            ACC Ulang
                                        @elseif ($data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan')
                                            ACC
                                        @endif
                                </a>
                                <a wire:click="tombol_tolak" onMouseOver="this.style.color='red'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_tolak" type="button"><i class="fas fa-ban"></i>
                                    Tolak</a>
                            </div>
                        </div>

                    </div>
                @else
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and $data_detail->approval_status != 'Disetujui')
                        <button type="button" class="btn btn-secondary mr-2" data-toggle="tooltip"
                            data-placement="bottom" disabled
                            title="Persetujuan Kepala Cabang dapat diakses ketika survey sudah disetujui">
                            Respon </button>
                    @endif
                @endif
            @else
                @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and $data_detail->approval_status == 'Belum Direspon')
                    <div class="mr-2">
                        <div class="btn-group float-right">

                            <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="background-color: #cccccc">Respon</button>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #cccccc">
                                <span class="sr-only">Toggle
                                    Dropdown</span>
                            </button>

                            <div class="dropdown-menu ">
                                <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                    @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan' or $data_detail->approval_status_pencairan_direktur == 'Ditolak')
                                            ACC Ulang
                                        @elseif ($data_detail->approval_status == 'Disetujui' && $data_detail->pencairan_status == 'Belum Dicairkan')
                                            ACC
                                        @endif
                                </a>
                                <a wire:click="tombol_tolak" onMouseOver="this.style.color='red'"
                                    onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                    data-target="#modal_tolak" type="button"><i class="fas fa-ban"></i>
                                    Tolak</a>
                            </div>
                        </div>

                    </div>
                @else
                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3' and $data_detail->approval_status != 'Disetujui')
                        <button type="button" class="btn btn-secondary mr-2" data-toggle="tooltip"
                            data-placement="bottom" disabled>
                            Respon </button>
                    @endif
                @endif
            @endif
        @endif --}}
        </div>
        {{-- end judul --}}




        {{-- tabel --}}
        <div class="col-12 mt-2">
            {{-- tabel --}}
            <table class="table table-bordered mt-2">
                <thead>

                    {{-- @if ($data_detail->approval_status_pencairan_direktur == 'Disetujui' or $data_detail->approval_status == 'Belum Direspon') --}}
                    {{-- tanggal disetujui --}}
                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Tgl
                            Disetujui
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->approval_date_pencairan_direktur == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data_detail->approval_date_pencairan_direktur)->isoFormat('dddd, D MMMM Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Nominal Disetujui
                        </td>
                        <td>
                            @if ($data_detail->nominal_disetujui_pencairan_direktur == null)
                                Rp0,-
                            @else
                                <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_disetujui_pencairan_direktur, 0, '.', '.') }},-
                                </b>
                                ({{ $data_detail->jumlah_penerima }} x
                                Rp{{ number_format($data_detail->satuan_disetujui_pencairan_direktur, 0, '.', '.') }})
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <td> <b style="font-size: 12pt;">Sumber Dana</b></td>
                        <td>{{ $data_detail->sumber_dana_opsi ?? '-' }}</td>
                    </tr>


                    <tr>
                        <td class="text-bold">Pilar
                        </td>
                        <td>
                            <b style="font-size: 12pt;">
                                {{ $this->nama_pilar($data_detail->id_program_pilar) ?? '-' }}
                            </b> <br>
                            {{ $this->nama_kegiatan($data_detail->id_program_kegiatan) ?? '-' }}


                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Asnaf
                        </td>
                        <td>
                            {{ $asnaf ?? '-' }}


                        </td>
                    </tr>


                    <tr>
                        <td class="text-bold">Keterangan
                        </td>
                        <td>
                            {{ $data_detail->keterangan_acc_pencairan_direktur ?? '-' }}


                        </td>
                    </tr>


                    {{-- {{dd($data_detail)}} --}}
                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Disetujui Oleh
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->approval_pencairan_direktur_id == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data_detail->approval_pencairan_direktur_id) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->approval_pencairan_direktur_id) }})</span>
                            @endif
                        </td>
                    </tr>

                    {{-- @endif --}}

                    @if ($data_detail->approval_status_pencairan_direktur == 'Ditolak')
                        <tr>
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Tgl Ditolak
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($data_detail->denial_date_pencairan_direktur == null)
                                    -
                                @else
                                    {{ Carbon\Carbon::parse($data_detail->denial_date_pencairan_direktur)->isoFormat('dddd, D MMMM Y') }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Ditolak Oleh
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($data_detail->denial_pencairan_direktur_id == null)
                                    -
                                @else
                                    {{ $this->nama_pengurus_pc($data_detail->denial_pencairan_direktur_id) }}
                                    <br>
                                    <span
                                        style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->denial_pencairan_direktur_id) }})</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-bold" style="width: 30%;vertical-align: middle;">
                                Alasan Penolakan
                            </td>
                            <td style="vertical-align: middle;">
                                @if ($data_detail->denial_note_pencairan_direktur == null)
                                    -
                                @else
                                    {{ $data_detail->denial_note_pencairan_direktur }}
                                @endif
                            </td>
                        </tr>
                    @endif




                </thead>
            </table>
            {{-- end tabel --}}


        </div>

    </div>

    <div class=" col-sm-6 col-md-6 col-lg-6 tab-keuangan-detail-umum-pc mt-2">
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                <b> B. PENCAIRAN KEUANGAN</b>
                {{-- <p class="tab-keuangan-status-detail-umum-pc d-inline">
                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                    <sup
                        class="badge badge-danger text-white bg-warning mb-2">{{ $data_detail->pencairan_status }}</sup>
                @else
                    <sup
                        class="badge badge-danger text-white bg-success mb-2">{{ $data_detail->pencairan_status }}</sup>
                @endif
            </p> --}}
            </div>
            @if (Auth::user()->gocap_id_pc_pengurus == $data_detail->staf_keuangan_pc)
                <div class="mr-2">
                    <div class="btn-group float-right">
                        <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" style="background-color: #cccccc">Respon</button>
                        <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="background-color: #cccccc">
                            <span class="sr-only">Toggle
                                Dropdown</span>
                        </button>
                        <div class="dropdown-menu ">
                            <a wire:click="tombol_acc" onMouseOver="this.style.color='green'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" type="button"
                                data-container="body" data-toggle="popover" data-placement="left"
                                data-content="Left popover"><i class="fas fa-user-check"></i>
                                @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                                    Cairkan Dana
                                @else
                                    Cairkan Ulang
                                @endif
                            </a>

                            <a wire:click="tombol_tolak_keuangan" onMouseOver="this.style.color='red'"
                                onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                data-target="#modal_tolak_keuangan" type="button"><i class="fas fa-ban"></i>
                                Tolak</a>
                        </div>

                    </div>

                </div>
            @endif

        </div>
        {{-- end judul --}}






        {{-- tabel --}}
        <div class="col-12 mt-2">
            {{-- tabel --}}
            <table class="table table-bordered mt-2">
                <thead>




                    {{-- <tr>
                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                    Status Pencairan
                </td>
                <td style="vertical-align: middle;">
                    {{ $data_detail->pencairan_status }}
                </td>
            </tr> --}}

                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Tgl Pencairan
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->tgl_pencairan == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($data_detail->tgl_pencairan)->isoFormat('dddd, D MMMM Y') }}
                            @endif
                        </td>
                    </tr>



                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Nominal Pencairan
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->nominal_pencairan == null)
                                <b style="font-size: 12pt;">Rp0,-
                                </b>
                                ({{ $data_detail->jumlah_penerima }} x
                                Rp{{ number_format($data_detail->satuan_pencairan, 0, '.', '.') }})
                            @else
                                <b style="font-size: 12pt;">Rp{{ number_format($data_detail->nominal_pencairan, 0, '.', '.') }},-
                                </b>
                                ({{ $data_detail->jumlah_penerima }} x
                                Rp{{ number_format($data_detail->satuan_pencairan, 0, '.', '.') }})
                            @endif
                        </td>
                    </tr>



                    <tr>

                        <td class="text-bold">Rekening Sumber Dana
                        </td>
                        <td>
                            @if ($data_detail->pencairan_status == 'Belum Dicairkan')
                                -
                            @elseif($data_detail->pencairan_status == 'Ditolak')
                                -
                            @else
                                {{ $this->nama_rekening($data_detail->id_rekening) ?? '-' }}<br>
                                @if ($data_detail->metode_pencairan == 'Transfer')
                                    <span class="text-light badge badge-primary">Transfer
                                    </span><br>
                                    <span>
                                        Atas Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :
                                        {{ $data_detail->atas_nama_penerima ?? '-' }}
                                        <br>
                                        Bank Tujuan &nbsp;&nbsp;&nbsp;&nbsp;:
                                        {{ $data_detail->nama_bank_penerima ?? '-' }}
                                        <br>
                                        No Rek Tujuan : {{ $data_detail->no_rek_penerima ?? '-' }} <br>

                                    </span>
                                @elseif ($data_detail->metode_pencairan == 'Langsung')
                                    <span class="text-light badge badge-success">Langsung
                                    </span>
                                @else
                                    -
                                @endif


                            @endif

                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold">Keterangan
                        </td>
                        <td>
                            {{ $data_detail->keterangan_pencairan ?? '-' }}


                        </td>
                    </tr>


                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Dicairkan Kepada
                        </td>
                        <td style="vertical-align: middle;">
                            @if ($data_detail->dicairkan_kepada == null)
                                -
                            @else
                                {{ $this->nama_pengurus_pc($data_detail->dicairkan_kepada) }}
                                <br>
                                <span
                                    style="font-size:11pt;">({{ $this->jabatan_pengurus_pc($data_detail->dicairkan_kepada) }})</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold" style="width: 30%;vertical-align: middle;">
                            Kwitansi Pencairan
                        </td>
                        <td>
                            <span>Format Kwitansi Pencairan </span><br>
                            <a href="/pc/kwitansi_pencairan_umum/{{ $data_detail->id_pengajuan_detail }}"
                                target="_blank" class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2"
                                role="button" style="border-radius:10px; width:3cm;">Download
                            </a>
                            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '20f2ff4d-1596-48ab-b60d-8a4b75a9784d' and
                                    $data_detail->pencairan_status == 'Berhasil Dicairkan')
                                <button wire:click="sendNotifKwitansiUmum()"
                                    class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2" role="button"
                                    style="border-radius:10px; width:3cm;"
                                    @if ($data_detail->terima_kwitansi == '1') disabled @endif>Terima
                                    Kwitansi
                                </button>
                            @endif

                        </td>
                    </tr>




                    {{-- <tr>
                <td class="text-bold" style="width: 30%;vertical-align: middle;">
                    Kwitansi
                </td>
                <td style="vertical-align: middle;">
                    @if ($data_detail->file == null)
                        -
                    @else
                        <a href="{{ asset('uploads/pengajuan_kwitansi/' . $data_detail->file) }}" target="_blank">
                            {{ $data_detail->file }} </a>
                    @endif
                </td>
            </tr> --}}
                </thead>
            </table>
            {{-- end tabel --}}


        </div>
    </div>



    <div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <b class="ml-2">C. LAMPIRAN PENCAIRAN
                    </b>
                </div>
            </div>

            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' ||
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                <button class="btn btn-outline-success btn-sm tombol-tambah"
                    wire:click="modal_lampiran_pencairan_tambah" class="btn btn-primary" data-toggle="modal"
                    data-target="#modal_lampiran_pencairan_tambah" type="button"><i class="fas fa-plus-circle"></i>
                    Tambah</button>
            @endif
        </div>

        {{-- alert --}}
        @if (session()->has('alert_lampiran_pencairan'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('alert_lampiran_pencairan_hapus'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan_hapus') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('alert_lampiran_pencairan_ubah'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lampiran_pencairan_ubah') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end alert --}}
        <table class="table table-bordered table-hover mt-2" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;vertical-align:middle;">No</th>
                    <th style="width: 30%;vertical-align:middle;">Judul</th>
                    <!--<th style="width: 30%;vertical-align:middle;">Pembuat</th>-->
                    <th style="width: 25%;vertical-align:middle;">File</th>
                    @if (count($lampiran_pencairan) > 0)
                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' ||
                                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                            <th style="width: 10%;vertical-align:middle;">Aksi</th>
                        @endif
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($lampiran_pencairan as $lp)
                @empty
                    <tr>
                        <td colspan="6" class="text-center"> Belum ada data</td>
                    </tr>
                @endforelse
                @foreach ($lampiran_pencairan as $lp)
                    <tr>
                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                        <td><span style="font-size:16px;">{{ $lp->judul }}</span>
                        </td>



                        <td><span style="font-size:16px;"><a target="_blank"
                                    href="{{ asset('uploads/lampiran_pencairan/' . $lp->file) }}">{{ $lp->file }}</a></span>
                            <br>
                            {{ Carbon\Carbon::parse($lp->created_at)->isoFormat('dddd, D MMMM Y') }}
                        </td>

                        @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '694f38af-5374-11ed-882e-e4a8df91d8b3' ||
                                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8c5a0ce3-540f-11ed-abf5-e4a8df91d8b3')
                            <td style="text-align:center;">
                                <!-- tombol aksi -->
                                <div class="btn-group">
                                    <button type="button" class=" btn btn-success btn-sm" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">Kelola</button>
                                    <button type="button"
                                        class=" btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle
                                            Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item tombol-ubah"
                                            wire:click="modal_lampiran_pencairan_ubah('{{ $lp->id_lampiran_pencairan }}')"
                                            type="button" data-toggle="modal"
                                            data-target="#modal_lampiran_pencairan_ubah"><i class="fas fa-edit"
                                                style="width:20px"></i>
                                            Ubah</a>
                                        <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                            class="dropdown-item"
                                            wire:click="modal_lampiran_pencairan_hapus('{{ $lp->id_lampiran_pencairan }}')"
                                            data-toggle="modal" data-target="#modal_lampiran_pencairan_hapus"
                                            type="button"><i class="fas fa-trash" style="width:20px"></i>
                                            Hapus</a>
                                    </div>
                                </div>
                                {{-- end tombol aksi --}}
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{-- end tabel --}}
    </div>
    {{-- end penerima manfaat --}}

    {{-- @if ($cek_jurnal_tersedia > 0) --}}
    <div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
        <div class="card card-outline mb-0 pb-0" style="border-radius: 10px;">
            <div class="card-body">
                <div class="row mb-0 pb-0 pl-0">
                    <div class="col-10 pr-0 d-highlight pr-0 mr-0 mb-1">
                        <strong>
                            <b class="text-success">Detail Jurnal Umum {{ $detail_jurnal->nomor ?? '' }} </b>
                        </strong>
                    </div>

                    @if ($detail_jurnal && isset($detail_jurnal->id_jurnal_umum))
                        <div class="col-2 pr-0 d-highlight pr-0 mr-0 mb-1 btn-block">
                            <a class="text-center btn btn-primary" target="_blank"
                                href="{{ route('print_jurnal_umum', $detail_jurnal->id_jurnal_umum) }}"><i
                                    class="fa fa-print nav-icon"></i> CETAK JURNAL</a>
                        </div>
                    @else
                        <div class="col-2 pr-0 d-highlight pr-0 mr-0 mb-1 btn-block">
                            <span class="text-center btn btn-primary disabled">CETAK JURNAL</span>
                        </div>
                    @endif



                </div>

            </div>
            @include('jurnal_umum.form_detail_jurnal_umum')
        </div>
    </div>

</div>

@include('modal.modal_lampiran_pencairan_tambah')
@include('modal.modal_lampiran_pencairan_ubah')
@include('modal.modal_lampiran_pencairan_hapus')



@push('script')
    <script>
        Livewire.on('resetKuitansi', () => {
            let inputFile = document.querySelector('#customFileScanKwitansi input[type="file"]');
            let inputLabel = document.querySelector('#customFileLabel');

            if (inputFile) {
                inputFile.value = '';
            }

            if (inputLabel) {
                inputLabel.innerHTML = 'Pilih file';
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {

                bsCustomFileInput.init();


                $('.tombol-cair').click(function() {
                    $(".custom-file-kwitansi").html('').change();

                });

                $('#nominal_pencairan').on('input', function(e) {
                    $('#nominal_pencairan').val(formatRupiah($('#nominal_pencairan').val(),
                        'Rp. '));
                });
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            $('#inptKabupaten').select2();
            $('#inptKabupaten').on('change', function(e) {
                var data = $('#inptKabupaten').select2("val");
                @this.set('id_rekening2', data);
            });


        });
    </script>

    <script>
        $(document).ready(function() {
            $('#inptKabupaten2').select2();
            $('#inptKabupaten2').on('change', function(e) {
                var data = $('#inptKabupaten2').select2("val");
                @this.set('id_rekening', data);
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            window.loadContactDeviceSelect2 = () => {


                $('#nominal_disetujui').on('input', function(e) {
                    $('#nominal_disetujui').val(formatRupiah($('#nominal_disetujui').val(),
                        'Rp. '));
                });

                $('#satuan_disetujui').on('input', function(e) {
                    $('#satuan_disetujui').val(formatRupiah($('#satuan_disetujui').val(),
                        'Rp. '));
                });


                $('#nominal_disetujui2').on('input', function(e) {
                    $('#nominal_disetujui2').val(formatRupiah($('#nominal_disetujui2').val(),
                        'Rp. '));
                });

                $('#satuan_disetujui2').on('input', function(e) {
                    $('#satuan_disetujui2').val(formatRupiah($('#satuan_disetujui2').val(),
                        'Rp. '));
                });

                $('#satuan_disetujui_direktur').on('input', function(e) {
                    $('#satuan_disetujui_direktur').val(formatRupiah($('#satuan_disetujui_direktur')
                        .val(),
                        'Rp. '));
                });
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>

    <script>
        Livewire.on('dataTersimpanTambah', () => {
            $('#modal_lampiran_pencairan_tambah').modal('hide');
        });
    </script>

    <script>
        Livewire.on('dataTersimpanHapus', () => {
            $('#modal_lampiran_pencairan_hapus').modal('hide');
        });
    </script>

    <script>
        Livewire.on('dataTersimpanPerubahan', () => {
            $('#modal_lampiran_pencairan_ubah').modal('hide');
        });
    </script>
@endpush
