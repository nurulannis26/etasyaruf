<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- IonIcons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

<link rel="stylesheet" href="{{ asset('assets/dist/css/style.css') }}">

<!-- Bootstrap-Select -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- daterange picker -->





<style>
    .select2-container {
        width: 100% !important;
    }
   
    .tooltip-inner {
    background-color: rgb(255, 255, 255) !important;
    color: #000000 ;
    border-style: solid !important;
    border-width: 1px !important;
    border-color: black !important;
    text-align:left !important;
    /* background-color: rgb(254, 35, 35) !important; */
    }
   

    .bs-tooltip-bottom .arrow::before, 
    .bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
        border-bottom-color: rgb(8, 8, 8) !important;
        
    }



    /* Media query untuk tampilan tablet dan hp */
</style>
<style>
    .kartu {
        /* box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); */
        /* transition: 0.3s; */
        /* width: 300px; */
        /* padding:  10px 10px 10px 10px; */
        /* height: 30px; */

        box-shadow: 0 4px 8px 0 rgba(0, 0, 1, 0.2);
        transition: 0.3s;
        width: 100%;
        height: 50px;
        border-radius: 10px;
        padding: 2px 16px;
    }

    .noClick {
        pointer-events: none;
    }

    .bg-ijo {
        background-color: #CBF2D6;
    }

    .btn {
        border-radius: 8px;
    }

    .form-control {
        border-radius: 8px;
    }

    .input-group-text {
        border-radius: 8px;
    }

    .input-group-select2 {
        border-radius: 8px;
    }


    #select2RekeningInternal+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/info.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        padding-left: 30px;
    }

   

    #select2Status+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/info.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: center;
        padding-left: 30px;
    }

    #select2Status+.select2-container .select2-selection:focus {
        transform: scale(1.03);
    }

    #select2Status+.select2-container .select2-selection:hover {
        transform: scale(1.03);
    }

    #select2Upzis+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/mwcnu.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: center;
        padding-left: 30px;
    }

    #select2Upzis+.select2-container .select2-selection:focus {
        transform: scale(1.03);
    }

    #select2Upzis+.select2-container .select2-selection:hover {
        transform: scale(1.03);
    }


    /* Ranting */
    #select2Status2+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/info.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: center;
        padding-left: 30px;
    }

    #select2Status2+.select2-container .select2-selection:focus {
        transform: scale(1.03);
    }

    #select2Status2+.select2-container .select2-selection:hover {
        transform: scale(1.03);
    }

    #select2Upzis2+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/mwcnu.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: center;
        padding-left: 30px;
    }

    #select2Upzis2+.select2-container .select2-selection:focus {
        transform: scale(1.03);
    }

    #select2Upzis2+.select2-container .select2-selection:hover {
        transform: scale(1.03);
    }

    #select2Ranting2+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/ranting.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: center;
        padding-left: 30px;
    }

    #select2Ranting2+.select2-container .select2-selection:focus {
        transform: scale(1.03);
    }

    #select2Ranting2+.select2-container .select2-selection:hover {
        transform: scale(1.03);
    }

    .form-control:focus {
        border-color: #c7c7c7;
    }

    #select2PjUpzis+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/user.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2PjRanting+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/user.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Ranting3+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/ranting.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Petugas+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/user.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Program+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/program.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Pilar+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/pilar.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Kegiatan+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/kegiatan.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Rekening+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/user.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }

    #select2Penerima+.select2-container .select2-selection {
        border-radius: 8px;
        border-color: #c7c7c7;
        position: relative;
        /* background-image: url("/logo/user.png"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        transition: transform 0.3s ease-in-out;
        text-align: left;
        /* padding-left: 30px; */
    }


    /* CSS */
    .fade-in-form {
        opacity: 0;
        /* Mulai dengan opasitas 0 */
        animation: fadeIn 1s ease-in forwards;
        /* Animasi fade in dengan durasi 1 detik */
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
            /* Animasi berakhir dengan opasitas 1 (terlihat sepenuhnya) */
        }
    }

    /* Untuk input tanggal dengan garis bawah */
    .underline-input {
        border: none;
        outline: none;
        background: none;
        border-bottom: 1px solid #000;
        font-size: 16px;
        /* Atur ukuran font sesuai kebutuhan */
        padding: 2px;
        /* Sesuaikan padding jika diperlukan */
    }

    .alert {
        border-radius: 10px;

    }



    .input-group-text {

        background-color: rgb(255, 255, 255);
    }

    .border-grey {
        border-color: #c7c7c7;
    }

    .hover {
        transition: transform 0.3s ease-in-out;

    }

    .hover:hover {
        border-color: #c7c7c7;
        transform: scale(1.03);
    }

    .btn-light {
        background-color: white;
    }

    .btn-light:hover {
        background-color: white;
    }

    .icon-input {
        position: relative;
        /* background-image: url("/logo/date.jpg"); */
        background-repeat: no-repeat;
        background-position: left 10px center;
        background-size: 20px 20px;
        /* padding-right: 35px; */
        padding-left: 35px;
        Sesuaikan sesuai dengan lebar ikon transition: transform 0.3s ease-in-out;
    }

    .icon-input:focus {
        transform: scale(1.03);
        /* Ubah faktor skala sesuai dengan preferensi Anda */
    }

    .icon-input:hover {
        transform: scale(1.03);
        /* Ubah faktor skala sesuai dengan preferensi Anda */
    }

    .badge1 {
        border-radius: 4px;
        background-color: #cbf2d6;
    }

    .badge2 {
        border-radius: 4px;
        background-color: #dcdcdc;
    }

    .paginate_button .page-link {
        font-size: 9pt;
        padding: 6px;
        margin: 3px;
        border-radius: 4px;
        background-color: rgb(255, 255, 255) !important;
        border: 1px solid rgb(198, 198, 198) !important;
        color: black;
        transition: transform 0.3s ease-in-out;

    }

    .paginate_button.active .page-link {
        background-color: rgb(243, 243, 243) !important;
        border: 1px solid rgb(198, 198, 198) !important;
        color: black;
    }

    .paginate_button:hover .page-link {
        transform: scale(1.03);
    }

    .modal-content {
        -webkit-border-radius: 0px !important;
        -moz-border-radius: 0px !important;
        border-radius: 12px !important;
        -webkit-border: 0px !important;
        -moz-border: 0px !important;
        border: 0px !important;
    }
</style>

<style>
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 64px;
        height: 64px;
        margin: 8px;
        border: 8px solid #fff;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #fff transparent transparent transparent;
    }

    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }

    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }

    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }

    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<style>
    .loader {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: black;
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 9999;
        width: 100%;
        height: 100%;
        opacity: 0.5;

    }

    .border {
        border-radius: 10px;
    }


    .tracking-detail {
        padding: 3rem 0
    }

    #tracking {
        margin-bottom: 1rem;

    }

    [class*=tracking-status-] p {
        margin: 0;
        font-size: 1.1rem;
        color: #fff;
        text-transform: uppercase;
        text-align: center
    }

    [class*=tracking-status-] {
        padding: 0.6rem 0;
        border-top-left-radius: 9px;
        /* Ganti 9px dengan ukuran radius sudut yang diinginkan */
        border-top-right-radius: 9px;
        /* Ganti 9px dengan ukuran radius sudut yang diinginkan */
        border-bottom-left-radius: 0;
        /* Radius sudut bawah kiri diatur ke 0 untuk menghilangkan batas di sana */
        border-bottom-right-radius: 0;
        /* Radius sudut bawah kanan diatur ke 0 untuk menghilangkan batas di sana */

    }


    .tracking-status-intransit {
        background-color: #65aee0
    }

    .tracking-status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-status-delivered {
        background-color: #4cbb87
    }

    .tracking-status-attemptfail {
        background-color: #b789c7
    }

    .tracking-status-error,
    .tracking-status-exception {
        background-color: #d26759
    }

    .tracking-status-expired {
        background-color: #616e7d
    }

    .tracking-status-pending {
        background-color: #ccc
    }

    .tracking-status-inforeceived {
        background-color: #214977
    }

    .tracking-list {
        /* border: 1px solid #e5e5e5 */
    }

    .tracking-item {
        border-left: 1px solid #e5e5e5;
        position: relative;
        padding: 2rem 1.5rem .5rem 2.5rem;
        font-size: .9rem;
        margin-left: 3rem;
        min-height: 5rem
    }

    .tracking-item:last-child {
        padding-bottom: 4rem
    }

    .tracking-item .tracking-date {
        margin-bottom: .5rem
    }

    .tracking-item .tracking-date span {
        color: #888;
        font-size: 85%;
        padding-left: .4rem
    }

    .tracking-item .tracking-content {
        padding: .5rem .8rem;
        background-color: #f4f4f4;
        border-radius: .5rem
    }

    .tracking-item .tracking-content span {
        display: block;
        color: #888;
        font-size: 85%
    }

    .tracking-item .tracking-icon {
        line-height: 1.2rem;
        position: absolute;
        left: -0.75rem;
        width: 1.4rem;
        height: 1.4rem;
        text-align: center;
        border-radius: 50%;
        font-size: 1.1rem;
        background-color: #fff;
        color: #fff
    }

    .tracking-item .tracking-icon.status-sponsored {
        background-color: #f68
    }

    .tracking-item .tracking-icon.status-delivered {
        background-color: #28A745
    }

    .tracking-item .tracking-icon.status-outfordelivery {
        background-color: #f5a551
    }

    .tracking-item .tracking-icon.status-deliveryoffice {
        background-color: #f7dc6f
    }

    .tracking-item .tracking-icon.status-attemptfail {
        background-color: #b789c7
    }

    .tracking-item .tracking-icon.status-exception {
        background-color: #d26759
    }

    .tracking-item .tracking-icon.status-inforeceived {
        background-color: #214977
    }

    .tracking-item .tracking-icon.status-intransit {
        color: #e5e5e5;
        border: 1px solid #e5e5e5;
        font-size: .6rem
    }

    /* @media(min-width:992px) {
        .tracking-item {
            margin-left: 10rem
        }

        .tracking-item .tracking-date {
            position: absolute;
            left: -10rem;
            width: 7.5rem;
            text-align: right
        }

        .tracking-item .tracking-date span {
            display: block
        }

        .tracking-item .tracking-content {
            padding: 0;
            background-color: transparent
        }
    } */
</style>
