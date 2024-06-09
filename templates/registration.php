      <div class="auth_block">
        <div class="auth_block_content">
          <p>Регистрация</p>
          <form class="auth_block_form" action="./templates/phpscripts/registration.php" method="post">
            <label>Введите имя пользователя</label>
            <input type="text" name="reg_username" placeholder="Введите имя пользователя" required >
            <label>Введите Ваш пароль</label>
            <input type="password" name="reg_pass" placeholder="Введите пароль" required >
            <button class="--red" type="submit" name="form_auth_submit">Зарегистрироваться</button>
          </form>
          <?php
              if(isset($_COOKIE['error'])):
          ?>
              <p><?=$_COOKIE['error']?></p>
          <?php
              endif;
          ?>
        </div>
      </div>
      <style>
        header{
          position:inherit;
        }
      </style>