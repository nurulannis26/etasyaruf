<div class="row">

    <div class="col col-md-12 col-sm-12">

        {{-- diinput oleh --}}
        <div class="card mt-3 ml-2 mr-2">
            <div class="card-body">
                <span>
                    <i class="fas fa-info-circle"></i>

                    Diinput oleh Petugas Pentasyarufan
                    ({{ $this->nama_pengurus_pc($data->pj_pc) }})
                </span>
            </div>
        </div>
        {{-- end diinput oleh --}}

        <div class="tab-survey-detail-umum-pc">
            {{-- card detail kegiatan --}}
            <div class="col col-md-12 col-sm-12 mt-2">
                {{-- detail --}}

                {{-- judul --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-clipboard-check"></i><b class="ml-2"> SURVEY</b>
                        <p class="tab-survey-status-detail-umum-pc d-inline">
                            @if ($survey == null)
                                <sup class="badge badge-danger text-white bg-warning mb-2">Belum Survey</sup>
                            @else
                                @if ($survey->survey_hasil == 'Disetujui')
                                    <sup class="badge badge-danger text-white bg-success mb-2">Sudah Survey</sup>
                                @else
                                    <sup class="badge badge-danger text-white bg-danger mb-2">Ditolak</sup>
                                @endif
                            @endif
                        </p>
                    </div>

                    @if (Auth::user()->gocap_id_pc_pengurus == $data->pj_pc and ($survey == null or $survey->survey_hasil == 'Ditolak'))
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
                                    <a wire:click="tombol_survey" onMouseOver="this.style.color='green'"
                                        onMouseOut="this.style.color='black'" class="dropdown-item" data-toggle="modal"
                                        data-target="#modal_acc" type="button"><i class="fas fa-user-check"></i>
                                        @if ($survey_hasil == 'Ditolak')
                                            Survey Ulang
                                        @else
                                            Survey
                                        @endif
                                    </a>

                                </div>
                            </div>

                        </div>
                    @endif

                </div>
                {{-- end judul --}}





                {{-- alert --}}
                @if (session()->has('alert_survey'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        <i class="far fa-check-circle"></i> {{ session('alert_survey') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                {{-- end alert --}}



                {{-- card acc --}}
                <div class="card card-body mt-3 mr-1 ml-1" style="display: {{ $none_block_survey }};">

                    <div class="d-flex justify-content-between align-items-center">
                        <b class="text-success">SURVEY</b>
                        <a wire:click="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>


                    {{-- form --}}
                    <form wire:submit.prevent="survey">
                        <div class="form-row mt-4">


                            {{-- nama surveyor --}}
                            <div class="form-group col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nama Surveyor</span>
                                    </div>
                                    <input value="{{ Auth::user()->nama }}" disabled type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end nama surveyor --}}

                            {{-- tgl_survey --}}
                            <div class="form-group col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tgl Survey</span>
                                    </div>
                                    <input wire:model="tgl_survey" type="date" class="form-control">
                                </div>
                            </div>
                            {{-- end tgl_survey --}}

                            {{-- nama mustahik --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nama Penerima Manfaat</span>
                                    </div>
                                    <input wire:model="nama_mustahik" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end nama mustahik --}}

                            {{-- alamat_mustahik --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Alamat Penerima Manfaat</span>
                                    </div>
                                    <input wire:model="alamat_mustahik" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end alamat_mustahik --}}

                            <span class="text-bold mb-2">Jenis permohonan bantuan ke Lazisnu Cilacap</span>
                            {{-- jenis_permohonan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Jawab</span>
                                    </div>
                                    <input wire:model="jenis_permohonan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end jenis_permohonan --}}
                            <span class="text-bold mb-2">A. Berapa jumlah anggota keluarga ?</span>
                            {{-- jumlah_anak --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Jumlah anak</span>
                                    </div>
                                    <input wire:model="jumlah_anak" type="number" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">orang</span>
                                    </div>
                                </div>
                            </div>
                            {{-- end jumlah_anak --}}
                            {{-- total_anggota --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jumlah total anggota keluarga</p>
                                    </div>
                                    <input wire:model="jumlah_total" type="number" class="form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text">orang</span>
                                    </div>
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}
                            <span class="text-bold mb-2">B. Apakah Masih mempunyai suami / istri ?</span>
                            {{-- punya suami/istri? --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="punya_pasangan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end punya suami/istri? --}}
                            <span class="text-bold mb-2">C. Apa pekerjaan anggota keluarga ?</span>
                            {{-- pekerjaan suami --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Pekerjaan Suami</p>
                                    </div>
                                    <input wire:model="pekerjaan_suami" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end pekerjaan suami --}}
                            {{-- pekerjaan istri --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Pekerjaan Istri</p>
                                    </div>
                                    <input wire:model="pekerjaan_istri" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end pekerjaan istri --}}
                            {{-- pekerjaan anak --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Pekerjaan Anak</p>
                                    </div>
                                    <input wire:model="pekerjaan_anak" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end pekerjaan anak --}}
                            <span class="text-bold mb-2">D. Berapa penghasilan keluarga ?</span>
                            {{-- penghasilan suami --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Penghasilan Suami</p>
                                    </div>
                                    <input wire:model="penghasilan_suami" type-currency="IDR" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end penghasilan suami --}}
                            {{-- penghasilan istri --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Penghasilan Istri</p>
                                    </div>
                                    <input wire:model="penghasilan_istri" type-currency="IDR" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end penghasilan istri --}}
                            {{-- penghasilan anak --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Penghasilan Anak</p>
                                    </div>
                                    <input wire:model="penghasilan_anak" type-currency="IDR" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end penghasilan anak --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold">E. Bagaimana kondisi rumah ?</span>
                            </div>
                            {{-- kondisi atap --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Atap</p>
                                    </div>
                                    <input wire:model="kondisi_atap" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kondisi atap --}}
                            {{-- kondisi dinding --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Dinding</p>
                                    </div>
                                    <input wire:model="kondisi_dinding" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kondisi dinding --}}
                            {{-- kondisi ukuran rumah --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Ukuran Rumah</p>
                                    </div>
                                    <input wire:model="kondisi_ukuran_rumah" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kondisi ukuran rumah --}}
                            {{-- kondisi lantai --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Lantai</p>
                                    </div>
                                    <input wire:model="kondisi_lantai" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kondisi lantai --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">F. Status kepemilikan rumah dan tanah ?</span>
                            </div>
                            {{-- kepemilikan rumah --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Rumah</p>
                                    </div>
                                    <input wire:model="kepemilikan_rumah" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kepemilikan rumah --}}
                            {{-- kepemilikan tanah --}}
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Tanah</p>
                                    </div>
                                    <input wire:model="kepemilikan_tanah" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kepemilikan tanah --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">G. Sebutkan harta / aset / kekayaan yang dimiliki ?</span>
                            </div>
                            {{-- harta / aset --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="harta_aset_kekayaan" type-currency="IDR" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end harta / aset --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">H. Berapa biaya / tanggungan / pengeluaran rutin setiap
                                    bulan dan untuk apa saja, jelaskan ?</span>
                            </div>
                            {{-- tanggungan rutin bulan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="tanggungan_rutin_bulan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end tanggungan rutin bulan --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">I. Apa saja kebutuhan yang sangat dibutuhkan untuk saat
                                    ini , berdasarkan pengajuan permohonan ke LAZISNU??</span>
                            </div>
                            {{-- kebutuhan yg di butuhkan --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="kebutuhan_yg_dibutuhkan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end kebutuhan yg di butuhkan --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">J. Bantuan apa saja yang sudah pernah di dapatkan, kapan
                                    dan dari mana / siapa ?</span>
                            </div>
                            {{-- bantuan yg pernah didapat --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="bantuan_yg_pernah_didapat" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end bantuan yg pernah didapat --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">RAKEPITULASI KELAYAKAN</span>
                            </div>
                            {{-- indeks kelayakan rumah --}}
                            <div class="form-group col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Indeks Rumah </p>
                                    </div>
                                    <select wire:model="indeks_rumah" id="" class="custom-select">
                                        <option value="layak">Layak</option>
                                        <option value="tidak layak">Tidak Layak</option>
                                    </select>
                                </div>
                            </div>
                            {{-- end indeks kelayakan rumah --}}
                            {{-- keterangan indeks rumah --}}
                            <div class="form-group col-md-8 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Keterangan</p>
                                    </div>
                                    <input wire:model="indeks_rumah_keterangan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end keterangan indeks rumah --}}
                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Kepemilikan Harta </p>
                                    </div>
                                    <select wire:model="indeks_harta" id="" class="custom-select">
                                        <option value="layak">Layak</option>
                                        <option value="tidak layak">Tidak Layak</option>
                                    </select>
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}
                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-8 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Keterangan</p>
                                    </div>
                                    <input wire:model="indeks_harta_keterangan" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}
                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-4 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Pendapatan </p>
                                    </div>
                                    <select wire:model="indeks_pendapatan" id="" class="custom-select">
                                        <option value="layak">Layak</option>
                                        <option value="tidak layak">Tidak Layak</option>
                                    </select>
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}
                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-8 col-sm-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Keterangan</p>
                                    </div>
                                    <input wire:model="indeks_pendapatan_keterangan" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}
                            <div class="col-md-12 mb-2">
                                <span class="text-bold mb-2">K. Rekomendasi dari surveyor beserta alasan tentang
                                    kelayakan dalam penerimaan bantuan dari LAZISNU </span>
                            </div>
                            {{-- tgl disetujui --}}
                            <div class="form-group col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <p class="input-group-text">Jawab</p>
                                    </div>
                                    <input wire:model="rokemendasi_surveyor" type="text" class="form-control">
                                </div>
                            </div>
                            {{-- end tgl disetujui --}}

                            {{-- lokasi --}}
                            {{-- <div class="form-group col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">&nbsp;Lokasi&nbsp;&nbsp;</span>
                                    </div>
                                    <input wire:model="survey_lokasi" type="text" class="form-control"
                                        placeholder="Masukan Lokasi">
                                </div>
                            </div> --}}
                            {{-- end lokasi --}}

                            {{-- hasil --}}
                            {{-- <div class="form-group col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span
                                            class="input-group-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </div>
                                    <select wire:model="survey_hasil" class=" custom-select">
                                        <option value="">Pilih Hasil</option>
                                        <option value="Disetujui">Disetujui</option>
                                        <option value="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                            </div> --}}
                            {{-- end hasil --}}

                            {{-- catatan --}}
                            {{-- <div class="form-group col-md-7">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Catatan</span>
                                    </div>
                                    <input wire:model="survey_catatan" type="text" class="form-control"
                                        placeholder="Masukan Catatan">
                                </div>
                            </div> --}}
                            {{-- end catatan --}}

                            {{-- info --}}
                            <div class="form-group col-md-12">
                                <div class="card card-body " style="background-color:#e0e0e0;">
                                    <b>INFORMASI!</b>
                                    <span>
                                        Dengan klik tombol Simpan, divisi penyaluran memberikan konfirmasi pengajuan
                                        telah
                                        disurvey & selanjutnya menunggu persetujuan oleh direktur
                                    </span>
                                </div>
                            </div>
                            {{-- end info --}}


                            <div class="form-group col-md-9">
                            </div>
                            <div class="form-group col-md-3 ">
                                @if (
                                    $tgl_survey == '' or
                                        $nama_mustahik == '' or
                                        $alamat_mustahik == '' or
                                        $jenis_permohonan == '' or
                                        $jumlah_anak == '' or
                                        $jumlah_total == '' or
                                        $punya_pasangan == '' or
                                        $pekerjaan_suami == '' or
                                        $pekerjaan_istri == '' or
                                        $pekerjaan_anak == '' or
                                        $penghasilan_suami == '' or
                                        $penghasilan_istri == '' or
                                        $penghasilan_anak == '' or
                                        $kondisi_atap == '' or
                                        $kondisi_dinding == '' or
                                        $kondisi_ukuran_rumah == '' or
                                        $kondisi_lantai == '' or
                                        $kepemilikan_rumah == '' or
                                        $kepemilikan_tanah == '' or
                                        $harta_aset_kekayaan == '' or
                                        $tanggungan_rutin_bulan == '' or
                                        $kebutuhan_yg_dibutuhkan == '' or
                                        $bantuan_yg_pernah_didapat == '' or
                                        $indeks_rumah == '' or
                                        $indeks_rumah_keterangan == '' or
                                        $indeks_harta == '' or
                                        $indeks_harta_keterangan == '' or
                                        $indeks_pendapatan == '' or
                                        $indeks_pendapatan_keterangan == '' or
                                        $rokemendasi_surveyor == '')
                                    <button class="btn btn-success btn-block" disabled wire:loading.attr="disabled"><i
                                            class="fas fa-check-circle"></i>
                                        Simpan</button>
                                @else
                                    <button type="submit" name="submit" class="btn btn-success btn-block"
                                        wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                        Simpan</button>
                                @endif
                            </div>
                            {{-- acc --}}


                    </form>




                </div>






            </div>
            {{-- end card acc --}}

            <table class="table table-bordered mt-2" style="border: 1px solid;">
                <thead>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Tgl Survey</td>
                        <td>
                            @if ($survey == null)
                                -
                            @else
                                {{ Carbon\Carbon::parse($survey->tgl_survey)->isoFormat('dddd, D MMMM Y') }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Hasil</td>
                        <td>
                            @if ($survey == null)
                                -
                            @else
                                {{ $survey->survey_hasil }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Lokasi</td>
                        <td>
                            @if ($survey == null)
                                -
                            @else
                                {{ $survey->survey_lokasi }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-bold " style="width: 30%">
                            Catatan</td>
                        <td>
                            @if ($survey == null)
                                -
                            @else
                                {{ $survey->survey_catatan }}
                            @endif
                        </td>
                    </tr>

                </thead>

            </table>

        </div>
        {{-- end detail --}}



    </div>

</div>







</div>
