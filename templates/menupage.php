<section class="sectionMenu">
                <div class="sectionMenu__block">
                    <img src="img/fiveLeft.png" alt="">
                    <div class="sectionMenu__block--center">
                        <div>
                            <p>ORDER BEST PIZZA</p>
                        </div>
                        <div>
                            <div class="sectionMenu__block--center--blockTwo__col">
                                    <?php if($items != NULL):?>
                                        <?php foreach($items as $item):?>
                                            <?=renderTemplate('templates/item-menu.php', ['item' => $item]);?>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                            </div>
                        </div>
                        <div>
                            <button class="--red">
                                ORDER NOW
                            </button>
                        </div>
                    </div>
                    <img src="img/fiveRight.png" alt="">
                </div>
</section>