<?php
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
    $temp = '';
    if ($nilai < 12) {
        $temp = ' ' . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = penyebut($nilai - 10) . ' Belas';
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai / 10) . ' Puluh' . penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = ' Seratus' . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . ' Ratus' . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = ' Seribu' . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . ' Ribu' . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . ' Juta' . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . ' Milyar' . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . ' Trilyun' . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = 'Minus ' . trim(penyebut($nilai));
    } elseif ($nilai == 0) {
        $hasil = 'Nol ' . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil . ' Rupiah';
}

?>


{{-- <table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}"
                width="76" height="76" ></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                width="146" height="76" ></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}"
                width="146" height="76"></td>
    </tr>
</table> --}}

    {{-- <table cellpadding="0" cellspacing="0" style="width:531.6pt; border-collapse:collapse;">
        <tbody>
            <tr>
                <td colspan="5"
                    style="width:520.8pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                 <br>
                    <p
                        style="margin-top:6pt; margin-bottom:0pt; text-align:center; line-height:125%; font-size:11pt;">
                        <strong><span>KWITANSI PENERIMA MANFAAT</span></strong>
                    </p>

                  
                </td>
            </tr>
        </tbody>
    </table> --}}

    <body>
        {{-- kertas kwitansi --}}
        <div style="clear: both; ">
           
            <?php
            // Save the current position
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            
            // Calculate the center position for the image
            $xPosition = ($pdf->getPageWidth() - 60) / 2;
            $yPosition = $currentY + 30; // Adjust this value based on your requirements
            
            // Set the position for the image
            $pdf->SetXY($xPosition, $yPosition);
            
            // Set the alpha (opacity) for the image
            $pdf->SetAlpha(0.15);
            
            // Display the image (stempel) in the background
            $pdf->Image(public_path('/images/logo_lazisnu2.png'), $pdf->GetX(), $pdf->GetY(), 70);
            
            // Reset the alpha to 1 (fully opaque) for other elements
            $pdf->SetAlpha(1);
            
            // Restore the position to continue with the text
            $pdf->SetXY($currentX, $currentY);
            ?>
            
            <table style="width:100%; height: 6cm; background-color:#E2EFD9; font-size:10pt; position: relative;page-break-inside: avoid;">
                <tr><td></td></tr>
            <tr>
                <td style="width:5%;"></td>
                <td style="width:20%;vertical-align:top;padding-top:3mm">
                    <img src="{{ public_path('/images/logo_lazisnu2.png') }}" width="110" height="60"
                        style="margin: 0 auto; display: block; ">
                </td>
                <td style="width:70%;vertical-align:top;padding:2mm;text-align:left" colspan="3"><span style="font-size:13pt"><b> KUITANSI PENTASYAARUFAN</b></span>
                    <br>
                    <span style="font-size:12pt">NU CARE-LAZISNU CILACAP
                    </span>
                    <br>
                    <span style="font-size:8pt">Alamat: Jalan Masjid No. 9 Kelurahan Sidanegara Kecamatan Cilacap Tengah Cp: 081228221010
                    </span>

                  <u><hr style="text-decoration: underline; border-bottom: 1px solid #000;"></u>
                </td>
                    <td style="width:5%"></td>
            </tr>

            </table>


                <table style="width:100%; height: 6cm; background-color:#E2EFD9; position: relative;page-break-inside: avoid;font-size:12px;">
                    <tr>
                        <td style="width:95%; text-align: right;"><b>{{ strtoupper($data->nomor_surat) }}</b></td>
                        <td style="width:5%;">
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:20%;vertical-align:top;padding-left:4mm;text-align:left;">
                            Telah terima dari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 
                        </td>
                        <td style="width:70%;vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;" colspan="3"><span class="custom-text">@if ($data->tingkat == 'Upzis MWCNU')UPZIS MWCNU {{ strtoupper($nama_upzis) }} @elseif ($data->tingkat == 'Ranting NU')PRNU {{ strtoupper($nama_ranting) }}@else NU CARE LAZISNU CILACAP @endif
                            </span>
                           
                        </td>
                        <td style="width:5%;">
                        </td>
                    </tr>


                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:20%;vertical-align:top;padding-left:4mm;text-align:left;">
                            Uang sejumlah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td id="custom-cell"
                            style="vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;width:70%;"colspan="3"><span class="custom-text2">{{ terbilang($data->senilai) }}
                            </span>
                         
                        </td>
                        <td style="width:5%;">
                        </td>
                    </tr>

                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:20%;vertical-align:top;padding-left:4mm;text-align:left;">
                            Digunakan untuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td
                            style="vertical-align: top; text-align: left;padding-top: 1.5mm;width: 50%;width:70%;" colspan="3">{{ $data->pengajuan_note }}
                        </td>
                        <td style="width:5%;">
                        </td>
                    </tr>

                </table>

                <table
                style="width:100%; height: 6cm; background-color:#E2EFD9; position: relative;page-break-inside: avoid;font-size:12px;">
                    
                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:46%;vertical-align:top;padding-left:4mm;" colspan="2">     
                            <div style="padding-left:2mm; border-top: 1px solid black;border-bottom: 1px solid black; ">
                                Rp{{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                            </div>
                        </td>
                        <td style="width: 22%;text-align:center;vertical-align:top">
                            <br><br>
                            Yang menerima
                            <br>
                            <br>
                              <br>
                            <br><br>
                            ({{ $data->nama2 ?? '..............' }})
                        </td>
                        <td style="width: 22%;text-align:center;vertical-align:top">
                            <br>
                            {{ $data->tgl_berita ? Carbon\Carbon::parse($data->tgl_berita ?? null)->isoFormat('dddd,D MMMM Y') : '(............)' }} 
                            <br>Yang menyalurkan
                            <br>
                            <br>
                              <br>
                            <br><br>
                            ({{ $data->nama1 ?? '..............' }})
                            <br>
                        
                        </td>

                        <td style="width:5%;"></td>
                    </tr>


                </table>
                <br>
          

        </div>


    </body>
