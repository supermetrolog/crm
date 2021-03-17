<div class='map' id='map_shops' style='width :100%; height: 600px;'>
	    
</div>

<?

$points_arr = array();
$i =0;

$points_sql = $pdo->prepare("SELECT * FROM shops  " );
$points_sql->execute();
while($point_info = $points_sql->fetch()){
   $photo = unserialize($point_info['photo']); 
   $points_arr[$i] = $point_info['id'].'&'.$point_info['title'].'&'.$photo[0].'&'.$point_info['latitude'].'&'.$point_info['longitude'].'&'.$point_info['address'];       	
   $i++;
}

$points_json = json_encode($points_arr);   
?>
<script>
      function initMap() {
        var home = {lat: 55.7182753, lng: 37.6775274};
        var map = new google.maps.Map(document.getElementById('map_shops'), {
          zoom: 12,
          center: home
        });

        var points = JSON.parse('<?=$points_json?>');

                    points.forEach(function(item, i, arr){
                      var params_points = item.split('&');
                      var id = params_points[0];
                      var title = params_points[1];
					  var photo = params_points[2];
                      var lat = Number(params_points[3]);
                      var lon = Number(params_points[4]);
                      //var city = params_points[4];
                      var address = params_points[5];
                      //var phone = params_points[6];
					  //var working_time = params_points[7]; 
					  //var description = params_points[8];
                       
                      //var contentString = "<div style='text-align: center; ' id='content'><a style='text-align: center;' href='/shop_card.php?id="+id+"&cathegory=shops&city="+city+"&title="+ title +"' ><b>"+ title +"</b></a><br><p class='map_address'><img style='width: 100px;' src='" + photo+ "' /><p>Адрес: " + address+ "</p><p class=''>Тел: " + phone + "</p><p class='map_status'>Время работы: " + working_time + "</p></div>";
                      var contentString = "<div style='text-align: center; ' id='content'><img style='width: 100px;' src='"+photo+"' /><br><a style='text-align: center;' href='' ><b>"+ title +"</b></a></p></div>";
                        var infowindow_users = new google.maps.InfoWindow({
	                    content: contentString
                      });     
                       
                      var marker = new google.maps.Marker({
                        position: {lat: lat , lng: lon},
                        map: map
                      });
                     
                      google.maps.event.addListener(marker, 'click', function() {
	                    infowindow_users.open(map,marker);
                      });    
                    }); 
      }
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=<?=$media_src['g_maps_key']?>&callback=initMap" async defer>  </script>				  		