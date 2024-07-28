{{-- card kegiatan --}}

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
                <sup class="text-light badge badge-success">Disetujui KC</sup>
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
                <sup class="text-light badge badge-danger">Ditolak/revisi KC</sup>
            @endif
            <br>

            @if ($data_detail->approval_status == 'Disetujui')

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
                    Persetujuan pencairan dana oleh Kepala Cabang & Div. Keuangan
                @endif
            </span>


        </p>






    </div>
</div>
<div class="row ml-2 mr-2">
    <div class="d-flex float-left" style="margin-bottom: 10px; margin-top: 0px">
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
        </svg> <a href="{{ route('print_tanda_terima_fo', ['id_pengajuan' => $data_detail->id_pengajuan]) }}"
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Tanda Terima Front Office.pdf</a>


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
            target="_blank" class="text-center mt-2"> &nbsp;&nbsp;Lembar Pencairan.pdf &nbsp;</a>

    </div>

</div>

{{-- diinput oleh --}}
<div class="card mt-2 " id="nt-1" style="display: @if ($bg_card_kegiatan == 'bg-success') block @else none @endif ">
    <div class="card-body ">
        <div class="form-row ">

            <div class="col-12 col-md-9 col-sm-12 mb-2 mb-xl-0">
                <div class="d-flex flex-row bd-highlight align-items-center">

                    <div class="p-1 bd-highlight">
                        <span>
                            <i class="fas fa-info-circle"></i>
                            Diinput oleh Petugas Pentasyarufan
                            ({{ $this->nama_pengurus_pc($data->pj_pc) }})
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3  col-sm-12 mb-2 mb-xl-0 dana-tersisa-detail-umum-pc">
                <button data-toggle="modal" class="btn btn-outline-success noClick btn-block btn-sm">
                    Dana
                    Tersisa
                    Rp{{ number_format($nominal_pencairan - $dana_digunakan, 0, '.', '.') }},-</button>
            </div>
        </div>
    </div>


</div>
{{-- end diinput oleh --}}
<div class="card card-body">
    @if (session()->has('alert_kegiatan'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('alert_kegiatan') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif



    @if (session()->has('acc_alert_lpj'))
        <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('acc_alert_lpj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('alert_lpj'))
        <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('alert_lpj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('upload_berkas_lpj'))
        <div class="alert alert-success alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('upload_berkas_lpj') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('upload_berkas_lpj_gagal'))
        <div class="alert alert-danger alert-dismissible fade show mt-2 mr-2 ml-2" role="alert">
            <i class="far fa-check-circle"></i>
            {{ session('upload_berkas_lpj_gagal') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="row">

        <div class="col col-md-12 col-sm-12">
            <div class="row">


                {{-- start berita --}}
                <div class="col col-md-7 col-sm-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <b class="ml-2">
                                A. BERITA
                            </b>
                        </div>

                        @if ($data_detail->pencairan_status == 'Berhasil Dicairkan')
                            @if (Auth::user()->PcPengurus->JabatanPengurus->jabatan == 'Divisi Program dan Administrasi Umum')
                                @if ($data_detail->konfirmasi_lpj_div_prog != 'Dikonfirmasi')
                                    <div class="ml-2" style="padding-left: 250px;">
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
                                                <a wire:click="tombol_acc_div_program_lpj('{{ $data_detail->id_pengajuan }}')"
                                                    onMouseOver="this.style.color='green'"
                                                    onMouseOut="this.style.color='black'" class="dropdown-item"
                                                    data-toggle="modal" data-target="#modal_acc" type="button"><i
                                                        class="fas fa-user-check"></i>
                                                    {{-- @if ($data_detail->approval_status == 'Ditolak')
                                            ACC Ulang
                                        @else --}}
                                                    ACC
                                                    {{-- @endif --}}
                                                </a>
                                                {{-- <a wire:click="tombol_tolak_direktur_keuangan"
                                        onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item" data-toggle="modal" data-target="#modal_tolak"
                                        type="button"><i class="fas fa-ban"></i>
                                        Tolak</a> --}}
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            @endif
                        @endif


                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>


                                <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                    <td class="text-bold" style="width: 40%;">
                                        Isi Berita Acara
                                    </td>
                                    <td>
                                        <span>Isi Kelengkapan Data Berita Acara</span><br>

                                        <a wire:click="modal_edit_berita('{{ $data_detail->id_pengajuan_detail }}')"
                                            class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                            data-toggle="modal" data-target="#edit_berita_pengajuan"
                                            style="border-radius:10px; width:3cm;">Isi
                                            Data
                                        </a>
                                    </td>
                                </tr>
                                <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                    <td class="text-bold" style="width: 40%;">
                                        Format
                                        Berita
                                        Acara
                                    </td>
                                    <td>
                                        <span>Format Berita Acara </span><br>
                                        <div class="btn-group ">
                                            <button type="button" class="btn btn-sm btn-outline-success hover float-left dropdown-toggle mr-2 mt-2"
                                                data-toggle="dropdown" aria-expanded="false" style="border-radius:10px; width:3cm;">
                                                 Download
                                            </button>
                                            <div class="dropdown-menu" style="border-radius: 10px;">
                                                <a class="dropdown-item btn-block" target="_blank" href="/pc/berita_serah_terima/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                    >Penyaluran Langsung
                                                </a>
                                                <a class="dropdown-item btn-block" target="_blank" href="/pc/berita_serah_terima_transfer/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                    >Penyaluran Melalui Transfer
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                
                                    @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '20f2ff4d-1596-48ab-b60d-8a4b75a9784d')
                                        <tr class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                            <td class="text-bold" style="width: 40%;">
                                                Upload
                                                Berita
                                                Acara
                                            </td>

                                            <td>
                                            <div class="custom-file" id="customFileScanBerita">
                                                <input type="file" wire:model="scan_berita"
                                                    accept="application/pdf"
                                                    class="custom-file-input" name="file">
                                                <label class="custom-file-label" for="customFile">Pilih
                                                    file</label>
                                            </div><br>
                                            <input wire:model="konfirmasi_note" type="text"
                                                class="form-control mt-2" placeholder="Masukan Catatan (Jika Ada)">

                                            {{-- <button wire:click="uploadBeritaUmumPc"
                                                class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                style="border-radius:10px; width:3cm;" id="uploadBerita"
                                                wire:loading.attr="disabled">Upload
                                            </button> --}}

                                            @if ($scan_berita == '')
                                            <button wire:click="uploadBeritaUmumPc"
                                                class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                style="border-radius:10px; width:3cm;" id="uploadBerita"
                                                disabled>Upload
                                            </button>
                                            @else
                                                <button wire:click="uploadBeritaUmumPc"
                                                    class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                    style="border-radius:10px; width:3cm;" id="uploadBerita"
                                                    wire:loading.attr="disabled">Upload
                                                </button>
                                            @endif



                                        </td>
                                        </tr>
                                    @endif



                                @if (Auth::user()->gocap_id_upzis_pengurus != null and $data_detail and $data_detail->status_berita == 'Sudah Diperiksa')
                                    <tr class="intro-detail-data-pengajuan-konfirmasi-format-berkas-download">
                                        <td class="text-bold" style="width: 40%;">
                                            Format
                                            Berita
                                            Acara
                                        </td>
                                        <td>
                                            <span>Format Berita Acara</span><br>
                                            <a href="/upzis/berita_acara/{{ $data_detail->id_pengajuan_detail ?? null }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-success hover float-left mr-2 mt-2"
                                                role="button" style="border-radius:10px; width:3cm;">Download
                                            </a>
                                        </td>
                                    </tr>
                                @endif


                                <tr class="intro-detail-data-pengajuan-konfirmasi-upload-berkas">
                                    <td class="text-bold" style="width: 40%;">
                                        Berita Acara
                                        ber
                                        TTD &
                                        Stampel
                                    </td>
                                    <td>
                                        @if ($data_detail and $data_detail->file_berita == null)
                                            -
                                        @elseif($data_detail)
                                            @if ($data_detail->status_berita == 'Sudah Diperiksa')
                                                <a href="/print-pdf/{{ $data_detail->id_pengajuan_detail }}"
                                                    target="_blank">{{ $data_detail->file_berita ?? null }}</a>
                                            @else
                                                <a href="{{ asset('uploads/pengajuan_berita/' . $data_detail->file_berita ?? null) }}"
                                                    target="_blank">{{ $data_detail->file_berita ?? null }}</a>
                                            @endif

                                        @endif
                                        
                                        @if ($data_detail->status_berita == 'Sudah Dikonfirmasi' and
                                                Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3' and $data_detail->file_berita != null)
                                            <br>
                                            <button wire:click="hapusBeritaUmum"
                                                class="btn btn-sm btn-outline-primary hover float-left mr-2 mt-2"
                                                style="border-radius:10px; width:3cm;" id="hapusBerita">Hapus
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-bold" style="width: 40%;">
                                        Dikonfirmasi
                                        Oleh
                                    </td>
                                    <td>
                                        @if ($data_detail and $data_detail->berita_konfirmasi_pc)
                                            <span class="text-bold">
                                                {{ \App\Models\Pengguna::where('gocap_id_pc_pengurus', $data_detail->berita_konfirmasi_pc)->value('nama') }}</span>
                                            @php
                                                $PengurusPc = \App\Models\PcPengurus::where('id_pc_pengurus', $data_detail->berita_konfirmasi_pc)->value('id_pengurus_jabatan');
                                                $jabatan = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $PengurusPc)->value('jabatan');
                                                $bidang = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $PengurusPc)->value('divisi');
                                                $jab = $jabatan . ' Bidang ' . $bidang;
                                            @endphp
                                            <span style="font-size:11pt;">
                                                ({{ $jab ?? '' }})</span>
                                        @else
                                            -
                                        @endif
                                        <br>
                                        Tanggal :
                                        @if ($data_detail and $data_detail->tgl_konfirmasi == null)
                                            -
                                        @elseif($data_detail)
                                            {{ Carbon\Carbon::parse($data_detail->tgl_konfirmasi)->isoFormat('dddd, D MMMM Y') }}
                                        @endif

                                        <br>
                                        Catatan :
                                        {{ $data_detail->konfirmasi_note ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold" style="width: 40%;">
                                        Diperiksa Oleh
                                    </td>
                                    <td>
                                        @if ($data_detail and $data_detail->lpj_pemeriksa_pc)
                                            <span class="text-bold">
                                                {{ \App\Models\Pengguna::where('gocap_id_pc_pengurus', $data_detail->lpj_pemeriksa_pc)->value('nama') }}</span>
                                            @php
                                                $PengurusPc = \App\Models\PcPengurus::where('id_pc_pengurus', $data_detail->lpj_pemeriksa_pc)->value('id_pengurus_jabatan');
                                                $jabatan = \App\Models\JabatanPengurus::where('id_pengurus_jabatan', $PengurusPc)->value('jabatan');
                                            @endphp
                                            <span style="font-size:11pt;">
                                                ({{ $jabatan ?? '' }})</span>
                                        @else
                                            -
                                        @endif
                                        <br>

                                        Tanggal :
                                        @if ($data_detail and $data_detail->tgl_diperiksa == null)
                                            -
                                        @elseif($data_detail)
                                            {{ Carbon\Carbon::parse($data_detail->tgl_diperiksa)->isoFormat('dddd, D MMMM Y') }}
                                        @endif


                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold" style="width: 40%;">
                                        Konfirmasi Pemohon
                                    </td>
                                    <td>
                                        @if (Auth::user()->gocap_id_pc_pengurus != null and
                                        Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                                            <button wire:click="konfirmasiPemohon()" class="btn btn-sm btn-secondary hover"
                                            data-toggle="collapse" data-target="#rekomendasi" aria-expanded="false"
                                            aria-controls="rekomendasi">
                                            {{ $dp->konfirmasi_pemohon == '0' ? 'Kirim Notif' : 'Kirim Ulang Notif' }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
                {{-- end berita --}}


                {{-- card dokumentasi --}}
                <div class="col col-md-5 col-sm-12">

                    <div class="dana-dokumentasi-detail-umum-pc">

                        {{-- judul --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <b class="ml-2">
                                    B. DOKUMENTASI
                                </b>
                            </div>
                            <br>
                            @if (Auth::user()->gocap_id_pc_pengurus == $data->pj_pc or
                                    Auth::user()->gocap_id_pc_pengurus == '9f14046b-a733-4ef8-a3a4-db8185a889e8')
                                <button wire:click="modal_pengajuan_dokumentasi"
                                    class="btn btn-outline-secondary btn-sm float-right" role="button"
                                    data-toggle="modal" data-target="#modal_pengajuan_dokumentasi"><i
                                        class="fas fa-edit"></i>
                                    Ubah</button>
                            @endif
                        </div>
                        {{-- end judul --}}


                        {{-- foto --}}
                        <div class="mt-2 ">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @php
                                        $b = 1;
                                        $active = 'active';
                                    @endphp
                                    @forelse($dokumentasi as $a)
                                        @if ($b > 1)
                                            @php
                                                $active = '';
                                            @endphp
                                        @endif

                                        @php
                                            $b++;
                                        @endphp

                                        <div class="carousel-item {{ $active }}">
                                            <img class="d-block w-100" style="border-radius:10px; "
                                                src="{{ asset('uploads/pengajuan_dokumentasi/' . $a->file) }}"
                                                alt="First slide">
                                            <p class="text-center mt-2">
                                                {{ $a->judul }}
                                            </p>
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <img class="d-block w-100" style="border-radius:10px; "
                                                src="{{ asset('default/no-image.png') }}" alt="First slide">

                                        </div>
                                    @endforelse

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        {{-- end foto --}}
                    </div>

                </div>
                {{-- end dokumentasi --}}


            </div>
        </div>


    @if (Auth::user()->gocap_id_pc_pengurus == '9f14046b-a733-4ef8-a3a4-db8185a889e8')
        <div>
            <b> &nbsp;C. LAMPIRAN PENGAJUAN/PROPOSAL/LAINNYA</b>
        </div>

        <div class="col-sm-12 mt-3 col-md-12 col-lg-12 tab-tab-lampiran-pengajuan-umum-pc">


            {{-- tabel dokumentasi --}}
            <table class="table table-bordered mt-2 mb-2" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 40%">Judul</th>
                        <th>File</th>
                        <th>Waktu Upload</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($lampiran as $a)
                        {{-- @php
                        dd($a);
                    @endphp --}}
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $a->judul }} <br>
                                {{-- <span style="font-size: 10pt">Diinput Oleh :
                                    {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                                    ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                                </span> --}}
                            </td>
                            <td>
                                <a href="{{ asset('uploads/pengajuan_lampiran/' . $a->file) }}" target="_blank">
                                    {{ $a->file }}
                                </a>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($a->created_at)->format('d/m/Y H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center"> Belum ada data</td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
            {{-- end tabel --}}
        </div>


        <div>
            <b class="ml-2"> D. LAMPIRAN SURVEY
            </b>
        </div>

        {{-- penerima manfaat --}}
        <div class="col-sm-12 col-lg-12 col-md-12 mt-2">
            <table class="table table-bordered table-hover mt-2" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 10px;vertical-align:middle;">No</th>
                        <th style="width: 25%;vertical-align:middle;">Penerima Manfaat</th>
                        <th style="width: 20%;vertical-align:middle;">Alamat & No HP</th>
                        <th style="width: 20%;vertical-align:middle;">Nominal & Jenis Permohonan</th>
                        <th style="width: 20%;vertical-align:middle;">Keterangan</th>
                        @if ($data_detail->approval_status == 'Disetujui')
                            <th style="width: 35%;vertical-align:middle;">Survey</th>
                        @endif
                        @if ($data_detail->pil_survey == 'Perlu')
                            @if (count($penerima) > 0)
                                <th style="vertical-align:middle;">Aksi</th>
                            @endif
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerima as $a)
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> Belum ada data</td>
                        </tr>
                    @endforelse
                    @foreach ($penerima as $a)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><b style="font-size:16px;">{{ $a->nama }}</b> <br>
                                NIK: {{ $a->nik ?? '-' }} <br>
                                KK: {{ $a->nokk ?? '-' }}
                                {{-- <span style="font-size: 10pt">Diinput Oleh :
                            {{ $this->nama_pengurus_pc($a->maker_tingkat_pc) }}
                            ({{ $this->jabatan_pengurus_pc($a->maker_tingkat_pc) }})
                        </span> --}}
                            </td>
                            <td> <b style="font-size:16px;">{{ $a->alamat ?? '-' }}</b> <br>
                                No HP: {{ $a->nohp ?? '-' }}</td>
                            <td class="text-left">
                                <b style="font-size:16px;">Rp{{ number_format($a->nominal_bantuan, 0, '.', '.') }},-
                                </b> <br>
                                Jenis Bantuan: {{ $a->jenis_bantuan ?? '-' }}
                            </td>
                            {{-- <td>{{ $a->keterangan }}</td> --}}

                            <td><b style="font-size:16px;">{{ $a->keterangan ?? '-' }}</b> <br>
                            </td>
                            @if ($data_detail->approval_status == 'Disetujui')
                                <td>
                                    @if ($data_detail->pil_survey == 'Perlu')
                                        @php
                                            $tgl = App\Models\SurveyPenerimaManfaat::where('id_penerima_manfaat', $a->id_pengajuan_penerima)->first();
                                        @endphp
                                       @if ($tgl && $tgl->tanggal_survey)
                                            {{ Carbon\Carbon::parse($tgl->tanggal_survey)->isoFormat('dddd, D MMMM Y') ?? '' }}
                                            <br>
                                        @endif

                                        @php
                                            $pengajuanSurvey = DB::table('survey_penerima_manfaat')
                                                ->leftjoin('pengajuan_penerima', 'pengajuan_penerima.id_pengajuan_penerima', '=', 'survey_penerima_manfaat.id_penerima_manfaat')
                                                ->where('pengajuan_penerima.id_pengajuan_penerima', $a->id_pengajuan_penerima)
                                                ->where('pengajuan_penerima.id_pengajuan', $data_detail->id_pengajuan)
                                                ->where('pengajuan_penerima.id_pengajuan_detail', $data_detail->id_pengajuan_detail)
                                                ->first();
                                        @endphp

                                        @if ($pengajuanSurvey)
                                            @if ($pengajuanSurvey->hasil == 'disetujui')
                                                <span class="badge badge-success"
                                                    style="font-size: 14px;">Disetujui</span>
                                            @elseif($pengajuanSurvey->hasil == 'ditolak')
                                                <span class="badge badge-danger"
                                                    style="font-size: 14px;">Ditolak</span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 14px;">Belum
                                                Direspon</span>
                                        @endif
                                    @endif

                                </td>
                            @endif
                            @if ($data_detail->pil_survey == 'Perlu')
                                <td>
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

                                            @if ($data_detail->pil_survey == 'Perlu')
                                                @if (Auth::user()->gocap_id_pc_pengurus != $data->pj_pc and $this->kelolaSurvey($a->id_pengajuan_penerima) == 0)
                                                    @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                                        <a onMouseOver="this.style.color='orange'"
                                                            onMouseOut="this.style.color='black'"
                                                            class="dropdown-item tombol-orange"
                                                            wire:click="belum_survey()">
                                                            <i class="fas fa-print" style="width: 20px"></i>Cetak
                                                            Survey</a>
                                                    @endif
                                                @else
                                                    @if ($this->kelolaSurvey($a->id_pengajuan_penerima) == 1)
                                                        <a onMouseOver="this.style.color='orange'"
                                                            onMouseOut="this.style.color='black'"
                                                            class="dropdown-item tombol-orange" target="_blank"
                                                            {{-- wire:click="ngok('{{ $a->id_pengajuan_penerima }}')" --}}
                                                            href="/pc/survey/{{ $a->id_pengajuan_penerima }}"><i
                                                                class="fas fa-print" style="width: 20px"></i>Cetak
                                                            Survey</a>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>

                                    </div>
                                    {{-- end tombol aksi --}}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    {{-- {{ dd($data_detail->id_pengajuan); }} --}}
                </tbody>
            </table>
            {{-- end tabel --}}
        </div>
        {{-- end penerima manfaat --}}

        <div>
            <b class="ml-2"> E. LAMPIRAN PENCAIRAN
            </b>
        </div>
        <div class="col-sm-12 col-lg-12 col-md-12 mt-2 tab-tab-daftar-penerima-manfaat-pengajuan-umum-pc">
            <table class="table table-bordered table-hover mt-2" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;vertical-align:middle;">No</th>
                        <th style="width: 30%;vertical-align:middle;">Judul</th>
                        <th style="width: 30%;vertical-align:middle;">Pembuat</th>
                        <th style="width: 25%;vertical-align:middle;">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lampiran_pencairan as $lp)
                        {{-- @php
                        dd($lp);
                    @endphp --}}
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> Belum ada data</td>
                        </tr>
                    @endforelse
                    @foreach ($lampiran_pencairan as $lp)
                        <tr>
                            <td style="text-align:center;">{{ $loop->iteration }}</td>
                            <td><b style="font-size:16px;">{{ $lp->judul }}</b>
                            </td>
                            @php
                                $nama_pembuat = App\Models\Pengguna::where('gocap_id_pc_pengurus', $lp->id_pengurus_pc)->value('nama');
                                $id_jabatan = App\Models\PcPengurus::where('id_pc_pengurus', $lp->id_pengurus_pc)->value('id_pengurus_jabatan');
                                $jabatan = App\Models\JabatanPengurus::where('id_pengurus_jabatan', $id_jabatan)->value('jabatan');
                            @endphp
                            <td class="text-left">
                                <b style="font-size:16px;">{{ $nama_pembuat . ' (' . $jabatan . ')' }}
                            </td>


                            <td><b style="font-size:16px;"><a target="_blank"
                                        href="{{ asset('uploads/lampiran_pencairan/' . $lp->file) }}">{{ $lp->file }}</a></b>
                                <br>
                                {{ Carbon\Carbon::parse($lp->created_at)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                        </tr>
                    @endforeach

                     </tbody>
            </table>
                    {{-- end tabel --}}
        </div>
        @endif
        
        <div class="col-sm-12 mt-3 col-md-12 col-lg-12 tab-tab-lampiran-pengajuan-umum-pc">
        {{-- judul --}}
        <div class="d-flex justify-content-between align-items-center">
            @if (Auth::user()->gocap_id_pc_pengurus == '9f14046b-a733-4ef8-a3a4-db8185a889e8')
            <div>
                <b> F. LAMPIRAN LPJ</b>
            </div>
            @else
            <div>
                <b> C. LAMPIRAN LPJ</b>
            </div>
            @endif
            @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3' ||
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                <button class="btn btn-outline-success btn-sm tombol-tambah" data-toggle="modal"
                    wire:click="modal_umum_lpj_tambah" data-target="#modal_umum_lpj_tambah" type="button"><i
                        class="fas fa-plus-circle"></i>
                    Tambah</button>
            @endif
        </div>
        {{-- end judul --}}

        {{-- alert --}}
        @if (session()->has('alert_lpj'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <i class="far fa-check-circle"></i> {{ session('alert_lpj') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        {{-- end alert --}}

        {{-- tabel --}}
        {{-- tabel dokumentasi --}}
        <table class="table table-bordered mt-2 mb-2" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%">Judul</th>
                    <th>File</th>
                     @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3' ||
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @forelse($lpj as $a)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $a->judul_lpj }} <br>
                        </td>
                        <td>
                            <a href="{{ asset('uploads/pengajuan_lpj/' . $a->file_lpj) }}" target="_blank">
                                {{ $a->file_lpj }}
                            </a>
                        </td>
                         @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3' ||
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                        <td>
                            <!-- tombol aksi -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">Kelola</button>
                                <button type="button"
                                    class="btn btn-success dropdown-toggle dropdown-toggle-split btn-sm"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle
                                        Dropdown</span>
                                </button>
                                <div class="dropdown-menu">
                                    <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item tombol-ubah tombol-tambah"
                                        wire:click="modal_umum_lpj_ubah('{{ $a->id_pengajuan_lpj }}','{{ $a->file }}')"
                                        type="button" data-toggle="modal" data-target="#modal_umum_lpj_ubah"><i
                                            class="fas fa-edit"></i>
                                        Ubah</a>
                                    <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item"
                                        wire:click="modal_umum_lpj_hapus('{{ $a->id_pengajuan_lpj }}','{{ $a->file }}')"
                                        data-toggle="modal" data-target="#modal_umum_lpj_hapus" type="button"><i
                                            class="fas fa-trash"></i>
                                        Hapus</a>
                                    <a href="/pc/unduh-lpj/{{ $a->id_pengajuan_lpj }}"
                                        onMouseOver="this.style.color='green'" onMouseOut="this.style.color='black'"
                                        class="dropdown-item" type="button">
                                        <i class="fa fa-download"></i> Cetak
                                    </a>

                                </div>
                            </div>
                            {{-- end tombol aksi --}}
                        </td>
                        @endif


                    </tr>
                @empty
                 @if (Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == 'e7fc67fe-725b-11ed-ad27-e4a8df91d8b3' ||
                    Auth::user()->PcPengurus->JabatanPengurus->id_pengurus_jabatan == '8e2ba55e-725b-11ed-ad27-e4a8df91d8b3')
                    <tr>
                        <td colspan="4" class="text-center"> Belum ada data</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="3" class="text-center"> Belum ada data</td>
                    </tr>
                    @endif
                @endforelse


            </tbody>
        </table>
        {{-- end tabel --}}
    </div>
    
    <div class="col-sm-12 mt-3 col-md-12 col-lg-12 tab-tab-lampiran-pengajuan-umum-pc1">
            {{-- judul --}}
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <b>
                        @if (Auth::user()->gocap_id_pc_pengurus == '9f14046b-a733-4ef8-a3a4-db8185a889e8')
                            G. PENGGUNAAN DANA
                        @else
                            D. PENGGUNAAN DANA
                        @endif
                    </b>
                </div>
                <div class="ml-auto">
                    <a href="/pc/print_penggunaan_dana_umum/{{ $data_detail->id_pengajuan_detail }}" target="_blank"
                        class="btn btn-outline-success btn-sm tombol-cetak" type="button">
                        <i class="fa fa-file-pdf"></i> &nbsp;Cetak
                    </a>
                    @if (Auth::user()->gocap_id_pc_pengurus == $data_detail->maker_tingkat_pc)
                        <a class="btn btn-outline-success btn-sm tombol-tambah" data-toggle="modal"
                            wire:click="modal_umum_penggunaan_dana" data-target="#modal_umum_penggunaan_dana"
                            type="button">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </a>
                    @endif
                </div>
            </div>
            <br>


            <div class="row">
                <div class="col-12">

                    <nav class="navbar navbar-expand-sm mb-1">
                        <ul class="navbar-nav mr-auto my-4 my-sm-0 navbar-nav-scroll">
                            <div class="row">
                                <div class="col">Show</div>
                                <div class="col">

                                    <li class="nav-item p-0">
                                        <div class="dataTables_length" id="example_length">
                                            <select name="example_length" aria-controls="example_length"
                                                class="custom-select custom-select-sm form-control form-control-sm">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                                <option value="200">200</option>
                                            </select>
                                        </div>
                                    </li>
                                </div>


                            </div>
                        </ul>




                        <form>

                            <div class="input-group mr-12 float-right">

                                <input wire:model="cari" type="search" class="form-control form-control-sm"
                                    placeholder="Silahkan Cari" value="">

                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-default noClick">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>

                            </div>
                        </form>
                    </nav>

                    <div class="form-row mb-3 d-flex justify-content-end">
                        <div class="col-12 col-md-3 col-sm-12 mb-xl-0">
                            <button class="btn btn-outline-dark btn-block" style="font-size: 15px">
                                Dana Dicairkan&nbsp;: Rp
                                @if ($data_detail->pencairan_status == 'Berhasil Dicairkan')
                                    {{ number_format($data_detail->nominal_pencairan), 0, '.', '.' }}
                                @else
                                    0
                                @endif
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-sm-12 mb-xl-0">
                            <button class="btn btn-outline-dark btn-block" style="font-size: 15px">
                                Dana Digunakan&nbsp;: Rp
                                @if ($data_detail->pencairan_status == 'Berhasil Dicairkan' || ($data->approval_status = 'Disetujui'))
                                    {{ number_format($dana_digunakan_umum), 0, '.', '.' }}
                                @else
                                    0
                                @endif
                            </button>
                        </div>
                        @php
                            if ($sisa_dana < 0) {
                                $format_sisa_dana = '-Rp' . number_format(abs($sisa_dana), 0, '.', '.');
                                $warna = 'danger';
                            } else {
                                $format_sisa_dana = 'Rp' . number_format($sisa_dana, 0, '.', '.');
                                $warna = 'black';
                            }
                        @endphp
                        <div class="col-12 col-md-3 col-sm-12 mb-xl-0">
                            <button class="btn btn-outline-dark btn-block" style="font-size: 15px">
                                Sisa Dana&nbsp;:
                                @if ($data_detail->pencairan_status == 'Berhasil Dicairkan' || ($data->approval_status = 'Disetujui'))
                                    <span class="text-{{ $warna }}">{{ $format_sisa_dana }}</span>
                                @else
                                    Rp0
                                @endif
                            </button>
                        </div>
                    </div>


                    @if (session()->has('alert_lampiran'))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            <i class="far fa-check-circle"></i> {{ session('alert_lampiran') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table class="table table-bordered table-hover table-responsive" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="vertical-align:middle;width: 3%;">No</th>
                                <th style="vertical-align:middle;width: 10%;">Tgl Input</th>
                                <th style="vertical-align:middle;width: 10%;">Tgl Penggunaan <br> Dana</th>
                                <th style="vertical-align:middle;width: 14%;">Keterangan
                                </th>
                                <th style="vertical-align:middle;width: 12%;">Dibayarkan Kepada
                                </th>
                                <th style="vertical-align:middle;width: 15%;">Nota/Kwitansi
                                </th>
                                <th style="vertical-align:middle;width: 13%;">Nominal
                                </th>
                                <th style="vertical-align:middle;width: 10%;">Opsi Dana</th>
                                @if (Auth::user()->gocap_id_pc_pengurus == $data_detail->maker_tingkat_pc)
                                    <th style="vertical-align:middle;width: 30%;">Aksi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($datas) }} --}}
                            @forelse($datas as $datab)
                                <tr>
                                    {{-- {{ dd($a) }} --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td style="10%">
                                        {{ \Carbon\Carbon::parse($datab->created_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td style="10%">
                                        {{ \Carbon\Carbon::parse($datab->tgl_penggunaan_dana)->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td style="25%">{{ $datab->keterangan ?? '-' }}</td>
                                    <td style="12%">{{ $datab->dibayarkan_kepada ?? '-' }}</td>
                                    <td style="13%"><a class="text-primary"
                                        href="{{ asset('uploads/penggunaan_dana_umum/' . $datab->nota) }}"
                                        target="_blank">Nota/Kwitansi</a> <br>
                                        <a class="text-primary"
                                        href="{{ asset('uploads/foto_kegiatan_umum/' . $datab->foto_kegiatan) }}"
                                        target="_blank">Foto Barang</a>
                                </td>
                                    <td style="13%">Rp {{ number_format($datab->nominal), 0, '.', '.' }},-
                                    </td>
                                    <td style="width: 15%">
                                        @if ($datab->opsi_dana == 'Penggunaan Dana')
                                            <span class="badge badge-success text-white">Penggunaan Dana</span>
                                        @else
                                            <span class="badge badge-primary text-white">Pengembalian
                                                Dana</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc)
                                        <td style="30%">
                                            <div class="d-flex justify-content-center">
                                                <div id="hoverText">
                                                    <a wire:click="modal_ubah_lpj_umum('{{ $datab->id_lpj_umum }}')"
                                                        style="cursor: pointer; color: #007bff; margin-right: 2pt;"
                                                        data-toggle="modal" data-target="#modal_ubah_lpj_umum"
                                                        type="button" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a wire:click="modal_hapus_lpj_umum('{{ $datab->id_lpj_umum }}')"
                                                        style="cursor: pointer; color: #dc3545;" data-toggle="modal"
                                                        data-target="#modal_hapus_lpj_umum" type="button"
                                                        title="Hapus">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"> Data
                                        tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @include('modal.modal_umum_penggunaan_dana')
            @include('modal.modal_ubah_lpj_umum')
            @include('modal.modal_hapus_lpj_umum')
        </div>

    </div>

</div>

@push('script')
    <script>
        window.addEventListener('closeModal', event => {
            $('#modal_umum_penggunaan_dana').modal('hide')
        });
        window.addEventListener('close-modal', event => {
            $('#modal_ubah_lpj_umum').modal('hide')
        });
        window.addEventListener('tutupModal', event => {
            $('#modal_hapus_lpj_umum').modal('hide')
        });
    </script>
    <script>
        Livewire.on('dataTersimpanLpj', () => {
            $('#edit_berita_pengajuan').modal('hide');
        });
        
        Livewire.on('dataTersimpanTambahLPJ', () => {
            $('#modal_umum_lpj_tambah').modal('hide');
        });

        Livewire.on('dataTersimpanHapusLPJ', () => {
            $('#modal_umum_lpj_hapus').modal('hide');
        });

        Livewire.on('dataTersimpanUbahLPJ', () => {
            $('#modal_umum_lpj_ubah').modal('hide');
        });
    </script>
@endpush
