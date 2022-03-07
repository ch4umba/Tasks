<?php

function setPhoto($main_photo, $alt, $photos, $alts) {  
    $main_dir = '/magazine/img/' . $main_photo;
    echo '<img src=\'' . $main_dir . '\' alt=\'' . $alt . '\' onmouseover="setZoomImage(\'zoom\', \'' . $main_dir . '\')"/>';
    for ($i = 0; $i < count($photos); $i++) {
        $dir = '/img/' . $photos[$i];
        echo '<img src=\'' . $dir . '\' alt=\'' . $alts[$i] . '\' onmouseover="setZoomImage(\'zoom\', ' . '\'' . $dir . '\')"/>';
    }
}

function redirecting($link) {
    $qh = "SELECT name,
              url
         FROM category
        WHERE category_id = " . intval($_GET['c_id']);
    $rh = mysqli_query($link, $qh);
    $rh = mysqli_fetch_array($rh);
    return '/magazine/scripts/category.php' . '?c_id=' . intval($_GET['c_id']) . '&p=1';
}

function connectToDB($hostname, $username, $password, $dbname) {
    $link = mysqli_connect($hostname,$username, $password, $dbname);
    if (!$link) {
        die('Не удалось соединиться : ' . mysql_error());
    }
    return $link;
}

function setCategory ($category, $url, $c_id) {
    for ($i = 0; $i < count($category); $i++) {
        $dir = '/magazine/catalogue/' . $url[$i] . '?c_id=' . $c_id[$i] . '&p=1';
        echo '<li><a href ="' . $dir . '">' . $category[$i] . '</a></li>';
    }
}


    $link = connectToDB("localhost", "root", "", "mydb");
    $query = 'SELECT p.product_id,
                     p.name,
	                 p.price,
                     p.price_sale,
                     p.price_old,
                     p.description,
                     p.main_category_id,
                     ph.photo_url as main_photo,
                     ph.alt_name as alt
                FROM products as p
                LEFT JOIN photos as ph
	              ON ph.photo_id = p.main_photo_id
               WHERE p.product_id = ' . intval($_GET["p_id"]);
    $result = mysqli_query($link, $query);

    if ($result == false) {
        print("Произошла ошибка при выполнении взятия основной информации");
    } else {
    $row = mysqli_fetch_array($result);
    $price = $row["price"];
    $price_old = $row["price_old"];
    $price_sale = $row["price_sale"];
    $description = $row["description"];
    $name = $row["name"];
    $mp = $row["main_photo"];
    $alt = $row["alt"];
    $pid = $row['product_id'];
    $cid = $row['main_category_id'];
    }

    $query = 'SELECT ph.photo_url,
                     ph.alt_name
                FROM products as p
           LEFT JOIN `products/photos` as pph
                  ON pph.product_id = p.product_id
           LEFT JOIN photos as ph
                  ON ph.photo_id = pph.photo_id
               WHERE p.main_photo_id != ph.photo_id
                 AND p.product_id = ' . intval($_GET["p_id"]);
    $result = mysqli_query($link, $query);
    $photos = array();
    $alts = array();
    if ($result == false) {
        print("Произошла ошибка при выполнении взятия картинок");
    } else { 
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result);
            array_push($photos, $row["photo_url"]);
            array_push($alts, $row["alt_name"]);
        }
    }

    $query = 'SELECT c.category_id,
                     c.name as category_name,
                     c.url
                FROM products as p
           LEFT JOIN `products/category` as pc
                  ON pc.product_id = p.product_id
           LEFT JOIN category as c
                  ON c.category_id = pc.category_id
               WHERE p.product_id =' . intval($_GET['p_id']);
    
    $result = mysqli_query($link, $query);

    
    if ($result == false) {
        print("Произошла ошибка при выполнении взятия категорий");
    } else {
        $category = array();
        $url = array();
        $c_id = array();
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_array($result);
            array_push($category, $row["category_name"]);
            array_push($url, $row["url"]);
            array_push($c_id, $row["category_id"]);
        }
    }
?>