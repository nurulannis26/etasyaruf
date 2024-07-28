 {{-- modal body --}}
 <div class="modal-body">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputNama">ASNAF &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <select wire:model="id_asnaf" class="select2dulus form-control ">
                <option value="">Pilih Asnaf</option>
                @php
                    $asnaf_get = DB::table('asnaf')->get();
                @endphp
                @foreach ($asnaf_get as $as)
                    <option value="{{ $as->id_asnaf }}">{{ $as->nama_asnaf }}</option>
                @endforeach
            </select>
        </div>
        {{-- pilar --}}
        <div class="form-group col-md-6">
            <label for="inputNama">PILAR &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <select wire:model="id_program_pilar" id="id_program_pilars" class="select2dulur form-control pilar">
                {{-- @if ($id_program == '')
                    <option value="">Pilih Kategori Terlebih Dahulu</option>
                @else --}}
                <option value="">Pilih Pilar</option>
                @foreach ($daftar_pilar as $a)
                    <option value="{{ $a->id_program_pilar }}">{{ $a->pilar }}</option>
                @endforeach
                {{-- @endif --}}
            </select>
        </div>
        {{-- end pilar --}}

        {{-- kegiatan --}}
        <div class="form-group col-md-12">
            <label for="inputNama">JENIS PROGRAM &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <select class="form-control" id="select2-dropdown" wire:model="selectedProgram"
                data-placeholder="Pilih Pilar Terlebih Dahulu">

                @if ($id_program_pilar == '')
                    <option value="" disabled>Pilih Pilar Terlebih Dahulu</option>
                @else
                    @foreach ($daftar_kegiatan as $a)
                        <option value="{{ $a->id_program_kegiatan }}">{{ $a->no_urut }}
                            {{ $a->nama_program }}</option>
                    @endforeach
                    @foreach ($daftar_kegiatan2 as $a)
                        <option value="{{ $a->id_program_kegiatan }}">{{ $a->no_urut }}
                            {{ $a->nama_program }}</option>
                    @endforeach
                @endif
            </select>
        </div>


        {{--  pengajuan note --}}
        <div class="form-group col-md-12">
            <label for="inputAlamat">KETERANGAN&nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <textarea type="text" class="form-control" wire:model="pengajuan_note" placeholder="Masukan Keterangan"
                rows="4"> </textarea>

        </div>
        {{-- end pengajuan note --}}

        {{-- nama penerima manfaat --}}
        <div class="form-group col-md-12">
            <label for="inputNama">TARGET PENERIMA MANFAAT &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <input wire:model="nama_penerima" type="text" class="form-control"
                placeholder="Contoh : UMKM Binaan, Warga Duafa, DLL.">
        </div>
        {{-- end keterangan --}}

        {{-- nama stuan --}}
        <div class="form-group col-md-5">
            <label for="inputNama">NOMINAL PENGAJUAN &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bor-abu">Rp</span>
                </div>

                <input type="text" wire:model="satuan_pengajuan" id="satuan_pengajuan" class="form-control"
                    placeholder="Nominal Per-penerima">
            </div>
        </div>
        {{-- end satuan --}}

        {{-- jumlah --}}
        <div class="form-group col-md-3">
            <label for="inputNama">JML PENERIMA&nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bor-abu"><i class="fas fa-users"></i></span>
                </div>
                <input wire:model="jumlah_penerima" type="text" class="form-control"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    placeholder="Jml Penerima">
            </div>
        </div>
        {{-- end jumlah --}}

        {{-- nominal --}}
        <div class="form-group col-md-4">
            <label for="inputNama">NOMINAL TOTAL &nbsp;</label>
            <span style="color:rgba(230, 82, 82)">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bor-abu">Rp</span>
                </div>
                <input type="text" class="form-control"
                    value="{{ number_format($nominal_pengajuan, 0, '.', '.') }}" readonly>
            </div>
        </div>
        {{-- end nominal --}}

    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            window.loadContactDeviceSelect2 = () => {
                window.initSelectStationDrop = () => {
                    $('#select2-dropdown').select2();
                    $('#select2-dropdown').on('change', function() {
                        var selectedValue = $(this).val();
                        @this.set('selectedProgram', selectedValue);
                    });
                }
                initSelectStationDrop();
                window.livewire.on('select2', () => {
                    initSelectStationDrop();
                });
            }
            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });

        });
    </script>
@endpush

{{-- end modal body --}}
@push('script')
    <script>
        $(document).ready(function() {
            $('.select2dulu').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            window.loadContactDeviceSelect2 = () => {
                $('#satuan_pengajuan').on('input', function(e) {
                    $('#satuan_pengajuan').val(formatRupiah($('#satuan_pengajuan').val(),
                        'Rp. '));
                });

                // $(".pilar").on('change',function () {
                //     console.log('LOF');
                //     $('.select2dulu').select2();
                // });
                $('#jenis_program').on('change', function() {
                    console.log('asd');
                    console.log($("#jenis_program").val());
                    @this.set('id_program_kegiatan', $("#jenis_program").val(););
                });
            }
            loadContactDeviceSelect2();
            window.livewire.on('loadContactDeviceSelect2', () => {
                loadContactDeviceSelect2();
            });
        });
    </script>
    <script>
        // $('#id_programs').on('change',function() {
        //             var s = $("#id_programs").val();
        //             var x = '{{ url('/data-pilar/') }}';
        //             var a = x+'/'+s;
        //             console.log(a);
        //             console.log('as');
        //         });
        // $(document).ready(function () {
        //     $('.select2dulu').select2(
        //         ajax:{
        //         url: 'http://127.0.0.1:8000/data-pilar/bed10d9c-81a8-11ed-b4ef-dc215c5aad51',
        //         dataType:'json',
        //         processResults: function(data) {
        //             return{
        //                 result:data.items
        //             }
        //         }
        //     });
        // });
    </script>
    <script>
        // $(document).ready(function() {
        //     $('#id_programs').select2();
        //     $('#id_programs').on('change', function(e) {
        //         var data = $('#id_programs').select2("val");
        //         @this.set('id_program', data);
        //     });
        // });
    </script>
    <script>
        // $(document).ready(function() {

        // $('#id_programs').on('change',function() {
        //     console.log('as');
        //     var s = $("#id_programs").val();
        //     var x = '{{ url('/data-pilar/') }}';
        //     var a = x+'/'+s;
        //     console.log('JADI');
        //     console.log(a);
        //     console.log(s);
        //     $('#id_program_pilars').select2(
        //         ajax:{
        //         url: a,
        //         console.log('JADI');
        //         dataType:'json',
        //         processResults: function(data) {
        //             return{
        //                 result:data.items
        //             }
        //         }
        //     }
        //     );
        // })
        // $('#id_program_pilars').on('change', function(e) {
        //     var data = $('#id_program_pilars').select2("val");
        //     @this.set('id_program_pilar', data);
        // });
        // });
        //     $(document).ready(function () {
        //     $('#jenis_program').select2({
        //         ajax:{
        //             url: 'http://127.0.0.1:8000/jenis-program/30746c18-3f7a-4736-ae47-ea91154a5a00',
        //             dataType:'json',
        //             processResults: function(data) {
        //                 return{
        //                     results: data.items
        //                 }
        //             }
        //         }
        //     }
        //     );
        // });
    </script>
@endpush
