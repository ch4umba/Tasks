# Tasks
# -----------MAGAZINE-----------
# Установка:
  1. Скачать архив с папкой magazine
  2. Переместить (скопировать) папку magazine на web-сервер. (У меня сборка xampp, поэтому мой путь: C:\xampp\htdocs)
  3. Умирать от глазовыдирательницы
  
# Защита:
  Все запросы, передачи по GET (XSS атаки, SQL Injection) защищены приведением типов, 
  так как я использую лишь int значения, подставить в запрос какие либо символы, кроме цифр, невозможно: 
  
  $query = 'SELECT c.category_id,
                   c.name as category_name,
                   c.url
              FROM products as p
              LEFT JOIN `products/category` as pc
                ON pc.product_id = p.product_id
              LEFT JOIN category as c
                ON c.category_id = pc.category_id
             WHERE p.product_id =' . intval($_GET['p_id']);





