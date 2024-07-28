<div>
    <div class="d-flex justify-content-between">
        <h5 class=" mt-2 ml-2">
            <b class="text-success pl-2 mt-1">LAPORAN KEUANGAN UPZIS MWCNU
                {{ strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama) }}</b>

        </h5>
        <button type="button" class="btn btn-success toastsDefaultSuccess mt-3 mr-3">
            Ekspor Excel
        </button>
    </div>
    {{-- card body --}}
    <div class="card-body">



        <table id="example1" class=" table-bordered table-hover mt-0 pt-0"
            style="text-align: center;vertical-align: middle;">
            <thead>
                <tr>
                    <th style="width:50px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        NO
                    </th>
                    <th style="width:220px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        BULAN</th>
                    <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2" colspan="3">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            SALDO AWAL BANK
                        </span>
                    </th>

                    <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2" colspan="3">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            SALDO AWAL KAS
                        </span>
                    </th>
                    <th style="vertical-align:middle;text-align:center;height:20px" rowspan="2" colspan="5">
                        PENERIMAAN
                    </th>
                    <th style="vertical-align:middle;text-align:center;height:35px" colspan="13">
                        PENYALURAN
                    </th>

                    <th style="width:150px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            PENGELUARAN <br> LAINNYA (ex:adm bank,dll)
                        </span>

                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        SALDO AKHIR
                    </th>
                    <th style="width:100px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        JUMLAH <br>
                        PENERIMA <br>
                        MANFAAT
                    </th>
                    <th style="width:250px;vertical-align:middle;text-align:center;height:20px" rowspan="4">
                        KETERANGAN
                    </th>
                </tr>

                <tr>
                    {{-- penyaluran --}}
                    <th style="vertical-align:middle;text-align:center" colspan="12">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            Pengeluaran Dana Berdasarkan Program
                        </span>
                    </th>

                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="3">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            JUMLAH PENYALURAN PROGRAM
                        </span>
                    </th>
                </tr>

                <tr>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        SOSIAL
                        ({{ $this->no_rekening_sosial }})
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        KELEMBAGAAN ({{ $this->no_rekening_kelembagaan }})

                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        OPERASIONAL
                        ({{ $this->no_rekening_operasional }})

                    </th>

                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        SOSIAL
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        KELEMBAGAAN
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        OPERASIONAL
                    </th>

                    <th style="vertical-align:middle;text-align:center" colspan="3">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            PROSENTASE KOIN NU
                        </span>
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        <span data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                            PENERIMAAN LAINNYA (ex:bagi hasil bank,dll)
                        </span>
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center" rowspan="2">
                        JUMLAH
                        PENERIMAAN
                    </th>

                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Pendidikan
                    </th>
                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Kesehatan
                    </th>
                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Ekonomi
                    </th>
                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Dakwah dan Kemanusiaan
                    </th>
                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Lingkungan
                    </th>
                    <th style="vertical-align:middle;text-align:center" colspan="2">
                        Kelembagaan
                    </th>


                </tr>

                <tr>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        SOSIAL
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        KELEMBAGAAN
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        OPERASIONAL
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        JUMLAH
                    </th>

                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>
                    <th style="width:150px;vertical-align:middle;text-align:center">
                        Jumlah
                    </th>
                    <th style="width:50px;vertical-align:middle;text-align:center">
                        PM
                    </th>

                </tr>
            </thead>

            <tbody>
                @foreach ($bul as $data)
                    <tr data-toggle="collapse" href="#collapseExample{{ $loop->iteration }}" role="button"
                        aria-expanded="false" aria-controls="collapseExample">
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $loop->iteration }}</td>
                        <td
                            style="text-align:left;padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <div class="d-flex ">
                                {{ app\Helpers\BasicHelper::getNamaBulan($data['bulan']) . ' (' . $tahun . ')' }}
                                <div style="margin-top:0.1cm;">
                                    @if ($data['bulan'] == date('m'))
                                        <sup class="badge  text-white bg-success ">Bulan Ini</sup>
                                    @endif
                                </div>
                            </div>
                            {{-- {{ $a->bulan }} --}}

                            {{-- {{ $a->bulan }} --}}


                            <div class="collapse" id="collapseExample{{ $loop->iteration }}">

                                <a href="" data-toggle="modal"
                                    data-target="#modal_laporan_saldo_awal{{ $data['bulan'] }}">a.
                                    Laporan Saldo Awal
                                </a> <br>

                                <a href="" onclick="showConsoleLog('12')" data-toggle="modal"
                                    data-target="#myModal">b. Laporan
                                    Penerimaan</a> <br>

                                <a
                                    href="/{{ $role }}/laporanpenyaluran/{{ $data['bulan'] }}/{{ $tahun }}/{{ $id_upzis }}">c.
                                    Laporan
                                    Penyaluran</a>
                                <br>
                                <a
                                    href="/{{ $role }}/laporanperudana/{{ $data['bulan'] }}/{{ $tahun }}/{{ $id_upzis }}">d.
                                    Laporan Perubahan
                                    Dana</a>
                                <br>

                            </div>


                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sab_sosial'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sab_sosial'] == '-' ? '-' : number_format($data['sab_sosial'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sab_kelembagaan'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sab_kelembagaan'] == '-' ? '-' : number_format($data['sab_kelembagaan'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sab_operasional'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sab_operasional'] == '-' ? '-' : number_format($data['sab_operasional'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sak_sosial'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sak_sosial'] == '-' ? '-' : number_format($data['sak_sosial'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sak_kelembagaan'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sak_kelembagaan'] == '-' ? '-' : number_format($data['sak_kelembagaan'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            <span style="float: left;">{{ $data['sak_operasional'] == '-' ? '' : 'Rp' }}</span>
                            <span
                                style="float: right;">{{ $data['sak_operasional'] == '-' ? '-' : number_format($data['sak_operasional'], 0, '.', '.') . '-,' }}</span>
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getPenerimaanPerProgram($data['bulan'], $tahun, $data['id_rekening_sosial']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getPenerimaanPerProgram($data['bulan'], $tahun, $data['id_rekening_kelembagaan']) !!}

                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getPenerimaanPerProgram($data['bulan'], $tahun, $data['id_rekening_operasional']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getPenerimaanLainnya($data['bulan'], $tahun) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPenerimaan(
                                $data['bulan'],
                                $tahun,
                                $data['id_rekening_sosial'],
                                $data['id_rekening_kelembagaan'],
                                $data['id_rekening_operasional'],
                            ) !!}
                        </td>

                        {{-- pendidikan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_pendidikan']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_pendidikan']) }}
                        </td>
                        {{-- end pendidikan --}}

                        {{-- kesehatan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kesehatan']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kesehatan']) }}
                        </td>
                        {{-- end kesehatan --}}

                        {{-- ekonomi --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_ekonomi']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_ekonomi']) }}
                        </td>
                        {{-- end ekonomi --}}

                        {{-- kemanusiaan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kemanusiaan']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kemanusiaan']) }}
                        </td>
                        {{-- end kemanusiaan --}}

                        {{-- lingkungan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_lingkungan']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_lingkungan']) }}
                        </td>
                        {{-- end lingkungan --}}

                        {{-- kelembagaan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPilar($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kelembagaan']) !!}
                        </td>
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaat($data['bulan'], $tahun, $id_upzis, $data['id_pilar_kelembagaan']) }}
                        </td>
                        {{-- end kelembagaan --}}

                        {{-- jumlah penyaluran program --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getJumlahPenyaluranProgram($data['bulan'], $tahun, $id_upzis) !!}
                        </td>
                        {{-- end jumlah penyaluran program --}}

                        {{-- pengeluaran lainnya --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getPengeluaranLainnya($data['bulan'], $tahun) !!}
                        </td>
                        {{-- end pengeluaran lainnya --}}

                        {{-- saldo akhir --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {!! $this->getSaldoAkhir(
                                $data['bulan'],
                                $tahun,
                                $id_upzis,
                                $data['jumlah_saldo_awal'],
                                $data['id_rekening_sosial'],
                                $data['id_rekening_kelembagaan'],
                                $data['id_rekening_operasional'],
                            ) !!}
                        </td>
                        {{-- end saldo akhir --}}

                        {{-- jumlah penerima manfaat --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $this->getJumlahPenerimaManfaatTotal($data['bulan'], $tahun, $id_upzis) }}
                        </td>
                        {{-- end jumlah penerima manfaat --}}

                        {{-- keterangan --}}
                        <td
                            style="padding-left:5px;padding-right:5px;vertical-align:top;padding-top:5px;padding-bottom:5px;">
                            {{ $data['keterangan'] == null ? '-' : $data['keterangan'] }}
                        </td>
                        {{-- end keterangan --}}


                    </tr>

                    @include('modal.modal_laporan_saldo_awal')
                @endforeach

            </tbody>

        </table>

        {{-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Nilai dari server: <span id="value"></span></p>
        </div>
    </div> --}}

        <div class="modal fade show" id="myModal" tabindex="-1" aria-labelledby="jemputVerifikasiLabel"
            aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="jemputVerifikasiLabel">Verifikasi Penghimpunan
                            Ranting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class=" bg-ijo d-flex justify-content-around p-2 rounded">
                            <div class="col">
                                <span class="text-bold">Ranting</span><br>
                                <span id="value1"></span><br>
                                <span id="value2"></span><br>
                            </div>
                            <div class="col">
                                <span class="text-bold">Koordinator Desa</span><br>
                                <span>Suyadi</span><br>
                                <span>085726036689</span><br>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-12">
                                <div class="card" style="height: 135px">
                                    <div class="card-body">
                                        <span class="text-bold">PLPK</span><br>
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td>Aktif</td>
                                                    <td>:</td>
                                                    <td>25</td>
                                                </tr>
                                                <tr>
                                                    <td>Menjemput</td>
                                                    <td>:</td>
                                                    <td>9</td>
                                                </tr>
                                                <tr>
                                                    <td>Persentase</td>
                                                    <td>:</td>
                                                    <td>36.0 %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="card" style="height: 135px">
                                    <div class="card-body">
                                        <span class="text-bold">Munfiq</span><br>
                                        <table style="width: 100%">
                                            <tbody>
                                                <tr>
                                                    <td>Aktif</td>
                                                    <td>:</td>
                                                    <td>1705</td>
                                                </tr>
                                                <tr>
                                                    <td>Terjemput</td>
                                                    <td>:</td>
                                                    <td>187</td>
                                                </tr>
                                                <tr>
                                                    <td>Persentase</td>
                                                    <td>:</td>
                                                    <td>10.9 %</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="card" style="height: 135px">
                                    <div class="card-body">
                                        <span class="text-bold">Periode</span><br>
                                        <span class="-">Mei 2023</span><br>
                                        <span class="text-bold">Nominal</span><br>
                                        <span class="-">Rp.
                                            3.769.100,-</span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="">
                        <div class="mr-auto">
                            <span class="text-bold text-danger mr-auto">Belum diVerifikasi
                                Upzis</span><br>
                            <span>Verifikasi sebagai konfirmasi bahwa dana koin sudah diterima
                                upzis</span>
                        </div>
                        <button type="button" class="btn btn-outline-success"
                            onclick="openInNewTab('/koin-ranting/P05/05/2023')"><i class="fas fa-info-circle"></i>
                            Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        <script>
            function exportToExcel() {
                const wb = XLSX.utils.table_to_book(document.getElementById('example1'), {
                    sheet: 'Sheet 1'
                });
                XLSX.writeFile(wb, 'data.xlsx');
            }

            document.getElementById('exportButton').addEventListener('click', exportToExcel);
        </script>
        {{-- end card body --}}

    </div>
