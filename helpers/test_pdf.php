<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <style>
        body{
            background: #282828;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            font-family: DejaVu Sans, sans-serif;
            background: #ffffff;
        }

        .flex-box{
             display: flex;
             align-items: center;
         }

        .flex-between{
            justify-content:  space-between;
        }

        .flex-wrap{
            flex-wrap: wrap;
        }

        .one-third{
            box-sizing: border-box;
            width: 33.33%;
        }

        .two-third{
            box-sizing: border-box;
            width: 66.66%;
        }

        .background-fix{
            background-position: center center !important ;
            background-size: cover !important;
            background-repeat: no-repeat !important;
        }

        .inline-block{
            display: inline-block;
        }

        .full-width{
            width: 100%
        }

        .full-height{
            height: 100%;
        }

        .box{
            padding: 20px;
            box-sizing: border-box;
        }

        .box-small{
            padding: 10px;
            box-sizing: border-box;
        }

        .box-small-vertical{
            padding: 10px 0;
            box-sizing: border-box;
        }

        .purple-background{
            background: #c9cfff;
        }

        .purple-color{
            color: #c9cfff;
        }

        .object-option{
            height: 50%;
            border: 1px solid #e7e5f2;
        }

        .uppercase{
            text-transform: uppercase;
        }

        .to-end{
            margin-left: auto;
        }

        .isBold{
            font-weight: bold;
        }

        .text-center{
            text-align: center;
        }

        .attention{
            color: #9c2b09;
        }

        .photo-big{
            -webkit-box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
            -moz-box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
            box-shadow: inset 0px 0px 218px 96px rgba(0,0,0,0.75);
        }

        .photo-small{
            height: 250px;
        }

        #map{
            height: 450px;
            background: #e1e1e1;
        }

        .controller{
            display: none !important;
        }
        .object-id{
            position: relative;
            background: #b02b00;
        }
        .object-id::after {
            content: '';
            position: absolute; /* Абсолютное позиционирование */
            left: 120px; bottom: 0px; /* Положение треугольника */
            border: 19px solid transparent; /* Прозрачные границы */
            border-left: 19px solid #b02b00;
        }
        .blocks-body > div:nth-child(2n + 1){
            background: #c9cfff;
        }

        .blocks-body > div > div{
            border: 1px solid gainsboro;
        }

        .box-shadow-full{
            -webkit-box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
            box-shadow: inset 0px 0px 300px 0px rgba(0,0,0,0.75);
        }
    </style>


    <meta charset="UTF-8">
    <title>Title dick</title>
</head>
<body>
<div class="container box">
    <div class="pdf_header flex-box">
        <div class="pdf_logo  inline-block" >
            <a href="realtor.ru">
                <img style="width: 100%" src="img/pdf/logo.jpg"/>
            </a>
        </div>
        <div class="pdf_main_contacts inline-block to-end">
            <div class="inline-block box-small" style="border-right: 1px solid red;">
                <div class="isBold">
                    Александр Отделенцев
                </div>
                <div class="attention">
                    Ведущий консультант
                </div>
            </div>
            <div class="inline-block box-small">
                <div>
                    + 7 926 345 67 90
                </div>
                <div>
                    + 7 926 345 67 91
                </div>
            </div>
        </div>
    </div>
    <div class="box-small-vertical flex-box">
        <div class="two-third background-fix photo-big" style="position: relative;  background: url('/uploads/objects/2525/thumbs/9_0f967a7aa70411bfe46a7872ff87bb5b.jpg')">
            <div class="box-small object-id" style=" color: white; width: 120px">
                Обьект 2413
            </div>
            <div style="height: 200px">

            </div>
            <div class="box" style=" color: white;">
                <div class="uppercase" style="font-size: 40px; font-weight: bold;">
                    MLP-подольск
                </div>
                <div class="purple-color">
                    Производственно-складской комплекс
                </div>
                <div class="box-small-vertical">
                    <div class="inline-block box-small purple-background" style="color: black; font-weight: bold;">
                        Малые вязьмы
                    </div>
                    <div class="inline-block box-small purple-background" style="color: black; font-weight: bold;">
                        Минсоке шоссе
                    </div>
                    <div class="inline-block box-small purple-background" style="color: black; font-weight: bold;">
                        25км от мкад
                    </div>
                </div>
            </div>
        </div>
        <div class="one-third" style="height: 400px; overflow: hidden" >
            <div id="map">

            </div>

        </div>
    </div>
    <div class="box-small-vertical flex-box">
        <div class="flex-box two-third"  style=" border: 2px solid  #e7e5f2; ">
            <div class="one-third box-small" style="background: #e7e5f2; height: 100px;">
                <div class="isBold">
                    площадь в аренду
                </div>
                <div class="isBold" style="font-size: 38px">
                    18 250 <span style="line-height: 10px;">м<sup>2</sup></span>
                </div>
                <div>
                    Деление от <span class="attention isBold">8 000 м<sup>2</sup></span>
                </div>
            </div>
            <div class="two-third box-small">
                <div class="isBold">
                    ставка за <span style="line-height: 10px;">м<sup>2</sup>/год,</span> <span class="attention ">без НДС</span>
                </div>
                <div class="attention isBold" style="font-size: 38px">
                    4 200 руб.
                </div>
                <div>
                    не включает <span class="isBold">КУ(+250руб.)</span> и <span class="isBold">OPEX(+1200руб.)</span>
                </div>
            </div>
        </div>
        <div class="one-third flex-box flex-wrap text-center box-small">
            <div class="one-third box-small object-option">
                <div>
                    <i class="fas fa-signal"></i>
                </div>
                <div>
                    1-4 этажи
                </div>
            </div>
            <div class="one-third box-small object-option">
                <div>
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <div>
                    8 ворот
                </div>
            </div>
            <div class="one-third box-small object-option">
                <div>
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    1500кВТ
                </div>
            </div>
            <div class="one-third box-small object-option">
                <div>
                    <i class="fas fa-arrows-alt-v"></i>
                </div>
                <div>
                    1-5 метров
                </div>
            </div>
            <div class="one-third box-small object-option">
                <div>
                    <i class="rotate-45 fas fa-arrows-alt"></i>
                </div>
                <div>
                    Антипыль
                </div>
            </div>
            <div class="one-third box-small object-option">
                <div>
                    <i class="fas fa-truck-loading"></i>
                </div>
                <div>
                    2-400 тонн
                </div>
            </div>
        </div>
    </div>
    <div class="flex-box flex-between">
        <div class="one-third">
            <div class="background-fix photo-small" style="background-image: url('uploads/objects/2525/1_7ab46d4c4c78e02962a2d2a01a96d019.jpg');">

            </div>
        </div>
        <div class="one-third box-small" >
            <div class="background-fix photo-small" style="background-image: url('/uploads/objects/2525/thumbs/10_a20a7ae0a8a470da72dca620db6df576.jpg');">

            </div>
        </div>
        <div class="one-third" >
            <div class="background-fix photo-small" style="background-image: url('/uploads/objects/2525/thumbs/11_a9a7aae6d84492010a8ea4bfc64ad874.jpg');">

            </div>
        </div>
    </div>
    <div class="blocks-block">
        <div class=" text-center isBold uppercase">
            <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 180px">
                Варианты деления
            </div>
        </div>
        <div style="border: 1px solid #e7e5f2;">
            <div class="blocks-header flex-box box-small-vertical isBold">
                <div class="box-small" style=" width: 10%;">ID блока</div>
                <div class="box-small" style=" width:5%;">Этаж</div>
                <div class="box-small" style=" width:15%;">Площадь</div>
                <div class="box-small" style=" width:10%;">Высота</div>
                <div class="box-small" style=" width:10%;">Тип пола</div>
                <div class="box-small" style=" width:10%;">Ворота</div>
                <div class="box-small" style=" width:10%;">Отопление</div>
                <div class="box-small" style=" width:15%;">Ставка</div>
                <div class="box-small" style=" width:15%;">Итого, цена в месяц</div>
            </div>
            <div class="blocks-body">
                <? $blocks = [1,2,3,4,5,6,7,8,9];?>
                <?foreach($blocks as $block){?>
                    <div class="flex-box">
                        <div class="box-small" style=" width: 10%;">23657-1</div>
                        <div class="box-small" style=" width:5%;">2</div>
                        <div class="box-small" style=" width:15%;"><span class="isBold">10000-200000</span> руб.</div>
                        <div class="box-small" style=" width:10%;">8-9</div>
                        <div class="box-small" style=" width:10%;">антипыль</div>
                        <div class="box-small" style=" width:10%;">на нуле</div>
                        <div class="box-small" style=" width:10%;">теплый</div>
                        <div class="box-small" style=" width:15%;"><span class="isBold">5500</span> руб.</div>
                        <div class="box-small" style=" width:15%;">10000000 руб</div>
                    </div>
                <?}?>
            </div>
        </div>
    </div>
    <div class="flex-box flex-between box-small-vertical">
        <div class="one-third">
            <div class="background-fix photo-small" style="background-image: url('uploads/objects/2525/1_7ab46d4c4c78e02962a2d2a01a96d019.jpg');">

            </div>
        </div>
        <div class="one-third box-small" >
            <div class="background-fix photo-small" style="background-image: url('/uploads/objects/2525/thumbs/10_a20a7ae0a8a470da72dca620db6df576.jpg');">

            </div>
        </div>
        <div class="one-third" >
            <div class="background-fix photo-small" style="background-image: url('/uploads/objects/2525/thumbs/11_a9a7aae6d84492010a8ea4bfc64ad874.jpg');">

            </div>
        </div>
    </div>
    <div class="description-block box-small-vertical">
        <div class="text-center isBold uppercase" >
            <div class="box-small-vertical text-center inline-block" style="border-bottom: 2px solid #9c2b09; width: 200px">
                Описание обьекта
            </div>
        </div>
        <div class="box-small-vertical">
            Аренда помещения под склад 7 500 кв.м по Ярославское шоссе, Пушкино в 15 км от МКАД.

            Из них 3 863 кв.м на мезонине. Возможно деление площади от 2 800 кв.м.. Высота потолков от 12 м. Полы - антипыль. Доступные ворота: 43 шт – докового типа. Площадь офисов на объекте: 2 811 кв.м. Площадь участка - 350 соток.

            Выделенные блоки (5 шт): 2 500 кв.м, 2 900 кв.м, 6 193 кв.м, 7 500 кв.м, 9 800 кв.м. Помещение располагается на 1 эт. Нагрузка на пол: 1 эт - 9.00 т/кв.м. Сетка колонн: 12x24 м.

            Центральное отопление, приточно-вытяжная вентиляция, канализация, 1 500 кВт, объект под охраной, бесплатный въезд, газ.

            Помещение подходит под: алкогольный склад, фармацевтический склад.

            Без комиссии. ID 2413.
        </div>
    </div>
    <div class="text-center background-fix box-shadow-full" style="padding: 20px; color: white; background-image: url('uploads/objects/2525/thumbs/9_0f967a7aa70411bfe46a7872ff87bb5b.jpg'); margin: 0 -20px;">
        <div class="box">

        </div>
        <div class="isBold">
            Узнайте первым о новом, подходящем Вам предложении
        </div>
        <div class="box-small-vertical">
            Настройте параметры поиска подходящего Вам объекта и как только он появится на рынке система ватоматически пришлет его Вам на эл.почту
        </div>
        <div >
            <a href="industry.realtor.ru" style="color: white;">
                industry.realtor.ru
            </a>
        </div>
        <div class="box">

        </div>
    </div>
</div>


<script src="https://api-maps.yandex.ru/2.1/?apikey=7cb3c3f6-2764-4ca3-ba87-121bd8921a4e&lang=ru_RU" type="text/javascript"></script>
<script>
    let myMap;
    ymaps.ready(init); // Ожидание загрузки API с сервера Яндекса
    function init () {
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64], // Координаты центра карты
            zoom: 10,
            controls: []
        });


    }
</script>



</body>
</html>

