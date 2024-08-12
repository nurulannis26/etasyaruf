<div>
    {{-- Do your work, then step back. --}}

    <div class="row">
        <div class="col-lg-6 col-6">

            <div class="form-group row input-tgl-terbit-berita-umum">
                <p class="col-sm-4 col-form-label">Tanggal
                    Terbit</p>
                <div class="col-sm-8 ">
                    <input type="date" class="form-control  @error('tanggal_terbit') is-invalid @enderror"
                        name="tanggal_terbit" placeholder="Tanggal Arsip" value="{{ old('tanggal_terbit') }}">
                    @error('tanggal_terbit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row input-kategori-berita-umum">
                <p class="col-sm-4 col-form-label">Kategori Berita</p>
                <div class="col-sm-8 ">

                    <select wire:model="kategori_berita"
                        class="form-control @error('kategori_berita') is-invalid @enderror" name="kategori_berita"
                        data-placeholder="Masukan Klasifikasi Surat" value="{{ old('kategori_berita') }}">


                        <option value="Lazisnu Cilacap"> Lazisnu Cilacap</option>
                        <option value="Upzis MWCNU">Upzis MWCNU</option>
                        <option value="Ranting NU">Ranting NU</option>
                    </select>

                    @error('kategori_berita')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @if ($kategori_berita == 'Upzis MWCNU' or $kategori_berita == 'Ranting NU')
                <div class="form-group row input-kategori-berita-umum">
                    <p class="col-sm-4 col-form-label">Upzis MWCNU</p>
                    <div class="col-sm-8 ">

                        <select wire:model="id_upzis" class="form-control" name="id_upzis">
                            @foreach ($daftar_upzis as $a)
                                <option value="{{ $a->id_upzis }}">{{ $a->nama }}
                                    ({{ $a->id_wilayah }})
                                </option>
                            @endforeach
                        </select>


                    </div>
                </div>
            @endif


        </div>




        <div class="col-lg-6 col-6">



            <div class="form-group row">
                <p class="col-sm-4 col-form-label">Judul Berita</p>
                <div class="col-sm-8">
                    <input type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                        name="judul_berita" placeholder="Masukan Judul Berita" value="{{ old('judul_berita') }}">
                    @error('judul_berita')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>

            <div class="form-group row input-tag-berita-umum" wire:ignore>
                <p class="col-sm-4 col-form-label">Hastag Berita</p>
                <div class="col-sm-8 ">
                    <input type="text"class="form-control  @error('hastag_berita') is-invalid @enderror"
                        name="hastag_berita[]" id="tags" placeholder="Masukan Tag Berita" data-role="tagsinput">

                    @error('hastag_berita')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @if ($kategori_berita == 'Ranting NU')
                <div class="form-group row input-kategori-berita-umum">
                    <p class="col-sm-4 col-form-label">PRNU</p>
                    <div class="col-sm-8 ">

                        <select wire:model="id_ranting" class="form-control" name="id_ranting">
                            @foreach ($daftar_ranting as $a)
                                <option value="{{ $a->id_ranting }}">{{ $a->nama }}
                                    ({{ $a->id_wilayah }})
                                </option>
                            @endforeach
                        </select>


                    </div>
                </div>
            @endif


        </div>

    </div>


</div>
