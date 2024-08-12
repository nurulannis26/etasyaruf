<div class="row ">
    <div class="col col-md-12 col-sm-12 ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <i class="fas fa-clipboard-list"></i><b class="ml-2"> PENGELUARAN</b>
                    </div>
                    <div>
                        <button {{-- wire:click="modal_kegiatan('{{ $kegiatan->id_pengajuan_kegiatan ?? null }}')"  --}} type="button"
                            class="btn btn-sm btn-outline-success hover float-right ml-2 createEditPengeluaran">
                            <i class="fas fa-plus-circle"></i>
                            Tambah Pengeluaran
                        </button>
                        <button class="btn btn-outline-primary btn-sm hover" disabled data-toggle="tooltip"
                            data-placement="top" title="Dalam Pengembangan">
                            Berita Acara
                        </button>
                    </div>
                </div>
                <div class="card mt-2 p-3">
                    <div class="row">
                        <div class="col-sm-4">
                            <em>Nominal Pencairan</em>
                            <span class="text-bold text-warning"><br>
                                {{ $this->numberFormat($this->getNominalPencairan()) }}</span>
                        </div>
                        <div class="col-sm-4">
                            <em>Dana Digunakan</em>
                            <span class="text-bold text-primary"><br>
                                {{ $this->numberFormat($this->getDanaDigunakan()) }}</span>
                        </div>
                        <div class="col-sm-4">
                            <em>Dana Tersisa</em>
                            <span class="text-bold"><br>
                                {{ $this->numberFormat($this->getNominalPencairan() - $this->getDanaDigunakan()) }}</span>
                        </div>
                    </div>
                </div>
                @if (session()->has('pengeluaran'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="far fa-check-circle"></i>
                        {{ session('pengeluaran') }}
                    </div>
                @endif
                {{-- tabel pengeluaran --}}
                <div class="table-responsive modal-detail-kegiatan-pengeluaran_penyaluran_panduan">
                    <table class="table table-bordered mt-2" style="width:100%">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 4%;">No</th>
                                <th style="width: 35%;">Judul Pengeluaran</th>
                                <th style="width: 15%;">Tgl Pengeluaran</th>
                                <th style="width: 10%;">Jumlah</th>
                                <th style="width: 14%;">Nominal</th>
                                <th style="width: 14%;">Saldo Akhir </th>
                                <th style="width: 14%;">Aksi </th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $saldo_akhir = 0;
                                $v = 1;
                            @endphp
                            @forelse ($dataPengeluaran as $a)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}</td>
                                    <td>
                                        <span>
                                            {{ $a->judul }}
                                        </span>
                                        {{-- <a href="{{ asset('uploads/nota_pengeluaran/' . $a->nota) }}" target="_blank">
                                            {{ $a->judul }} </a> --}}
                                        <br>
                                        <span style="font-size: 10pt">Diinput oleh
                                            :
                                            {{ \App\Http\Controllers\Helper::getNamaPengurus('upzis', $a->maker_tingkat_upzis ?? null) }}
                                            {{-- ({{ $this->jabatan_pengurus_upzis($a->maker_tingkat_upzis) }}) --}}
                                        </span>
                                    </td>
                                    <td style="text-align: center">
                                        {{ Carbon\Carbon::parse($a->tgl_pengeluaran)->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td style="text-align: center">
                                        {{ $a->jumlah }}</td>
                                    <td style="text-align: center">
                                        {{ $this->numberFormat($a->nominal_pengeluaran) }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            if ($v == 1) {
                                                $saldo_akhir = $this->getNominalPencairan() - $this->getDanaDigunakan();
                                            }
                                        @endphp
                                        {{ $this->numberFormat($saldo_akhir) }}
                                        @php
                                            $saldo_akhir = $saldo_akhir + $a->nominal_pengeluaran;
                                            $v++;
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ asset('uploads/nota_pengeluaran/' . $a->nota) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary hover mr-1 "
                                                data-toggle="tooltip" data-placement="top" title="Nota Pengeluaran"><i
                                                    class="fas fa-money-check-alt"></i>
                                            </a>
                                            <button
                                                wire:click="modal_edit_pengeluaran('{{ $a->id_pengajuan_pengeluaran }}','{{ $a->judul }}','{{ $a->tgl_pengeluaran }}','{{ $a->jumlah }}','{{ $a->nominal_pengeluaran }}')"
                                                class="btn
                                                btn-sm btn-outline-secondary hover mr-1 createEditPengeluaran"><i
                                                    class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                wire:click="deleteFotoKegiatan('{{ $a->nominal_pengeluaran }}','{{ $a->nominal_pengeluaran }}')"
                                                class="btn btn-sm btn-outline-danger hover "><i
                                                    class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Belum
                                        ada pengeluaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
