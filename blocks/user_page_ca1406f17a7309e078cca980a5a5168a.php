<?php
$page_template = $router->getPageName();
$page_item = $router->getPageItemId();
if($page_template == 'user'){
    if($page_item == $logedUser->member_id()){
        $pageUser = new Member($user_id = $logedUser->member_id());
    }else{
        $pageUser = new Member($page_item);
        if($logedUser->member_id() > 0){
            $pageUser->setNewVisitor($logedUser->member_id());
        }
    }
}else{
    $pageUser = new Member($logedUser->member_id());
}

?>

    <div class='profile-card personal-page-grid'>
        <? include($_SERVER["DOCUMENT_ROOT"].'/templates/users/header/index.php');?>
        <div class='user-menu '>
            <div class='widget'>
                <div class='widget-title'>
                    Меню пользователя
                </div>
                <div class="widget-body">
                    <ul>
                        <?
                        $sql = $pdo->prepare("SELECT * FROM user_areas ORDER BY order_row DESC");
                        $sql->execute();
                        while($menu_item = $sql->fetch()){?>
                            <li class="<?=(trim($menu_item['link'], '/') == (trim($page_template, '/'))  ) ? 'btn-highlight' : ''; ?> ">
                                <div>
                                    <a href="<?=PROJECT_URL?>/<?=$menu_item['link']?><?=(trim($menu_item['link'], '/') == 'user')? $logedUser->member_id(): '';?>" ><?=$menu_item['title']?></a>
                                </div>
                            </li>
                        <?}?>
                    </ul>
                </div>
            </div>
            <?
            $user_field_groups = new FieldsGroup(0);
            foreach ($user_field_groups->getAllActiveUnits() as $fields_group){
                $fields_group = new FieldsGroup($fields_group['id']);
                /**
                 *Если у поля есть активные и публичные поля то показываем его и смотри его поля
                 */
                if($fields_group->groupHasPublicFields()){?>
                    <div class='widget'>
                        <div class='widget-title'>
                            <?=$fields_group->title()?>
                        </div>
                        <div class="widget-body">
                            <ul>
                                <?foreach ($fields_group->getGroupPublicFields() as $field_item){
                                    /*$field_item = new Field($field_item['title']);
                                    /**
                                     *Получаем все публичные поля поля и если они не пустые выводим
                                     */
                                    /*if(trim($pageUser->showField($field_item->title()))){?>
                                        <li class="widget-list-element">
                                            <div class="element-title">
                                                <b><a><?=$field_item->description()?></a></b>
                                            </div>
                                            <div >
                                                <a href="#"><?=$pageUser->showField($field_item->title())?></a>
                                            </div>
                                        </li>
                                    <?}*/
                                }?>
                            </ul>
                        </div>
                    </div>
                <?}?>
            <?}?>
            <? if($pageUser->instagram() !='' &&  $pageUser->instagram() !=' '){ ?>
                <div class='widget'>
                    <div class='widget-title'>
                        <a href='<?=$pageUser->instagram();?>' target='_blank'><?=$pageUser->name();?> в instagram</a>
                    </div>
                    <div class="widget-body">
                        <?$insta = new Instagram($pageUser->instagram()); // Инициализируем сеанс CURL  ?>
                        <div id='carousel' class='flexslider'>
                            <ul class='slides'>
                                <?for ($x=0; $x < 12; $x++) {?>
                                    <li><a href='<?=$insta->getLink()?>' target='_blank''><img src='<?=$insta->getProfilePostImage($x)?>'/></a></li>
                                <?}?>
                            </ul>
                        </div>
                        <script>
                            $(window).load(function() {
                                $('.flexslider ').flexslider({
                                    animation: "slide",
                                    controlNav: false,
                                    directionNav: true,
                                    itemWidth: 310,
                                    itemMargin: 5,
                                    minItems: 1,
                                    maxItems: 2
                                });
                            });
                        </script>
                        <script type="text/javascript" src="../js/jquery.flexslider.js"></script>
                    </div>
                </div>
            <?}?>
            <?if($pageUser->hasMarker()){  ?>
                <div class='event_map'>
                    <div class='bitkit_widget_title isBold text_left'>
                        <a href='<?=$pageUser->instagram()?>' target='_blank'><?=$pageUser->name()?> на карте</a>
                    </div>
                    <div id='point_map'>

                    </div>
                </div>
            <?}?>
            <?
            /**
             * Выводим все социальные круги и их членов если они есть
             */
            $circles = new Post(0);
            $circles->getTable('user_social_circles');
            foreach($circles->getAllActiveUnits() as $circle){
                if($pageUser->showJsonField($circle['users_circles_field']) != NULL){?>
                    <div class='widget'>
                        <div class='widget-title'>
                            <a href='#' target='_blank'><?=count($pageUser->showJsonField($circle['users_circles_field']))?>  <?=$circle['title']?></a>
                        </div>
                        <div class="flex-box flex-wrap">
                            <?foreach ($pageUser->showJsonField($circle['users_circles_field']) as $circle_member){
                                $circle_member = new Member($circle_member)?>
                                <div class="photo-round photo-small" style="margin: 10px;">
                                    <a href="<?=PROJECT_URL?>/user/<?=$circle_member->member_id()?>">
                                        <img title="<?=$circle_member->name()?>" src="<?=$circle_member->avatar()?>"/>
                                    </a>
                                </div>
                            <?}?>
                        </div>
                    </div>
                <?}?>
            <?}?>
            <?if($pageUser->getALLVisitors() != NULL){?>
                <div class='widget'>
                    <div class='widget-title'>
                        <a href='<?=$pageUser->instagram()?>' target='_blank'><?=count($pageUser->getALLVisitors() )?> Посетители</a>
                    </div>
                    <div class="widget-body">
                        <ul>
                            <?foreach ($pageUser->getALLVisitors() as $visitor_data){
                                $visitor = new Member($visitor_data->id)?>
                                <li class="widget-list-element flex-box">
                                    <div class="photo-round photo-small" >
                                        <a href="<?=PROJECT_URL?>/user/<?=$visitor->member_id()?>">
                                            <img title="<?=$visitor->name()?>" src="<?=$visitor->avatar()?>"/>
                                        </a>
                                    </div>
                                    <div class="box">
                                        <div class="user-name-block">
                                            <a href="<?=PROJECT_URL?>/user/<?=$visitor->member_id()?>/">
                                                <span><b><?=$visitor->name()?> </b></span><?=$visitor->surName()?> <?=$visitor->fatherName()?>
                                            </a>
                                        </div>
                                        <div class="ghost text_left">
                                            <?=date_format_rus($visitor_data->time)?>
                                        </div>
                                    </div>
                                </li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            <?}?>
        </div>
        <div class='work-area box-left-top'>
            <? //include($_SERVER["DOCUMENT_ROOT"].'/system/user/'.$page_template.'.php');?>
        </div>
    </div>

<?// include_once($_SERVER["DOCUMENT_ROOT"].'/system/templates/modals/member-edit/index.php')?>

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