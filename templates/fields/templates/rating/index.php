<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="star-rating">
    <div class="star-rating__wrap">
        <?php
        $rating = new Post(0);
        $rating->getTable('rating_points');
        foreach ($rating->getAllUnitsReverse() as $raiting_unit){?>
            <input <?=($post->rating() == $raiting_unit['id'])? 'checked' : ''?> class="star-rating__input" id="star-rating-<?=$raiting_unit['id']?>" type="radio" name="rating" value="<?=$raiting_unit['id']?>">
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-<?=$raiting_unit['id']?>" title="<?=$raiting_unit['title']?>"></label>
        <?}?>
    </div>
</div>