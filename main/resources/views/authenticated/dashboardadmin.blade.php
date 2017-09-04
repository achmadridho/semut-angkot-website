<!DOCTYPE html>
<html>
<head>
    <title> Semut Angkot</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <link href="{{url('/')}}/main/resources/assets/semantic/dist/semantic.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{url('/')}}/main/resources/assets/images/angkot/Artboard%202hdpi.png"/>

    <style>


    </style>
</head>
<body style="height: 100%">


<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/jquery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/semantic.js"></script>
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyCSGRdkLk-IiiUGIucZP3Vs6FnpCqNJLew"></script>

<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<meta charset="utf-8">
<meta name="_token" content="{{ csrf_token() }}">
<script type="text/javascript">
    $(document).ready(function(){
        $(".openbtn").on("click", function() {
            $(".ui.sidebar").toggleClass("very thin icon");
            $(".asd").toggleClass("marginlefting");
            $(".sidebar z").toggleClass("displaynone");
            $(".ui.accordion").toggleClass("displaynone");
            $(".ui.dropdown.item").toggleClass("displayblock");
            $(".logo").find('img').toggle();
            if(!isMobile) isMobile = true;
            else isMobile = false;
        })
        $(".ui.dropdown").dropdown({
            allowCategorySelection: true,
            transition: "fade up",
            context: 'sidebar',
            on: "hover"
        });

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        function loadListDriver() {
            $.get('<?=url('user/listangkot')?>',{ },
                    function(data) {
                        loadtabelangkot(data,2);
                    }
            );
        }
        loadListDriver();

        function loadtabelangkot(data,x) {
            $("#listuserangkot tr").remove();
            var table = document.getElementById("listuserangkot");
            var thead, tr, td;
            table.appendChild(thead = document.createElement("thead"));
            thead.appendChild(tr = document.createElement("tr"));
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "No";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Nama";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Email";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Nomor Telepon";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Plat Nomor";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Trayek";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "ID";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "";
            var count=1;
            var btn=new Array();
            var editBtn=new Array();
            var countBtn=0;
            for (var i = 0; i < data.length; i++) {
                tr = document.createElement("tr");
                tr.setAttribute("id", "row" + i);
                if (i%2 == 0)
                {
                    tr.setAttribute("style", "background:white");
                }
                table.appendChild(tr);
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =count;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].Name;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].Email;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].PhoneNumber;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].Angkot.PlatNomor;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].Angkot.Trayek.Nama;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].Angkot.Trayek.TrayekID;

                tr.appendChild(td = document.createElement("td"));
                btn[i] = document.createElement('input');
                btn[i].type = "button";
                btn[i].id = "button"+i;
                btn[i].name = "button"+i;
                btn[i].className = "ui red button";
                btn[i].value = "delete";
                btn[i].nama=data[i].nama;
                btn[i]._id=data[i]._id;
                td.appendChild(btn[i]);
                $("#button"+i+"").click(function () {

                    deleteusertaxi($(this).prop("_id"));
                });

                count++;
            };
        }
        function editFormOpen(data) {
            $(".editTataModalBody #_id").val(data._id);
            $(".editTataModalBody #Name").val(data.Name);
            $(".editTataModalBody #Username").val(data.username);
            $(".editTataModalBody #Email").val(data.Email);
            $(".editTataModalBody #PhoneNumber").val(data.PhoneNumber);
            $(".editTataModalBody #Plat_motor").val(data.Plat_motor);
            $(".editTataModalBody #fotoProfile").attr('src',data.Path_foto);
            $('.ui.modal')
                    .modal('show')
            ;
        }
        function deleteusertaxi(id) {
            var result = confirm("Anda Yakin Mau Menghapus User?");
            if (result) {
                $.post('<?=url('user/delete')?>',{ _id:id},
                        function(data) {
                            window.location.reload();
                        }
                );
            }

        }
        var daftayBy=0;
        $("#insertuser").click(function() {
            var nama=document.getElementById("Name").value;
            var entity=document.getElementById("Entity").value;
            var plat=document.getElementById("Plat_motor").value;
            var password=document.getElementById("Password").value;
            var namaTrayek=$("#Trayek option:selected").text();
            var idTrayek=document.getElementById("Trayek").value;
            var showerror=document.getElementById('showerror');
            if(nama!=""&&entity!=""&&plat!=""&&password!=""&&namaTrayek!=""&&idTrayek!=""){
                if (hasWhiteSpace(plat)) {
                    showerror.style.display='block';
                    showerror.innerHTML="Plat Motor Tidak Boleh Memakai Spasi"
                }else {
                    if(daftayBy==0){
                        if(validateEmail(entity)){
                            $.ajax({
                                url: 'http://167.205.7.226:3049/users/register-angkot',
                                type: 'post',
                                crossDomain: true,
                                contentType: "application/x-www-form-urlencoded",
                                data: {
                                    password:password,
                                    name:nama,
                                    platnomor:plat,
                                    trayek:namaTrayek,
                                    trayek_id:idTrayek,
                                    entity:entity
                                },
                                dataType: 'json',
                                success: function (data) {
                                    if(data.success==true){
                                        loadListDriver();
                                    }else {
                                        showerror.style.display='block';
                                        showerror.innerHTML=data.message;
                                    }
                                }
                            });
                        }else {
                            showerror.style.display='block';
                            showerror.innerHTML="Email tidak valid"
                        }
                    }else {
                        $.ajax({
                            url: 'http://167.205.7.226:3049/users/register-angkot',
                            type: 'post',
                            crossDomain: true,
                            contentType: "application/x-www-form-urlencoded",
                            data: {
                                password:password,
                                name:nama,
                                platnomor:plat,
                                trayek:namaTrayek,
                                trayek_id:idTrayek,
                                entity:entity
                            },
                            dataType: 'json',
                            success: function (data) {
                                if(data.success==true){
                                    loadListDriver();
                                }else {
                                    showerror.style.display='block';
                                    showerror.innerHTML=data.message;
                                }
                            }
                        });
                    }
                }
            }else {
                showerror.style.display='block';
                showerror.innerHTML="Silahkan Lengkapi data anda"
            }

        });
        function validateEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        function hasWhiteSpace(s) {
            return s.indexOf(' ') >= 0;
        }
        $("#ByEntitiyButton").click(function() {

            var ByEntitiyButton=document.getElementById("ByEntitiyButton");
            var byentitylabel=document.getElementById("byentitylabel");
            if(byentitylabel.textContent=="Handphone"){
                ByEntitiyButton.textContent="Dengan Handphone";
                byentitylabel.textContent="Email";
                daftayBy=0;
            }else {
                ByEntitiyButton.textContent="Dengan Email";
                byentitylabel.textContent="Handphone";
                daftayBy=1;
            }


        });
    });


</script>


<div class="pusher" style="padding-left:5%;padding-right: 5%;background: lightblue;height: 100%">
    <div class="ui secondary pointing menu" style="padding: 5px;border-color: yellow;">
            <img class="ui image" src="{{url('/')}}/main/resources/assets/images/angkot/Artboard%202hdpi.png" style="height: 50px">

            <div class="right menu">
                <a class="item" href="{{url('/')}}">Lihat Peta</a>
                <a href="{{url('user/logout')}}"  class="item">Logout</a>
            </div>

    </div>
    <div  class="ui grid" >
        <div id="formtambahusertaxi" class="three wide column ui form" >
            <h3>Tambah Angkot</h3>
            <button class="ui primary basic button"  id="ByEntitiyButton" style="width: 100%">Dengan Handphone</button>
            <div class="ui segment fifteen wide column" style="border: double;border-color: yellow" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="field">
                    <label>Nama</label>
                    <input type="Username" name="Name" id="Name">
                </div>
                <div class="field">
                    <label id="byentitylabel">Email</label>
                    <input type="Username" id="Entity">
                </div>
                <div class="field">
                    <label>Nomor Plat</label>
                    <input type="Username" id="Plat_motor">
                </div>
                <div class="field">
                    <label>Trayek</label>
                    <select id="Trayek" class="ui fluid selection dropdown">
                        <option value="">Trayek</option>
                        <option value="1">Cimindi pasar sederhana 24</option>
                        <option value="2">St hall gunung batu 14</option>

                    </select>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="Username" id="Password">
                </div>
                <input class="ui button green" type="button" name="submit_id" id="insertuser" value="Simpan"/>
            </div>
        </div>
        <div class="thirteen wide column"  >
            <div id="showerror" class="ui ignored negative message" style="display:none">

            </div>
            @if (count($errors) > 0)
                <div class="ui ignored negative message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ( Session::has('message') )
                <div class="ui ignored negative message">
                    {{ Session::get('message') }}
                </div>
            @endif
            @if ( Session::has('success') )
                <div class="ui ignored positive message">
                    {{ Session::get('success') }}
                </div>
            @endif
            <h1>Daftar List Angkot</h1>
            <table class="ui celled padded table" id="listuserangkot" style="border: double;border-color: yellow">

            </table>

        </div>

    </div>
</div>







</div>

</body>
</html>


