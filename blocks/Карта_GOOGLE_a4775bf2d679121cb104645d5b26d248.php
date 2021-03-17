
<div class='map' id='map_google' style='width :100%; height: 600px;'>
	    
</div>

<script>
      function initMap() {
        var home = {lat: 55.7182753, lng: 37.6775274};
		//создаем карту
        var map = new google.maps.Map(document.getElementById('map_google'), {
          zoom: 16,
          center: home
        });
		//содаем маркер
        var marker = new google.maps.Marker({
          position: home,
          map: map
        });
		//создаем всплывающее окно с текстом
		var contentString = "<div style='text-align: center; ' id='content'>г.Москва, Шарикоподшипниковская ул., дом 13, стр.3, офис 16 (ст.метро 'Дубровка')</div>";
           var infowindow_users = new google.maps.InfoWindow({
	       content: contentString
        }); 
		//цепляем окно на маркер
		google.maps.event.addListener(marker, 'click', function() {  
	       infowindow_users.open(map,marker);
        }); 
      }
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=<?=$media_src['g_maps_key']?>&callback=initMap" async defer>  </script>