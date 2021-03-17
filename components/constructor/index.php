<div class='editBtn grid-edit-btn'>
   <i class="fa fa-chevron-right"></i>
</div>
<div class='grid-edit-panel grid-edit-panel-right'>
        <div class="grid-column-add greenBtn box">
            Добавить
        </div>
	    <div class='grid-elements-list grid-column-sortable-zone'>
          <?
            $blocks = new Block(0);
            foreach($blocks->getAllActiveUnits() as $block){?>
                <?if($block['id']){?>
                    <?$block = new Block($block['id']);?>
                    <?if($block->canSee()){?>
                        <?include $_SERVER['DOCUMENT_ROOT'].'/templates/blocks/list/index.php'?>
                    <?}?>
                <?}?>
		  <?}?>
		</div>
        <div class='grid-elements-save greenBtn editBtn box pointer'  data-grid-container="grid-canvas" data-grid-type="core_blocks" data-grid-table="core_pages" data-grid-id="<?=$router->getPageId()?>" data-grid-field="grid_elements_test">Сохранить</div>
</div>
<script>
//////////СОХРАНЕНИЕ ПОРЯДКА БЛОКОВ///////////////////////////////////////////////////

	$(document).ready(function() {
		//получение вытаскиваемого блока
		$('.elements-list .section').hover(function() {
			window.new_block = this;
			window.new_block_id = $(this).attr("id");
		});
	});



//////////СКРОЛЛИНГ СТРАНИЦ///////////////////////////////////////////////////
	
//////////МЕНЮ РЕДАКТИРОВАНИЯ СТРАНИЦЫ///////////////////////////////////////////////////
	$(document).ready(function() {

      let menu_flag = 0;
      let sorts = ['.grid-page-sortable-zone','.grid-column-sortable-zone'];

	  let widthScreen = $(window).width();
	  widthScreen = widthScreen - 285;

      $('.editBtn').click(function() { 
        if(menu_flag === 0){
            $('.grid-edit-panel').animate({  right: '0px' }, 200);
            $('.grid-edit-btn').animate({ right: '210px' }, 200);
             $('body').css("width",widthScreen);

            menu_flag = 1;

            $('.grid-column, .grid-element-unit').addClass('grid-element-editable');
            //делаем сортбельными
            makeThemSortable(sorts);

	    }else{
            menu_flag = 0;

            $('.grid-edit-panel').animate({ right: '-210px' }, 200);
            $('.editBtn').animate({  right: '0px' }, 200);
            $('body').css("width",$(window).width());

            $('.grid-column, .grid-element-unit').removeClass('grid-element-editable');
            //делаем НЕ сортбельными
            makeThemNotSortable(sorts);

		 }
    });
});


document.querySelector("body").onclick = function() {
    gridElementDelete();
    gridColumnCreate();

    gridElementsSave();

};


</script>
