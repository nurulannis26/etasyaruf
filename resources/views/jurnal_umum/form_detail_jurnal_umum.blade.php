<div class="modal-body mt-1">
    <div class="tab-content ">
        <div class="tab-pane fade active show" role="tabpanel" aria-labelledby="nav-satu-tab">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label style="font-weight: normal;">Tanggal Transaksi&nbsp;</label>
                    <br>
                    <label>
                        @if (!empty($detail_jurnal) && !empty($detail_jurnal->tgl_transaksi))
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $detail_jurnal->tgl_transaksi)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label style="font-weight: normal;">Nomor&nbsp;</label>
                    <br>
                    <label>
                        {{ !empty($detail_jurnal) && !empty($detail_jurnal->nomor) ? $detail_jurnal->nomor : '-' }}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label style="font-weight: normal;">Jenis&nbsp;</label>
                    <br>
                    <label>
                        {{ !empty($detail_jurnal) && !empty($detail_jurnal->jenis) ? $detail_jurnal->jenis : '-' }}
                    </label>
                </div>
            </div>

            <style>
                .badge {
                    display: inline-block;
                    padding: 0.25em 0.4em;
                    font-size: 80%;
                    font-weight: normal;
                    line-height: 1;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: baseline;
                    border-radius: 0.25rem;
                }
            </style>
            
           

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label style="font-weight: normal;">Bank &nbsp;</label>
                    <br>
                    @if (is_string($bank) && $bank == '')
                        <label>Pembayaran Tunai</label>
                    @elseif (count($bank) == 1)
                        @if (!empty($detail_jurnal) && !empty($detail_jurnal->bank))
                            @php
                                $banks = \App\Models\Rekening::where('id_rekening', $detail_jurnal->bank)->first();
                            @endphp
                            <label>{{ $banks->no_rekening ?? '' }} - {{ $banks->nama_rekening ?? '' }}</label>
                        @endif
                    @elseif (count($bank) > 1)
                        @php
                            $bank_details = [];
                        @endphp
                        @foreach ($bank as $banks => $entries)
                            @php
                                $bank_info = \App\Models\Rekening::where('id_rekening', $banks)->first();
                                if ($bank_info) {
                                    // dd($bank_info);
                                    $type = $bank_info->jenis_rekening == 'Bank' ? 'Transfer' : 'Tunai';
                                    // dd($type);
                                    $bank_details[] =
                                        $bank_info->no_rekening .
                                        ' - ' .
                                        $bank_info->nama_rekening .
                                        ' (' .
                                        $type .
                                        ') ';
                                }
                            @endphp
                        @endforeach
                        @if (count($bank_details) > 1)
                            @foreach ($bank_details as $detail)
                                <label>{{ $detail }}</label><br>
                            @endforeach
                        @else
                            <label>{{ $bank_details[0] ?? '' }}</label>
                        @endif
                    @endif
                    
                    
                </div>
            </div>

            <table id="example6" class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Akun</th>
                        <th>Deskripsi</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($get_detail as $get)
                        <tr style="cursor: pointer">
                            <td>{{ $get->nomor_akun }} - {{ $get->nama_rekening }}</td>
                            <td>
                                {{ $get->deskripsi ?? '-' }}
                                @if ($get->ziswaf_atas_nama)
                                    <br>
                                    Nama Muzaki : {{ $get->ziswaf_atas_nama }}
                                @endif
                            </td>
                            <td>Rp. {{ number_format($get->debit, 0, ',', '.') ?? '-' }}</td>
                            <td>Rp. {{ number_format($get->kredit, 0, ',', '.') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center"> Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
