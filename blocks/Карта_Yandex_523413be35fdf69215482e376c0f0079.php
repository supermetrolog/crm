		    <div id="map_yandex" style='width: 100%; height: 600px;'></div>				  		
<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script> 
<script>
ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map("map_yandex", {
            center: [55.7182753, 37.6775274],
            zoom: 12,
			controls: []
        }, {
            searchControlProvider: 'yandex#search'
        }),

    // Создаем геообъект с типом геометрии "Точка".
        
        myPieChart = new ymaps.Placemark([
            55.847, 37.6
        ], {
            // Данные для построения диаграммы.
            data: [
                {weight: 8, color: '#0E4779'},
                {weight: 6, color: '#1E98FF'},
                {weight: 4, color: '#82CDFF'}
            ],
            iconCaption: "Диаграмма"
        }, {
            // Зададим произвольный макет метки.
            iconLayout: 'default#pieChart',
            // Радиус диаграммы в пикселях.
            iconPieChartRadius: 30,
            // Радиус центральной части макета.
            iconPieChartCoreRadius: 10,
            // Стиль заливки центральной части.
            iconPieChartCoreFillStyle: '#ffffff',
            // Cтиль линий-разделителей секторов и внешней обводки диаграммы.
            iconPieChartStrokeStyle: '#ffffff',
            // Ширина линий-разделителей секторов и внешней обводки диаграммы.
            iconPieChartStrokeWidth: 3,
            // Максимальная ширина подписи метки.
            iconPieChartCaptionMaxWidth: 200
        });

    myMap.geoObjects

        .add(new ymaps.Placemark([55.7182753, 37.6775274], {
            balloonContent: '<?=$media_src['address']?>'
        }, {
            preset: ''
        }));
        
        
        
}
</script>  
		