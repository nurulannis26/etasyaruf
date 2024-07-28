<!DOCTYPE html>
<html>

<head>
    <title>Jurnal Umum Nomor {{ $detail_jurnal->nomor }}</title>
</head>

<body>
    <table cellspacing="0" cellpadding="0" style="border:none; border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <img width="120px;" src="{{ public_path('/images/logo_lazisnu.png') }}">
                </td>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:18pt;"><strong><span
                                style="font-family:Arial; color:green">Jurnal Umum</span></strong></p>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:18pt;"><strong><span
                                style="font-family:Arial; color:green">&nbsp;</span></strong></p>
                </td>
            </tr>
            <tr>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;"> Jenis Jurnal</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;">{{ $detail_jurnal->jenis }}</span></p>
                </td>
            </tr>
            <tr>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;">Tanggal&nbsp;</span></p>
                </td>
                <td style="width:115.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;">{{ date('d/m/Y', strtotime($detail_jurnal->tgl_transaksi)) }}
                        </span></p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><strong><span
                style="font-family:Arial; color:green">PC NU LAZISNU CILACAP</span></strong></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">Jl. Masjid No.9, Cilacap,
            Sidanegara,</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">Kec. Cilacap Tengah,</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">Kabupaten Cilacap,</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span><span style="font-family:Arial;">Jawa Tengah 53223.</span></p>
    <table cellspacing="0" cellpadding="0" style="border:0.75pt solid #000000; border-collapse:collapse;">
        <tbody>
            <tr style="text-align: center;background-color:#2F4F4F">
                <th
                    style="color:white;padding-top:5px; padding-bottom:5px;width:130.7pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span style="font-family:Arial;">Nama
                            Akun</span></p>
                </th>
                <th
                    style="color:white;padding-top:5px; padding-bottom:5px;width:130.95pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">Deskripsi</span></p>
                </th>
                <th
                    style="color:white;padding-top:5px; padding-bottom:5px;width:95.55pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">Debit</span></p>
                </th>
                <th
                    style="color:white;padding-top:5px; padding-bottom:5px;width:103.4pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">Kredit</span></p>
                </th>
            </tr>
            @foreach ($get_detail as $get)
                <tr>
                    <td
                        style="padding-top:5px; padding-bottom:5px;width:130.7pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:8pt; line-height:108%; font-size:12pt;"><span
                                style="font-family:Arial;">{{ $get->nomor_akun }} - {{ $get->nama_rekening }}
                            </span></p>
                    </td>
                    <td
                        style="padding-top:5px; padding-bottom:5px;width:130.95pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:8pt; line-height:108%; font-size:12pt;"><span
                                style="font-family:Arial;">{{ $get->deskripsi }}&nbsp;</span></p>
                    </td>
                    <td
                        style="padding-top:5px; padding-bottom:5px;width:95.55pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p
                            style="margin-top:0pt; margin-bottom:8pt; text-align:right; line-height:108%; font-size:12pt;">
                            <span style="font-family:Arial;">Rp. {{ number_format($get->debit, 0, ',', '.') }}</span>
                        </p>
                    </td>
                    <td
                        style="padding-top:5px; padding-bottom:5px;width:103.4pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p
                            style="margin-top:0pt; margin-bottom:8pt; text-align:right; line-height:108%; font-size:12pt;">
                            <span style="font-family:Arial;">Rp. {{ number_format($get->kredit, 0, ',', '.') }}</span>
                        </p>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2"
                    style="padding-top:5px; padding-bottom:5px;width:272.45pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span
                            style="font-family:Arial;">Total</span></p>
                </th>
                <td
                    style="padding-top:5px; padding-bottom:5px;width:95.55pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;"> Rp.
                            {{ number_format($get_detail->sum('debit'), 0, ',', '.') }}</span>
                    </p>
                </td>
                <td
                    style="padding-top:5px; padding-bottom:5px;width:103.4pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:right; font-size:12pt;"><span
                            style="font-family:Arial;"> Rp.
                            {{ number_format($get_detail->sum('debit'), 0, ',', '.') }}</span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    @php
        function terbilang($number)
        {
            $words = [
                1 => 'satu',
                2 => 'dua',
                3 => 'tiga',
                4 => 'empat',
                5 => 'lima',
                6 => 'enam',
                7 => 'tujuh',
                8 => 'delapan',
                9 => 'sembilan',
                10 => 'sepuluh',
                11 => 'sebelas',
                100 => 'seratus',
                1000 => 'seribu',
                1000000 => 'satu juta',
                1000000000 => 'satu miliar',
            ];
        
            if ($number < 12) {
                return $words[$number];
            }
        
            if ($number < 20) {
                return terbilang($number - 10) . ' belas';
            }
        
            if ($number < 100) {
                $tens = floor($number / 10);
                $remainder = $number % 10;
                $result = terbilang($tens) . ' puluh';
                if ($remainder > 0) {
                    $result .= ' ' . terbilang($remainder);
                }
                return $result;
            }
        
            if ($number < 200) {
                return 'seratus ' . terbilang($number - 100);
            }
        
            if ($number < 1000) {
                $hundreds = floor($number / 100);
                $remainder = $number % 100;
                $result = terbilang($hundreds) . ' ratus';
                if ($remainder > 0) {
                    $result .= ' ' . terbilang($remainder);
                }
                return $result;
            }
        
            if ($number < 2000) {
                return 'seribu ' . terbilang($number - 1000);
            }
        
            if ($number < 1000000) {
                $thousands = floor($number / 1000);
                $remainder = $number % 1000;
                $result = terbilang($thousands) . ' ribu';
                if ($remainder > 0) {
                    $result .= ' ' . terbilang($remainder);
                }
                return $result;
            }
        
            if ($number < 1000000000) {
                $millions = floor($number / 1000000);
                $remainder = $number % 1000000;
                $result = terbilang($millions) . ' juta';
                if ($remainder > 0) {
                    $result .= ' ' . terbilang($remainder);
                }
                return $result;
            }
        
            $billions = floor($number / 1000000000);
            $remainder = fmod($number, 1000000000);
            $result = terbilang($billions) . ' miliar';
            if ($remainder > 0) {
                $result .= ' ' . terbilang($remainder);
            }
            return $result;
        }
    @endphp




    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">Terbilang : &nbsp;</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span style="font-family:Arial;">
            {{ ($terbilang = ucwords(terbilang($get_detail->sum('debit')))) === 'Satu' ? 'Seribu' : $terbilang }}
            Rupiah</span></p>
    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span></p>

    <table cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:157.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span
                            style="font-family:Arial;">Dengan Hormat,</span></p>
                </td>
            </tr>
            <tr>
                <td style="width:157.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                        style="font-family:Arial;">&nbsp;</span></p>
                    <img style="margin-left: 50px"
                                src="https://gocapv2.nucarecilacap.id/uploads/ttd/1705916035.Veni%20Mutia%20Sari,%20S.Ak.jpg"
                                alt="Tanda tangan" width="100" height="70">
                </td>
            </tr>
            <tr>
                <td style="width:157.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><u><span
                                style="font-family:Arial;">{{ $nama->nama }} </span></u></p>
                </td>
            </tr>
            <tr>
                <td style="width:157.1pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; font-size:12pt;"><span
                            style="font-family:Arial;">&nbsp;</span></p>
                </td>
                <td style="width:157.15pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;"><span
                            style="font-family:Arial;">{{ $jabatan->jabatan }}</span></p>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:0pt; margin-bottom:8pt; line-height:normal; font-size:12pt;"><span
            style="font-family:Arial;">&nbsp;</span></p>
</body>

</html>
