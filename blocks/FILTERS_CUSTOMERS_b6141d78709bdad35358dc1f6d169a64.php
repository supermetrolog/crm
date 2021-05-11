
<div class="search-block" >

    <form id="catalog-form" class="filters-block" method="POST" >
        <div id="filters-first-step">
            <div class="filter-primary-block background-fix"  style=" background-image: url(http://pennylane.linkholder.ru/uploads/objects/90/1.jpg) ">
                <div>
                    <div class="search-line-block"  >
                        <div class="search-line flex-box">
                            <input  style="" value="" class="full-width box filter-input" type="text"  name="search" placeholder="ID, аресс, собственник, телефон, Ф.И.О, брокер, название СК" />
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="box-small" style="background: #f3f3f3;">
            <div id="filters-second-step" style="background: #ffffff">

            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    let filter_arr = {}; // Создаём ассоциативный массив

    document.getElementById('filters-first-step').oninput = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            setTimeout(reloadFilters(request), 500);
            setTimeout(reloadCatalog(request), 500);

        }
    }

    document.getElementById('filters-second-step').oninput = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            setTimeout(reloadCatalog(request), 500);
        }
    }

    document.getElementById('body').onclick = function() {
        if (event.target.tagName === 'INPUT') {
            let request = builtRequest();
            setTimeout(reloadCatalog(request), 500);
        }
    }


    //ПОМЕНЯТЬНА НАТИВ
    $('body').on('click','.filters-more',function () {
        $('.filters-panel').animate({'max-height' : '1000px'},1000);
    });

    $('body').on('click','.map-more',function () {
        $('#map_google').animate({'height' : '700px'},1000);
    });


    function reloadCatalog(request) {
        document.getElementById("preloader").style.display = 'block';

        let xhttp=new XMLHttpRequest();
        xhttp.open('GET',"<?=PROJECT_URL?>/blocks/catalog_customers_513e0cce21b334b29a11da49d736dbe4.php?request="+request,true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status !== 200) {
                // обработать ошибку
                alert( 'ошибка: ' + (this.status ? this.statusText : 'запрос не удался') );
                return;
            }

            if (xhttp.readyState === 4 && xhttp.status === 200){
                document.getElementById("main-area").innerHTML = xhttp.responseText;
                document.getElementById("preloader").style.display = 'none';
            }else{
                alert('возникли неполадки');
            }

            // получить результат из this.responseText или this.responseXML
        }
    }

    function reloadFilters(request){

        if(filter_arr['deal_type'] > 0 && filter_arr['object_type'] > 0 ) {
            let xhttp=new XMLHttpRequest();
            xhttp.open('GET',"<?=PROJECT_URL?>/system/templates/filters/panel/index.php?request="+request,true);
            xhttp.send();

            xhttp.onreadystatechange = function() {
                if (this.readyState !== 4) return;

                if (this.status !== 200) {
                    // обработать ошибку
                    alert( 'ошибка: ' + (this.status ? this.statusText : 'запрос не удался') );
                    return;
                }

                if (xhttp.readyState === 4 && xhttp.status === 200){
                    document.getElementById("filters-second-step").innerHTML = xhttp.responseText;
                    //document.getElementById("preloader").style.display = 'none';
                }else{
                    alert('возникли неполадки');
                }
            }
        }else{
            document.getElementById("filters-second-step").innerHTML = '';
        }
    }

    function builtRequest(){


        let target = event.target;
        let input_name = target.name.replace('[]','');
        let input_value = target.value;

        if(target.type === 'checkbox'){
            let field_arr  = filter_arr[input_name];
            let flag = 0;
            let key;
            if(field_arr === undefined) {
                field_arr = [];
                field_arr.push(input_value);
            }else{
                for (let i = 0; i < field_arr.length ;i++){
                    if (field_arr[i] === input_value) {
                        flag = 1;
                        key = i;
                        break;
                    }
                }
                if(flag === 1){
                    field_arr.splice(key, 1);
                }else{
                    field_arr.push(input_value);
                }
            }
            filter_arr[input_name] = field_arr;
        }else{
            filter_arr[input_name] = input_value;
        }


        //alert(JSON.stringify(filter_arr));
        return JSON.stringify(filter_arr);
    }

</script>