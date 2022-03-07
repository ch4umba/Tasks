<?php
        
    $hostname="localhost"; // Не думаю, что тут комментарии нужны, просто вывод карточек
	$username="root";
	$password="";
	$dbname="mydb";
    $link = mysqli_connect($hostname,$username, $password, $dbname);
    if (!$link) {
        die('Не удалось соединиться : ' . mysql_error());
    }
    $query = "SELECT c.category_id,
                     c.name as category_name,
                     count(c.name) as products_count,
                     c.url
                FROM category as c
               RIGHT JOIN `products/category` as pc
                  ON pc.category_id = c.category_id
               RIGHT JOIN products as p
                  ON pc.product_id = p.product_id
               GROUP BY c.name
               ORDER BY products_count DESC";

    $result = mysqli_query($link, $query);
    
    if ($result == false) {
        print("Произошла ошибка при выполнении запроса"); 
    }
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_array($result);
        echo '<div class="cards__item"><a href="' . "/magazine/scripts/category.php?c_id=" . $row["category_id"] . "&p=1" . '">' . $row['category_name'] 
            . '(' . $row['products_count'] . ')' . '</a></div>';
    }
?>