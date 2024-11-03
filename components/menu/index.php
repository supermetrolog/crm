<header class="header container">
    <div class="container_menu">
        <div class="header-menu box flex-box flex-between">
            <div class="logo">
                <a href="/" class="logo">
                    <div>
                        <img src="<?=PROJECT_URL?>/img/g.png" >
                    </div>
                    <div class="site-title ghost" style="line-height: 15px;">
                        <?=$theme->siteTitle()?>
                    </div>
                </a>
            </div>
            <div class="main-menu">
                <ul>
                    <?php
                    $page_template = $router->getPageName();
                    $menu = new Menu(1);
                    foreach($menu->menuActivePages() as $menu_item ){
                            $menu_item = new Page($menu_item['id']); ?>
                            <li>
                                <a c href="<?=PROJECT_URL.'/'.$menu_item->furl()?>" class="<?=(trim($menu_item->furl(), '/') == (trim($page_template, '/'))  ) ? 'isBold' : 'ghost'; ?>" ><?=$menu_item->title()?></a>
                            </li>
                    <?}?>
                </ul>
            </div>
            <div class="user-info flex-box">
                <div class="user-stats flex-box">
                    <div class="isBold box-wide"><?=count($logedUser->getFavourites())?></div>
                    <div class="icon-round <?=(count($logedUser->getFavourites()) > 0) ? 'icon-hl' : '' ?>">
                        <a href="/favorites/">
                            <i class="fas fa-star"></i>
                        </a>
                    </div>
                </div>
                <div class="user-stats flex-box dropdown-container">
                    <?$newMsgs = count($logedUser->getAllNewMessages())?>
                    <?$newTasks = count($logedUser->getAllNewTasks())?>
                    <div class="isBold box-wide"><?= ($newMsgs + $newTasks)?></div>
                    <div class="dropdown-button icon-round <?=($newMsgs + $newTasks > 0) ? 'icon-hl' : '' ?>">
                        <div class="icon-bell">

                                <i class="fas fa-bell"></i>

                        </div>
                    </div>
                    <div class="dropdown-menu" >
                        <ul>
                            <li>
                                <a href="<?=PROJECT_URL?>/tasks/">
                                    <div class="flex-box">
                                        <div>
                                            Новые задачи
                                        </div>
                                        <div class="to-end">
                                            <?=count($logedUser->getAllNewTasks())?>
                                        </div>
                                    </div>
                                </a>
                            </li>  
                            <li>
                                <a href="<?=PROJECT_URL?>/inbox/">
                                    <div class="flex-box">
                                        <div>
                                            Новые сообщения
                                        </div>
                                        <div class="to-end">
                                            <?=count($logedUser->getAllNewMessages())?>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="user-stats flex-box">
                    <div class="isBold box-wide">1</div>
                    <div class="icon-round">
                        <a href="/disliked/" class="icon-thumbs-down">
                            <i class="fas fa-thumbs-down"></i>
                        </a>
                    </div>
                </div>
                <div class="user-stats dropdown-container user-info flex-box flex-between">
                    <div class="dropdown-button" id="user-actions">
                        <span class="ghost"><?=$logedUser->group_name()?></span>
                        <div class="isBold  pointer"><?=$logedUser->title()?></div>
                    </div>
                    <div>
                        <i class="fas fa-caret-down"></i>
                    </div>
                    <div class="dropdown-menu" >
                        <ul>
                            <li><a href="<?=PROJECT_URL?>/user/<?=$logedUser->member_id()?>">Моя страница</a> </li>
                            <li><a href="<?=PROJECT_URL?>/tasks/">Мои задачи</a> </li>
                            <li><a href="<?=PROJECT_URL?>/calendar/">Мой календарь</a> </li>
                            <li><a href="<?=PROJECT_URL?>/companies/">Создать компанию</a></li>
                            <li><a href="<?=PROJECT_URL?>/admin/" target="_blank">Панель администратора</a></li>
                            <li><a href="<?=PROJECT_URL?>/system/controllers/login/index.php">Выйти</a></li>
                        </ul>
                    </div>
                    <script type="text/javascript">
                        //Подгрузка колва товара в корзине
                        $(document).ready(function() {
                            $('.dropdown-button').click(function() {
                                $('.dropdown-menu').slideUp(0);
                                $(this).closest('.dropdown-container').find('.dropdown-menu').slideToggle(100);
                                //$('.dropdown-menu').slideUp(100);
                            });
                        });
                    </script>
                </div>
            </div>
            <div style="display: none">
                <div id='menu_1' >
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
                <div class="mob_menu">
                    <div class='mob_menu_header'>
                        <div style='display :none;' class='mob_menu_search'><i class="fa fa-search" aria-hidden="true"></i></div>
                        <div class='mob_menu_photo'>
                            <a href='/users/'>
                                <img src='<?=$logedUser->avatar()?>'/>
                            </a>
                        </div><br>
                        <div class='mob_menu_name'>
                            <a href='/users/'><?=$logedUser->title()?></a><br>
                        </div>
                    </div>
                    <div class='mob_menu_list'>
                        <ul>
                            <?foreach($menu->menuActivePages() as $menu_item ){
                                $menu_item = new Page($menu_item['id']);?>
                                <li class='menu_item'><a href="/<?=$menu_item->furl()?>" class="<?=(trim($menu_item->furl(), '/') == (trim($page_template, '/'))  ) ? 'isBold' : ''; ?>"><?=$menu_item->title()?></a></li>
                            <?}?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>

