            <section class="sectionOne">
                <div class="sectionOneImg">
                    <div class="sectionOne__block">
                        <div class="sectionOne__block--title">
                            <h1>
                                ВСЁ САМОЕ ЛУЧШЕЕ, ЭТО КРУГЛОЕ
                            </h1>
                        </div>
                        <div class="sectionOne__block--button --red">
                            <button class="--red">
                            <?php if(isset($_COOKIE['user'])): ?>
                                <a href="./pageView.php?id=roulette.php">РУЛЕТКА</a>
                            <?php else: ?>
                                <a href="./pageView.php?id=auth.php">РУЛЕТКА</a>
                            <?php endif; ?>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="sectionTwo">
                <div class="sectionTwoImg">
                    <div class="sectionTwo__block">
                        <div class="sectionTwo__block--one">
                            <img class="sectionTwo__block--one-img" src="img/sectionTwoPizza.png" alt="">
                        </div>
                        <div class="sectionTwo__block--two">
                            <div style="width: 500px;">
                                <h1>
                                    Накормите зверя праздничной пиццей
                                </h1>
                            </div>
                            <div style="grid-column-start: 1; grid-row-start: 2; grid-row-end: 4; display: flex;justify-content: space-evenly;align-items: flex-start;flex-direction:column;padding-bottom: 20px;">
                                <img src="img/oil.png" alt="">
                                <p style="font-size: 24px; font-weight: bold;">
                                    Итальянские масла
                                </p>
                                <p>
                                    Отборные итальянские масла из отборных оливок.
                                </p>
                            </div>
                            <div style="grid-column-start: 2; grid-row-start: 3; grid-row-end: 5; display: flex;justify-content: space-evenly;align-items: flex-start;flex-direction:column;padding-bottom: 20px;">
                                <img src="img/tomato.png" alt="">
                                <p style="font-size: 24px; font-weight: bold;">
                                    Томаты
                                </p>
                                <p>
                                    Самое главное в пицце, это свежие томаты!
                                </p>
                            </div>
                            <div style="grid-column-start: 1; grid-row-start: 4; grid-row-end: 6; display: flex;justify-content: space-evenly;align-items: flex-start;flex-direction:column;padding-bottom: 20px;">
                                <img src="img/shrimp.png" alt="">
                                <p style="font-size: 24px; font-weight: bold;">
                                    Свежие продукты
                                </p>
                                <p>
                                    Все самое свежее и отборное, для великопных пицц и их любителей.
                                </p>
                            </div>
                            <div style="grid-column-start: 2; grid-row-start: 5; grid-row-end: 7; display: flex;justify-content: space-evenly;align-items: flex-start;flex-direction:column;padding-bottom: 20px;">
                                <img src="img/like.png" alt="">
                                <p style="font-size: 24px; font-weight: bold;">
                                    Лучшие мастера
                                </p>
                                <p>
                                    Нашим мастерам завидуют все итальяские мафиози.
                                </p>
                            </div>
                        </div>
                        <div class="sectionTwo__block--three">
                            <div class="sectionTwo__block--three__blockOne">
                                <h1>
                                    ПИЦЦА С ОТЛИЧНЫМ ВКУСОМ
                                </h1>
                                <p>
                                    Выберите свою любимую пиццу из списка великолепных пицц.
                                </p>
                                <div>
                                    <button class="bttn_prev">
                                        <img src="img/prev.svg" alt="Previous">
                                    </button>
                                    <button class="bttn_next">
                                        <img src="img/next.svg" alt="Next">
                                    </button>
                                </div>
                            </div>
                            <div class="sectionTwo__block--three__wrapper">
                                <div class="sectionTwo__block--three__container" id="sliderContainer">
                                    <?php if($items != NULL):?>
                                        <?php foreach($items as $item):?>
                                            <?=renderTemplate('templates/item.php', ['item' => $item]);?>
                                        <?php endforeach; ?>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="sectionThree">
                <div class="tickers">
                    <div class="ticker">
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                    </div>
                  </div>
            </section>
            <section class="sectionFour">
                <div class="sectionFour__block">
                    <img class="sectionFour__block-img" style="border-right: 2px solid #B72A23;" src="img/pizzaLeft.png" alt="">
                    <div class="sectionFour__block--center">
                        <h1>
                            ЗАКАЗЫВАЙТЕ СЕЙЧАС
                        </h1>
                        <p>
                            Нам доверяют не только наши клиенты, но и их родители, дети и их животики.
                        </p>
                        <button class="--red" href="./menu.php">
                            ЗАКАЗАТЬ
                        </button>
                    </div>
                    <img class="sectionFour__block-img" style="border-left: 2px solid #B72A23;" src="img/pizzaRight.png" alt="">
                </div>
            </section>
            <section class="sectionFive">
                <div class="sectionFive__block">
                    <img src="img/fiveLeft.png" alt="">
                    <div class="sectionFive__block--center">
                        <div>
                            <h1>ЗАКАЗЫВАЙТЕ ЛУЧШУЮ ПИЦЦУ</h1>
                        </div>
                        <div class="sectionFive__block--center--blockTwo">
                            <div class="sectionFive__block--center--blockTwo__col one-col">
                                <?php if($items != NULL):?>
                                    <?php foreach($items as $item):?>
                                        <?=renderTemplate('templates/item-desc.php', ['item' => $item]);?>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </div>
                        </div>
                        <div style="display: flex;align-items: center;">
                            <button class="--red">
                                ЗАКАЗАТЬ
                            </button>
                        </div>
                    </div>
                    <img src="img/fiveRight.png" alt="">
                </div>
            </section>
            <section class="sectionSix">
                <div class="sectionSix__block">
                    <img style=" width: 100%;border-right: 2px solid #B72A23; border-bottom: 2px solid #B72A23;" src="img/sixOne.png" alt="">
                    <div class="six-one">
                        <h1>
                            Заказывайте наши лучшие пиццы
                        </h1>
                        <p>
                            Если вы не можете определиться, чем же порадовать себя сегодня, то представляем вам список лучших пицц!
                        </p>
                        <div class="sectionSix__block-ul">
                            <ul>
                                <li>
                                    Пепперони
                                </li>
                                <li>
                                    Диабло
                                </li>
                                <li>
                                    Маргарита
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    Маргарита
                                </li>
                                <li>
                                    Пепперони
                                </li>
                                <li>
                                    Диабло
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="six-two">
                        <h1>
                            Перекусите в нашем заведении.
                        </h1>
                        <p>
                            Так же, вы можете поесть и у нас на улице, сидя за столиком, наблюдать прекрасное.
                        </p>
                        <button class="--red">
                            ЗАКАЗАТЬ
                        </button>
                    </div>
                    <img style="width: 100%;border-left: 2px solid #B72A23; border-top: 2px solid #B72A23;" src="img/sixFour.png" alt="">
                </div>
            </section>
            <section class="sectionSeven">
                <div class="sectionSeven__block">
                    <img style="border-radius: 10px;" src="img/sevenOne.png" alt="">
                    <img style="border-radius: 10px;" src="img/sevenTwo.png" alt="">
                    <img style="border-radius: 10px;" src="img/sevenThree.png" alt="">
                    <img style="border-radius: 10px;" src="img/sevenFour.png" alt="">
                    <img style="border-radius: 10px;" src="img/sevenFive.png" alt="">
                </div>
            </section>
            <section class="sectionEight">
                <div class="tickers" style="background-color: #B72A23;">
                    <div class="ticker" style="color: #FFFFFF;">
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                      <h1 class="ticker__head">МЫ ЛЮБИМ ФАСТФУД*МЫ ЛЮБИМ ПИЦЦУ*</h1>
                    </div>
                  </div>
            </section>
