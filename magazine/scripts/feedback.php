<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Magazine catalogue</title>
    <link href="/magazine/styles/style_main.css" rel="stylesheet" type="text/css">
    <link href="/magazine/styles/feedback.css" rel="stylesheet" type="text/css">
  </head>
    <body>
        <div class="layout">
            <header>
            <?php
                include $_SERVER["DOCUMENT_ROOT"] . "/magazine/template/header.html";
                include $_SERVER["DOCUMENT_ROOT"] . "/magazine/scripts/validation.php";
                validation();
            ?>
            </header>
            <div class="feedback">
                <h1 class="cards__page-title">Обратная связь</h1>
                <form action="//localhost/magazine/scripts/feedback.php" method="POST">
                <div class="feedback__name">
                    <span class="error"><?php echo getError($GLOBALS['cn'], 0) ?></span>
                    <span class="tab">Имя:</span>
                    <input type="text" name="name" value='<?php echo htmlspecialchars(getStrToInput('name')); ?>' style='<?php echo $GLOBALS['cn'] ?>'>
                </div>
                <div class="feedback__email">
                     <span class="error"><?php echo getError($GLOBALS['ce'], 1) ?></span>
                    <span class="tab">email:</span>
                    <input type="text" name="email" value='<?php echo htmlspecialchars(getStrToInput('email')); ?>' style='<?php echo $GLOBALS['ce'] ?>'>
                </div>
                
                <div class="feedback__birth">
                     <span class="error"><?php echo getError($GLOBALS['cb'], 2) ?></span>
                    <span class="tab">Birthday:</span>
                    <select name="birth" style='<?php echo $GLOBALS['cb'] ?>'>
                        <option <?php echo selected(getVar("birth"), 0); ?> value="0"></option>
                        <option <?php echo selected(getVar("birth"), 2001); ?> value="2001">2001</option>
                        <option <?php echo selected(getVar("birth"), 1978); ?> value="1978">1978</option>
                        <option <?php echo selected(getVar("birth"), 1993); ?> value="1993">1993</option>
                        <option <?php echo selected(getVar("birth"), 1987); ?> value="1987">1987</option>
                    </select>
                </div>
                <div class="feedback__sex">
                     <span class="error"><?php echo getErrorInput('sex', 3)?></span>
                    <span class="tab">Пол:</span>
                    <input name="sex" type="radio" value="male" <?php echo checked(getVar("sex"), "male"); ?>> М
                    <input name="sex" type="radio" value="female" <?php echo checked(getVar("sex"), "female")    ; ?>> Ж
                </div>
                <div class="feedback__topic">
                     <span class="error"><?php echo getError($GLOBALS['ct'], 4) ?></span>
                    <span class="tab">Тема обращения:</span>
                    <input type="text" name ="topic" value='<?php echo htmlspecialchars(getPostValue('topic')); ?>' style='<?php echo $GLOBALS['ct'] ?>'>
                </div>
                <div class="feedback__text">
                     <span class="error"><?php echo getError($GLOBALS['cc'], 5) ?></span>
                    <span class="tab">Текст:</span>
                    <textarea name="comment" rows="10" cols="50" style='<?php echo $GLOBALS['cc'] ?>'><?php echo htmlspecialchars(getPostValue('comment')); ?></textarea>
                </div>
                <div class="feedback__agreement">
                    <span class="error"><?php echo getErrorInput('agree', 6)?></span>
                    <span>C контрактом ознакомлен</span>
                    <input type="checkbox" name="agree">
                </div>
                <div class="feedback__submit">
                    <input type="submit" name="accept" value="Отправить">
                </div>
            </form>
          </div>
        </div>
    </body>
</html> 