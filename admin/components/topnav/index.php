
    <div class='admin_logo isBold'>
        <a href='/admin/index.php' >
            <img style="width: 30px;"  src='<?=PROJECT_URL?>/img/g.png'/>
        </a>
    </div>
    <div class="opt_desk">
        <div class="">
            <a href="<?=PROJECT_URL?>/" target='_blank' title='Перейти на сайт'>
                <i class="fa fa-home" aria-hidden="true"></i>
            </a>
        </div>
        <div class="">
            <a href="<?=PROJECT_URL?>//admin/index.php"  title='Основные настройки'>
                <i class="fa fa-cogs" aria-hidden="true"></i>
            </a>
        </div>
        <?if($_GET['action'] == 'show'){?>
            <div class="">
                <a href="<?=PROJECT_URL?>//admin/index.php?table=<?=$_GET['table']?>&template=<?=$_GET['template']?>&view=list&action=show"  title='Вид списка'>
                    <i class="fas fa-bars"></i>
                </a>
            </div>
            <div class="">
                <a href="<?=PROJECT_URL?>//admin/index.php?table=<?=$_GET['table']?>&template=<?=$_GET['template']?>&view=tile&action=show"  title='Плиточный вид'>
                    <i class="fas fa-th"></i>
                </a>
            </div>
        <?}?>
        <?if($_GET['action'] == 'create' || $_GET['action'] == 'change'){?>
            <div class="">
                <a href="<?=PROJECT_URL?>//admin/index.php?template=page&table=<?=$_GET['table']?>&action=show"  title='Вернуться в раздел'>
                    <i class="fas fa-reply-all"></i>
                </a>
            </div>
        <?}?>
    </div>
    <?if($_GET['template'] == 'page'){?>
    <div class='admin_filters'>
        <input class='admin-search-line box-small' oninput='art_search(this.value);'  type='text' placeholder='Поиск'/>
    </div>
    <?}?>
    <div class='admin_exit'>
        <div class="tabs">
            <div class="drop_down_menu">
                <ul>
                    <li><a href ='<?=PROJECT_URL?>/system/controllers/login/index.php'><i class="fa fa-power-off" aria-hidden="true"></i> Выйти</a></li>
                </ul>
            </div>
            <div class='photo_round'>
                <img class='' src='<?=$admin->photo()?>'/>
            </div>
        </div>
    </div>

    <? if($_GET['action'] == 'show'){?>
        <div class='new_post Btn orangeBtn button_small isBold' title='создать новый пост'>
            <a href='/admin/index.php?table=<? echo $_GET['table'];?>&template=post&action=create&title=создание поста'><i class="fa fa-plus-circle" aria-hidden="true"></i> Создать</a>
        </div>
    <? } ?>

    <div class='admin_block_title'>
        <? if(isset($_GET['title'])){echo $_GET['title'];}else {echo "Главная";}?>
    </div>