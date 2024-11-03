//делаем все первые вкладки активными
function tabsInitialize(elem){
    let tabs = document.querySelector(elem).getElementsByClassName('tabs-block');
    for(let i = 0; i < tabs.length; i++){
        //classAdd(tabs[i].querySelector('.tab'),'tab-active');
        //classAdd(tabs[i].querySelector('.tab-content'),'tab-content-active');
        if(!tabs[i].classList.contains('tabs-active-free')){
            if(!tabs[i].querySelector('.tab').classList.contains('offer-tab')){
                tabs[i].querySelector('.tab').classList.add('tab-active');
                tabs[i].querySelector('.tab-content').classList.add('tab-content-active');
            }
        }
    }
}

tabsInitialize('body');




/*
 КОД ДЛЯ ПЕРЕКЛЮЧЕНИЯ ВКЛАДОК
 */
function tabSelect(){
    let elem = event.target.closest('.tab');
    if (elem) {
        let tabs = elem.closest('.tabs').querySelectorAll('.tab');
        let tabs_num = tabs.length;
        //console.log(tabs_num);
        for(let t = 0 ; t < tabs_num; t++){
            if(tabs[t] === elem){
                cr = t;
            }
        }
        let tabs_content = elem.closest('.tabs-block').querySelector('.tabs-content').children;



        if(tabs[cr].classList.contains('tab-active')){
            for(let c = 0 ; c < tabs_num; c++){
                tabs[c].classList.remove('tab-active');
                tabs_content[c].classList.remove('tab-content-active');
            }
        }else{
            for(let c = 0 ; c < tabs_num; c++){
                tabs[c].classList.remove('tab-active');
                tabs_content[c].classList.remove('tab-content-active');
            }

            tabs_content[cr].classList.add('tab-content-active');
            tabs[cr].classList.add('tab-active');
        }


    }
}

function in_array(needle, haystack, strict) {

    var found = false, key, strict = !!strict;

    for (key in haystack) {
        if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
            found = true;
            break;
        }
    }

    return found;
}



function getFormUrl() {
    return event.target.closest('form').action;
}

function disableForm() {
    event.preventDefault();
}

function getFormElements() {

    let params = [];
    let form = event.target.closest('form');
    for(let i = 0; i < form.elements.length; i++){
        if(form.elements[i].name){
            if((form.elements[i].type === 'checkbox' || form.elements[i].type === 'radio') && !form.elements[i].checked) continue;
            params.push(form.elements[i].name + '=' + form.elements[i].value);
        }
    }
    params.push('ajax=1');
    return params;
}

function getFormFields(form = null) {

    let params = [];
    if(!form){
        let form = event.target.closest('form');
    }
    for(let i = 0; i < form.elements.length; i++){
        if(form.elements[i].name){
            if((form.elements[i].type === 'checkbox' || form.elements[i].type === 'radio') && !form.elements[i].checked) continue;
            params.push(form.elements[i].name);
        }
    }
    return params;
}

function saveFormAsync() {
    sendAjaxRequestPost(getFormUrl(),getFormElements(), false);
}

function sendFormAsync() {
    disableForm();
    saveFormAsync();
}


function sendAjaxRequest(type,url,params,async){
    let xhr = new XMLHttpRequest();
    xhr.open(type, url, async);

    if(type == 'POST'){
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    }

    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200){
            //alert(xhr.responseText + 'ответ от файла');
            return xhr.responseText;
        }
    };

    if(type == 'POST') {
        xhr.send(params.join('&'));
    }else{
        url += '?' + params.join('&');
        xhr.send(null);
    }


    return xhr.responseText;
    //!!!!!!!!если async TRUE то не возвращает значение (не успевает)

    //return xhr.responseText;


}


function sendAjaxRequestPost(url,params,async){
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, async);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200){
            //alert(xhr.responseText + 'ответ от файла');
        }
    };
    xhr.send(params.join('&'));

    //console.log(xhr.responseText);

    //!!!!!!!!если async TRUE то не возвращает значение (не успевает)
    return xhr.responseText;

}


function sendAjaxRequestGet(url,params,async){
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, async);
    //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4 && xhr.status === 200){
            //alert(xhr.responseText + 'ответ от файла');
        }
    };

    url += '?' + params.join('&');
    xhr.send(null);
    //xhr.send(params.join('&'));

    //!!!!!!!!если async TRUE то не возвращает значение (не успевает)
    return xhr.responseText;

}



function add_script(src){
    let fileRef=document.createElement("script");
    fileRef.type="text/javascript";
    fileRef.src=src;
    document.getElementsByTagName("head")[0].appendChild(fileRef);
}


function getPostHtml(url, post_id, table_id){
    let params = [];
    params.push('post_id='+post_id);
    params.push('table='+table_id);
    return (sendAjaxRequest('POST',url,params,false));
}  








