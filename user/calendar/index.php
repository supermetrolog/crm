<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 15.06.2018
 * Time: 12:55
 */
?>
<script type="text/javascript">
    //Переключение календаря
    $(document).ready(function () {
        var month = <?=date("n")?>;
        var year = <?=date("Y")?>;

        $.ajax({
            url: "<?=PROJECT_URL?>//components/calendar.php",
            type: "GET",
            data: {"month": month, "year": year},
            cache: false,
            success: function (response) {
                if (response == 0) {  // смотрим ответ от сервера и выполняем соответствующее действие
//alert("не удалось");
                } else {
//alert("удалось");
                    $(".calendar_container").html(response);
                }
            }
        });

        $('body').on('click', '.calendar_switch', function () {
//считаем месяцы
            if ($(this).attr('id') == 'next') {
                month++;
            } else if ($(this).attr('id') == 'prev') {
                month--;
            } else {

            }
//alert($(this).attr('id'));
//считаем год
            if (month > 12) {
                year++;
                month = 1;
            } else if (month < 1) {
                year--;
                month = 12;
            } else {

            }
//alert(month);
//alert(year);
            $.ajax({
                url: "<?=PROJECT_URL?>//components/calendar.php",
                type: "GET",
                data: {"month": month, "year": year},
                cache: false,
                success: function (response) {
                    if (response == 0) {  // смотрим ответ от сервера и выполняем соответствующее действие
//alert("не удалось");
                    } else {
//alert("удалось");
                        $(".calendar_container").html(response);
                    }
                }
            });
        });
    });
</script>
<div class='calendar_container'></div>

