<div class="grid-element-unit section <?=($page_block->hasPadding())? 'bitkit_box': '';?>"  data-element-id="<?=$page_block->blockId()?>" >
    <div class="grid-element-core">
        <div class="grid-element-content" >
            <div>
                <?if($page_block->blockType() == 'php'){
                    if($page_block->getField('link')){
                        include('blocks/'.$page_block->getField('link'));
                    }else{
                        include('blocks/'.$page_block->block_name());
                    }
                }else{
                    echo $page_block->description();
                }?>
            </div>
        </div>
        <div class="grid-element-name" >
            <b><?=$page_block->title()?></b>
        </div>
        <div class="grid-element-delete" data-element-delete-id="<?=$page_block->blockId()?>">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="grid-element-overlay" >

        </div>
    </div>
</div>
