
<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Trans Lampung</title>
    <link rel="shortcut icon" href="{{url('/')}}/main/resources/assets/images/tlits.png"/>
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/reset.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/site.css">

    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/container.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/grid.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/header.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/image.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/menu.css">

    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/divider.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/dropdown.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/segment.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/button.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/list.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/icon.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/sidebar.css">
    <link rel="stylesheet" type="text/css" href="{{url('/')}}/main/resources/assets/semantic/dist/components/transition.css">

    <style type="text/css">

        .menucolored{
            color: white;
        }
        .hidden.menu {
            display: none;
        }

        .masthead.segment {
            min-height: 700px;
            padding: 1em 0em;
        }
        .masthead .logo.item img {
            margin-right: 1em;
        }
        .masthead .ui.menu .ui.button {
            margin-left: 0.5em;
        }
        .masthead h1.ui.header {
            margin-top: 3em;
            margin-bottom: 0em;
            font-size: 4em;
            font-weight: normal;
        }
        .masthead h2 {
            font-size: 1.7em;
            font-weight: normal;
        }

        .ui.vertical.stripe {
            padding: 8em 0em;
        }
        .ui.vertical.stripe h3 {
            font-size: 2em;
        }
        .ui.vertical.stripe .button + h3,
        .ui.vertical.stripe p + h3 {
            margin-top: 3em;
        }
        .ui.vertical.stripe .floated.image {
            clear: both;
        }
        .ui.vertical.stripe p {
            font-size: 1.33em;
        }
        .ui.vertical.stripe .horizontal.divider {
            margin: 3em 0em;
        }

        .quote.stripe.segment {
            padding: 0em;
        }
        .quote.stripe.segment .grid .column {
            padding-top: 5em;
            padding-bottom: 5em;
        }

        .footer.segment {
            padding: 5em 0em;
        }

        .secondary.pointing.menu .toc.item {
            display: none;
        }

        @media only screen and (max-width: 700px) {
            .ui.fixed.menu {
                display: none !important;
            }
            .secondary.pointing.menu .item,
            .secondary.pointing.menu .menu {
                display: none;
            }
            .secondary.pointing.menu .toc.item {
                display: block;
            }
            .masthead.segment {
                min-height: 350px;
            }
            .masthead h1.ui.header {
                font-size: 2em;
                margin-top: 1.5em;
            }
            .masthead h2 {
                margin-top: 0.5em;
                font-size: 1.5em;
            }
        }


    </style>

    <script src="{{url('/')}}/main/resources/assets/semantic/dist/jquery.min.js"></script>
    <script src="{{url('/')}}/main/resources/assets/semantic/dist/components/visibility.js"></script>
    <script src="{{url('/')}}/main/resources/assets/semantic/dist/components/sidebar.js"></script>
    <script src="{{url('/')}}/main/resources/assets/semantic/dist/components/transition.js"></script>
    <script>
        $(document)
            .ready(function() {

                // fix menu when passed
                $('.masthead')
                    .visibility({
                        once: false,
                        onBottomPassed: function() {
                            $('.fixed.menu').transition('fade in');
                        },
                        onBottomPassedReverse: function() {
                            $('.fixed.menu').transition('fade out');
                        }
                    })
                ;

                // create sidebar and attach to menu open
                $('.ui.sidebar')
                    .sidebar('attach events', '.toc.item')
                ;

                $("button").click(function() {
                    $('html,body').animate({
                            scrollTop: $(".second").offset().top},
                        'slow');
                });

            })
        function scrooltodiv(selecteddiv) {
            $('html,body').animate({
                    scrollTop: $(selecteddiv).offset().top},
                'slow');
        };
        ;
    </script>
</head>
<body>

<!-- Following Menu -->
<div class="ui large top fixed hidden menu" style="border-color: #0d71bb;">
    <div class="ui container">
        <a class="active item "onclick="scrooltodiv('#home')"><i class="icon home" ></i></a>
        <a class="item" onclick="scrooltodiv('#tentangkami')">Tentang Kami</a>
        <a class="item" onclick="scrooltodiv('#produkkami')">Produk</a>
        <a class="item" onclick="scrooltodiv('#beritakami')">Berita</a>
        <a class="item" onclick="scrooltodiv('#contactus')">Kontak</a>
        <a class="item">Rute</a>
        <a class="item">Karir</a>

        <div class="ui right menu">
            <a class="item" href=" {{url('/login')}}">Login</a>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<div class="ui vertical sidebar menu" style="border-color: #0d71bb;">
    <a class="active item "onclick="scrooltodiv('#home')"><i class="icon home" ></i></a>
    <a class="item" onclick="scrooltodiv('#tentangkami')">Tentang Kami</a>
    <a class="item" onclick="scrooltodiv('#produkkami')">Produk</a>
    <a class="item" onclick="scrooltodiv('#beritakami')">Berita</a>
    <a class="item" onclick="scrooltodiv('#contactus')">Kontak</a>
    <a class="item">Rute</a>
    <a class="item">Karir</a>
    <div class="ui right menu">
        <a class="item" href=" {{url('/login')}}">Login</a>
    </div>
</div>

<!-- Page Contents -->
<div class="pusher">
    <div class="ui inverted vertical masthead center aligned segment" style="background: #329ee1">

        <div class="ui container" id="home" >
            <div class="ui large secondary inverted pointing menu" style="border-color: transparent">
                <a class="toc item">
                    <i class="sidebar icon"></i>
                </a>
                <a class="active item "onclick="scrooltodiv('#home')"><i class="icon home" ></i></a>
                <a class="item" onclick="scrooltodiv('#tentangkami')">Tentang Kami</a>
                <a class="item" onclick="scrooltodiv('#produkkami')">Produk Kami</a>
                <a class="item" onclick="scrooltodiv('#beritakami')">Berita</a>
                <a class="item" onclick="scrooltodiv('#contactus')">Kontak</a>
                <a class="item">Rute</a>
                <a class="item">Karir</a>
                <div class="ui right secondary inverted pointing menu" style="border-color: transparent">
                    <a class="item" href="{{url('/login')}}">Login</a>
                </div>
            </div>
        </div>

        <div class="ui text container">
            <h1 class="ui inverted header">
                Trans Lampung
            </h1>
            <h2>motto atau slogan</h2>
            <a class="ui huge primary button" href="{{url('/map')}}" >Lihat Map <i class="right arrow icon" ></i></a>
        </div>

    </div>

    <div id="tentangkami" class="ui vertical stripe segment">
        <div class="ui middle aligned stackable grid container">
            <div class="row">
                <div class="eight wide column">
                    <h3 class="ui header">"Apakah Lorem Ipsum itu?"</h3>
                    <p>Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf. </p>
                    <h3 class="ui header">"Dari mana asalnya?"</h3>
                    <p>Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih dari 2000 tahun. Richard McClintock, seorang professor Bahasa Latin dari Hampden-Sidney College di Virginia, </p>
                </div>
                <div class="six wide right floated column">
                    <img src="{{url('/')}}/main/resources/assets/images/tlits.png" class="ui large bordered rounded image">
                </div>
            </div>
            <div class="row">
                <div class="center aligned column">
                    <a class="ui huge button">Lihat Lebih</a>
                </div>
            </div>
        </div>
    </div>


    <div id="produkkami" class="ui vertical stripe quote segment">
        <div class="ui equal width stackable internally celled grid">
            <div class="center aligned row">
                <div class="column">
                    <h3>"Dari mana saya bisa mendapatkannya?"</h3>
                    <p>Ada banyak variasi tulisan Lorem Ipsum yang tersedia, tapi kebanyakan sudah mengalami perubahan bentuk,</p>
                </div>
                <div class="column">
                    <h3>"Mengapa kita menggunakannya?"</h3>
                    <p>
                        <img src="{{url('/')}}/main/resources/assets/images/tlits.png" class="ui avatar image"> <b>Nan</b> Chief Fun Officer Acme Toys
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="beritakami" class="ui vertical stripe segment">
        <div class="ui text container">
            <h3 class="ui header">Terjemahan tahun 1914 oleh H. Rackham</h3>
            <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,</p>
            <a class="ui large button">Lihat Selengkapnya</a>
            <h4 class="ui horizontal header divider">
                <a href="#">Case Studies</a>
            </h4>
            <h3 class="ui header">Naskah Lorem Ipsum standar yang digunakan sejak tahun 1500an</h3>
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            <a class="ui large button">Lihat Selengkapnya</a>
        </div>
    </div>


    <div id="contactus" class="ui inverted vertical footer segment" style="background-color:#329ee1 ">
        <div class="ui container">
            <div class="ui stackable inverted divided equal height stackable grid">
                <div class="three wide column">
                    <h4 class="ui inverted header">About</h4>
                    <div class="ui inverted link list">
                       <p>PT. Trans Lampung Utama</p>
                       <p>Lampung, Sumatera Selatan</p>
                       <p>Nomor Telepon :</p>
                       <p>05842216**</p>
                       <p>0214578**</p>
                    </div>
                </div>
                <div class="three wide column">
                    <h4 class="ui inverted header">Services</h4>
                    <div class="ui inverted link list">
                        <a href="#" class="item">Banana Pre-Order</a>
                        <a href="#" class="item">DNA FAQ</a>
                        <a href="#" class="item">How To Access</a>
                        <a href="#" class="item">Favorite X-Men</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
