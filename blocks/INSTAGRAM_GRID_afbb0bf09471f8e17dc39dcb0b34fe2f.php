
<?// include ($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>
<style>
    .insta_grid{
        display: grid;
        grid-gap: 0;
        grid-template-columns: repeat(12, 1fr);
        grid-template-areas:
                "c1 c1 c1 c1 c1 c1 c1 c1 c2 c2 c2 c2"
                "c3 c3 c3 c4 c4 c4 c4 c4 c4 c4 c4 c4"
                "c3 c3 c3 c5 c5 c5 c5 c5 c6 c6 c6 c6"
                "c7 c7 c7 c7 c7 c7 c7 c7 c6 c6 c6 c6"
                "c8 c8 c8 c8 c9 c9 c9 c9 c9 c9 c9 c9";
    }
    .insta_grid div{
        background-position: top center !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
        height: 100%;
        box-sizing: border-box;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .insta_grid div a{
        color :white;
        font-size: 35px;
        font-weight: bold;
    }

    .item1 {
        grid-area: c1;
    }
    .item2 {
        grid-area: c2;
    }
    .item3 {
        grid-area: c3;
    }
    .item4 {
        grid-area: c4;
    }
    .item5 {
        grid-area: c5;
    }
    .item6 {
        grid-area: c6;
    }
    .item7 {
        grid-area: c7;
    }
    .item8 {
        grid-area: c8;
    }
    .item9 {
        grid-area: c9;
    }
</style>

<div class='insta_grid'>
    <? $insta = new Bitkit\Social\Instagram($media_src['instagram']);
    for ($x=1; $x < 10; $x++) { ?>
        <div class='item<?=$x?>' style='background: url("<?=$insta->getProfilePostImage($x)?>");'>
            <a href='<?=$insta->getLink()?>' target='_blank'> Instagram</a>
        </div>
    <?}
    ?>
</div>
