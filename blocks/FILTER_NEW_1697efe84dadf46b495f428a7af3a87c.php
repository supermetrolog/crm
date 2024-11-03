<div class="search-block" >
    <div id="catalog-form" class="filters-block"  >
        <div>
            <div class="filter-primary-block background-fix filters-first-step"  style=" background-image: url(<?=PROJECT_URL?>//uploads/objects/90/1.jpg) ">
                <div>
                    <div class="flex-box flex-between ">
                        <?if($router->getPageName() == 'objects' || $router->getPageName() == 'requests' || $router->getPageName() == 'offers'){?>
                            <div class=" box flex-box flex-around full-width">
                                <!--
                                <div id="filter-step-12" class="flex-box">
                                    <?$filter = new Filter(64)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                -->

                                <div id="filter-step-1" class="flex-box">
                                    <?$filter = new Filter(33)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <div id="filter-step-2" class="flex-box flex-around box-vertical to-end">
                                    <?$filter = new Filter(1)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <div id="filter-step-safe"  class="flex-box flex-around ">
                                    <?$filter = new Filter(67)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                    <div style="height: 50px">

                    </div>
                    <div class="search-line-block"  >
                        <div class="search-line flex-box">
                            <input id="main-search"  style="padding: 15px ;" value="" class="full-width filter-input" type="text"  name="search" placeholder="ID, адрес, собственник, телефон, Ф.И.О, брокер, название СК" />
                        </div>
                    </div>
                    <div id="filter-step-3"  class="flex-around flex-box">
                        <?if($router->getPageName() == 'objects' || $router->getPageName() == 'requests' || $router->getPageName() == 'offers'){?>
                            <div class=" box-vertical ">
                                <div class="flex-box flex-around ">
                                    <?$filter = new Filter(42)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <!-- тут тип обьекта-->
                                <div class="flex-box flex-around box">
                                    <?$filter = new Filter(41)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <div class="box hidden">
                                    <?$filter = new Filter(65)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                            </div>
                        <?}?>
                        <?if($router->getPageName() == 'companies'){?>
                            <div class="box" id="filter-step-1-comp">
                                <div class="filter-unit flex-box flex-around ">
                                    <?$filter = new Filter(46)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <div class="filter-unit flex-box flex-around flex-around">
                                    <?$filter = new Filter(14)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                                <div class="filter-unit flex-box flex-around flex-around">
                                    <?$filter = new Filter(66)?>
                                    <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/filters/templates/'.$filter->filterGroupTemplate().'/index.php') ?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div style="height: 100px">

                </div>
            </div>

        </div>

        <?if( $router->getPageName() == 'offers' || $router->getPageName() == 'requests'){?>
        <div id="filter-step-4" class="box-small" style="background: #f3f3f3;">
            <div id="filters-panel-regions" style="background: #ffffff">

            </div>
        </div>
        <div id="filter-step-5" class="box-small" style="background: #f3f3f3;" >
            <div id="filters-panel-all" style="background: #ffffff">

            </div>
        </div>
        <?}?>
        <div class=" box-small">
            <div class="flex-box flex-center box-small" >
                <div class="filter-clear flex-box flex-center" style="position: absolute; bottom: -35px; z-index: 999; background: #f3f3f3; border-radius: 50%; width: 70px; height: 70px; border-bottom: 3px solid white;">
                    <div class="flex-box flex-center" style="background: white; border-radius: 50%; width: 35px; height: 35px; border: 1px solid #d0d0d0;">
                        <a href="/offers/"  >
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">




    let filter_arr = {}; // Создаём ассоциативный массив

    document.getElementById('main-search').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadCatalog(request);
        }
    };

    /*
    $("#main-search").keyup(function(event){
        if(event.keyCode === 13){
            let request = builtRequest();
            reloadCatalog(request);
            //alert('dfdfdfd');
        }
    });
    */

    <?if($router->getPageName() == 'objects' || $router->getPageName() == 'requests' || $router->getPageName() == 'offers'){?>


    document.getElementById('filter-step-1').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadFiltersRegions(request);
            reloadCatalog(request);

        }
    };

    document.getElementById('filter-step-2').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadCatalog(request);
        }
    };

    document.getElementById('filter-step-safe').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadCatalog(request);
        }
    };

    document.getElementById('filter-step-3').onchange = function() {
        //alert('ds');
        if (event.target.tagName === 'INPUT') {

            let request = builtRequest();
            reloadFilters(request);
            reloadCatalog(request);


            $('input[name="price_format"]:first-child').hide();
            $('input[name="price_format"]:first-child').prop('checked', true);

            //alert(event.target.value);
        }
    };

    $('body').on('click','.filter-sort',function(){
        let request = builtRequest();
        reloadCatalog(request);
    });

    /*
    document.getElementById('main-area').onclick = function() {
        alert('fggf');
        if (event.target.getAttribute('filter-sort') === '1') {
            alert('fggf');
            let request = builtRequest();
            reloadCatalog(request);
        }
    };
    */


    document.getElementById('filter-step-4').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadCatalog(request);
        }
    };

    document.getElementById('filter-step-5').onchange = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            reloadCatalog(request);
        }
    };





    <?}?>

    <?if($router->getPageName() == 'companies'){?>


        document.getElementById('filter-step-1-comp').onchange = function() {
            if (event.target.tagName === 'INPUT') {
                let request = builtRequest();
                reloadCatalog(request);
            }
        };



    <?}?>



    

    $('body').on('click','.page-item',function () {
        let request = builtRequest();
        reloadCatalog(request);
    });

    //СОРТИРОВКА
    document.getElementById('body').onchange = function() {
        if (event.target.getAttribute('data-sort') === '1') {
            //alert('3223232')
            let request = builtRequest();
            reloadCatalog(request);
        }
    };

    $('body').on('click','.filters-more',function () {
        //$('.filters-panel').css('max-height','none');
        $('.filters-panel').toggleClass('big-filters');
    });



    $('body').on('click','input[name="deal_type"]',function () {
        if(this.value == 3) {
            $('input[name="object_type"]').closest('.box').hide();
            $('input[name="safe_type[]"]').closest('.box').show();

            $('input[name="object_type"]').prop('checked', false);
            $('input[name="purposes[]"]').prop('checked', false);


            filter_arr['object_type'] = '';
            filter_arr['purposes'] = '';


        }else{
            $('input[name="safe_type[]"]').closest('.box').hide();
            $('input[name="object_type"]').closest('.box').show();

            $('input[name="safe_type[]"]').prop('checked', false);
            filter_arr['safe_type'] = '';
        }
    });

    $('body').on('click','.map-more',function () {
        $('.map-block').toggleClass('big-map');
    });

    window.xhttp = new XMLHttpRequest();
    window.xhttpPanelRegion = new XMLHttpRequest();
    window.xhttpPanelAll = new XMLHttpRequest();

    function reloadCatalog(request) {

        xhttp.abort();

        document.getElementById("preloader").style.display = 'block';

        let catalog_array = {
            'objects': 'objects',
            'offers': 'offers',
            'companies': 'companies',
            'requests': 'requests',
            'contacts': 'catalog_customers_513e0cce21b334b29a11da49d736dbe4.php'
        };

        //let xhttp=new XMLHttpRequest();
        let url = "<?=PROJECT_URL?>/templates/"+catalog_array['<?=$router->getPageName()?>']+"/wall/index.php?request="+request;
        //alert(url);
        xhttp.open('GET',url,true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status !== 200) {
                // обработать ошибку
                //alert( 'ошибка: ' + (this.status ? this.statusText : xhttp.responseText) );
                //alert( 'ошибка: ' + (this.status ? xhttp.responseText : xhttp.responseText) );
                //document.getElementById("main-area").innerHTML = xhttp.responseText;
                return;
            }

            if (xhttp.readyState === 4 && xhttp.status === 200){
                //alert(xhttp.responseText);
                document.getElementById("main-area").innerHTML = xhttp.responseText;
                document.getElementById("preloader").style.display = 'none';

                if('<?=$router->getPageName()?>' == 'offers'){
                    showPoints(request);
                }

                //
            }else{
                alert('возникли неполадки');
            }

            // получить результат из this.responseText или this.responseXML
        };
        return true;
    }

    showPoints(JSON.stringify([]));

    function showPoints(request){
        let xhttpPoints=new XMLHttpRequest();
        let pointsUrl = "<?=PROJECT_URL?>/templates/objects/points/index.php?request="+request;
        //alert(pointsUrl);
        xhttpPoints.open('GET',pointsUrl,true);
        xhttpPoints.send();

        xhttpPoints.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status !== 200) {
                // обработать ошибку
                //alert( 'ошибка: ' + (this.status ? xhttpPoints.responseText : 'запрос не удался') );
                return;
            }

            if (xhttpPoints.readyState === 4 && xhttpPoints.status === 200){
                //alert(xhttpPoints.responseText);

                initMap(JSON.parse(xhttpPoints.responseText));

            }else{
                alert('возникли неполадки');
            }
        };
    }


    function reloadFiltersRegions(request){
        if(filter_arr['region'] ) {






            xhttpPanelRegion.abort();
            xhttpPanelRegion.open('GET',"<?=PROJECT_URL?>/templates/filters/panel-regions/index.php?request="+request,true);
            xhttpPanelRegion.send();

            xhttpPanelRegion.onreadystatechange = function() {
                if (this.readyState !== 4) return;

                if (this.status !== 200) {
                    // обработать ошибку
                    //alert( 'ошибка: ' + (this.status ? this.statusText : 'запрос не удался') );
                    return;
                }

                if (xhttpPanelRegion.readyState === 4 && xhttpPanelRegion.status === 200){
                    document.getElementById("filters-panel-regions").innerHTML = xhttpPanelRegion.responseText;
                    //document.getElementById("filters-panel-all").innerHTML = '1';
                    //document.getElementById("preloader").style.display = 'none';
                }else{
                    alert('возникли неполадки');
                }
            }
        }else{
            document.getElementById("filters-panel-all").innerHTML = '';
        }
    }

    function reloadFilters(request){          

        //alert('ds');

        if(filter_arr['deal_type'] && (filter_arr['object_type'] || filter_arr['safe_type']) ) {
        //if(filter_arr['deal_type'] == 3 || (filter_arr['deal_type'] && filter_arr['object_type']) ) {
            //alert('Начали перезагружать фильтры');


            xhttpPanelAll.abort();
            xhttpPanelAll.open('GET',"<?=PROJECT_URL?>/templates/filters/panel-manual/index.php?request="+request,true);
            xhttpPanelAll.send();



            xhttpPanelAll.onreadystatechange = function() {

                //alert(xhttpPanelAll.responseText);
                document.getElementById("filters-panel-all").innerHTML = xhttpPanelAll.responseText;

                if (this.readyState !== 4) return;

                if (this.status !== 200) {
                    // обработать ошибку
                    //alert( 'ошибка: ' + (this.status ? this.statusText : 'запрос не удался') );
                    return;
                }


                if (xhttpPanelAll.readyState === 4 && xhttpPanelAll.status === 200){
                    //alert(xhttpPanelAll.responseText);
                    //document.getElementById("filters-panel-all").innerHTML = xhttpPanelAll.responseText;
                    //document.getElementById("preloader").style.display = 'none';
                }else{
                    alert('возникли неполадки');
                }
            }

            //alert('Перезагрузили фильтры');
        }else{
            document.getElementById("filters-panel-all").innerHTML = '';
        }
    }

    function builtRequest(){

        let target = event.target;

        //для input  и НЕ input
        let input_name = (target.getAttribute('name').replace('[]','')) ? target.getAttribute('name').replace('[]','') : target.name.replace('[]','');
        let input_value = (target.getAttribute('value'))? target.getAttribute('value') : target.value;

        if(target.type === 'checkbox' ){

            let field_arr = [];
            let items = document.getElementsByName(target.name);
            for(let i = 0; i < items.length; i++){
                if(items[i].checked === true){
                    field_arr.push(items[i].value);
                }
            }
            filter_arr[input_name] = field_arr;
        }else{
            filter_arr[input_name] = input_value;
        }

        if(input_name !== 'page_num'){
            filter_arr['page_num'] = '1';
        }

        //ПИШЕМ НА ФИЛЬТРАХ ВЫБРАННЫЕ ПУНКТЫ
        if(input_name === 'region' ){
            //ИЗМЕНЯЕМ ВИД ВЫПАДАШКИ
            if(filter_arr[input_name].length > 0 ){
                let str = document.getElementById('label-'+input_name+'-'+filter_arr[input_name]).getAttribute('title');
                /* если множественный выбор
                let str = '';
                for(let i = 0; i < filter_arr[input_name].length; i++){
                    str += document.getElementById('label-'+input_name+'-'+filter_arr[input_name][i]).getAttribute('title') +', ';
                    //alert()
                    if(i === 1){
                        str = str.substring(0, str.length - 2);
                        if(filter_arr[input_name].length - i - 1 > 0){
                            str = str + ' + еще '+(filter_arr[input_name].length - i - 1 );
                        }
                        break;
                    }
                }
                */
                $(target).closest('.custom-select').find('.custom-select-header .box-wide').html(str);
                $(target).closest('.custom-select').find('.select-title-filled').css('background','#ffdf88');
                $(target).closest('.custom-select').find('.select-title-filled').css('color','#00000');
                $(target).closest('.custom-select').find('.select-title-underline').css('color','limegreen');
                $(target).closest('.custom-select').find('.select-title-underline').css('border-bottom','2px dashed limegreen');
            }else{
                $(target).closest('.custom-select').find('.custom-select-header .box-wide').html($(target).closest('.custom-select').attr('title'));
                $(target).closest('.custom-select').find('.select-title-filled').css('background','#ffffff');
                $(target).closest('.custom-select').find('.select-title-filled').css('color','white');
                $(target).closest('.custom-select').find('.select-title-underline').css('color','white');
                $(target).closest('.custom-select').find('.select-title-underline').css('border-bottom','2px dashed white');
            }
        }



        //Выкидываем все данные из вторичных фильтров при изменении типа сделки и типа объекта
        if(input_name === 'deal_type' || input_name === 'object_type'){

            let first_step_fields = [
                'search',
                'deal_type',
                'object_type',
                'purposes',
                'page_num',
                'safe_type',
                'directions',
                'region',
                'districts_moscow',
                'status'
            ];

            let filter_arr_new = {};

            //alert(first_step_fields.length);

            for(let i=0; i < first_step_fields.length; i++){
                if(filter_arr[first_step_fields[i]] != 0 && filter_arr[first_step_fields[i]] != undefined){
                    filter_arr_new[first_step_fields[i]] = filter_arr[first_step_fields[i]];
                    //alert(filter_arr_new[first_step_fields[i]]);
                }
            }

            filter_arr = filter_arr_new;
        }

        //очищаем занчения направлений и тд
        if(input_name === 'region'){
            delete filter_arr['directions'];
            delete filter_arr['districts_moscow'];
        }


        //alert(JSON.stringify(filter_arr));
        return JSON.stringify(filter_arr);
    }

</script>