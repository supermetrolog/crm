<?php
if($page_template == 'user'){
    if(explode('/',$furl['path'])[2] != NULL){
        $user_id = explode('/',$furl['path'])[2];
    }else{
        $user_id = $logedUser->member_id();
    }
    $user_id = explode('/',$furl['path'])[2];
}else{
    $user_id = $logedUser->member_id();
}
(!$user_id)? $user_id = $logedUser->member_id() : '';
$pageUser = new Member($user_id);
$event = new Event(2);
?>

<div class='event-card personal-page-grid'>
    <? include($_SERVER["DOCUMENT_ROOT"].'/system/templates/events/header/index.php');?>
    <div class='user-menu '>
        <div class='text_left user-pages'>
            <div class='bitkit_widget_title isBold text_left'>
                Основная информация
            </div>
            <div class='list_element'>
                <?=$event->description()?>
            </div>
        </div>
        <?if($pageUser->hasMarker()){  ?>
            <div class='event_map'>
                <div class='bitkit_widget_title isBold text_left'>
                    <a href='<?=$pageUser->instagram()?>' target='_blank'><?=$pageUser->name()?> на карте</a>
                </div>
                <div id='point_map'>

                </div>
            </div>
        <? } ?>
    </div>
    <div class='work-area box-left-top'>
        <? include('system/user/'.$page_template.'.php');?>
    </div>
</div>


<?if($pageUser->hasMarker()){  ?>
    <script>
        function initMap() {
            var home = {lat: <?=$pageUser->marker()->markerLatitude()?>, lng: <?=$pageUser->marker()->markerLongitude()?>};
            var map = new google.maps.Map(document.getElementById('point_map'), {
                zoom: 16,
                center: home
            });
            var marker = new google.maps.Marker({
                position: home,
                map: map
            });

            var contentString = "<div сlass='photo-round photo-middle'  style='text-align: center; ' id='content'><div style='border-radius: 50%; overflow: hidden; width :100px; height: 100px'><img style='width: 100%;' src='<?=PROJECT_URL.'/'.$pageUser->avatar()?>' /></div></a><br><a style='text-align: center;' href='' ><b><?=$pageUser->name()?></b></a></p></div>";
            var infowindow_users = new google.maps.InfoWindow({
                content: contentString
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow_users.open(map,marker);
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$media_src['g_maps_key']?>&callback=initMap" async defer>  </script>
<? } ?>