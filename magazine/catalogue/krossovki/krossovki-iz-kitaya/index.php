<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <link href="/styles/style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="/scripts/notify.js"></script>
    <script src="/scripts/zoom.js"></script>
    <?php
      $dir = basename(__DIR__);
      include $_SERVER['DOCUMENT_ROOT'] . "/scripts/getInformation.php" 
          
      ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            let buttonPlus = document.getElementById("buttonPlus");
            let buttonMinus = document.getElementById("buttonMinus");
            let count = document.getElementById("textCounter");
            let buttonBuy = document.getElementById("buttonBuy");
            let number = 1;

            buttonPlus.onclick = function() {
                if (number == 1) {
                        $('.button__counter-minus').css('color', 'black');
                        buttonMinus.disabled = false;
                    }
                number++;
                count.innerHTML = number;
            }
            
            buttonMinus.onclick = function() {
                number--;
                count.innerHTML = number;
                if (number == 1) {
                    $('.button__counter-minus').css('color', 'gray');
                    buttonMinus.disabled = true;
                }
            }
            
            buttonBuy.onclick = function() {
                var inBasket = "В корзину добавлено " + number + " товаров(-а)!";
                $.notify(inBasket, {
                    globalPosition: "top right",
                    className: "success"
                });
            }
        });
      </script>
    <title>Trial assignments</title>
  </head>
  <body>
      <div class="layout">
          <div class="product">
          <div class="product__preview">
              <div class="group__picture">
                    <?php setPhoto($mp, $alt, $photos, $alts); ?>
              </div>
              <div class="zoom__picture">
                  <img src='<?php echo '/img/' . $mp ?>' alt='<?php echo $alt ?>' id="zoom"/> 
            </div>
          </div>
          <div class="product__description">
           <h2><?php  echo $name ?></h2>
           <div class="product__tags">
            <ul>
             <?php setCategory($category, $url, $c_id); ?>
            </ul>
           </div>
           <div class="product__price">
              <div class="product__price-actual">
                  <span class="product__price-old"><?php  echo $price_old ?></span>
                  <span class="product__price-new price"><?php  echo $price ?></span>
               </div>
              <div class="product__price-discount">
                  <span class="product__price-discount-cost price"><?php  echo $price_sale ?></span>
                  <span class="product__price-discount-text">- с промокодом</span>
               </div>
           </div>
           <div class="product__info">
               <div class="product__info-item">
                   <img src="/logo/accept.png" alt="#"/>
                    В наличии в магазине<a href="#">Lamoda </a>
               </div>
               <div class="product__info-item">
                   <img src="/logo/delivery.png" alt="#"/>
                   Бесплатная доставка
               </div>
           </div>
              <div class="button__counter">
                   <input type="button" class="button__counter-minus" id="buttonMinus" disabled value="-">
                   <span class="text__counter" id="textCounter">1</span>
                   <input type="button" class="button__counter-plus" id="buttonPlus" value="+">
               </div>
           <div class="product__action">
               <button class="action__button action__button_blue" id="buttonBuy">Купить</button>
               <button class="action__button">в избранное</button>
              </div>
              <div class ="product__text">
              <p><?php  echo $description ?>
             </p>
          </div>
              <div class="product__share">
                  <span class="product__share-title">Поделиться:</span>
                  <div class="product__share-list">
                      <a href="#">
                          <img src="/logo/vk.png" alt="vk">
                      </a>
                      <a href="#">
                          <img src="/logo/facebook.png" alt="fb">
                      </a>
                      <a href="#">
                          <img src="/logo/google.png" alt="google">
                      </a>
                  </div>
                  <div id="product__share-count">
                      <span class="product__share-count-text">123</span>
                  </div>
                </div>
          <div class="product__button-back">
              <form action="<?php echo redirecting($link) ?>" method="POST">
                 <input type="submit" class="button-back" name="back__button-file" value="Назад">
              </form>
          </div>
              </div>
          </div>
      </div>
  </body>
</html>