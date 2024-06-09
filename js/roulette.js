$(document).ready(function() {
    initWheel();
 
    $('.roulette-bttn').on('click', function(){
        var outcome = Math.floor(Math.random() * 15);
        spinWheel(outcome);
    });
});

function initWheel(){
    var $wheel = $('.roulette-wrapper .wheel'),
        row = "";
      
    row += "<div class='row'>";
    row += "  <div class='card red'>5%<\/div>";
    row += "  <div class='card red'>25%<\/div>";
    row += "  <div class='card black'>ничего..<\/div>";
    row += "  <div class='card red'>5%<\/div>";
    row += "  <div class='card red'>20%<\/div>";
    row += "  <div class='card red'>5%<\/div>";
    row += "  <div class='card black'>ничего..<\/div>";
    row += "  <div class='card green'>Пепперони!<\/div>";
    row += "  <div class='card black'>ничего..<\/div>";
    row += "  <div class='card red'>5%<\/div>";
    row += "  <div class='card red'>10%<\/div>";
    row += "  <div class='card black'>ничего..<\/div>";
    row += "  <div class='card red'>5%<\/div>";
    row += "  <div class='card red'>15%<\/div>";
    row += "  <div class='card black'>ничего..<\/div>";
    row += "<\/div>";
  
    for(var x = 0; x < 29; x++){
        $wheel.append(row);
    }
}

function spinWheel(){
    var $wheel = $('.roulette-wrapper .wheel'),
        order = ['Пепперони!', 'ничего..', '5%', '10%', 'ничего..', '5%', '15%', 'ничего..', '5%', '25%', 'ничего..', '5%', '20%', '5%', 'ничего..'];
    
    $('.roulette-bttn').attr('disabled', 'disabled');
      
    var roll = Math.floor(Math.random() * order.length);
    var outcome = order[roll];
    var position = roll;
            
    var rows = 12,
        card = 135 + 3 * 2,
        landingPosition = (rows * 15 * card) + (position * card);
    
    var randomize = Math.floor(Math.random() * 135) - (135/2);
    
    landingPosition = landingPosition + randomize;
    
    var object = {
        x: Math.floor(Math.random() * 50) / 100,
        y: Math.floor(Math.random() * 20) / 100
    };
  
    $wheel.css({
        'transition-timing-function':'cubic-bezier(0,'+ object.x +','+ object.y + ',1)',
        'transition-duration':'6s',
        'transform':'translate3d(-'+landingPosition+'px, 0px, 0px)'
    });
  
    setTimeout(function(){
        $wheel.css({
            'transition-timing-function':'',
            'transition-duration':'',
        });
    
        var resetTo = -(position * card + randomize);
        $wheel.css('transform', 'translate3d('+resetTo+'px, 0px, 0px)');
      
        $('#prize').val(outcome);

        savePrize(outcome);
        displayMessage(outcome);

        $('.roulette-bttn').removeAttr('disabled');
    }, 6 * 1000);
}

function savePrize(prize) {
    var username = getCookie('user');

    $.ajax({
        url: './templates/phpscripts/saveprize.php',
        type: 'POST',
        data: {
            prize: prize,
            username: encodeURIComponent(username)
        },
        success: function(response) {
            console.log('Prize saved successfully: ' + response);
        },
        error: function(error) {
            console.error('Error saving prize: ' + error);
        }
    });
}

function displayMessage(prize) {
    var message = '';
    if (prize.includes('%')) {
        message = 'Поздравляем со скидкой ' + prize + ' к заказу!';
    } else if (prize === 'Пепперони!') {
        message = 'Ого! Да вы везунчик, держите бесплатную пиццу Пепперони к заказу!';
    } else {
        message = 'Увы, вам сегодня не повезло.. не расстраивайтесь!';
    }

    var prizeModalContent = '<div class="prizeModal-content">' +
                            '<span class="close">&times;</span>' +
                            '<p>' + message + '</p>' +
                        '</div>';

    // Создаем модальное окно
    var prizeModal = document.createElement('div');
    prizeModal.className = 'prizeModal';
    prizeModal.innerHTML = prizeModalContent;

    // Добавляем модальное окно на страницу
    document.body.appendChild(prizeModal);

    // Находим элемент для закрытия модального окна
    var closeButton = prizeModal.querySelector('.close');

    // Закрываем модальное окно при клике на кнопку закрытия или вне его
    closeButton.onclick = function() {
        prizeModal.style.display = 'none';
    };
    window.onclick = function(event) {
        if (event.target == prizeModal) {
            prizeModal.style.display = 'none';
        }
    };

    // Отображаем модальное окно
    prizeModal.style.display = 'block';
}

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}