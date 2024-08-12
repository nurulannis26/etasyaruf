{{-- Disetujui oleh Direktur Eksekutif --}}
<div class="card mt-3 mr-2">
    <div class="card-body">
        @if ($data->tgl_pengajuan != null)
            <sup class="badge badge-success text-white">FPPD berhasil diajukan</sup>
        @else
            <sup class="badge badge-warning text-white">FPPD belum selesai diajukan</sup>
        @endif

        @if ($data->approval_status_divpro == 'Disetujui')
            <sup class="text-light badge badge-success">Disposisi Diterima Div. Program</sup>
        @else
            <sup class="text-light badge badge-warning">Disposisi Blm Diterima Div. Program
            </sup>
        @endif

        @if ($data->approval_status_divpro == 'Disetujui')
            @if ($data->approval_status == 'Belum Direspon')
                <sup class="badge badge-warning text-white mb-2">Pengajuan blm disetujui Direktur</sup>
            @elseif($data->approval_status == 'Disetujui')
                <sup class="badge badge-success text-white mb-2">Pengajuan disetujui Direktur</sup>
            @else
                <sup class="badge badge-danger text-white mb-2">Pengajuan ditolak Direktur</sup>
            @endif
        @endif

        @if ($data->approval_status == 'Disetujui')
            @if ($data->pencairan_status == 'Belum Dicairkan')
                <sup class="badge badge-warning text-white mb-2">Pencairan blm disetujui Div. Keuangan</sup>
            @elseif($data->pencairan_status == 'Berhasil Dicairkan')
                <sup class="badge badge-success text-white mb-2">Pencairan disetujui Div. Keuangan</sup>
            @else
                <sup class="badge badge-danger text-white mb-2">Pencairan ditolak Div. Keuangan</sup>
            @endif
        @endif
        <br>
        <div class="row align-items-center">
            <span class="col-md-6">
                <i class="fas fa-info-circle"></i>
                Input penggunaan dana oleh pemohon ({{ $this->nama_pengurus_pc($data->maker_tingkat_pc) }}).
            </span>
            <div class="col-md-6 text-md-right">
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
                </svg> <a
                    href="/pc/internal{{ $data->id_internal }}/{{ str_replace('/', '_', $data->nomor_surat) . '_INTERNAL' }}"
                    target="_blank" class="text-center"> &nbsp;&nbsp;FPPD.pdf</a>


            </div>
        </div>
    </div>
</div>





{{-- end Disetujui oleh Direktur Eksekutif --}}
<div class="intro-detail-pencairan-keuangan-arsips">
    {{-- judul --}}
    @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc and $data->pencairan_status == 'Berhasil Dicairkan')
        <div class="row mb-2">
            <div class="col-md-6">
                <button wire:click="modal_internal_penggunaan_dana" class="btn btn btn-outline-success"
                    data-toggle="modal" data-target="#modal_internal_penggunaan_dana" type="button"><i
                        class="fas fa-plus-circle"></i>
                    Tambah Penggunaan Dana </button>
            </div>
            <div class=" col-md-6 text-md-right">
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
                </svg> <a href="/pc/print_penggunaan_dana/{{ $data->id_internal }}" target="_blank"
                    class="text-center mt-2"> &nbsp;&nbsp;LPJ.pdf</a>

            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card mt-2">
                <div class="card-body">

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
                                @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                    {{ number_format($data->nominal_pencairan), 0, '.', '.' }}
                                @else
                                    0
                                @endif
                            </button>
                        </div>
                        <div class="col-12 col-md-3 col-sm-12 mb-xl-0">
                            <button class="btn btn-outline-dark btn-block" style="font-size: 15px">
                                Dana Digunakan&nbsp;: Rp
                                @if ($data->pencairan_status == 'Berhasil Dicairkan')
                                    {{ number_format($dana_digunakan_internal), 0, '.', '.' }}
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
                                @if ($data->pencairan_status == 'Berhasil Dicairkan')
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
                                <th style="vertical-align:middle;width: 25%;">Keterangan
                                </th>
                                <th style="vertical-align:middle;width: 15%;">Dibayarkan Kepada
                                </th>
                                <th style="vertical-align:middle;width: 10%;">Nota/Kwitansi
                                </th>
                                <th style="vertical-align:middle;width: 17%;">Nominal
                                </th>
                                @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc and $data->pencairan_status == 'Berhasil Dicairkan')
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
                                    <td style="15%">{{ $datab->dibayarkan_kepada ?? '-' }}</td>
                                    <td style="10%"><a class="text-primary"
                                            href="{{ asset('uploads/penggunaan_dana/' . $datab->nota) }}"
                                            target="_blank">Lihat</a>
                                    </td>
                                    <td style="17%">Rp {{ number_format($datab->nominal), 0, '.', '.' }},-</td>
                                    @if (Auth::user()->gocap_id_pc_pengurus == $data->maker_tingkat_pc and $data->pencairan_status == 'Berhasil Dicairkan')
                                        <td style="30%">
                                            <div class="d-flex justify-content-center">
                                                <div id="hoverText">
                                                    <a wire:click="modal_ubah_lpj('{{ $datab->id_lpj_internal }}')"
                                                        style="cursor: pointer; color: #007bff; margin-right: 2pt;"
                                                        data-toggle="modal" data-target="#modal_ubah_lpj"
                                                        type="button" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a wire:click="modal_hapus_lpj('{{ $datab->id_lpj_internal }}')"
                                                        style="cursor: pointer; color: #dc3545;" data-toggle="modal"
                                                        data-target="#modal_hapus_lpj" type="button" title="Hapus">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center"> Data
                                        tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('modal.modal_internal_penggunaan_dana')
    @include('modal.modal_ubah_lpj')
    @include('modal.modal_hapus_lpj')

</div>


@push('script')
    <script>
        window.addEventListener('closeModal', event => {
            $('#modal_internal_penggunaan_dana').modal('hide')
        });
        window.addEventListener('close-modal', event => {
            $('#modal_ubah_lpj').modal('hide')
        });
        window.addEventListener('tutupModal', event => {
            $('#modal_hapus_lpj').modal('hide')
        });
    </script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            window.loadContactDeviceSelect2 = () => {
                window.initSelectStationDrop = () => {
                    $('#select2-dropdown').select2();
                    $('#select2-dropdown').on('change', function() {
                        var selectedValue = $(this).val();
                        @this.set('selectedProgram', selectedValue);
                    });

                }
                initSelectStationDrop();
                window.livewire.on('select2', () => {
                    initSelectStationDrop();
                });
            }

            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>
@endpush
