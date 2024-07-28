<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>
    <style>
        body {
            line-height: 115%;
            font-family: Calibri;
            font-size: 11pt;
            margin-left: 10px;
            margin-right: 10px;
        }

        p {
            margin: 0pt 0pt 10pt
        }

        li,
        table {
            margin-top: 0pt;
            margin-bottom: 10pt
        }

        .ListParagraph {
            margin-left: 36pt;
            margin-bottom: 10pt;
            line-height: 115%;
            font-size: 11pt
        }
    </style>
</head>

<body>

    <table style="width:436.75pt; margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse; !important;">
        <tbody>
            <tr style="height:30.65pt;">
                <td
                    style="width:110.75pt; border-right:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><br><strong><span
                                style="font-family:'Arial Narrow';"><img width="80px;" height="50px;"
                                    src="{{ public_path('/disposisi_penyaluran/nucare.png') }}"></span></strong></p>
                </td>
                <td
                    style="width:270.4pt; border-right:0.75pt solid #000000; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;font-size:15px;">
                        <br><strong><span style="font-family:'Arial Narrow';">TANDA TERIMA SURAT / DOKUMEN /
                                BARANG</span></strong>
                    </p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;font-size:15px;"><strong><span
                                style="font-family:'Arial Narrow';">FRONT OFFICE NUCARE LAZISNU
                                CILACAP&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:110.45pt; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><br><strong><span
                                style="font-family:'Arial Narrow';"><img width="80px;" height="50px;"
                                    src="{{ public_path('/disposisi_penyaluran/gerakan_nu.png') }}"></span></strong></p>
                    <p style="margin-bottom:0pt; line-height:normal;"><strong><span
                                style="font-family:'Arial Narrow';">&nbsp;</span></strong></p>
                </td>
            </tr>
        </tbody>
    </table>


    <p style="line-height:108%;"><span style="font-family:Arial;">&nbsp;</span></p>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td
                    style="width:70pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Jenis</span></p>
                </td>
                <td
                    style="width:3.4pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>

                <td
                    style="width:80pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="barangCheckbox" name="barangCheckbox" value="barang"
                            style="vertical-align: middle;" @if ($jenis_penerima == 'barang') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="barangCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_penerima == 'barang')
                                <b>Barang</b>
                            @else
                                Barang
                            @endif
                        </label>
                    </div>
                </td>

                <td
                    style="width:80pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="dokumenCheckbox" name="dokumenCheckbox" value="dokumen"
                            style="vertical-align: middle;" @if ($jenis_penerima == 'dokumen') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="dokumenCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_penerima == 'dokumen')
                                <b>Dokumen</b>
                            @else
                                Dokumen
                            @endif
                        </label>
                    </div>
                </td>


                <td
                    style="width:80pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="suratCheckbox" name="suratCheckbox" value="surat"
                            style="vertical-align: middle;" @if ($jenis_penerima == 'surat') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="suratCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_penerima == 'surat')
                                <b>Surat</b>
                            @else
                                Surat
                            @endif
                        </label>
                    </div>
                </td>

                <td
                    style="width:80pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <div style="display: inline-block; vertical-align: middle;">
                        <input type="checkbox" id="lainnyaCheckbox" name="lainnyaCheckbox" value="lainnya"
                            style="vertical-align: middle;" @if ($jenis_penerima == 'lainnya') checked @else @endif>
                    </div>
                    <div style="display: inline-block; vertical-align: middle;">
                        <label for="lainnyaCheckbox" style="vertical-align: middle;">&nbsp;@if ($jenis_penerima == 'lainnya')
                                <b>Lainnya</b>
                            @else
                                Lainnya
                            @endif
                        </label>
                    </div>
                </td>

            </tr>
            @if ($D_pengajuan->lainnya)
                <tr>
                    <td colspan="2"
                        style="width:144.9pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td colspan="4"
                        style="width:364.55pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p><span style="font-family:Arial;">({{ $D_pengajuan->lainnya }})</span></p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- <p style="line-height:108%;"><span style="font-family:Arial;">&nbsp;</span></p> --}}
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                @if ($pengajuan->opsi_pemohon == 'Entitas')
                    <td
                        style="width:70.7pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span style="font-family:Arial;">Nama Entitas</span></p>
                    </td>
                @else
                    <td
                        style="width:70.7pt; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span style="font-family:Arial;">Nama Pemohon</span></p>
                    </td>
                @endif
                <td
                    style="width:3.4pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                @if ($pengajuan->opsi_pemohon == 'Entitas')
                    <td
                        style="width:130pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->nama_entitas }}</span>
                        </p>
                    </td>
                @elseif ($pengajuan->opsi_pemohon == 'Individu')
                    <td
                        style="width:130pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->nama_pemohon }}</span>
                        </p>
                    </td>
                @else
                    <td
                        style="width:130pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ app('App\Http\Controllers\PrintPenyaluranController')->nama_pengurus_pc($pengajuan->pemohon_internal) }}</span>
                        </p>
                    </td>
                @endif
                <td
                    style="width:70.8pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Tujuan Surat</span></p>
                </td>
                <td
                    style="width:3.3pt; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:170.55pt; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Front Office PC Lazisnu
                            Cilacap</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:70.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Tanggal surat</span><span
                            style="width:4.74pt; font-family:Arial; display:inline-block;">&nbsp;</span></p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:75.5pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">
                            @if ($D_pengajuan->tgl_surat)
                                {{ Carbon\Carbon::parse($D_pengajuan->tgl_surat)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </p>
                </td>
                <td
                    style="width:70.8pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Perihal</span><span
                            style="width:2.98pt; font-family:Arial; display:inline-block;">&nbsp;</span></p>
                </td>
                <td
                    style="width:3.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:170.55pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span
                            style="font-family:Arial;">{{ $D_pengajuan->pengajuan_note }}</span>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:70.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">Nomor Surat</span></p>
                </td>
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:75.5pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">{{str_replace("/","/ ",$D_pengajuan->no_surat)}}</span>
                    
                    </p>
                </td>

                <td
                    style="width:70.8pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">No.HP</span></p>
                </td>
                <td
                    style="width:3.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:170.55pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;">
                        @if ($pengajuan->opsi_pemohon == 'Entitas')
                            <span style="font-family:Arial;">{{ $D_pengajuan->no_hp_entitas }}</span>
                        @elseif($pengajuan->opsi_pemohon == 'Individu')
                            <span style="font-family:Arial;">{{ $D_pengajuan->nohp_pemohon }}</span>
                        @elseif($pengajuan->opsi_pemohon == 'Internal')
                            <span
                                style="font-family:Arial;">{{ app('App\Http\Controllers\PrintPenyaluranController')->nohp_pengurus_pc($pengajuan->pemohon_internal) }}</span>
                        @endif

                    </p>
                </td>
            </tr>
            <tr>
                @if ($pengajuan->opsi_pemohon == 'Entitas')
                    <td
                        style="width:70.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span style="font-family:Arial;">Alamat Entitas</span></p>
                    </td>
                @else
                    <td
                        style="width:70.7pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span style="font-family:Arial;">Alamat Pemohon</span></p>
                    </td>
                @endif
                <td
                    style="width:3.4pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                @if ($pengajuan->opsi_pemohon == 'Entitas')
                    <td
                        style="width:75.5pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->alamat_entitas }}</span>
                        </p>
                    </td>
                @elseif($pengajuan->opsi_pemohon == 'Individu')
                    <td
                        style="width:75.5pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ $D_pengajuan->alamat_pemohon }}</span>
                        </p>
                    </td>
                @else
                    <td
                        style="width:75.5pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="line-height:108%;"><span
                                style="font-family:Arial;">{{ app('App\Http\Controllers\PrintPenyaluranController')->alamat_pc($pengajuan->pemohon_internal) }}</span>
                        </p>
                    </td>
                @endif
                <td
                    style="width:70.8pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">No. Pengajuan</span></p>
                </td>
                <td
                    style="width:3.3pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span style="font-family:Arial;">:</span></p>
                </td>
                <td
                    style="width:170.55pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="line-height:108%;"><span
                            style="font-family:Arial;">{{ $pengajuan->nomor_surat }}</span>
                    </p>
                </td>
            </tr>

        </tbody>
    </table>
    <p><em><span style="font-family:Arial;">&nbsp;</span></em></p>
    <table style="margin-bottom:0pt; border:0.75pt solid #FFFFFF; border-collapse:collapse;">
        <tbody>
            <tr>
                <td colspan="3"
                    style="width:520.25pt; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center;"><span style="font-family:Arial;">Diterima tanggal :
                            @if ($pengajuan->tgl_pengajuan)
                                {{ Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->isoFormat('dddd, D MMMM Y') }}
                            @else
                                -
                            @endif
                        </span><em><span style="font-family:Arial;"></span></em>
                    </p>
                </td>
            </tr>
            <tr>
                <td
                    style="width:173.25pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center;"><strong><span style="font-family:Arial;">Pengirim</span></strong>
                    </p>
                    {{-- <p><em><span style="font-family:Arial;">&nbsp;</span></em></p> --}}
                </td>
                <td
                    style="width:138.05pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td
                    style="width:187.35pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center; line-height:normal;"><strong><span
                                style="font-family:Arial;">Penerima</span></strong></p>
                    {{-- <p><em><span style="font-family:Arial;">&nbsp;</span></em></p> --}}
                </td>
            </tr>
            <tr>
                <td
                    style="width:173.25pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center;"><strong><span style="font-family:Arial;">&nbsp;</span></strong></p>
                </td>
                <td
                    style="width:138.05pt; border:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p><span style="font-family:Arial;">&nbsp;</span></p>
                </td>

                <td
                    style="width:166.2pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-bottom:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top; text-align: center;">
                    <strong><span style="font-family:Arial;">Front
                            Office PC LAZISNU CILACAP</span></strong> <br>
                    <img src="https://gocapv2.nucarecilacap.id/uploads/ttd/1697185584.ACHMAD%20MUTOHAR.jpg"
                        width="100px" height="80px">

                    <br>

                </td>
            </tr>
            <tr>
                <td
                    style="width:173.25pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center;"><strong><span style="font-family:Arial;">
                                @if ($pengajuan->opsi_pemohon == 'Entitas')
                                    {{ $D_pengajuan->nama_pj_permohonan_entitas }}
                                @elseif ($pengajuan->opsi_pemohon == 'Individu')
                                    {{ $D_pengajuan->nama_pemohon }}
                                @else
                                    {{ app('App\Http\Controllers\PrintPenyaluranController')->nama_pengurus_pc($pengajuan->pemohon_internal) }}
                                @endif
                            </span></strong>
                    </p>
                </td>
                <td
                    style="width:138.05pt; border-top:0.75pt solid #FFFFFF; border-right:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p><span style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td
                    style="width:187.35pt; border-top:0.75pt solid #FFFFFF; border-left:0.75pt solid #FFFFFF; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="text-align:center; line-height:normal;"><strong><span style="font-family:Arial;">ACHMAD
                                MUTOHAR</span></strong></p>
                </td>
            </tr>
        </tbody>
    </table>
    <p><em><span style="font-family:Arial;">&nbsp;</span></em></p>


</body>

</html>
