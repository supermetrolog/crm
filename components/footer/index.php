
<!--Place for footer embedded_code-->
<?  $top_embedded_code = new EmbeddedCode(0);
foreach($top_embedded_code->getBottomBlocks() as $top_code_block){
    $top_code_block = new EmbeddedCode($top_code_block['id']);
    echo $top_code_block->description();
} ?>

<div id="modal_form" class="flex-box"><!-- Сaмo oкнo -->
    <div id="modal_close">
        <span>&#215;</span> <!-- Кнoпкa зaкрыть -->
    </div>
    <div class="flex-box " style="height: 95%;">
        <form id='car_action_form' action='<?=PROJECT_URL?>/system/controllers/posts/delete.php' method='POST'>
            <p>Вы действительно хотите удалить элемент?</p>
            <input  id='post_id'  name='id' type='hidden' />
            <input  id='post_table'  name='table' type='hidden' />
            <button class="button btn-green btn-medium " id='car_action_accept'>Да</button><br><br>
            <!--<button disabled id='car_action_cancel' class="button btn-medium flex-box-inline flex-around">Нет</button>-->
        </form>
    </div>
</div>


<? include_once($_SERVER["DOCUMENT_ROOT"].'/templates/modals/modal/index.php')?>


<div id="overlay">
</div><!-- Пoдлoжкa -->

<div class="page-to-top" title="вверх">
    <a href="#catalogtop">
        <i class="fas fa-chevron-double-up"></i>
    </a>
</div>

<script type="text/javascript">
    $(document).ready(function() {


        $('body').on('click', '.photos-more-show, .photos-more-hide ', function(){ // лoвим клик пo кнопке
            $(this).closest('.card-photo-area').find('.photos-more').slideToggle(300);
            $(this).closest('.card-photo-area').find('.photos-more-count').slideToggle(1);
            $(this).closest('.card-photo-area').find('.photos-more-hide').slideToggle(1);
        });

        $('body').on('click', '.delete_post', function(event){ // лoвим клик пo кнопке
            $('#post_id').val($(this).attr("data-id"));
            $('#post_table').val($(this).attr("data-table"));
        });

        $('body').on('click', '.modal-close', function(){ // лoвим клик пo кнопке
            this.closest('#modal-kit').style.display = 'none';
            $('#modal-kit > div').removeAttr('class');
            $('body').css('overflow','auto'); // снaчaлa плaвнo пoкaзывaем темную пoдлoжку


        });

        let address_request = 1;

        $('body').on('input','.address-validation  input',function(){
            $(this).closest('.address-validation').find('.to-end').html('<i class="fas fa-times attention"></i>');
        });


        $('body').on('click','ymaps',function(){
            //console.log(address_request);
            //alert('2322');
            //alert($('#field-address').val());
            if(address_request === 1){

                $(this).closest('.address-validation').find('.to-end').html('<i class="fas fa-check good"></i>');
                //let address = $('#field-address').val();
                let address = document.getElementById('field-address').value;
                //console.log(address);
                let params = [];
                params.push('address='+address);
                //alert(sendAjaxRequestPost('https://pennylane.pro/helpers/stations.php',params,false));
                document.getElementById('address-transport').innerHTML = sendAjaxRequestPost('https://pennylane.pro/helpers/stations.php',params,false);
            }
            address_request++;
            if(address_request === 7){
                address_request = 1;
            }
        });

        $('body').on('change','input[type="checkbox"]',function(e){
            let name = $(this).attr('name');
            $(this).prop('checked');
            let punkts = document.querySelectorAll('input[name="'+name+'"]');
            let flag = 0;

            for(let i=0; i < punkts.length; i++){
                if($(punkts[i]).is(':checked')){
                    flag = 1;
                }
            }
            console.log(flag);
            //console.log('sd');
            if(flag == 1){
                $('input[name="'+name+'"]').removeAttr('required');
            }else{
                $('input[name="'+name+'"]').attr('required','required');
            }
        });


        $('body').on('change','.mixer-building input[type="checkbox"]',function(e){
            console.log('yhhtgh');
            $(this).removeAttr('required');
        });

        /*
        function (){
            let requiredCheckboxes = $(':checkbox[required]');
            requiredCheckboxes.on('change', function(e) {
                let checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
                let isChecked = checkboxGroup.is(':checked');
                checkboxGroup.prop('required', !isChecked);
            });
            requiredCheckboxes.trigger('change');
        });
        */

        //ПОКАЗЫВАЕМ ФОРМУ СОЗДАНИЯ И РЕДАКТИРОВАНИЯ
        $('body').on('click', '.modal-call-btn', function(){ // лoвим клик пo кнопке
            let size = this.getAttribute('data-modal-size');
            let modal = this.getAttribute('data-modal');
            let params = [];



            $('#modal-kit').css('display','flex');
            $('#modal-kit > div').addClass(size);
            $('body').css('overflow','hidden');

            //ПЕРЕДАЕМ ЗНАЧЕИНИЯ В СКРИПТ
            if(this.getAttribute('data-names')){
                //ПРИСВАИВАЕМ СКРЫТЫМ ПОЛЯМ ЗНАЧЕНИЯ ИЗ АТТРИБУТОВ
                let names = JSON.parse(this.getAttribute('data-names'));
                let values = JSON.parse(this.getAttribute('data-values'));

                for(let i = 0; i < names.length; i++){
                    //alert(names[i]);
                    //alert(values[i]);
                    params.push(names[i]+ '=' + values[i]);
                }
            }


            params.push('post=' + this.getAttribute('data-id'));
            params.push('table=' + this.getAttribute('data-table'));
            params.push('form=' + this.getAttribute('data-form'));

            let url = "<?=PROJECT_URL?>/templates/forms/"+modal+"/index.php";
            document.getElementById("modal-kit").querySelector('.modal-body').innerHTML = sendAjaxRequestPost(url,params,false);



            tabsInitialize('.modal-body');



            //ДЛЯ ПОДКЛЮЧЕНИЯ ЯНДЕКС АДРЕСА
            add_script("//api-maps.yandex.ru/2.1/?suggest_apikey=e08e55be-8f23-40a5-ae7f-d1a6758ebfca&apikey=7cb3c3f6-2764-4ca3-ba87-121bd8921a4e&lang=ru_RU&load=SuggestView&onload=addAddress");

            //ДЛЯ ПОДКЛЮЧЕНИЯ СЛАЙДЕРА
            add_script("https://pennylane.pro/js/slider.js");

            //ДЛЯ ПОДГРУЗКИ РЕДАКТОРА
            setTextEditor();

            //document.getElementById('form-fields').value = getFormFields(document.getElementById('edit-all-form')).join(',');



            //Показываем обычно скрытые поля
            //
            if(this.getAttribute('data-show-name')){
                //ПРИСВАИВАЕМ СКРЫТЫМ ПОЛЯМ ЗНАЧЕНИЯ ИЗ АТТРИБУТОВ
                let hidden_names = this.getAttribute('data-show-name').split(',');
                for(let i = 0; i < hidden_names.length; i++){
                    //alert(hidden_names[i]);
                    //alert(hidden_values[i]);
                    let el = document.querySelector('[name="'+hidden_names[i]+'"]');
                    if(el){
                        el.closest('.grid-element-unit').style.display = 'block';
                    }
                }
            }


            //ДЕЛАЕТСЯ через библиотеку maskedInput
            $("input[type='tel']").mask("+7 999 999-99-99");

            //$("#datepicker-from").datepicker();
            $("#datepicker-from").datepicker({
                monthNames:["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                dayNamesMin:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
                minDate: new Date(),
                firstDay:1,
                dateFormat:"dd.mm.yy"
            });

            //Для откроытия полей регионов и округов
            if(this.getAttribute('data-modal') === 'edit-all'){
                if (document.getElementById('regions-6') && document.getElementById('regions-6').getAttribute('checked') === 'checked') {
                    $('#field-224').slideDown();
                }
                if (document.getElementById('regions-1') && document.getElementById('regions-1').getAttribute('checked') === 'checked') {
                    $('#field-195').slideDown();
                }



                //обана
                if(this.getAttribute('data-table') == 15){
                    if (document.getElementsByName('contact_warning')[1] ) {
                        if(document.getElementsByName('contact_warning')[1].checked ){
                            $('#field-489').slideDown();
                        }else{
                            $('#field-489').slideUp();
                        }
                    }
                }



                //предложения
                if(this.getAttribute('data-table') == 16){
                    if(document.getElementsByName('built_to_suit')[0]){
                        if($(document.getElementsByName('built_to_suit')[0]).prop('checked') == true){
                            $('#field-370,#field-371').slideDown();
                        }else{
                            $('#field-370,#field-371').slideUp();
                        }
                    }

                    if(document.getElementsByName('rent_business')[0]){
                        if($(document.getElementsByName('rent_business')[0]).prop('checked') == true ){
                            $('#field-373,#field-374,#field-375,#field-376,#field-377,#field-378,#field-379').slideDown();
                        }else{
                            $('#field-373,#field-374,#field-375,#field-376,#field-377,#field-378,#field-379').slideUp();
                        }
                    }




                    //если есть налоги
                    if(document.getElementsByName('tax_form')[1]){

                        //Если ничего не выбрано то все поля и частично отключениы и скрыты
                        $('#field-574').slideUp();

                        $('#field-180').slideUp();

                        $('#field-573').slideUp();

                        $('#field-182').slideUp();

                        $('#field-180,#field-573,#field-182,#field-574').find('input').prop('disabled','disabled');


                        //если выбрано уже что то КРОМЕ TRIPLE NET
                        if(document.getElementsByName('tax_form')[1].checked || document.getElementsByName('tax_form')[2].checked || document.getElementsByName('tax_form')[3].checked){

                            //то тип включения OPEX  и КОММУНАЛЬНЫХ разрешен ЛЮБОЙ
                            $('#field-181,#field-575').find('input[value="1"]').removeAttr('disabled');
                            $('#field-181,#field-575').find('input[value="2"]').removeAttr('disabled');
                            $('#field-181,#field-575').find('input[value="4"]').removeAttr('disabled');

                        //если ВЫБРАН TRIPLE NET то
                        }else if(document.getElementsByName('tax_form')[0].checked) {

                            //поля ввода делаем обязательными и показываем
                            $('#field-573').slideDown();
                            $('#field-182').slideDown();
                            $('#field-182,#field-573').find('input').attr('required','required');

                            //частичные поля скрываем и делаем необязательными
                            $('#field-574').slideUp();
                            $('#field-180').slideUp();
                            $('#field-180,#field-574').find('input').prop('disabled','disabled');

                            // тип включения OPEX  и КОММУНАЛЬНЫХ  запрещаем все КРОМЕ НЕ ВКЛЮЧЕНО
                            $('#field-181,#field-575').find('input[value="1"]').prop('disabled','disabled');
                            $('#field-181,#field-575').find('input[value="2"]').prop('disabled','disabled');
                            $('#field-181,#field-575').find('input[value="4"]').prop('disabled','disabled');

                        }else{

                        }
                    }

                    //для OPEX
                    if(document.getElementsByName('price_opex')[1]){

                        //если OPEX  ВКЛЮЧЕНО/НЕ ЗНАЮ
                        if(document.getElementsByName('price_opex')[0].checked || document.getElementsByName('price_opex')[3].checked ){
                            //Скрываем и убиваем все поля OPEX
                            $('#field-574').slideUp();
                            $('#field-573').slideUp();
                            $('#field-573,#field-574').find('input').prop('disabled','disabled');

                        //если частично
                        }else if(document.getElementsByName('price_opex')[1].checked){
                            //показываем ЧАСТИЧНО
                            $('#field-574').slideDown();
                            $('#field-574').find('input').removeAttr('disabled');
                            //$('#field-574').find('input').attr('required','required');

                            //Скрываем поле
                            $('#field-573').slideUp();
                            $('#field-573').find('input').prop('disabled','disabled');

                        //если НЕ ВКЛЮЧЕНО
                        }else if(document.getElementsByName('price_opex')[2].checked){
                            //показываем  ПОЛЕ
                            $('#field-573').slideDown();
                            $('#field-573').find('input').removeAttr('disabled');
                            $('#field-573').find('input').attr('required','required');

                            //Скрываем ЧАСТИЧНО
                            $('#field-574').slideUp();
                            $('#field-574').find('input').prop('disabled','disabled');
                        }else{

                        }
                    }

                    //для коммунальных услуг
                    if(document.getElementsByName('public_services')[1]){

                        //если  ВКЛЮЧЕНО/НЕ ЗНАЮ
                        if(document.getElementsByName('public_services')[0].checked || document.getElementsByName('public_services')[3].checked ){
                            //Скрываем и убиваем все поля
                            $('#field-182').slideUp();
                            $('#field-180').slideUp();
                            $('#field-182,#field-180').find('input').prop('disabled','disabled');

                        //если частично
                        }else if(document.getElementsByName('public_services')[1].checked){
                            //показываем ЧАСТИЧНО
                            $('#field-180').slideDown();
                            $('#field-180').find('input').removeAttr('disabled');
                            //$('#field-180').find('input').attr('required','required');

                            //Скрываем поле
                            $('#field-182').slideUp();
                            $('#field-182').find('input').prop('disabled','disabled');

                        //если НЕ ВКЛЮЧЕНО
                        }else if(document.getElementsByName('public_services')[2].checked){
                            //показываем  ПОЛЕ
                            $('#field-182').slideDown();
                            $('#field-182').find('input').removeAttr('disabled');
                            $('#field-182').find('input').attr('required','required');

                            //Скрываем ЧАСТИЧНО
                            $('#field-180').slideUp();
                            $('#field-180').find('input').prop('disabled','disabled');
                        }else{

                        }
                    }


                }

                //лоты
                if(this.getAttribute('data-table') == 5){
                    let locations = document.querySelectorAll('.field-location-id');
                    let count = locations.length;
                    for(let i = 0; i < count; i++){
                        locations[i].setAttribute('disabled','disabled');
                    }
                    locations[0].removeAttribute('disabled');
                }

            }

            //document.body.scrollTop = document.documentElement.scrollTop = 0;

        });
    });




    //ДЛЯ ТИПА ОБЪЕКТА
    $('body').on('change','.object-type-field',function(){
        //alert('fdfd');
        $(this).closest('.object-type-block').find('.purpopes').slideToggle();
        $(this).closest('.object-type-block').find('.purpopes').find('input').prop("checked",false);
    });


//ПОМЕНЯТЬНА НАТИВ
    $('body').on('click','.custom-select-header',function () {
        $('.custom-select-body').slideUp(100);
        $(this).closest('.custom-select').find('.custom-select-body').slideToggle(100);
        $(this).closest('.custom-select').find('.custom-select-body').slideDown(100);
    });

    //закрытие кастом радио селект
    $('body').on('click','.custom-select-body-radio',function () {
        $(this).slideUp(100);
    });

    //закрытие списка кастом селекта
    $(document).mouseup(function (e) {
        let container = $(".custom-select-body");
        //if (container.has(e.target).length === 0 && !container.hasClass('dont-hide')){
        if (container.has(e.target).length === 0 ){
            container.hide();
        }
    });

    $(document).mouseup(function (e) {
        let container = $(".dropdown-menu");
        if (container.has(e.target).length === 0){
            container.hide();
        }
    });




</script>
<script>
    //ДЛЯ ПОДРУЗКИ АПИ ДЛЯ АДРЕСА
    function addAddress (ymaps) {
        let addresses = ['field-address','field-law_address'];
        for(let i =0; i < addresses.length; i ++){
            new ymaps.SuggestView(addresses[i], {results: 10, offset: [0, 0]});
        }
    }
</script>

<script>
    //Добавление мультиполя
    $('body').on('click','.more-fields',function(){
        let par_field_obj = this.closest('.full-width').querySelector('.multifield-container');
        let field_obj = par_field_obj.querySelector('.multifield');
        let clone = field_obj.cloneNode(true);  //клонируем первое поле
        let inputs = clone.querySelectorAll('input');
        for(let i = 0 ; i < inputs.length; i++){
            inputs[i].value = '';
        }
        let selects = clone.querySelectorAll('select');
        for(let j = 0 ; j < selects.length; j++){
            selects[j].value = '';
        }
        //clone.querySelector('input').value = '';
        par_field_obj.appendChild(clone);
        $("input[type='tel']").mask("+7 999 999-99-99");
    });




    //Добавление мультиполя

    $('body').on('click','.field-delete',function(){
        let result = confirm('Вы уверены?');
        if(result){
            this.closest('.multifield').remove();
        }

    });

    //хайлайт выбранного селекта
    $('body').on('change','.full-width > select',function(){
        if($(this).val() !== ''){
            $(this).addClass('field-checked');
        }else{
            $(this).removeClass('field-checked');
        }
    });


    //отрезаем пробелы в именах фамилиях
    $('body').on('keyup','.singleword',function(){
        this.value=this.value.replace(/\s+/gi,'');
    });
    //onkeyup="this.value=this.value.replace(/\s+/gi,'')"


    //Превью одинарного файла
        function handleFileSelect() {

            let obj = event.target;

            let files = obj.files; // FileList object

            // Loop through the FileList and render image files as thumbnails.
            for (let i = 0, f; f = files[i]; i++) {


                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                let reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function(theFile) {
                    return function(e) {
                        // Render thumbnail.
                        window.span = '<div class="form-file"><img class="full-width"  src="'+e.target.result+'" title="'+theFile.name+'"/></div>';
                        //alert(span);

                        $(obj).closest('.files-single').find('.form-file').hide();
                        $(obj).closest('.files-single').prepend(span);

                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }
    $('body').on('change','.file-input',handleFileSelect );

    //document.querySelector('.file-input').addEventListener('change', handleFileSelect, false);


</script>

<script src="<?=PROJECT_URL?>/libs/front/inputmask/jquery.maskedinput.min.js"></script>
<script>
    /*
    $('body').on('input','input',function(){
        let str = this.value;
        if (!str) return str;
        this.value =  str[0].toUpperCase() + str.slice(1);
        //this.value = str;
    });

    function ucFirst(str) {
        // только пустая строка в логическом контексте даст false
        if (!str) return str;
        return str[0].toUpperCase() + str.slice(1);
    }
    */

    //    /document.getElementById('label-region-1');
    //ДЛЯ РЕГИОНОВ И НАПРАВЛЕНИЙ
    document.getElementById('body').onchange = function() {
        if (event.target.getAttribute('id') === 'regions-6') {
            $('#field-224').slideToggle();
        }

        if (event.target.getAttribute('id') === 'regions-1') {
            $('#field-195').slideToggle();
        }



        //built-to-suit
        if (event.target.name === 'built_to_suit' ) {
            if(event.target.value == 1){
                $('#field-370,#field-371').slideDown();
            }else{
                $('#field-370,#field-371').slideUp();
            }
        }

        //клики по OPEX
        if (event.target.name === 'price_opex' ) {

            //если ВКЛЮЧЕНО / НЕ ЗНАЮ
            if(event.target.value == 1 ||  event.target.value == 4){
                //поле OPEX
                $('#field-573').slideUp();
                $('#field-574').slideUp();
                $('#field-573,#field-574').find('input').removeAttr('required');

            //если ЧАСТИЧНО
            }else if(event.target.value == 2 ){
                $('#field-573').slideUp();
                $('#field-573').find('input').removeAttr('required');

                $('#field-574').slideDown();
                $('#field-574').find('input').removeAttr('disabled');
                //$('#field-574').find('input').attr('required','required');

            //если НЕ ВКЛЮЧЕНО
            }else if(event.target.value == 3 ){
                $('#field-574').slideUp();
                $('#field-574').find('input').removeAttr('required');

                $('#field-573').slideDown();
                $('#field-573').find('input').attr('required','required');
                $('#field-573').find('input').removeAttr('disabled');
            }else{

            }
        }

        //клики по УСЛУГАМ
        if (event.target.name === 'public_services' ) {

            //если ВКЛЮЧЕНО / НЕ ЗНАЮ
            if(event.target.value == 1 ||  event.target.value == 4){
                //поле OPEX
                $('#field-182').slideUp();
                $('#field-180').slideUp();
                $('#field-182,#field-180').find('input').removeAttr('required');

            //если ЧАСТИЧНО
            }else if(event.target.value == 2 ){

                $('#field-182').slideUp();
                $('#field-182').find('input').removeAttr('required');

                $('#field-180').slideDown();
                $('#field-180').find('input').removeAttr('disabled');
                //$('#field-180').find('input').attr('required','required');

            }else if(event.target.value == 3 ){
                $('#field-180').slideUp();
                $('#field-180').find('input').removeAttr('required');

                $('#field-182').slideDown();
                $('#field-182').find('input').attr('required','required');
                $('#field-182').find('input').removeAttr('disabled');
            }else{


            }
        }

        //что включено НАЛОГИ
        if (event.target.name === 'tax_form' ) {

            //если ВСЕ КРОМЕ TRIPLE NET
            if(event.target.value == 2 || event.target.value == 3 || event.target.value == 4){

                //разршаем выбирать все а не только НЕ ВКЛЮЧЕНО
                $('#field-181,#field-575').find('input[value="1"]').removeAttr('disabled');
                $('#field-181,#field-575').find('input[value="2"]').removeAttr('disabled');
                $('#field-181,#field-575').find('input[value="4"]').removeAttr('disabled');


            //если TRIPLE NET
            }else{
                //показываем и активируем ПОЛЯ
                $('#field-573,#field-182').slideDown();
                $('#field-573,#field-182').find('input').attr('required','required');
                $('#field-573,#field-182').find('input').removeAttr('disabled'); 

                //поле КУ


                //скрываем и отключаем ЧАСТИЧНО
                $('#field-180,#field-574').slideUp();
                $('#field-180,#field-574').find('input').removeAttr('checked');
                $('#field-180,#field-574').find('input').removeAttr('required');

                //ищем два поля и проставляем НЕ ВКЛЮЧЕНО
                $('#field-181,#field-575').find('input[value="3"]').prop('checked','true');
                $('#field-181,#field-575').find('input[value="1"]').prop('disabled','disabled');
                $('#field-181,#field-575').find('input[value="2"]').prop('disabled','disabled');
                $('#field-181,#field-575').find('input[value="4"]').prop('disabled','disabled'); 

            }
        }

        //арендный бизнес
        if (event.target.name === 'rent_business' ) {
            if(event.target.value == 1){
                $('#field-373,#field-374,#field-375,#field-376,#field-377,#field-378,#field-379').slideDown();
            }else{
                $('#field-373,#field-374,#field-375,#field-376,#field-377,#field-378,#field-379').slideUp();
            }
        }

        //обана
        if (event.target.name === 'contact_warning' ) {
            if(event.target.value == 1){
                $('#field-489').slideDown();
            }else{
                $('#field-489').slideUp();
            }
        }



    };



    //Добавление комментария
    $('body').on('click','.btn-ajax',function(){
        let response = JSON.parse(sendAjaxRequestPost(getFormUrl(),getFormElements(), false));
        this.closest('form').querySelector('textarea').value = '';
        let post_id = response['post_id'];
        let table_id = response['table'];
        let url = '<?=PROJECT_URL?>/templates/comments/index/index.php';
        //место куда вставляем response
        this.closest('.comments').querySelector('ul').innerHTML = getPostHtml(url, post_id, table_id) + this.closest('.comments').querySelector('ul').innerHTML;
    });



    //Сохранение формы редактирования
    $('body').on('click','.btn-async',function(){
        sendFormAsync();
    });


    //Подгружаем добавление локации
    $('body').on('click','.create-location-new',function(){
        if($('.create-location-panel').html() == ''){
            let url = 'https://pennylane.pro/system/controllers/locations/add_panel.php';
            let response = sendAjaxRequestPost(url,[], false);
            $('.create-location-panel').append(response);
        }else{
            $('.create-location-panel').html('');
        }

    });

    //Сохранение в панели рекламы И ДЛЯ ВСЕХ АСИНХРОННЫХ ФОРМ ПО ТЫЧКУ
    $('body').on('click','.form-element-autosave',function(){
        saveFormAsync();
    });

    $('body').on('keyup','.form-element-autosave',function(){
        saveFormAsync();
    });

    //клик вне списка даталист
    $(document).mouseup(function (e) {
        var container = $('.field-list-variants');
        if (container.has(e.target).length === 0){
            container.hide();
        }
    });



    function handleFileSelectMultiple() {

        let obj = event.target;

        let fileTypes = obj.getAttribute('accept');

         let files = obj.files; // FileList object

         // Loop through the FileList and render image files as thumbnails.
         for (let i = 0, f; f = files[i]; i++) {

             // Only process image files.
             let reader = new FileReader();

             // Closure to capture the file information.
             reader.onload = (function(theFile) {
             return function(e) {
                 // Render thumbnail.
                 if (f.type.match('image.*')) {
                     new_item = '<div class="files-grid-unit"><div class="photo-container background-fix" style="background: url('+e.target.result+');" title="'+theFile.name+'" "></div>';
                 }else{
                     new_item = '<div class="files-grid-unit"><div class="text_center full-height flex-box flex-box-vertical grey-border" ><div class="box"></div><div style="font-size: 60px">'+getFileIcon(f.name)+'</div><div class="grey-background full-width box-small to-end-vertical"><span class="box-wide" style="font-size: 20px;">'+getFileIcon(f.name)+'</span>'+getFileNameShort(f.name)+getFileExtension(f.name)+'</div></div><div>';
                 }

                 $(obj).closest('.files-list').find('.draggable').append(new_item);

             };
             })(f);

             // Read in the image file as a data URL.
             reader.readAsDataURL(f);
         }


        //obj.closest('label').style.display = 'none';
        $(obj).closest('.files-list').find('label').hide();
        $(obj).closest('.files-list').append(
                                                '<label>'+
                                                    '<div>Загрузить еще</div>'+
                                                    '<input type="file" multiple class="file-input-multiple" name="'+obj.name+'"   accept="'+fileTypes+'">'+
                                                '</label>'
                                            );
        //obj.closest('.label-custom').style.display = 'none';

    }

     document.oninput = function() {
         if (event.target.className === 'file-input-multiple') {
            handleFileSelectMultiple();
         }
     };


    ///////показываем крестик и делаем сортируемыми
    $('body').on('dblclick','.files-grid-unit',function(){
        if($(this).closest('.files-grid').find('.file-delete').css('display') === 'flex'){
            $(this).closest('.files-grid').find('.file-delete').css('display','none');
            $(this).closest('.files-grid').find('.file-show').css('display','none');
        }else{
            $(this).closest('.files-grid').find('.file-delete').css('display','flex');
            $(this).closest('.files-grid').find('.file-show').css('display','flex');
        }

        //////делаем фотки сортируемыми
        $(".draggable").sortable().disableSelection();
    });

    ///////удаляем фотку
    $('body').on('click','.file-delete',function(){
        let unit = this.closest('.files-grid-unit');
        let field_cont = this.closest('.files-grid');

        let file = unit.getAttribute("data-src");
        let id= field_cont.getAttribute('data-id');
        let table = field_cont.getAttribute('data-table-id');
        let field = field_cont.getAttribute('data-field');

        let params=[];
        params.push('id='+id);
        params.push('table_id='+table);
        params.push('field='+field);
        params.push('file='+file);

        //alert(params);

        let url = '<?=PROJECT_URL?>/system/controllers/files/delete.php';
        //alert(sendAjaxRequestPost(url,params,false));
        sendAjaxRequestPost(url,params,false);
        unit.remove();
    });

//сохраняем сортированные фотки сортируем фотки
    $('body').on('click','.files_resort',function() {

        //event.preventDefault();

        let files_blocks = document.getElementsByClassName('files-list');
        let files_sort = [];

        //FOR EACH FILES BLOCK(FIELD) ON A FORM
        for(let i = 0; i < files_blocks.length; i++){

            let id= files_blocks[i].querySelector('.files-grid').getAttribute('data-id');
            let table = files_blocks[i].querySelector('.files-grid').getAttribute('data-table-id');
            let field = files_blocks[i].querySelector('.files-grid').getAttribute('data-field');

            let files = files_blocks[i].querySelector('.files-grid').getElementsByClassName("files-grid-unit");

            //finding all the files SRC and creating an array in order to make a JSON string
            for(let i = 0; i < files.length; i++){
                if(files[i].style.display !== 'none' && files[i].getAttribute("data-src")) {
                    files_sort.push(files[i].getAttribute("data-src"));
                }
            }

            let files_json = JSON.stringify(files_sort);

            let url = "<?=PROJECT_URL?>/system/controllers/files/resort.php";

            let params=[];
            params.push('id='+id);
            params.push('table_id='+table);
            params.push('field='+field);
            params.push('files='+files_json);

            //alert(params);

            //alert(sendAjaxRequestPost(url,params,true));
            sendAjaxRequestPost(url,params,true);

            //CLEANING PREVIOUS FILES LIST
            files_sort = [];

            //alert('Сохранили');
        }

    });



    /**
     * ДОБАВЛЕНИЕ В ИЗБРАННОЕ
     */

        $('body').on('click','.icon-star', function () {
            let element_id = this.getAttribute('data-offer-id');
            //alert(element_id);
            let xhttp = new XMLHttpRequest();
            xhttp.open('GET',"<?=PROJECT_URL?>/system/controllers/favourites/add.php?offer_id="+element_id,false);
            xhttp.send();
            if (xhttp.readyState === 4 && xhttp.status === 200){
                //alert(xhttp.responseText);
            }
        });

        $('body').on('click', '.icon-star', function(){ // лoвим клик пo кнопке
            $(this).toggleClass('icon-star-active');
        });




        /**
         * ОТМЕТИТЬ ПРЕЗУ
         */
        $('body').on('click','.icon-send', function () {
            //alert('fgff');
            let element_id = this.getAttribute('data-offer-id');
            //alert(element_id);
            let xhttp = new XMLHttpRequest();
            xhttp.open('GET',"https://pennylane.pro/system/controllers/presentations/add.php?offer_id="+element_id,false);
            xhttp.send();
            //alert(xhttp.responseText);
            if (xhttp.readyState === 4 && xhttp.status === 200){

                if(xhttp.responseText == 1){
                    //alert(xhttp.responseText);
                    $(this).closest('.object-item').find('.pres-overlay').show();

                }else{
                    $(this).closest('.object-item').find('.pres-overlay').hide();
                }
            }
        });





    //для полей с промежутком значений  настраиваем приязвку данных
    $('body').on('change','.input-range',function(){
       //alert($(this).val());
       let name = $(this).attr('name').split('_');

       name.pop();
       let name_main = name.join('_');
       //alert(name_main);
       let name_min = name_main+'_min';
       let name_max = name_main+'_max';

       //у этих полей двусторонняя привязка данных (куда бы ни ввел во втором будет столько же)
       let arr_prices = [
           'price_sub_three',
           'price_sub_two',
           'price_sub',
           'price_field',
           'price_floor',
           'price_mezzanine',
           'price_mezzanine_two',
           'price_mezzanine_three',
           'price_mezzanine_four',
           'price_floor_two',
           'price_floor_three',
           'price_floor_four',
           'price_floor_five',
           'price_floor_six',
           'price_office',
           'price_tech',


           'price_safe_pallet_eu',
           'price_safe_pallet_fin',
           'price_safe_pallet_us',
           'price_safe_pallet_oversized',
           'price_safe_cell_small',
           'price_safe_cell_middle',
           'price_safe_cell_big',
           'price_safe_floor',
           'price_safe_volume',


       ];

       console.log(name_main);

       if(!arr_prices.includes(name_main)) {

           if(!parseInt($('input[name="'+name_max+'"]').val())){
               let val = $('input[name="'+name_min+'"]').val();
               $('input[name="'+name_max+'"]').val(val);
           }

           if(parseInt($('input[name="'+name_min+'"]').val()) > parseInt($('input[name="'+name_max+'"]').val())){
               let val = $('input[name="'+name_min+'"]').val();
               $('input[name="'+name_max+'"]').val(val);
           }
       } else {
           if($(this).attr('name') === name_min){
               let val = $('input[name="'+name_min+'"]').val();
               $('input[name="'+name_max+'"]').val(val);
           }

           if($(this).attr('name') === name_max){
               let val = $('input[name="'+name_max+'"]').val();
               $('input[name="'+name_min+'"]').val(val);
           }
       }



    });


    $('body').on('click','.datalist-add-btn',function(){
        //alert($(this).val());


        let params = [];
        let table_id = $(this).attr('data-table');
        let title = $(this).closest('.datalist-add').find('.datalist-input').val();
        let field_name = $(this).closest('.datalist-add').find('.datalist-field').attr('data-name');

        params.push('table_id='+table_id);
        params.push('title='+title);

        //alert(table_id);
        //alert(title);


        if( $.trim(title) ){
            let result = confirm('Добавить?');
            if(result){
                let response = sendAjaxRequestPost('<?=PROJECT_URL?>/system/controllers/datalist/add.php',params,false);

                //alert(response);

                let res = JSON.parse(response);

                $(this).closest('.datalist-add').find('.datalist-input-hidden').val(res[0]);
                alert(res[1]);

                $(this).closest('.datalist-add').find('.datalist-selected').append(`
             <div class="datalist-selected-item flex-box">
                <div>`+title+`</div>
                <div>
                    <input type="hidden" value="`+res[0]+`" name="`+field_name+`[]"  />
                </div>
                <div class="box-wide pointer">
                        <i class="far fa-times"></i>
                </div>
             <div>
            `);

                $(this).closest('.datalist-add').find('.datalist-input').val('');
            }

        }else{
            alert('введите что-нибудь');
        }



        //alert(table_id);
        //alert(title);


    });


    $('body').on('click','.datalist-multicheck > div',function(){
        //alert($(this).val());


        let params = [];
        let post_id = $(this).attr('data-id');
        let post_text = $(this).html();

        let field_name = $(this).closest('.datalist-field').attr('data-name');

        $(this).closest('.datalist-add').find('.datalist-selected').append(`
             <div class="datalist-selected-item flex-box">
                <div>`+post_text+`</div>
                <div>
                    <input type="hidden" value="`+post_id+`" name="`+field_name+`[]"  />
                </div>
                <div class="box-wide pointer">
                        <i class="far fa-times"></i>
                </div>
             <div>
        `);




    });

    $('body').on('click','.datalist-selected-item > .pointer',function(){
        let result = confirm('Вы уверены?');
        if(result){
            $(this).closest('.datalist-selected-item').remove();
        }

    });





    //Переключение локации
    $('body').on('click','.location-tab',function(){
        let id = $(this).attr('id');
        $('.field-location-id').attr('disabled','disabled');
        $('.'+id).removeAttr('disabled');
    });


    $('body').on('click','.field-status',function(){
        if($(this).find('input').val() == 2){
            $(this).closest('.complex-status').find('.status-extends').slideDown();
            $(this).closest('.complex-status').find('.status-extends-active').slideUp();
            $(this).closest('.complex-status').find('.status-extends-active').find('select').attr("disabled", true);
            $(this).closest('.complex-status').find('.status-extends').find('select').removeAttr("disabled");

            $(this).closest('.complex-status').find('.status-time').slideUp();

            $(this).closest('.complex-status').find('.status-text').slideDown();
        }else{
            $(this).closest('.complex-status').find('.status-extends').slideUp();
            $(this).closest('.complex-status').find('.status-extends-active').slideDown();
            $(this).closest('.complex-status').find('.status-extends').find('select').attr("disabled", true);
            $(this).closest('.complex-status').find('.status-extends-active').find('select').removeAttr("disabled");

            $(this).closest('.complex-status').find('.status-text').slideUp();
        }
    });


    $('body').on('change','.status-extends select, .status-extends-active select',function(){
        //let arr = [16,17,18,19];
        if($(this).val() == 16 || $(this).val() == 17 || $(this).val() == 18 || $(this).val() == 19 ){
            $(this).closest('.complex-status').find('.status-time').slideDown();
        }else{
            $(this).closest('.complex-status').find('.status-time').slideUp();
        }
    });


    function sendNotification(title, options) {
// Проверим, поддерживает ли браузер HTML5 Notifications
        if (!("Notification" in window)) {
            alert('Ваш браузер не поддерживает HTML Notifications, его необходимо обновить.');
        }

// Проверим, есть ли права на отправку уведомлений
        else if (Notification.permission === "granted") {
// Если права есть, отправим уведомление
            var notification = new Notification(title, options);

            function clickFunc() {
                alert('Пользователь кликнул на уведомление');
            }

            notification.onclick = clickFunc;
        }

// Если прав нет, пытаемся их получить
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
// Если права успешно получены, отправляем уведомление
                if (permission === "granted") {
                    var notification = new Notification(title, options);

                } else {
                    alert('Вы запретили показывать уведомления'); // Юзер отклонил наш запрос на показ уведомлений
                }
            });
        } else {
// Пользователь ранее отклонил наш запрос на показ уведомлений
// В этом месте мы можем, но не будем его беспокоить. Уважайте решения своих пользователей.
        }
    }


    <?//if($logedUser->member_id() == 141){?>
    <?if(12 == 141){?>

        /*

        //var last_check = '<?=$logedUser->getField('last_check_tasks')?>';
        setInterval(function(){
            let params =[];
            let  user_id = '<?=$logedUser->member_id()?>';
            //alert(user_id);
            params.push('member_id='+user_id);
            let last_check = sendAjaxRequestPost('https://pennylane.pro/tasks.php',['time_request=1'],false);

            params.push('last_check_tasks='+last_check);
            //console.log(last_check);
            let result = sendAjaxRequestPost('https://pennylane.pro/tasks.php',params,false);
            //alert(result);
            if(result){
                let json = JSON.parse(result);
                //alert(json);
                //alert(json.length);


                for(let i = 0; i < 1; i ++){
                    sendNotification(json[i]['title'], {
                        body: json[i]['body'],
                        icon: json[i]['icon'],
                        image: json[i]['image'],
                        //напрравление текста
                        dir: 'auto',
                        //чтобы без звука и вибрации
                        silent: true,
                        //чтобы висел пка не закроют
                        requireInteraction: false
                    });


                }


            }
            //last_check = new Date().getTime() / 1000;
        },5000);

        */
    <?}?>


    //УДАЛЕНИЕ ПОСТА
    $('body').on('click','.card-trash',function(){
        let sure = confirm('Вы уверены?')
        if(sure){
            let params = [];
            let id = this.getAttribute('data-id');
            let table_id = this.getAttribute('data-table');

            params.push('id='+id);
            params.push('table_id='+table_id);

            let res = sendAjaxRequestPost("<?=PROJECT_URL?>/system/controllers/posts/delete.php",params,false);

            console.log(res);

            if(this.getAttribute('data-redirect')){
                window.location.href = this.getAttribute('data-redirect');
            }else{
                window.location.href = window.location.href;
            }
            //alert(res);

        }
    });


    $("body").on('focus',"input[type='tel'] ",function() {
        console.log( "Handler for .focus() called." );
        console.log(this) ;
        event.target.setSelectionRange(0,0);
    });


    $("body").on('click',".tasks-preview-switch",function() {
        $(this).closest('.tabs-block').find(".tasks-preview").slideToggle();
    });


    $("body").on('click',".catalog-blocks-switch",function() {

        $(this).closest('.object-item').find(".catalog-blocks").slideToggle();
        $(this).toggleClass('rotate-180');
        //lert('dfdfd');
    });

    $("body").on('click',".page-item",function() {
        //alert('dfd');
        $('body').scrollTop();
    });




</script>

<script>
    $('body').on('change','.block-check',function(){

        let test = [];
        var num;

        if($('.blocks-parts').val()){
            test = JSON.parse($('.blocks-parts').val());
        }
        if(!in_array($(this).val(),test)){
            test.push($(this).val());
        }else{
            for(let i = 0; i < test.length ; i++){
                if(test[i] ==  $(this).val()){
                    num = i;
                    break;
                }
            }
            test.splice(num, 1);
        }


        //alert(test);

        $('.blocks-parts').val(JSON.stringify(test));
    });



    //зависимости да нет полей
    $('body').on('click','.no-value',function(){
        $(this).closest('.field-module').find('.field-step-2').hide();
        $(this).closest('.field-module').find('.field-step-2').find('input').val('');
        $(this).closest('.field-module').find('.field-step-2').find('input').prop('disabled','true');
        $(this).closest('.field-module').find('.field-step-2').find('select').attr('disabled','true');
        $(this).closest('.field-module').find('.field-step-2').find('input').removeAttr("checked");
    });

    $('body').on('click','.yes-value',function(){
        $(this).closest('.field-module').find('.field-step-2').show();
        $(this).closest('.field-module').find('.field-step-2').find('select').removeAttr('disabled');
        $(this).closest('.field-module').find('.field-step-2').find('input').removeAttr("disabled");
    });


    //отщелкивание обязательных полей
    $('body').on('click','.test',function(){
        let input = $(this).closest('.value-novalue').find('.value-to-switch').find('.input-main');
        //alert($(input).attr('disabled'));
        if($(input).attr('disabled') == 'disabled'){
            $(input).removeAttr('disabled');
        }else{
            $(input).prop('disabled','true');
        }
        $(this).closest('.value-novalue').find('.value-to-switch').find('.input-main').val(' ');

    });

    //отщелкивание обязательных полей
    $('body').on('keyup','input',function(){
        //console.log('dfddf');
        let area_all = parseInt(document.querySelector('input[name="area_building"]').value);
        let area_floor = parseInt(document.querySelector('input[name="area_floor_full"]').value);
        let area_mezzanine = parseInt(document.querySelector('input[name="area_mezzanine_full"]').value);
        let area_office = parseInt(document.querySelector('input[name="area_office_full"]').value);
        let area_tech= parseInt(document.querySelector('input[name="area_tech_full"]').value);
        if(area_floor + area_mezzanine + area_office +area_tech > area_all){
            alert('площадь хуйня');
            document.getElementById('go').style.display = 'none';
        }else{
            document.getElementById('go').style.display = 'block';
        }

    });


</script>

<script defer>
    //ДЛЯ ОТОБРАЖЕНИЯ БЛОКОВ КРАНОВ таймаут для того чтобы вкладки успели включиться


        //ДЛЯ ОТОБРАЖЕНИЯ БЛОКОВ КРАНОВ
        $('.block-fix').click(function(){

            let target = this;

            let fields = [
                '.block-info-racks',
                '.block-info-gates',
                '.block-info-elevators',
                '.block-info-cranes_cathead',
                '.block-info-cranes_overhead',
                '.block-info-telphers',
                '.block-info-safe-types',
                '.block-info-floor-types',
                '.block-info-grid-types',
                '.block-header',
                '.object-block'
            ];

            setTimeout(function(){

                console.log('sdsds');




                //для блоков каждого класса
                for(let i = 0; i < fields.length; i++){

                    //console.log(fields[i]);



                    //все элементы этого класса
                    let items = $(target).closest('.tabs-block').find('.tabs-content').find(fields[i]);
                    //максимальная высота старт

                    console.log("Количество столбцов"+ items.length);


                    let max_height = 10;
                    //для все элементов класса
                    for(let j = 0; j < items.length ; j++){

                        //console.log(items[j]) ;

                        //высота элемента этого класса
                        let el_height = $(items[j]).height();

                        //console.log(el_height);

                        //ищем наибольшую высоту среди всех элементов
                        if(el_height > max_height){
                            max_height = el_height;
                        }

                    }


                    $(fields[i]).closest('.tab-content').find(fields[i]).css('height',max_height);

                }


            },500);



        });

</script>







<script src="<?=PROJECT_URL?>/js/script.js" async></script>
<script src="<?=PROJECT_URL?>/admin/js/system.js" async></script>













<!--
<script type="text/javascript" src="//www.gstatic.com/firebasejs/3.6.8/firebase.js"></script>
<script type="text/javascript" src="<?=PROJECT_URL?>/firebase_subscribe.js"></script>
-->




<script>
    /*
    //PUSH ОТПРАВКА СООБЩЕНИЙ ЧЕРЕЗ FIREBASE
    // firebase_subscribe.js
    firebase.initializeApp({
        messagingSenderId: '1047834886771'
    });

    // браузер поддерживает уведомления
    // вообще, эту проверку должна делать библиотека Firebase, но она этого не делает
    if ('Notification' in window) {
        var messaging = firebase.messaging();

        // пользователь уже разрешил получение уведомлений
        // подписываем на уведомления если ещё не подписали
        if (Notification.permission === 'granted') {
            subscribe();
        }

        // по клику, запрашиваем у пользователя разрешение на уведомления
        // и подписываем его
        $('#subscribe').on('click', function () {
            subscribe();
        });
    }

    function subscribe() {
        // запрашиваем разрешение на получение уведомлений
        messaging.requestPermission()
            .then(function () {
                // получаем ID устройства
                messaging.getToken()
                    .then(function (currentToken) {
                        console.log(currentToken);

                        if (currentToken) {
                            sendTokenToServer(currentToken);
                        } else {
                            console.warn('Не удалось получить токен.');
                            setTokenSentToServer(false);
                        }
                    })
                    .catch(function (err) {
                        console.warn('При получении токена произошла ошибка.', err);
                        setTokenSentToServer(false);
                    });
            })
            .catch(function (err) {
                console.warn('Не удалось получить разрешение на показ уведомлений.', err);
            });
    }

    // отправка ID на сервер
    function sendTokenToServer(currentToken) {
        if (!isTokenSentToServer(currentToken)) {
            console.log('Отправка токена на сервер...');

            var url = '<?//=PROJECT_URL?>/system/controllers/pushes/save.php'; // адрес скрипта на сервере который сохраняет ID устройства
            $.post(url, {
                token: currentToken,
                member_id: '<?//=$logedUser->member_id()?>'
            });

            setTokenSentToServer(currentToken);
        } else {
            console.log('Токен уже отправлен на сервер.');
        }
    }

    // используем localStorage для отметки того,
    // что пользователь уже подписался на уведомления
    function isTokenSentToServer(currentToken) {
        return window.localStorage.getItem('sentFirebaseMessagingToken') == currentToken;
    }

    function setTokenSentToServer(currentToken) {
        window.localStorage.setItem(
            'sentFirebaseMessagingToken',
            currentToken ? currentToken : ''
        );
    }

    */
</script>

<script defer>

    setTimeout(function(){
        $('.block-priceless')[0].click();
    },1000);


</script>

</body>
</html>
