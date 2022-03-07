<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>TEST Magazine</title>
    <link href="/magazine/styles/style_main.css" rel="stylesheet" type="text/css">
      <link href="/magazine/styles/card_style.css" rel="stylesheet" type="text/css">
    <?php
      include $_SERVER['DOCUMENT_ROOT'] . "/magazine/scripts/getProducts.php";
      if (isset($_GET['p']) && $_GET['p'] <= 0) {
            header("Location: " . '//' . $_SERVER['HTTP_HOST'] . '/magazine/');
            exit ();
        }
      ?>
  </head>
    <body>
        <div class="layout">
            <header>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/magazine/template/header.html' ?>
            <h2 class="category__name"><?php echo $rh["name"] ?></h2>
            <div class="product__button-back">
              <form action="<?php echo redirecting($link) ?>" method="POST">
                 <input type="submit" class="button-back" name="back__button-file" value="Назад">
              </form>
            </div>
            </header>
            <?php
          $dir = basename(__DIR__);
          showCards($result); ?>
          <div class="button__counter">
           <a href='<?php echo clickMinusButton(); ?>'><input type="button" class="button__counter-minus" name="buttonMinus" value="-"></a>
           <a href='<?php echo clickPlusButton(); ?>'><input type="button" class="button__counter-plus" name="buttonPlus" value="+"></a>
         </div>
        </div>
    </body>
</html> 