# -----------MAGAZINE-----------
## Установка:
  1. Скачать архив с папкой magazine
  2. Переместить (скопировать) папку magazine на web-сервер. (У меня сборка xampp, поэтому мой путь: C:\xampp\htdocs)
  3. Умирать от глазовыдирательницы
  
## Защита:
  Все запросы, передачи (XSS атаки, SQL Injection) защищены приведением типов, экранированием и регулярными выражениями.
  
```php
  /* getProducts.php */
  $query = 'SELECT c.category_id,
                     c.name as category_name,
                     c.url
                FROM products as p
           LEFT JOIN `products/category` as pc
                  ON pc.product_id = p.product_id
           LEFT JOIN category as c
                  ON c.category_id = pc.category_id
               WHERE p.product_id =' . intval($_GET['p_id']); // Запрос на категории
```

```php
   /* validation.php */
   if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $name = trim($name);
            preg_match('/([аА-яЯёЁ]{1,32}|[aA-zZ]{1,32})/mu', $name, $res);
   ....
```


## Запросы
  Первый запрос: Составить sql запрос, который выведет все категории, даже с
                 количеством товаров 0, но с указанием количества товара для каждой
                 категории, как и в оригинальном задании.
                 
```sql
    SELECT c.category_id,
           c.name as category_name,
           count(pc.category_id) as products_count,
           c.url
      FROM category as c
      LEFT JOIN `products/category` as pc
        ON pc.category_id = c.category_id
      LEFT JOIN products as p
        ON pc.product_id = p.product_id
     GROUP BY c.name
     ORDER BY products_count DESC
```     
  Второй запрос: Составить sql запрос, который выведет все категории товаров с
                 указанием количество товаров, имеющих количество товаров больше
                 либо равно 2.
                 
```sql
    SELECT c.category_id,
           c.name as category_name,
           count(pc.category_id) as products_count,
           c.url
      FROM category as c
      LEFT JOIN `products/category` as pc
        ON pc.category_id = c.category_id
      LEFT JOIN products as p
        ON pc.product_id = p.product_id
     GROUP BY c.name
    HAVING products_count > 2
     ORDER BY products_count DESC
```
     