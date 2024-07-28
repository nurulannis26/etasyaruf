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





<table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}"
                width="76" height="76" ></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}"
                width="146" height="76" ></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}"
                width="146" height="76"></td>
    </tr>
</table>


    <table cellpadding="0" cellspacing="0" style="width:531.6pt; border-collapse:collapse;">
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
    </table>

    <body>
        {{-- kertas kwitansi --}}
        <div style="clear: both; ">
           
            <?php
            // Save the current position
            $currentX = $pdf->GetX();
            $currentY = $pdf->GetY();
            
            // Calculate the center position for the image
            $xPosition = ($pdf->getPageWidth() - 50) / 2;
            $yPosition = $currentY + 56; // Adjust this value based on your requirements
            
            // Set the position for the image
            $pdf->SetXY($xPosition, $yPosition);
            
            // Set the alpha (opacity) for the image
            $pdf->SetAlpha(0.15);
            
            // Display the image (stempel) in the background
            $pdf->Image(public_path('/images/logo_lazisnu2.png'), $pdf->GetX(), $pdf->GetY(), 78);
            
            // Reset the alpha to 1 (fully opaque) for other elements
            $pdf->SetAlpha(1);
            
            // Restore the position to continue with the text
            $pdf->SetXY($currentX, $currentY);
            ?>
            

                <table
                    style="width:100%; height: 6cm; background-color:#E2EFD9; font-size:9pt; position: relative;page-break-inside: avoid;">
                    
                    <tr>
                        <td
                            style="width:20%;border-right:1px dashed  black;vertical-align:top;text-align:center;padding-top:3mm;position: relative">
                            <b>Telah terima dari</b>
                            <br>
                            <span class="a-custom-text">
                                @if ($data->tingkat == 'Upzis MWCNU')
                                UPZIS MWCNU
                                @endif
                                @if ($data->tingkat == 'Ranting NU')
                                PRNU
                                @endif
                            </span>
                            <br>
                            <span class="a2-custom-text">
                                @if ($data->tingkat == 'Upzis MWCNU')
                                {{ strtoupper($nama_upzis) }}
                                @endif
                                @if ($data->tingkat == 'Ranting NU')
                                {{ strtoupper($nama_ranting) }}
                                @endif
                            </span>
                        </td>
                        <td style="width:20%;vertical-align:top;text-align:center;padding-top:3mm">
                            <img src="{{ public_path('/images/logo_lazisnu2.png') }}" width="110" height="60"
                                style="margin: 0 auto; display: block; ">
                        </td>
                        <td style="width:55%;vertical-align:top;padding:2mm;text-align:center" colspan="3">
                            <span style="color:#008000;font-size:10pt">
                                <b> KWITANSI PENTASYARUFAN</b>
                            </span>
                            <br>
                            <span style="font-size:8pt">
                                NU CARE-LAZISNU CILACAP
                            </span>
                            <br>
                            <span style="font-size:8pt">
                                @if ($data->tingkat == 'Upzis MWCNU')
                                    UPZIS MWCNU {{ strtoupper($nama_upzis) }}
                                @elseif ($data->tingkat == 'Ranting NU')
                                    PRNU {{ strtoupper($nama_ranting) }}
                                @endif
                            </span>
                        </td>
                        <td style="width: 5%;">
                        </td>
                    </tr>

                    <tr>
                        <td style="width:20%;border-right:1px dashed  black;vertical-align:top;text-align:center;position: relative;"
                            rowspan="3">
                           <b>Digunakan Untuk</b> 
                            <br>
                            <span class="b-custom-text">
                                {{ $data->pengajuan_note }}
                            </span>
                        
                        </td>
                        <td style="width:20%;vertical-align:top;padding-left:4mm">
                            Telah terima dari &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td style="width:55%;vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;"
                            colspan="3"><span class="custom-text">@if ($data->tingkat == 'Upzis MWCNU')UPZIS MWCNU {{ strtoupper($nama_upzis) }}@endif @if ($data->tingkat == 'Ranting NU')PRNU {{ strtoupper($nama_ranting) }}@endif
                            </span>
                           
                        </td>
                        <td style="width:5%;">

                        </td>
                    </tr>


                    <tr>
                       
                        <td style=";vertical-align:top;padding-left:4mm">
                            Uang sejumlah &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td id="custom-cell"
                            style="vertical-align: top; text-align: left; position: relative;padding-top:1.5mm;"colspan="3"><span class="custom-text2">{{ terbilang($data->senilai) }}
                            </span>
                         
                        </td>
                        <td>

                        </td>




                    </tr>

                    <tr>
                        <td style=";vertical-align:top;padding-left:4mm;width: 20%;">
                            Digunakan untuk &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                        </td>
                        <td
                            style="vertical-align: top; text-align: left;padding-top: 1.5mm;width: 50%;" colspan="3">{{ $data->pengajuan_note }}
                        
                        </td>
                    
                    
                        <td style="width: 10%;">

                        </td>
                    </tr>

                    <tr>
                        <td style="border-right:1px dashed  black;vertical-align:top;text-align:center">

                        </td>
                        <td colspan="3" style="text-align:right;padding-right:6mm;">

                        </td>
                        <td style="text-align:center;">
                            {{ $data->tgl_berita ? Carbon\Carbon::parse($data->tgl_berita ?? null)->isoFormat('dddd,D MMMM Y') : '(............)' }}
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td
                            style="width:20%;border-right:1px dashed  black;vertical-align:top;text-align:left;padding-left:4mm;padding-right:4mm;">
                            
                            <div style="padding-left:2mm; border-top: 1px solid black;border-bottom: 1px solid black; ">
                                Rp{{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                            </div>
                            
                          
                        </td>
                        <td style="width:40%;vertical-align:top;padding-left:4mm" colspan="2">
                             
                            <div style="padding-left:2mm; border-top: 1px solid black;border-bottom: 1px solid black; ">
                                Rp{{ number_format($data->senilai ?? 0, 0, '.', '.') }}
                            </div>
                            
                        </td>
                        <td style="width: 20%;text-align:center;vertical-align:top">
                            Yang menerima
                            <br>
                            <br>
                              <br>
                            <br>
                            ({{ $data->nama2 ?? '..............' }})
                        </td>
                        <td style="width: 20%;text-align:center;vertical-align:top">
                            Yang menyalurkan
                            <br>
                            <br>
                              <br>
                            <br>
                            ({{ $data->nama1 ?? '..............' }})
                            <br>
                            <br>

                        </td>
                    </tr>


                </table>
                <br>
          

        </div>


    </body>
