<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans:ital,wght@0,1..1000;1,1..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Pattaya&display=swap" rel="stylesheet">
</head>
<body>
    
    <header>
        <?= $header; ?>
    </header>
    <main>
        <?= $content; ?>
    </main>
    <footer>
            <div class="footer__block" id="contacts">
                <div style="display: flex;flex-direction: column;justify-content: space-evenly;height: 100%;">
                    <p style="font-size: 24px; font-weight:bold;">
                        Get In Touch
                    </p>
                    <p>
                        +012-345-6789
                    </p>
                    <p>
                        Pizzalicious@contact.com
                    </p>
                    <p>
                        9889 lorem ipsum street, Pellentesque, CA, USA
                    </p>
                </div>
                <div class="footer__block--time">
                    <img src="img/PizzaliciousFooter.png" alt="">
                </div>
                <div style="display: flex;flex-direction: column;justify-content: space-evenly;height: 100%;">
                    <p style="font-size: 24px; font-weight:bold;">
                        Opening Hours
                    </p>
                    <p>
                        Monday/Friday 9:00-23:00
                    </p>
                    <p>
                        Saturday 10:00-21:00
                    </p>
                    <p>
                        Weekend Closed
                    </p>
                </div>
            </div>
    </footer>
    <script>
        var sliderContainer = document.getElementById('sliderContainer');

        var sliderItems = document.querySelectorAll('.sectionTwo__block--three__container .sectionTwo__block--three__card');

        var prevButton = document.querySelector('.bttn_prev');
        var nextButton = document.querySelector('.bttn_next');

        var maxSlides = 4;
        var slideIndex = 0;

        function nextSlide() {
            if (slideIndex < maxSlides - 1) {
                slideIndex++;
                slide();
            }
        }

        function prevSlide() {
            if (slideIndex > 0) {
                slideIndex--;
                slide();
            }
        }

        function slide() {
            var translateValue = -(434 * slideIndex) + 'px';
            sliderContainer.style.transition = 'transform 0.5s ease-in-out';
            sliderContainer.style.transform = 'translateX(' + translateValue + ')';
        }

        prevButton.addEventListener('click', prevSlide);
        nextButton.addEventListener('click', nextSlide);

        if (sliderItems.length < maxSlides) {
            var moreItemsButton = document.createElement('button');
            moreItemsButton.className = 'sectionTwo__block--three__card';
            moreItemsButton.textContent = 'Больше товаров';
            sliderContainer.appendChild(moreItemsButton);
        }
    </script>
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var modal = $('#productModal');
    var span = $('.close');

    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    $('.card_img_link, .descript_link, .price_button_link, .name_link, .desc_link').on('click', function(event) {
        event.preventDefault();
        var productId = $(this).data('id');

        $.ajax({
            url: './itemView.php',
            type: 'GET',
            data: { id: productId },
            success: function(response) {
                $('#modal-body').html(response);
                modal.show();
                var scrollbarWidth = getScrollbarWidth();
                $('body').addClass('no-scroll').css('padding-right', scrollbarWidth + 'px'); // Disable scrolling and add padding
            },
            error: function() {
                alert('Ошибка загрузки данных товара.');
            }
        });
    });

    span.on('click', function() {
        modal.hide();
        $('body').removeClass('no-scroll').css('padding-right', ''); // Enable scrolling and remove padding
    });

    $(window).on('click', function(event) {
        if (event.target == modal[0]) {
            modal.hide();
            $('body').removeClass('no-scroll').css('padding-right', ''); // Enable scrolling and remove padding
        }
    });
});
</script>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            var priceButtons = document.querySelectorAll('.price_button');

            priceButtons.forEach(function(button) {
                var originalText = button.textContent;

                button.addEventListener('mouseover', function() {
                    button.textContent = "+ Добавить в корзину";
                });

                button.addEventListener('mouseout', function() {
                    button.textContent = originalText;
                });
            });
        });
    </script>
    <script>
        document.getElementById('burgerMenu').addEventListener('click', function() {
    var nav = document.getElementById('mobileNav');
    if (nav.style.display === 'flex') {
        nav.style.display = 'none';
    } else {
        nav.style.display = 'flex';
    }
});
    </script>
    <script>
    $(document).ready(function() {
        $('#user-link').on('click', function(event) {
            event.preventDefault();

            // Проверяем, уже загружено ли меню
            if ($('#user-block').length === 0) {
                $.ajax({
                    url: 'templates/user.php',
                    method: 'GET',
                    success: function(response) {
                        $('#user-block-container').html(response);
                        $('#user-block').show();
                    }
                });
            } else {
                $('#user-block').toggle();
            }
        });

        // Закрытие выпадающего меню при клике вне его
        $(window).on('click', function(event) {
            if (!$(event.target).closest('#user-link, #user-block').length) {
                $('#user-block').hide();
            }
        });
    });
</script>
<script>
function updateQuantity(quantity, product_id, user_id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);  // Отправка запроса на тот же файл
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Quantity updated');
        } else {
            console.log('Error updating quantity');
        }
    };
    xhr.send("quantity=" + quantity + "&product_id=" + product_id + "&user_id=" + user_id);
}
</script>
<script src="./js/roulette.js"></script>
</body>
</html>