/*-------------------------------------СКРИПТЫ СОРТИРОВКИ ЭЛЕМЕНТОВ-----------------------------------------*/
/**
 * ПРИСОЕДИНЕНИЕ КОЛОНКИ К АКТИВНОМУ ХОЛСТУ (ДЛЯ МОМЕНТАЛЬНОГО D'n'D)
 */
function letsSort() {

    let sorts = ['.grid-book-sortable-zone','.grid-page-sortable-zone','.grid-column-sortable-zone'];
    //делаем сортбельными
    makeThemSortable(sorts);
}

function makeThemSortable(selectors) {
    //делаем сортбельными
    for(let i =0; i < selectors.length; i ++){
        $(selectors[i]).sortable('enable');
        $(selectors[i]).sortable({
            connectWith: selectors[i],
            cursor: "move",
            beforeStop: function() {

            }
        });
    }
}

function makeThemNotSortable(selectors) {
    //делаем сортбельными
    for(let i =0; i < selectors.length; i ++){
        $(selectors[i]).sortable('disable');
    }
}



/**
 * СОЗДАНИЕ КНИГИ
 */
function gridBookCreate(){
    let elem = event.target.closest('.grid-book-add');
    if (elem) {
        alert('добавляем книгу');
        let new_book_name = document.createElement('div');
        new_book_name.innerHTML = '<input class=""  value="Название"  type="text" />';
        new_book_name.setAttribute('class', 'tab');
        document.getElementById('grid-canvas').querySelector('.tabs').appendChild(new_book_name);

        let new_book_cont = document.createElement('div');
        new_book_cont.innerHTML = '<div class="grid-book-sortable-zone"></div>';
        new_book_cont.setAttribute('class', 'tab-content grid-book');
        document.getElementById('grid-canvas').querySelector('.tabs-content').appendChild(new_book_cont);

        letsSort();
    }

}



/**
 * СОЗДАНИЕ СТРАНИЦЫ
 */
function gridPageCreate(){
    let elem = event.target.closest('.grid-page-add');
    if (elem) {
        //alert('добавляем страницу');
        let new_page = document.createElement('div');
        new_page.innerHTML = '<input class="grid-page-name" value="Название"  type="text" /> <div class="grid-element-delete"><i class="fa fa-times" aria-hidden="true"></i></div><div class="grid-page-sortable-zone"></div>';
        new_page.setAttribute('class', 'grid-page grid-element-editable');

        let tabsContents = document.getElementById('grid-canvas').querySelector('.tabs-content').querySelector('.tab-content-active').querySelector('.grid-book-sortable-zone').prepend(new_page);

        letsSort();
    }

}



/**
 * СОЗДАНИЕ КОЛОНКИ
 */
function gridColumnCreate(){
    let elem = event.target.closest('.grid-column-add');
    if (elem) {
        let new_col = document.createElement('div');
        new_col.innerHTML = '<input class="grid-column-change" value="100"  type="number" /> <div class="grid-element-delete"><i class="fa fa-times" aria-hidden="true"></i></div><div class="grid-column-sortable-zone"></div> ';
        new_col.setAttribute('class', 'grid-column grid-element-editable');

        let tabsContents = document.getElementById('grid-canvas').querySelector('.tabs-content').querySelector('.tab-content-active').querySelector('.grid-page-sortable-zone').prepend(new_col);

        letsSort();
    }
}


/**
 * ИЗМЕНЕНИЕ ШИРИНЫ  КОЛОНКИ
 */
function gridColumnChange(){
    let elem = event.target.closest('.grid-column-change');
    if (elem) {
        if(elem.value > 100){elem.value = 100;}
        elem.closest('.grid-column').style.width = event.target.value+'%';
    }
}

/**
 * УДАЛЕНИЕ ПОЛЕЙ/БЛОКОВ
 */
function gridElementDelete(){
    let elem = event.target.closest('.grid-element-delete');
    if (elem) {
        elem.closest('.grid-element-editable').remove();
    }
}


document.querySelector("body").oninput = gridColumnChange;



/**
 * СОХРАНЕНИЕ КНИГ СТРАНИЦ КОЛОНОК И ПОЛЕЙ
 */
function gridElementsSave(table, post_id, field, elements_type){

    let elem = event.target.closest('.grid-elements-save');

    if (elem) {

        //блок где сохранять сетку
        let grid_container = elem.getAttribute('data-grid-container');
        //таблица куда сохранять
        let grid_table = elem.getAttribute('data-grid-table');
        //строка куда сохранять
        let grid_id = elem.getAttribute('data-grid-id');
        //поле куда сохранять
        let grid_field = elem.getAttribute('data-grid-field');
        //тип элементов сетки
        let grid_type = elem.getAttribute('data-grid-type');

        //alert(grid_container);

        let col_str = '';
        let books_arr_content = [];        //массив  с контентом книг
        let books_arr_names = [];        //массив с именами книг

        let book_sum_arr = new Map();

        //Собираем имена форм
        let books_names = document.getElementById(grid_container).querySelector('.tabs').getElementsByClassName("tab");
        for (let n = 0; n < books_names.length; n++) {
            books_arr_names.push(books_names[n].querySelector('input').value);
        }
        //alert(books_arr_names);


        //Собираем контент книг
        let books_content = document.getElementById(grid_container).querySelector('.tabs-content').getElementsByClassName("tab-content");
        //Для каждой КНИГИ собираем контент
        for (let c = 0; c < books_content.length; c++) {
            let book_pages_arr = [];

            let pages = books_content[c].getElementsByClassName("grid-page");
            //для всех СТРАНИЦ в книге
            for (let p = 0; p < pages.length; p++) {
                let cols_arr_full = [];       //массив колонок


                let page_name = pages[p].querySelector('.grid-page-name').value;
                if(!page_name){page_name = 'Вкладка';}



                //Для всех КОЛОНОК внутри СТРАНИЦЫ
                let cols = pages[p].getElementsByClassName("grid-column");
                for (let i = 0; i < cols.length; i++) {
                    //пустой массив элементов внутри колонки
                    let els_arr = [];

                    //получаем ширину колонки
                    let column_attribute;
                    if(grid_type === 'core_tasks'){
                        column_attribute = cols[i].querySelector('.task-column-title').querySelector('input').value;
                        if(!column_attribute){column_attribute = '';}
                    }else{
                        column_attribute = cols[i].style.width;
                        if(!column_attribute){column_attribute = '100%';}
                    }


                    //alert(column_attribute);

                    //Для всех БЛОКОВ внутри КОЛОНКИ
                    //let elements = cols[i].getElementsByClassName("task-column-element");
                    let elements = cols[i].getElementsByClassName("grid-element-unit");
                    //добавляем id элемента в массив в цикле
                    for (let j = 0; j < elements.length; j++) {
                        els_arr.push(elements[j].getAttribute('data-element-id'));
                    }
                    let col_arr = [ column_attribute , els_arr] ;
                    cols_arr_full.push(col_arr);
                }
                let page_arr = [ page_name , cols_arr_full] ;
                book_pages_arr.push(page_arr);
            }

            books_arr_content.push(book_pages_arr);
        }

        //alert(books_arr_content);


        for(let res = 0; res < books_arr_names.length; res++ ){
            book_sum_arr[books_arr_names[res]] = books_arr_content[res];
        }


        let books_str = JSON.stringify(book_sum_arr);
        //alert(books_str);



        let url = window.location.protocol+'//'+document.domain+'/system/controllers/blocks/save.php';
        let params = [];
        params.push('post_id='+grid_id);
        params.push('table='+grid_table);
        params.push('field='+grid_field);
        params.push('elements_type='+grid_type);
        params.push('elements='+books_str);

        //alert(sendAjaxRequestPost(url,params,false));

        sendAjaxRequestPost(url,params,false);

    }
}



