     <div class="auth_block">
        <div class="auth_block_content">
          <p>Авторизация</p>
          <form class="auth_block_form" action="./templates/phpscripts/authorization.php" method="post">
            <label>Введите имя пользователя</label>
            <input type="text" name="auth_username" placeholder="Введите имя пользователя" required >
            <label>Введите Ваш пароль</label>
            <input type="password" name="auth_pass" placeholder="Введите пароль" required >
            <button class="--red" type="submit" name="form_auth_submit">Войти</button>
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
        header {
        position: inherit;
        }
      </style>
      