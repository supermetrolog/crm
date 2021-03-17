<div class="admin_catalog_row flex-box flex-between">
    <div class="row_field box">
        <a href='/admin/index.php?template=post&id=<?=$post->postId()?>&table=<?=$post->setTable()?>&action=change&title=изменение''>
            <b>
                <?=$post->title()?>
            </b>
        </a>
    </div>
    <div class='ghost row_field box'>
        <i class="fa fa-calendar-o" aria-hidden="true" title='<?=date("d.m.y  G:i"  ,$post->publTime()); ?>'></i>
    </div>
    <div class='ghost row_field box'>
        <i class="fa fa-line-chart" aria-hidden="true" title='Приоритет отображения'></i> <?=$src['order_row']; ?>
    </div>
    <div>

    </div>
    <div class='ghost row_field box'>

    </div>
    <div>

    </div>
    <div>

    </div>
    <div class='delete_post box' name='<?=$post->postId()?>' title='<?=$post->setTable()?>' >
        <i class='fa fa-times' aria-hidden='true' title='Удалить'></i>
    </div>
</div>