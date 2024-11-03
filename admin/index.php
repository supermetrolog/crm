<?require_once ($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>


<? require_once(PROJECT_ROOT.'/admin/components/header/index.php');
//require_once(PROJECT_ROOT.'/errors.php');

if($_COOKIE['member_id'] == 141){
    //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}


$table = $_GET['table'];
if($table == 'pages') {
    $view_style = 'style="display: block;"';
}
$template = $_GET['template'];
?>

<?if($table == 'dashboard'){
    include('components/dashboard.php');
}

if(!isset($table)){
    //include('components/main_activity.php');
}

if($table == 'tables'){
    $tables_sql= $pdo->prepare("SHOW TABLES FROM $db");
    $tables_sql->execute();
    $i = 0;
    while($table = $tables_sql->fetch()){?>
        <div value='<?=$table["Tables_in_$db"]?>'>
            <a href="<?=PROJECT_URL?>/admin/index.php?action=show&table=<?=$table["Tables_in_$db"]?>&title=Таблица">
                <?=$table["Tables_in_$db"]?>
            </a>
        </div>
        <?$i++;
    }
}?>
    <div class="admin-container-grid">
        <div class="admin-menu">
            <? include_once(PROJECT_ROOT.'/admin/components/menu/index.php');?>
        </div>
        <div class="admin-content">
            <div class="admin-top-nav">
                <? include_once(PROJECT_ROOT.'/admin/components/topnav/index.php');?>
            </div>
            <div class="admin-workarea">
                <div class="admin-worksheet">
                    <? include_once(PROJECT_ROOT . "/admin/templates/$template/index/index.php");?>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
            var pageList;
            $(".admin_block_table").sortable({
                cursor: "move"
            });
            $('.edit_confirm_but').click(function() {
                pageList = '';
                $(".admin_post").each(function(indx, element){
                    pageList = pageList+$(element).attr("id")+",";
                });
                //alert(pageList);
                $.ajax({
                    url: "<?=PROJECT_URL?>//admin/components/menu_resort.php",
                    type: "GET",
                    data: {"pages": pageList},
                    cache: false,
                    success: function(response){
                        if(response == 0){  // смотрим ответ от сервера и выполняем соответствующее действие
                            alert("не удалось получить ответ от скрипта");
                        }else{
                            alert(response);
                            //$('.order_table').append(response);
                        }
                    }
                });

            });

        });
    </script>
<? require_once(PROJECT_ROOT.'/admin/components/footer/index.php');