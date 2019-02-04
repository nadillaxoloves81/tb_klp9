 <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1TwYksj1uQg1V_5yPUZqwqYYtUIvidrY&callback=basemap"></script>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

    <!--Fancybox-->
    <script type="text/javascript" src="fancy/jquery.mousewheel-3.0.6.pack.js"></script> <!-- Sertakan JQuery mousewheel untuk image gallery!-->
    <script type="text/javascript" src="fancy/source/jquery.fancybox.js?v=2.1.5"></script> <!-- Sertakan JQuery fancybox dan cssnya-->
    <link rel="stylesheet" type="text/css" href="fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />

   <!-- script pencarian -->
  <script type="text/javascript">
      $(function(){
        $('.fancybox').fancybox();
        $.ajax({
        url: server+'/caritipe.php', data: "", dataType: 'json', success: function(rows)
          {
            for (var i in rows)
              {
                var row = rows[i];
                $('#selecttipe').append('<option value="'+row+'">'+row+'</option>');
              }
          }
         });
        $(document).on('change','#selecttipe',function()
          {
            var tipe=document.getElementById("selecttipe").options[document.getElementById("selecttipe").selectedIndex].value;
            $('#selectjenis').html("");
              $.ajax({
                url: server+'/carijenis.php?tipe='+tipe+'', data: "", dataType: 'json', success: function(rows)
                    {
                      for (var i in rows)
                      {
                        var row = rows[i];
                        var idjenis=row.id_jenis;
                        var jenis=row.jenis;
                        $('#selectjenis').append('<option value="'+idjenis+'">'+jenis+'</option>');
                      }
                  }
                });
          });
      });
  </script>


  <script type="text/javascript">
      var infowindow;
      var geomarker;
      var markerarray = [];
      var map;
      var objek;
      var directionsService;
      var directionDisplay;
      var usegeolocation;
      var server='http://localhost/tb_klp9/webserver/';
      var markerarraygeo=[];
      var circlearray=[];
      var layernya;

      function initialize() {
            geolocation();
            basemap();
        }
      function basemap() {
          	google.maps.visualRefresh = true;
            map = new google.maps.Map(document.getElementById('map_canvas'), {
                  zoom: 16,
                  center: new google.maps.LatLng(-0.914813, 100.458801),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            loadLayer();
        };

      function loadLayer(){
            layernya = new google.maps.Data();
            layernya.loadGeoJson(server+'layer.php');
            layernya.setMap(map);

        }
      function loaddata(results){
        		if(results.features === null)
                 {
                     alert("Data yang dicari tidak ada");
                 }
                 else
                 {
                    for (var i = 0; i < results.features.length; i++) {
                        var data = results.features[i];
                        var coords = data.geometry.coordinates;
                        var id = data.properties.id;
                        var nama = data.properties.nama;
                        var alamat= data.properties.alamat;
                        var deskripsi=data.properties.deskripsi;
                        var pemilik=data.properties.pemilik;
                        var pegawai=data.properties.pegawai;
                        var kulkas=data.properties.kulkas;
                        var etalase=data.properties.etalase;
                        var meja_kasir=data.properties.meja_kasir;
                        var meja_luar=data.properties.meja_luar;
                        var mesin_kasir=data.properties.mesin_kasir;
                        var titiktengah = data.properties.center
                        var latitude = titiktengah.lat;
                        var longitude = titiktengah.lng;
                        var latLng = new google.maps.LatLng(latitude,longitude);
                  		  var gambar=data.properties.image; //menmpilkan informasi pada pencarian

                        google.maps.visualRefresh = true;
                                  map = new google.maps.Map(document.getElementById('map_canvas'), {
                                        zoom: 16,
                                        center: new google.maps.LatLng(latitude, longitude),
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                  });
                                  loadLayer();

                  		     $('.listdaftar').append('<p><b><a class="fancybox" href="#berita'+id+'"">'+nama+'</a></b></p><p>Travel Mode : <select id="travelmode"><option value="DRIVING">Driving</option><option value="WALKING">Walking</option><option value="BICYCLING">Bicycling</option><option value="TRANSIT">Transit</option></select></p><button id="'+i+'" class="buttongetdirection">Get Direction</button><br><br><div class="panel"></div>');
                  			 $('#berita').append('<div id="berita'+id+'" style="width:600px;display:none;text-align:justify;"><h2><b><center>'+nama+'</b></h2><br><br><center><img src="'+server+'/'+gambar+'" style="width:80%;"></center><br><br><p style="margin:5px;">'+deskripsi+'</p></div>');
                        var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
                        var marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            animation: google.maps.Animation.DROP,            
                            icon: "pict/img/iconfinder_Map-Marker-Push-Pin--Right-Pink_73062.png",
                            title: nama
                            //shadow: iconBase + 'schools_maps.shadow.png'
                          });

        		            markerarray.push(marker); //menampilkan informasi pada marking
                        var isiinfo="<div style='width:300px; padding: 10px; border: 2px solid #8E001B;'><b><h2 style='margin-top: -5px; color: #8E001B;'><center>"+nama+"</center></h2></b><center><img src='"+server+"/"+gambar+"' style='width:100%; border-radius: 5px;'></center><br> <div style='background-color: #FFE2E2; width: 100%; height:290px; padding: 5px; border: 1px solid #8E001B;'><center><h4>DESKRIPSI</h4></center><table style='width: 100%; '><tr><td><p><b>Alamat</b></p></td><td><p><b> : </b> "+alamat+"</p></td></tr>  <tr><td><p><b>Pemilik</b></p></td><td><p><b> : </b> "+pemilik+"</p></td></tr>   <tr><td><p><b>Jumlah Pegawai</b></p></td><td><p><b> : </b> "+pegawai+" orang</p></td></tr>   <tr><td><p><b>Atribut<span><b> : </b></span></b></p></td><td>   <ul><li><p><b>Kulkas : </b>"+kulkas+" buah</p></li><li><p><b>Etalase : </b>"+etalase+" buah</p></li><li><p><b>Meja Kasir : </b>"+meja_kasir+" buah</p></li><li><p><b>Meja Luar : </b>"+meja_luar+" buah</p></li><li><p><b>Mesin Kasir : </b>"+mesin_kasir+" buah</p></li></ul></p></td></tr></table></div></div>";
                        createInfoWindow(marker, isiinfo);
                      }
                  }

            $('.buttongetdirection').click(function(){
                $("#daftar").prepend('<div id="paneldirection"></div>');
                var k=this.id;
                var titikawal=geomarker.getPosition();
                var titikakhir=markerarray[k].getPosition();
                calcRoute(titikawal,titikakhir);
                clearmarker();
        			  $('.listdaftar').html('');
        		      });
          }

      var infowindow = new google.maps.InfoWindow();
      function createInfoWindow(marker, isiinfo) {
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(isiinfo);
                infowindow.open(map, this);
              });
        }
        google.maps.event.addDomListener(window, 'load', initialize);

      function calcRoute(start, end) {
          var travelmode = document.getElementById("travelmode").options[document.getElementById("travelmode").selectedIndex].value;
          directionsService = new google.maps.DirectionsService();
          var request = {
                 origin:start,
                 destination:end,
                 travelMode: google.maps.TravelMode[travelmode],
                 unitSystem: google.maps.UnitSystem.METRIC,
                 provideRouteAlternatives: true
            };
          directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                 directionsDisplay.setDirections(response);
                }
            });
          directionsDisplay = new google.maps.DirectionsRenderer({draggable: false});
          directionsDisplay.setMap(map);
        	directionsDisplay.setPanel(document.getElementById('paneldirection'));
        }

      function clearmarkergeo(){
          for (var i = 0; i < markerarraygeo.length; i++) {
               markerarraygeo[i].setMap(null);
            }
          markerarraygeo=[];
        }

      function clearmarker(){
          for (var i = 0; i < markerarray.length; i++) {
                markerarray[i].setMap(null);
            }
          markerarray=[];
        }

      function clearroute(){
          directionsDisplay.setMap(null);
        }


      function geolocation(){
          navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError);
        }

      function geolocationSuccess(posisi){
          var pos=new google.maps.LatLng(posisi.coords.latitude,posisi.coords.longitude);
          var image = 'pict/img/iconfinder_map-marker_299087.png';
          geomarker = new google.maps.Marker({
                map: map,
                position: pos,
                icon: image,
                animation: google.maps.Animation.DROP
        	  });
          map.panTo(pos);
          infowindow = new google.maps.InfoWindow();
          infowindow.setContent('Your Position');
          infowindow.open(map, geomarker);
          usegeolocation=true;
        }

      function geolocationError(err){
          usegeolocation=false;

        }

  </script>

  <script type="text/javascript">
  		$(function(){
  			$('#cari').click(function(){
  				$('#paneldirection').html('');
  				clearmarker();
  				$(".listdaftar").html("");
  				var hasil = document.getElementById("selectjenis").value;
  				var script1 = document.createElement('script');
          script1.src = server+'/caripeta.php?idjenis='+hasil+'';
  				document.getElementsByTagName('head')[0].appendChild(script1);
  				clearroute();
  				});
  		});

	</script>

<!-- membuat pencarian dan peta -->
    <div class="container" style="margin-top: 40px;">
        <div class="col-md-8 col-lg-offset-2">
        <div class="searchbox" style="text-align: center;">
            <h2 style="color: #8E001B; font-family: Bernard MT Condensed; font-size: 40px;">Pilih Objek Minimarket :</h2>
            <select class="custom-select"  name="selecttipe" id="selecttipe" class="custom-select" placeholder="Kata kunci" style="color: black;">
                <option>- Jenis -</option>
            </select>
            <select class="custom-select" name="selectjenis" id="selectjenis" placeholder="Jenis" style="color: black;">
                <option>- Pilihan -</option>
             </select>
            <button id="cari" class="btn btn-primary" >
             SEARCH <span class="glyphicon glyphicon-search"></span>
            </button>
        </div>
        </div>
    </div>
    <br>
    <div id="berita"></div>

    <div class="col-md-4">
      <div class="control-group">
          <div class="controls">
          <div id="daftar" style="float: left;">
                <div class="listdaftar"></div>
          </div>
          </div>
      </div>
    </div>

    <div class="col-md-8">  
          <div class="control-group" style="float: right;">
          <div id="map_canvas" style="height: 500px; width: 800px;"></div>
          </div>
    </div> 
    
    
    
    