<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Magazine catalogue</title>
    <link href="/magazine/styles/style_main.css" rel="stylesheet" type="text/css">
    <link href="/magazine/styles/catalogue.css" rel="stylesheet" type="text/css">
  </head>
    <body>
        <div class="layout">
            <header>
            <?php include $_SERVER["DOCUMENT_ROOT"] . "/magazine/template/header.html" ?>
            </header>
            <div class="cards">
                <h1 class="cards__page-title">Каталог товаров</h1>
                <?php include $_SERVER["DOCUMENT_ROOT"] . "/magazine/scripts/getCategories.php";?>
            </div>
        </div>
    </body>
</html> 