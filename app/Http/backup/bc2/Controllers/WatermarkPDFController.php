<?php

namespace App\Http\Controllers;

use App\Models\PengajuanDetail;
use ZendPdf\Image;
use ZendPdf\PdfDocument;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
// use Illuminate\Http\StreamedResponse;

class WatermarkPDFController extends Controller
{
    
    public function generateWatermarkedPDF($id_pengajuan_detail)
    {

        $etasyaruf = config('app.database_etasyaruf');
        $data = PengajuanDetail::where('id_pengajuan_detail', $id_pengajuan_detail)
            ->join($etasyaruf . '.pengajuan', $etasyaruf . '.pengajuan.id_pengajuan', '=', $etasyaruf . '.pengajuan_detail.id_pengajuan')
            ->first();

            if($data->status_berita == 'Sudah Diperiksa'){

        $inputPdf = public_path('/uploads/pengajuan_berita/'. $data->file_berita); 
        $watermarkImage = public_path('/images/ttd_muafah.png');
        $outputPdf =public_path('/uploads/pengajuan_berita2/12345.pdf');

        $pdf = PdfDocument::load($inputPdf);
        $image = Image::imageWithPath($watermarkImage);

        $firstPage = $pdf->pages[0]; // Get the first page

        $firstPage->saveGS(); // Save graphics state

        // Set the desired position and size of the watermark
        $xPercentage = 64; // Posisi horizontal (persentase dari lebar halaman)
        $yPercentage = 80.5; // Posisi vertikal (persentase dari tinggi halaman)
        $widthPercentage = 28; // Lebar gambar (persentase dari lebar halaman)
        $heightPercentage = 13; // Tinggi gambar (persentase dari tinggi halaman)
        
        $x = ($firstPage->getWidth() * $xPercentage) / 100;
        $y = ($firstPage->getHeight() * (100 - $yPercentage)) / 100; // Karena koordinat y terbalik pada PDF
        $width = ($firstPage->getWidth() * $widthPercentage) / 100;
        $height = ($firstPage->getHeight() * $heightPercentage) / 100;

        // Draw the image on the first page with specified size and position
        $firstPage->drawImage($image, $x, $y, $x + $width, $y + $height);

        $firstPage->restoreGS(); // Restore graphics state


        // Teks yang akan digunakan sebagai watermark
        $watermarkText =   $data->tgl_diperiksa ? \Carbon\Carbon::parse($data->tgl_diperiksa)->isoFormat('DD-MM-Y') : '........ - ........- 20......' ;

        // Ambil halaman pertama dari PDF
        $firstPage1 = $pdf->pages[0];

        // Set font dan ukuran font
        $font = \ZendPdf\Font::fontWithName(\ZendPdf\Font::FONT_HELVETICA);
        $firstPage1->setFont($font, 10);

        // Tentukan posisi dan ukuran teks watermark dalam persentase dari halaman
        $xPercentage1 = 78; // Posisi horizontal (persentase dari lebar halaman)
        $yPercentage1 = 70; // Posisi vertikal (persentase dari tinggi halaman)
        $widthPercentage1 = 23; // Lebar teks (persentase dari lebar halaman)
        $heightPercentage1 = 10; // Tinggi teks (persentase dari tinggi halaman)

        $x1 = ($firstPage1->getWidth() * $xPercentage1) / 100;
        $y1 = ($firstPage1->getHeight() * (100 - $yPercentage1)) / 100; // Karena koordinat y terbalik pada PDF
        $width1 = ($firstPage1->getWidth() * $widthPercentage1) / 100;
        $height1 = ($firstPage1->getHeight() * $heightPercentage1) / 100;

        // Tambahkan teks sebagai watermark pada halaman pertama
        $firstPage1->drawText($watermarkText, $x1, $y1);

            // Save the PDF with watermark
        file_put_contents($outputPdf, $pdf->render());

        // Create a callback function to generate the stream
        $callback = function () use ($outputPdf) {
            readfile($outputPdf);
            unlink($outputPdf); // Optionally, remove the temporary file after streaming
        };

        // Set the appropriate headers for streaming
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'filename=BA-' . Helper::getDataKegiatan($data->id_program_kegiatan)->pluck('nama_program')->first() . '-' . $data->nomor_surat . '_ACC.pdf',
        ];

        // Create a StreamedResponse with the callback and headers
        $response = new StreamedResponse($callback, 200, $headers);

        return $response;}
        else{
            return;
        }
    }

}
