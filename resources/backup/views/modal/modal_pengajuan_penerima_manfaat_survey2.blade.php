@if (Auth::user()->gocap_id_pc_pengurus != null)
    {{--  tambah program_penguatan_kelembagaan --}}
    <div wire:ignore.self class="modal fade" id="modal_pengajuan_penerima_manfaat_survey2" data-backdrop="static"
        tabindex="-1" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        SURVEY PENERIMA MANFAAT
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>



                {{-- modal body --}}
                <div class="modal-body">
                    {{-- <livewire:my-component wire:key="my-component-{{ \Illuminate\Support\Str::random(10) }}" /> --}}
                    <div class="container">
                        {{-- form --}}
                        <form wire:submit.prevent="survey">

                            <div class="form-row">


                                {{-- nama surveyor --}}
                                <div class="form-group col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark" style="width: 200px">Nama
                                                Surveyor</span>
                                        </div>
                                        <input value="{{ Auth::user()->nama }}" disabled type="text"
                                            class="form-control">
                                    </div>
                                </div>
                                {{-- end nama surveyor --}}

                                <style>
                                    @media only screen and (max-width: 765px) {
                                        .sss {
                                            width: 200px
                                        }
                                    }
                                </style>
                                {{-- tgl_survey --}}
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark sss">Tgl Survey</span>
                                        </div>
                                        <input wire:model="tgl_survey" type="date" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end tgl_survey --}}

                                {{-- nama mustahik --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark" style="width: 200px">Nama Penerima
                                                Manfaat</span>
                                        </div>
                                        <input wire:model="nama_mustahik" disabled type="text" class="form-control">
                                    </div>
                                </div>
                                {{-- end nama mustahik --}}

                                {{-- alamat_mustahik --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark" style="width: 200px">Alamat Penerima
                                                Manfaat</span>
                                        </div>
                                        <input wire:model="alamat_mustahik" disabled type="text"
                                            class="form-control">
                                    </div>
                                </div>
                                {{-- end alamat_mustahik --}}
                                {{-- jenis_permohonan --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }} "
                                                style="width: 200px">Lokasi Survey</span>
                                        </div>
                                        <input wire:model="survey_lokasi" type="text" class="form-control "
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end jenis_permohonan --}}

                                <span class="text-bold mb-2">Jenis permohonan bantuan ke Lazisnu Cilacap</span>
                                {{-- jenis_permohonan --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">Jawab</span>
                                        </div>
                                        <input wire:model="jenis_permohonan" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end jenis_permohonan --}}
                                <span class="text-bold mb-2">A. Berapa jumlah anggota keluarga ?</span>
                                {{-- jumlah_anak --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 230px">Jumlah anak</span>
                                        </div>
                                        <input wire:model="jumlah_anak" type="number" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">orang</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- end jumlah_anak --}}
                                {{-- total_anggota --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 230px">Jumlah total anggota keluarga</p>
                                        </div>
                                        <input wire:model="jumlah_total" type="number" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">orang</span>
                                        </div>
                                    </div>
                                </div>
                                {{-- end tgl disetujui --}}
                                <span class="text-bold mb-2">B. Apakah Masih mempunyai suami / istri ?</span>
                                {{-- punya suami/istri? --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <select wire:model="punya_pasangan" class="form-control" id=""
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                            <option selected></option>
                                            <option value="ya">Ya, Punya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                        {{-- <input wire:model="punya_pasangan" type="text" class="form-control"> --}}
                                    </div>
                                </div>
                                {{-- end punya suami/istri? --}}
                                <span class="text-bold mb-2">C. Apa pekerjaan anggota keluarga ?</span>
                                {{-- pekerjaan suami --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Pekerjaan Suami</p>
                                        </div>
                                        <input wire:model="pekerjaan_suami" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end pekerjaan suami --}}
                                {{-- pekerjaan istri --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Pekerjaan Istri</p>
                                        </div>
                                        <input wire:model="pekerjaan_istri" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end pekerjaan istri --}}
                                {{-- pekerjaan anak --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Pekerjaan Anak</p>
                                        </div>
                                        <input wire:model="pekerjaan_anak" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end pekerjaan anak --}}
                                <span class="text-bold mb-2">D. Berapa penghasilan keluarga ?</span>
                                {{-- penghasilan suami --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Penghasilan Suami</p>
                                        </div>
                                        <input wire:model="penghasilan_suami" type-currency="IDR" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end penghasilan suami --}}
                                {{-- penghasilan istri --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Penghasilan Istri</p>
                                        </div>
                                        <input wire:model="penghasilan_istri" type-currency="IDR" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end penghasilan istri --}}
                                {{-- penghasilan anak --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 145px">Penghasilan Anak</p>
                                        </div>
                                        <input wire:model="penghasilan_anak" type-currency="IDR" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 120px">Atap</p>
                                        </div>
                                        <input wire:model="kondisi_atap" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end kondisi atap --}}
                                {{-- kondisi dinding --}}
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"style="width: 120px">
                                                Dinding</p>
                                        </div>
                                        <input wire:model="kondisi_dinding" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end kondisi dinding --}}
                                {{-- kondisi ukuran rumah --}}
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"style="width: 120px">
                                                Ukuran Rumah</p>
                                        </div>
                                        <input wire:model="kondisi_ukuran_rumah" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                        <div class="input-group-append">
                                            <span
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">m<sup>2</sup></span>
                                        </div>
                                    </div>
                                </div>
                                {{-- end kondisi ukuran rumah --}}
                                {{-- kondisi lantai --}}
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"style="width: 120px">
                                                Lantai</p>
                                        </div>
                                        <input wire:model="kondisi_lantai" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 75px">Rumah</p>
                                        </div>
                                        <input wire:model="kepemilikan_rumah" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end kepemilikan rumah --}}
                                {{-- kepemilikan tanah --}}
                                <div class="form-group col-md-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 75px">Tanah</p>
                                        </div>
                                        <input wire:model="kepemilikan_tanah" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end kepemilikan tanah --}}
                                <div class="col-md-12 mb-2">
                                    <span class="text-bold mb-2">G. Sebutkan harta / aset / kekayaan yang dimiliki
                                        ?</span>
                                </div>
                                {{-- harta / aset --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <input wire:model="harta_aset_kekayaan" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end harta / aset --}}
                                <div class="col-md-12 mb-2">
                                    <span class="text-bold mb-2">H. Berapa biaya / tanggungan / pengeluaran rutin
                                        setiap bulan dan untuk apa saja, jelaskan ?</span>
                                </div>
                                {{-- tanggungan rutin bulan --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <input wire:model="tanggungan_rutin_bulan" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end tanggungan rutin bulan --}}
                                <div class="col-md-12 mb-2">
                                    <span class="text-bold mb-2">I. Apa saja kebutuhan yang sangat dibutuhkan untuk
                                        saat ini , berdasarkan pengajuan permohonan ke LAZISNU??</span>
                                </div>
                                {{-- kebutuhan yg di butuhkan --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <input wire:model="kebutuhan_yg_dibutuhkan" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end kebutuhan yg di butuhkan --}}
                                <div class="col-md-12 mb-2">
                                    <span class="text-bold mb-2">J. Bantuan apa saja yang sudah pernah di dapatkan,
                                        kapan dan dari mana / siapa ?</span>
                                </div>
                                {{-- bantuan yg pernah didapat --}}
                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <input wire:model="bantuan_yg_pernah_didapat" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Indeks Rumah </p>
                                        </div>
                                        <select wire:model="indeks_rumah" id="" class="custom-select"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                            <option selected></option>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Keterangan</p>
                                        </div>
                                        <input wire:model="indeks_rumah_keterangan" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end keterangan indeks rumah --}}
                                {{-- tgl disetujui --}}
                                <div class="form-group col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Kepemilikan Harta </p>
                                        </div>
                                        <select wire:model="indeks_harta" id="" class="custom-select"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                            <option selected></option>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Keterangan</p>
                                        </div>
                                        <input wire:model="indeks_harta_keterangan" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end tgl disetujui --}}
                                {{-- tgl disetujui --}}
                                <div class="form-group col-md-4 col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Pendapatan </p>
                                        </div>
                                        <select wire:model="indeks_pendapatan" id="" class="custom-select"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                            <option selected></option>
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
                                            <p class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}"
                                                style="width: 150px">Keterangan</p>
                                        </div>
                                        <input wire:model="indeks_pendapatan_keterangan" type="text"
                                            class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
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
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'bg-dark' }}">
                                                Jawab</p>
                                        </div>
                                        <input wire:model="rokemendasi_surveyor" type="text" class="form-control"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc && $this->kelolaSurvey($idsurveypenerima) != 1 ? '' : 'disabled' }}>
                                    </div>
                                </div>
                                {{-- end tgl disetujui --}}

                                {{-- end tgl disetujui --}}
                                <div class="col-md-12 mb-2">
                                    <span class="text-bold mb-2 text-center">HASIL AKHIR</span>
                                </div>
                                {{-- tgl disetujui --}}

                                <div class="form-group col-md-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <p
                                                class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc ? '' : 'bg-dark' }}">
                                                Hasil Akhir</p>
                                        </div>
                                        <select wire:model="survey_hasil" id="" class="custom-select"
                                            {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc ? '' : 'disabled' }}>
                                            <option selected></option>
                                            <option value="disetujui">Disetujui</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>
                                        {{-- <input wire:model="rokemendasi_surveyor" type="text" class="form-control"> --}}
                                    </div>
                                </div>
                                {{-- end tgl disetujui --}}

                                {{-- lokasi --}}
                                {{-- <div class="form-group col-md-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc?"":"bg-dark" }}">&nbsp;Lokasi&nbsp;&nbsp;</span>
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
                                                    class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc?"":"bg-dark" }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
                                                <span class="input-group-text {{ Auth::user()->gocap_id_pc_pengurus == $data->pj_pc?"":"bg-dark" }}">Catatan</span>
                                            </div>
                                            <input wire:model="survey_catatan" type="text" class="form-control"
                                                placeholder="Masukan Catatan">
                                        </div>
                                    </div> --}}
                                {{-- end catatan --}}


                                @if (Auth::user()->gocap_id_pc_pengurus == $data->pj_pc)
                                    {{-- info --}}
                                    <div class="form-group col-md-12">
                                        <div class="card card-body " style="background-color:#e0e0e0;">
                                            <b>INFORMASI!</b>
                                            <span>
                                                Dengan klik tombol Simpan, divisi penyaluran memberikan konfirmasi
                                                pengajuan
                                                telah
                                                disurvey & selanjutnya menunggu persetujuan oleh direktur
                                            </span>
                                        </div>
                                    </div>
                                    {{-- end info --}}

                                    <div class=" container">

                                        @if (
                                            $tgl_survey == '' or
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
                                            <span class="d-flex justify-content-center bg-danger p-2 text-center mb-3"
                                                style="border-radius: 5px">
                                                {{ $tgl_survey == '' ||
                                                $jenis_permohonan == '' ||
                                                $jumlah_anak == '' ||
                                                $jumlah_total == '' ||
                                                $punya_pasangan == '' ||
                                                $pekerjaan_suami == '' ||
                                                $pekerjaan_istri == '' ||
                                                $pekerjaan_anak == '' ||
                                                $penghasilan_suami == '' ||
                                                $penghasilan_istri == '' ||
                                                $penghasilan_anak == '' ||
                                                $kondisi_atap == '' ||
                                                $kondisi_dinding == '' ||
                                                $kondisi_ukuran_rumah == '' ||
                                                $kondisi_lantai == '' ||
                                                $kepemilikan_rumah == '' ||
                                                $kepemilikan_tanah == '' ||
                                                $harta_aset_kekayaan == '' ||
                                                $tanggungan_rutin_bulan == '' ||
                                                $kebutuhan_yg_dibutuhkan == '' ||
                                                $bantuan_yg_pernah_didapat == '' ||
                                                $indeks_rumah == '' ||
                                                $indeks_rumah_keterangan == '' ||
                                                $indeks_harta == '' ||
                                                $indeks_harta_keterangan == '' ||
                                                $indeks_pendapatan == '' ||
                                                $indeks_pendapatan_keterangan == '' ||
                                                $rokemendasi_surveyor == ''
                                                    ? 'Masih ada Kolom yang belum di isi'
                                                    : ' ' }}
                                            </span>

                                            <div class="d-flex justify-content-end">


                                                <button class="btn btn-success ml-1 " disabled
                                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                                    Simpan</button>
                                            </div>
                                        @else
                                            <div class="d-flex justify-content-end">

                                                <a wire:click.prevent="survey()" class="btn btn-success ml-1 "
                                                    wire:loading.attr="disabled"><i class="fas fa-check-circle"></i>
                                                    Simpan</a>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- acc --}}
                                @else
                                    <div class="container">
                                        <div class="d-flex justify-content-end">
                                            <a href="" class="btn btn-dark px-3" data-dismiss="modal"
                                                aria-label="Close">Kembali</a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                window.loadContactDeviceSelect2 = () => {


                    $('#nominal_bantuan').on('input', function(e) {
                        $('#nominal_bantuan').val(formatRupiah($('#nominal_bantuan').val(),
                            'Rp. '));
                    });
                }

                loadContactDeviceSelect2();
                window.livewire.on('loadContactDeviceSelect2', () => {
                    loadContactDeviceSelect2();
                });

            });
        </script>



        <script>
            Livewire.on('dataTersimpan', () => {
                $('#modal_pengajuan_penerima_manfaat_survey2').modal('hide');
            });
        </script>
    @endpush


@endif
