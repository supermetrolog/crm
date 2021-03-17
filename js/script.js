jQuery(function($){
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['ru']);
});


function classAdd(el,class_name) {
    el.classList.add(class_name);
}

function classRemove(el,class_name) {
    el.classList.remove(class_name);
}

function setTextEditor() {
    $('#modal-kit').find('.textarea-to-modify').addClass('editortextarea');
    tinymce.init({
        selector: '.editortextarea',
        theme: 'modern',
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],
        content_css: 'css/content.css',
        document_base_url : '../index.php',
        convert_urls : false,
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
    });
}

   



function reloadPageContent(pageUrl){
    let url = 'https://pennylane.pro/templates/pages/index/index.php';
    let params = [];
    params.push('page_url='+pageUrl);
    let res = sendAjaxRequestPost(url,params,false);
    alert(res);
    document.querySelector('.container_slim').innerHTML = res;
}


function getFileExtension(file){
    let parts = file.split('.');
    return '.'+parts.pop();
}

function getFilePureName(file){
    let divided_by_slashes_arr = file.split('/');           //divide name by slashes to find a path (arr)
    let without_folder = divided_by_slashes_arr.pop();      //throw away path                       (str)
    let divided_by_dots_arr = without_folder.split('.');    //divide name by dots to find extension (arr)
    divided_by_dots_arr.pop();                              //delete an extension                   (arr)
    return divided_by_dots_arr.join('.');                   //get a name without extension          (str)
}

function getFileNameShort(file){
    let file_name = getFilePureName(file);
    if(file_name.length > 15){
        return getFilePureName(file).substring(0, 15)+'...'
    }
    return getFilePureName(file);
}


function getFileIcon(file){
    let ext = getFileExtension(file);
    if(ext==='.mp3' || ext==='.ogg'){
        icon = '<i class="fas fa-file-video"></i>';
    }else if(ext === '.doc' || ext==='.docx'){
        icon = '<i class="far fa-file-word"></i>';
    }else if(ext === '.xls' || ext==='.xlsx'){
        icon = '<i class="far fa-file-excel"></i>';
    }else if(ext==='.htm' || ext==='.html' || ext==='.php' || ext==='.css' || ext==='.xml'){
        icon = '<i class="far fa-file-code"></i>';
    }else if(ext === '.exe'){
        icon = '<i class="fas fa-file-code"></i>';
    }else if(ext ==='.mp4' || ext === '.ogg' || ext === '.webm'){
        icon = '<i class="far fa-file-video"></i>';
    }else if(ext === '.rar' || ext === '.tar' || ext === '.zip'){
        icon = '<i class="far  fa-file-archive"></i>';
    }else if(ext === '.txt'){
        icon = '<i class="far fa-file-alt"></i>';
    }else if(ext === '.ppt' || ext === '.pptx' || ext === '.pptm'){
        icon = '<i class="fas fa-file-powerpoint"></i>';
    }else if(ext==='.pdf'){
        icon = '<i class="fas fa-file-pdf"></i>';
    }else if(ext === '.psd' || ext === '.jpg' || ext==='.png' || ext === '.gif'){
        icon = '<i class="far fa-file-image"></i>';
    }else{
        icon = '<i class="far fa-file"></i>';
    }
    return icon;
}





/*
 КОД ДЛЯ ПАНЕЛИ РЕКЛАМЫ
 */
function showAdPanel(){
    let elem = event.target.closest('.ad-panel-call');
    if (elem) {
        $('.ad-panel').slideToggle();
        /*
        let ad_panel = document.querySelector('.ad_panel');
        if(ad_panel.style.display !== 'block'){
            ad_panel.style.display = 'block';
        }else{
            ad_panel.style.display = 'none';
        }
        */
    }
}

function labelInput() {
    let elem = event.target.closest('.label-custom');
    if (elem) {
        //elem.querySelector('input').click();
        //elem.querySelector('input').input();
    }
}



//Установить выбрать пункт из списка
function setDatalistVariant(){
    let elem = event.target.closest('.datalist-item');
    if (elem) {
        let title = elem.getAttribute('data-title');
        let id = elem.getAttribute('data-id');
        let table = elem.closest('.datalist-field').querySelector('input').getAttribute('data-table');

        elem.closest('.datalist-field').querySelector('input').value = title;
        elem.closest('.datalist-field').querySelectorAll('input')[1].setAttribute('value',id);

        //если компании то нужно менять контакты
        if(table === 'c_industry_companies' && elem.closest('.datalist-field').querySelector('input').getAttribute('data-company') == 1){
            let params = [];
            let table = 'c_industry_contacts';
            params.push('search='+id);
            params.push('company_id='+id);
            params.push('table='+table);
            let result = sendAjaxRequestPost('https://pennylane.pro/templates/fields/datalist-items/index.php',params, false);

            //alert(result);
            let elems = JSON.parse(result);
            let elemsCount = elems.length;

            let html = '';
            for(let i = 0 ; i < elemsCount; i++){
                html += '<option  value="'+elems[i][0]+'">'+elems[i][1]+'</option>'
            }
            elem.closest('.datalist-company-block').querySelector('.datalist-subfield-contacts').querySelector('select').value = '';
            elem.closest('.datalist-company-block').querySelector('.datalist-subfield-contacts').querySelector('select').innerHTML = html;


        }

        if(table === 'l_locations'){

            let location_id = elem.getAttribute('data-id');
            //alert(location_id);
            let params = [];
            params.push('location_id='+location_id);
            //alert(sendAjaxRequestPost('https://pennylane.pro/templates/fields/templates/location/panel.php',params,false));
            document.getElementById('location_info').innerHTML = sendAjaxRequestPost('https://pennylane.pro/templates/fields/templates/location/panel.php',params,false);
        }


        //elem.closest('.field-list-variants').style.display = 'none';
        $('.field-list-variants').hide();



        /*

        */

        //alert(title);
    }

}

//Подгрузить список вариантов в поле даталист
function getDatalistVariants(){

    let elem = event.target.closest('.datalist-input');
    if (elem) {


        let result;
        let text = elem.value;
        let elemsCount;
        let elems;

        elem.closest('.datalist-field').querySelectorAll('input')[1].setAttribute('value','');

        if(elem.getAttribute('data-async') == 1){

            let table = elem.getAttribute('data-table');
            let params = [];
            params.push('search='+text);
            params.push('table='+table);

            result = sendAjaxRequestPost('https://pennylane.pro/templates/fields/datalist-items/index.php',params, false);

            //console.log(text);
            console.log(result);

            elems = JSON.parse(result);

            elemsCount = elems.length;
        }else{
            result = elem.closest('.datalist-field').querySelector('span').innerHTML;

            //console.log(result);

            elems = JSON.parse(result);
            elemsCount = elems.length;

            let good_results = [];
            for(let j = 0; j < elemsCount; j++){
                if( elems[j][1].indexOf(text.toLowerCase()) !== -1){
                    good_results.push(elems[j]);

                }
            }
            elems = good_results;
            elemsCount = elems.length;
        }



        let html = '';
        for(let i = 0 ; i < elemsCount; i++){
            let titleSecond = '';
            let titleThird = '';
            let titleFourth = '';
            if(elems[i][2]){
                titleSecond = '<div class="ghost box-wide">'+elems[i][2]+'</div>';
            }
            if(elems[i][3]){
                titleThird = '<div class="ghost">'+elems[i][3]+'</div>';
            }
            if(elems[i][4]){
                titleFourth = '<div class="ghost box-wide "> '+elems[i][4]+ ' </div>';
            }
            html += '<div class="datalist-item flex-box"  data-id="'+elems[i][0]+'" data-title="'+elems[i][1]+'">'+elems[i][1]+titleSecond+titleThird+titleFourth+'</div>'
        }
        elem.closest('.datalist-field').querySelector('.field-list-variants').innerHTML = html;
        elem.closest('.datalist-field').querySelector('.field-list-variants').style.display = 'block';

    }
}




document.onkeyup = function() {
    getDatalistVariants();
};

document.onclick = function() {
    tabSelect();
    showAdPanel();
    labelInput();

    setDatalistVariant();
};





	
	
