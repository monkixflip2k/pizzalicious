<div class="sectionMenu__block--three__card">
    <a href="#" class="card_img_link" data-id="<?=$item['id'];?>">
        <img src="<?=$item['img_path']?>" alt="" class="card_img">
    </a>
    <a href="#" class="name_link" data-id="<?=$item['id'];?>">
    <p class="name">
        <?=$item['name'];?>
    </p>
    </a>
    <a href="#" class="descript_link" style="color: #000000;" data-id="<?=$item['id'];?>">
    <p class="descript">
        <?=truncateText($item['description']);?>
    </p>
    </a>
    <a href="#" class="price_button_link" data-id="<?=$item['id'];?>">
    <button style="cursor: pointer;" class="price_button">
        <?=$item['price'];?>₽
    </button>
    </a>
</div>
<style>
    .sectionMenu__block--three__card a{
        text-decoration: none;
    }
</style>