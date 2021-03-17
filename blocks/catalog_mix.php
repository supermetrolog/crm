<?php
/**
 * Created by PhpStorm.
 * User: timondecathlon
 * Date: 07.08.20
 * Time: 12:09
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

?>

<div id="main-area">
    <? include_once ($_SERVER['DOCUMENT_ROOT'].'/templates/offers/wall/index_mix.php'); ?>
</div>

    <script src="https://api-maps.yandex.ru/2.1/?apikey=2b6763cf-cc99-48c7-81f1-f4ceb162502a&lang=ru_RU" type="text/javascript" async defer></script>
    <script>
        //ymaps.ready(initMap); // Ожидание загрузки API с сервера Яндекса
        document.ready = function() {
            //showPoints([]);
        };

        //function initMap (points) {
        function initMap(points) {

            console.log('212121');

            //let map = document.getElementById('map-catalog').style.backgroundImage = 'https://cdn.cssauthor.com/wp-content/uploads/2018/06/Jelly-Preloader.gif';

            myMap = new ymaps.Map("map-catalog", {
                center: [55.76, 37.64], // Координаты центра карты
                zoom: 10,
                controls: ['zoomControl']
            });

            //let points = document.getElementById('maps-points').innerHTML;



            let myGeoObjects = [];

            for(let i = 0; i < points.length; i++){

                let myPlacemark = new ymaps.Placemark(
                    // Координаты метки
                    [points[i]['latitude'], points[i]['longitude']],
                    {
                        hintContent: '<b>ID '+points[i]['id']+'</b><br>'+points[i]['address'],
                        balloonContent: '<b>ID '+points[i]['id']+'</b><br>'+points[i]['address']+'<br><a href="<?=PROJECT_URL?>/complex/'+points[i]['id']+'" target="_blank"> <img style="width: 200px" src="'+points[i]['thumb']+'" /></a>'
                    },
                    {
                        // Опции.
                        // Необходимо указать данный тип макета.
                        iconLayout: 'default#image',
                        // Своё изображение иконки метки.
                        iconImageHref: '<?=PROJECT_URL?>/img/marker.png',
                        // Размеры метки.
                        iconImageSize: [30, 30],
                        // Смещение левого верхнего угла иконки относительно
                        // её "ножки" (точки привязки).
                        iconImageOffset: [-15, -15]
                    }



                );

                // Добавление метки на карту
                myMap.geoObjects.add(myPlacemark);

                myGeoObjects.push(myPlacemark)
            }

            let clusterer = new ymaps.Clusterer();
            clusterer.add(myGeoObjects);
            myMap.geoObjects.add(clusterer);

            myMap.behaviors.disable('scrollZoom');
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').on('click', '.blocks-dropdown-button', function(){
                $('.blocks_'+$(this).attr('id')).slideToggle();
                if($(this).find('a').html() == '<i class="fas fa-angle-up"></i>'){
                    $(this).find('a').html('<i class="fas fa-bars"></i>');
                }else{
                    $(this).find('a').html('<i class="fas fa-angle-up"></i>');
                }
            });
        });
    </script>





<style>

    .tabs {
        text-align: left;
    }

    .tabs > .tab {
        padding: 10px;
        box-sizing: border-box;
        cursor: pointer;
    }

    .tabs-content > div{
        display: none;
    }

    .tabs > div > section {
        display: none;
    }

    .tab-selected{
        background: #e4eddb;
    }





</style>




