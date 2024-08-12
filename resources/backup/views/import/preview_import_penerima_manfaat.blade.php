<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- CSS SPIN LOAD  --}}
    <style>
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: black;
            z-index: 9999;
            display: none;
            opacity: 0.5;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 60px;
            height: 60px;
            border-style: solid;
            border-color: white;
            border-top-color: transparent;
            border-width: 9px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
    {{-- AKHIR SPIN LOAD --}}
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" style="display: flex; flex-direction: column; align-items: center;">
        <h3>PREVIEW TABLE HASIL IMPORT EXCEL ARSIP</h3>
        <!-- Tombol Simpan dan Batal -->
        <div style="display: flex; gap: 10px;">
            <form action="{{ route('import_save') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pengajuan" value="{{ $data }}">
                <input type="hidden" name="id_pengajuan_detail" value="{{ $data_detail }}">
                <input type="hidden" name="nama_file" value="{{ $nama_file }}">
                <button id="save-button" type="submit"
                    style="background-color: #4CAF50; color: white; padding: 8px 16px; border: none; cursor: pointer; border-radius: 4px;">
                    Simpan
                </button>
            </form>
            <form action="{{ route('import_cancel') }}" method="POST">
                @csrf
                <input type="hidden" name="nama_file" value="{{ $nama_file }}">
                <input type="hidden" name="id_pengajuan" value="{{ $data }}">
                <input type="hidden" name="id_pengajuan_detail" value="{{ $data_detail }}">
                <button id="cancel-button" type="submit"
                    style="background-color: #f44336; color: white; padding: 8px 16px; border: none; cursor: pointer; border-radius: 4px;">
                    Batal
                </button>
            </form>
        </div>

        <br>

        <div id="cover-spin"></div>
        <table style="border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">No</th>
                    <th style="border: 1px solid black; padding: 8px;">TGL PENYALURAN BANTUAN</th>
                    <th style="border: 1px solid black; padding: 8px;">TARGET PENERIMA MANFAAT</th>
                    <th style="border: 1px solid black; padding: 8px;">NIK</th>
                    <th style="border: 1px solid black; padding: 8px;">NO KK</th>
                    <th style="border: 1px solid black; padding: 8px;">NO HP</th>
                    <th style="border: 1px solid black; padding: 8px;">NOMINAL BANTUAN</th>
                    <th style="border: 1px solid black; padding: 8px;">JENIS BANTUAN</th>
                    <th style="border: 1px solid black; padding: 8px;">ALAMAT</th>
                    <th style="border: 1px solid black; padding: 8px;">KETERANGAN</th>



                </tr>
            </thead>
            <tbody>
                @foreach ($rows[0] as $index => $row)
                    @php
                        // Nilai numerik serial dari Excel
                        $excelSerialDate = $row[0];

                        // Dasar tanggal di Excel (1 Januari 1900)
                        $baseDate = \Carbon\Carbon::createFromDate(1900, 1, 1);

                        // Lakukan konversi
                        $tanggalBantuan = $baseDate->addDays($excelSerialDate - 2)->format('d-m-Y');
                    @endphp
                    <tr>
                        <td style="border: 1px solid black; padding: 8px;">{{ $index + 1 }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $tanggalBantuan }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[1] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[2] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[3] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[4] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[5] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[6] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[7] }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $row[8] }}</td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- JavaScript --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Tangkap elemen tombol "Simpan" dan "Batal"
                var saveButton = document.querySelector("#save-button");
                var cancelButton = document.querySelector("#cancel-button");
                var spinner = document.querySelector("#cover-spin");

                // Tambahkan event listener untuk saat tombol "Simpan" diklik
                saveButton.addEventListener("click", function() {
                    spinner.style.display = "block"; // Tampilkan spinner
                });

                // Tambahkan event listener untuk saat tombol "Batal" diklik
                cancelButton.addEventListener("click", function() {
                    spinner.style.display = "block"; // Tampilkan spinner
                });
            });
        </script>
    </div>
</body>

</html>
