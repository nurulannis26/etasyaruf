{{-- <table style="width:100%">
    <tr>
        <td style="width:33%; text-align:left;"><img src="{{ public_path('/images/gocap.png') }}" width="76"
                height="76"></td>
        <td style="width:33%;text-align:center;"><img src="{{ public_path('/images/logo_lazisnu.png') }}" width="146"
                height="76"></td>
        <td style="width:33%;text-align:right;"><img src="{{ public_path('/images/siftnu.png') }}" width="146"
                height="76"></td>
    </tr>
</table>

--}}
<table cellpadding="0" cellspacing="0" style="width:100%; border-collapse:collapse;">
    <tbody>
        <tr>
            <td colspan="5" style="100%; padding-right:5.4pt; padding-left:5.4pt;">

                <p style=" text-align:center;  font-size:11pt;">
                    <strong><span>DOKUMENTASI SURVEY MUSTAHIK NU CARE LAZISNU CILACAP

                        </span></strong>
                    </p>
            </td>
        </tr>
    </tbody>
</table>
<div></div>
<table class="table table-bordered table-hover mt-2" style="width:100%">
  
        @forelse($data_dokumentasi as $ds)
        @empty
            <tr>
                <td colspan="6" class="text-center"> Belum ada data</td>
            </tr>
        @endforelse
        @foreach ($data_dokumentasi as $ds)
        <tr style="page-break-inside: avoid;">
            <td style="width: 100%;vertical-align:middle;border: 1px solid black;text-align:center;">
                <span style="font-size:16px;">{{ $ds->judul }}</span>
            </td>
        </tr>
            <tr style="page-break-inside: avoid;">
                <td style="width: 100%;vertical-align:middle;border: 1px solid black;text-align:center;">
                    <img src="{{ public_path('uploads/dokumentasi_survey/' . $ds->foto) }}" width="680" height="360">
                </td>
            </tr>
        @endforeach
</table>