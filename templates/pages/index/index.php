
<div id="grid-canvas"   class=" tabs-block flex-box">
        <?$tabs = []?>
        <?$contents = []?>
        <?foreach ($page->getJsonField('grid_elements_test') as $key=>$value){?>
            <?$tabs[] = $key?>
            <?$contents[] = $value?>
        <?}?>
        <div class="tabs" style="display: none;">
            <?if($tabs){?>
                <?foreach ($tabs as $tab){?>
                    <div class="tab box-wide">
                        <input title="" type="text" value="<?=$tab?>"/>
                    </div>
                <?}?>
            <?}else{?>
                <div class="tab box-wide">
                    <input title="" type="text" value="main"/>
                </div>
            <?}?>
        </div>
        <div class="tabs-content full-width" >
            <?if($contents){?>
                <?foreach ($contents as $content){?>
                    <div class="tab-content <?=(!$first) ? 'tab-content-active' : ''?> <?$first = 1?> flex-box" style="display: flex">
                        <?foreach ($content as $page){?>
                            <div class="grid-page" style="width: 100%; flex-wrap: wrap; align-items: flex-start;">
                                <input style="display: none;" class="grid-page-name" value="<?=$page[0]?>" type="text" placeholder="Название страницы" >
                                <div class="grid-page-sortable-zone">
                                    <?foreach ($page[1] as $column){?>
                                        <div class="grid-column" style="width: <?=$column[0]?>">
                                            <input class="grid-column-change" value="<?=(int)$column[0]?>" type="number" placeholder="Ширина блока" >
                                            <div class="grid-element-delete">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>
                                            <div class="grid-column-sortable-zone"  >
                                                <?foreach($column[1] as $block_unit) {?>
                                                    <?$page_block = new Block($block_unit)?>
                                                    <?if($page_block->canSee()){?>
                                                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/blocks/index/index.php'?>
                                                    <?}?>
                                                <?}?>
                                            </div>
                                        </div>
                                    <?}?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                <?}?>
            <?}else{?>
                <div class="tab-content tab-content-active flex-box tab-content-active"  style="display: flex">
                    <div class="grid-page" style="width: 100%; flex-wrap: wrap; align-items: flex-start">
                        <input style="display: none;" class="grid-page-name" value="page" type="text" placeholder="Название страницы" >
                        <div class="grid-page-sortable-zone">
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
</div>



