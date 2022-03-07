<?php
    
function showCards($result) {
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result); 
            echo '<a href=/magazine/scripts/product.php?' . 'p_id=' . $row["product_id"] . "&c_id=" . intval($_GET['c_id']) .
                '><div class="card">' .
                '<div class="card__image">' .
                    '<img class="card__image" src="/magazine/img/'. $row["photo_url"] .'"' . ' alt="' . $row["alt_name"] . '">' .
                '</div>' .
                '<span class="card__category">'. $row["category_name"] .'</span><br>' .
                '<span class="card__name">' . $row["name"] . '</span>' .
            '</div></a>';
        }
}

function redirecting($link) {
    return '/magazine/';
}

function getProducts() {
    $start = (intval($_GET['p']) - 1) * 12;
    $end = intval($_GET['p']) * 12;
    return "SELECT p.product_id,
                     p.name,
                     cc.name as category_name,
                     cc.url as main_url,
                     ph.photo_url,
                     c.name as h,
                     p.url as product_url,
                     ph.alt_name
                FROM products as p
                LEFT JOIN photos as ph
                  ON ph.photo_id = p.main_photo_id
                LEFT JOIN `products/category` as pc
                  ON pc.product_id = p.product_id
                LEFT JOIN category as c
                  ON c.category_id = pc.category_id
                LEFT JOIN category as cc
                  ON cc.category_id = p.main_category_id
               WHERE p.is_active = 1 
                 AND c.category_id = " . intval($_GET["c_id"]) . 
              ' LIMIT ' . $start . ', ' . $end;
}

function clickMinusButton() {
    $value = intval($_GET["p"]);
    $value--;
    if ($value < 1) {
        $value = 1;
    }
    $str = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    for ($i = strlen($str) - 1; $str[$i] != '='; $i--) {
       $str = substr($str, 0, -1);
    }
    return $str . strval($value);
}

function clickPlusButton() {
    $value = intval($_GET["p"]);
    $value++;
    $str = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    for ($i = strlen($str) - 1; $str[$i] != '='; $i--) {
       $str = substr($str, 0, -1);
    }
    return $str . strval($value);
}

    $hostname="localhost";
	$username="root";
	$password="";
	$dbname="mydb";
    $link = mysqli_connect($hostname,$username, $password, $dbname);
    if (!$link) {
        die('Не удалось соединиться : ' . mysql_error());
    }
    
    $qh = "SELECT name,
                  url
             FROM category
            WHERE category_id = " . intval($_GET['c_id']);
    $rh = mysqli_query($link, $qh);
    $rh = mysqli_fetch_array($rh);
    $result = mysqli_query($link, getProducts());
?>