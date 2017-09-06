<!DOCTYPE html>
<html>
<head>
    <title>Semut Angkot</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <link href="{{url('/')}}/main/resources/assets/semantic/dist/semantic.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{url('/')}}/main/resources/assets/images/angkot/Artboard%202hdpi.png"/>

    <style>
        .custom .leaflet-popup-tip,
        .custom .leaflet-popup-content-wrapper {
            background-color: rgba(176,224,230,1) ;
            color: black;
        }
    </style>
</head>
<body style="height: 100%;background-color: white">
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/jquery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/semantic.js"></script>
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/Leaflet.MovingMarker-master/MovingMarker.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyCSGRdkLk-IiiUGIucZP3Vs6FnpCqNJLew"></script>

<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/Leaflet.draw.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/Leaflet.Draw.Event.js"></script>
<link rel="stylesheet" href="{{url('/')}}/main/resources/assets/Leaflet.draw/src/leaflet.draw.css"/>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/Toolbar.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/Tooltip.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/GeometryUtil.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/LatLngUtil.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/LineUtil.Intersect.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/Polygon.Intersect.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/Polyline.Intersect.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/ext/TouchEvents.js"></script>

<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/DrawToolbar.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Feature.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.SimpleShape.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Polyline.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Marker.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Circle.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.CircleMarker.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Polygon.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/draw/handler/Draw.Rectangle.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/EditToolbar.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/EditToolbar.Edit.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/EditToolbar.Delete.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/Control.Draw.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.Poly.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.SimpleShape.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.Rectangle.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.Marker.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.CircleMarker.js"></script>
<script src="{{url('/')}}/main/resources/assets/Leaflet.draw/src/edit/handler/Edit.Circle.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var map = L.map('mymap',{closePopupOnClick: false}).setView([-6.890420436859131, 107.6103515625], 12.5);
        var gpstracersLayer = L.layerGroup();
        var socialreportlayer = L.layerGroup();
        var gpstracersmarker=Array();
        var socialreportmarker=Array();
        var gpstracersMoveMarker=Array();
        var drawnItems = L.featureGroup().addTo(map);

        L.control.layers({
            "google": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                attribution: 'google'
            }),
            'mapbox':   L.tileLayer('http://api.tiles.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoic3J1cGllZWUiLCJhIjoib05wWVBWTSJ9.RqbymEhEdLg2eDuVr6oPZg', {
                maxZoom: 18,
                id: 'your.mapbox.project.id',
                accessToken: 'your.mapbox.public.access.token'
            }).addTo(map)
        }, { 'Gambar': drawnItems }, { position: 'topleft', collapsed: false }).addTo(map);
        map.addControl(new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                poly: {
                    allowIntersection: false
                }
            },
            draw: {
                polygon: {
                    allowIntersection: false,
                    showArea: true
                }
            }
        }));

        map.on(L.Draw.Event.CREATED, function (event) {
            var layer = event.layer;

            drawnItems.addLayer(layer);
        });
        var init=0;
        var tracerIcon = L.icon({
            iconUrl: "{{url('/')}}/main/resources/assets/images/angkot/Angkot 6.png",
            iconSize:     [30, 40], // size of the icon
            iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
            popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
        });
        var socialReportIcon = L.icon({
            iconUrl: "{{url('/')}}/main/resources/assets/images/angkot_report.png",
            iconSize:     [30, 40], // size of the icon
            iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
            popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
        });

        var info = L.control();

        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };


        function onclick_map_setting() {
            $('.ui.sidebar')
                    .sidebar('toggle')
            ;
        }
        function initTracker() {

            $.get('<?=url('user/listangkottoday')?>', function(gpstr) {
                console.log(gpstr)
                if($('#tracer').is(":checked")){
                    for(var i=0;i<gpstr.length;i++){
                        gpstracersMoveMarker[i] = L.Marker.movingMarker( [[gpstr[i].Latitude, gpstr[i].Longitude],[gpstr[i].Latitude, gpstr[i].Longitude]], 20000, {autostart: true});

                        gpstracersMoveMarker[i].options.icon=tracerIcon;

                        gpstracersLayer.addLayer(gpstracersMoveMarker[i]);
                        var speed=Math.round(gpstr[i].Speed*100)/100;
                        var customOptions =
                            {
                                'maxWidth': '500',
                                'className' : 'custom',
                                'autoClose':false
                            }
                        var costumTooltip=
                            {
                                permanent: true,
                                direction: 'bottom'
                            }
                        gpstracersMoveMarker[i].bindPopup("Nama :"+gpstr[i].Name+"<br>Email :"+gpstr[i].Email+'<br>Nomor Handphone: '+gpstr[i].PhoneNumber+"<br>Trayek: "+gpstr[i].Angkot.Trayek.Nama+"<br>Jumlah Penumpang: "+gpstr[i].Angkot.JumlahPenumpang,customOptions);
                        gpstracersMoveMarker[i].bindTooltip(gpstr[i].Angkot.PlatNomor,costumTooltip);
                    }
                    gpstracersLayer.addTo(map);
                }
            });
            init++;
        }
        initTracker();
        function initReport() {
            if($('#socialreport').is(":checked")){
            $.get('<?=url('user/reportlist')?>', function(report) {
                console.log(report)

                    for(var i=0;i<report.length;i++){
                       socialreportmarker[i]=L.marker([report[i].latitude, report[i].longitude], {icon: socialReportIcon}).addTo(map);
                       var costumTooltip=
                            {
                                permanent: true,
                                direction: 'bottom'
                            };
                        var customOptions =
                            {
                                'maxWidth': '500',
                                'className' : 'custom',
                                'autoClose':false
                            }
                       var detail=report[i].detail;
                        socialreportmarker[i].bindPopup(""+report[i].detail+'<br>'+report[i].date+" "+report[i].time+"<br>Oleh :"+report[i].PostBy.username,customOptions);
                        socialreportmarker[i].bindTooltip(detail,costumTooltip);
                       socialreportlayer.addLayer(socialreportmarker[i]);
                    }
                    socialreportlayer.addTo(map);

            });
            }
        }
        initReport();
        function updateTracker() {
            setInterval(function(){
                if (init>0){
                    $.get('<?=url('user/listangkottoday')?>', function(gpstr) {
                        if($('#tracer').is(":checked")){
                            for(var i=0;i<gpstr.length;i++){
                                gpstracersMoveMarker[i].moveTo([gpstr[i].Latitude, gpstr[i].Longitude],2000);
                               gpstracersMoveMarker[i].bindPopup("Nama :"+gpstr[i].Name+"<br>Email :"+gpstr[i].Email+'<br>Nomor Handphone: '+gpstr[i].PhoneNumber+"<br>Trayek: "+gpstr[i].Angkot.Trayek.Nama+"<br>Jumlah Penumpang: "+gpstr[i].Angkot.JumlahPenumpang);

                                if(gpstracersMoveMarker[i].isPopupOpen()){
                                    gpstracersMoveMarker[i].openPopup();
                                }
                            }
                        }
                    });
                }
            },5000);
        }
        updateTracker();
        var legend = L.control({position: 'bottomleft'});
        var semutweb='http://bsts.lskk.ee.itb.ac.id';
        legend.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend');

            // loop through our density intervals and generate a label with a colored square for each interva
            div.innerHTML +='<img src="{{url('/')}}/main/resources/assets/images/semut.png"  onclick="window.open(semutweb)" height="50" width="50" >';

            div.innerHTML +='<img src="{{url('/')}}/main/resources/assets/images/downloadaps.png"  onclick="window.open(semutbandarlampungapps)" height="50"  >';
            return div;
        };

        legend.addTo(map);

        var GooglePlacesSearchBox = L.Control.extend({position: 'bottomleft',
            onAdd: function() {
                var element = document.createElement("input");
                element.id = "searchBox";
                element.style.width = "250px";
                element.style.margin = "20px";
                return element;
            }
        });
        (new GooglePlacesSearchBox).addTo(map);

        var input = document.getElementById("searchBox");
        var searchBox = new google.maps.places.SearchBox(input);

        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            var group = L.featureGroup();

            places.forEach(function(place) {

                // Create a marker for each place.
                var marker = L.marker([
                    place.geometry.location.lat(),
                    place.geometry.location.lng()
                ]);
                group.addLayer(marker);
            });

            group.addTo(map);
            map.fitBounds(group.getBounds());

        });

        var button = L.control({position: 'bottomright'});
        button.onAdd = function (map) {

            var div = L.DomUtil.create('div', 'info legend');
            div.innerHTML +=' <a class="ui item" id="btnSetting"><div class="ui button" style="background-color: rgba(0, 0, 0, 0.1);color: white;font-weight: lighter;"><i class="setting icon"></i>Edit Map</div></a>';

            return div;
        };
        button.addTo(map);
        document.getElementById ("btnSetting").addEventListener ("click", onclick_map_setting, false);


    });
</script>
<div class="ui right sidebar inverted vertical menu" style="background: white">
    <div class="ui bulleted list">
        <div class="item">
            <h2 style="color: black">Map Selector</h2>
            <div class="list">
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox"  name="tracer" id="tracer" onclick="onclick_gps()" checked="true" >
                        <label>GPS Tracer</label>
                        <input type="checkbox"  name="socialreport" id="socialreport" onclick="onclick_gps()" checked="true" >
                        <label>Social Report</label>
                    </div>

                </div>
                <br>

            </div>
        </div>
    </div>
</div>
<div class="pusher" style="height: 100%;background: lightblue;padding-left:5%;padding-right: 5%">
    <div class="ui secondary pointing menu" style="padding: 5px;border-color: yellow">
        <img class="ui image" href="{{url('/login')}}" src="{{url('/')}}/main/resources/assets/images/angkot/Artboard%202hdpi.png" style="height: 50px">

        <div class="right menu">
            @if(session()->has('ID'))
                <a class="item" href="{{url('/admin/dashboard')}}">Dashboard Admin</a>
                <a class="item" href="{{url('user/logout')}}">Logout</a>
            @else
                <a class="item" href="{{url('/login')}}">Login</a>
            @endif
        </div>
        </div>

        <div id="mymap" style="height: 92%; width: 100%">

        </div>

</div>
</body>
</html>
