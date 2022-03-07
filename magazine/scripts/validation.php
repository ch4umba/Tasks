<?php

function getPostValue($v) { // Получаем наши данные, чтобы вставить их назад в форму, если они были
    return isset($_POST[$v]) ? $_POST[$v] : '';
}

function getStrToInput($v) { // Получим строки (подставим куки, если только зашли на страницу, иначе или форму, или пустую строку)
    if (isset($_POST['accept'])) {
        return getPostValue($v);
    } else if (isset($_COOKIE[$v])) {
        return $_COOKIE[$v];
    }
    return '';
}

function getVar($v) { // Получим переменную из select для вставки необходимого нам selected/checked
    if (isset($_COOKIE[$v])) {
        $field = $_COOKIE[$v];
    } else if (isset($_POST[$v])) {
	   $field = $_POST[$v];
    } else {
	   $field = 0;
    }
    return $field;
}

function checked($var, $value = null) // Выясняем, куда вставляем селект c помощью проверки через разбиение в массив
{
	if (is_null($value)) {
		return ($var) ? ' checked' : '';
	} else {
		if (!is_array($var)) {
			$var = explode(',', $var);
		}
 
		return (in_array($value, $var)) ? ' checked' : '';
	}
}

function selected($var, $value) { // Выясняем, куда вставляем селект c помощью проверки через разбиение в массив (тот же самый принцип)
	if (!is_array($var)) {
		$var = explode(',', $var);
	}
	return (in_array($value, $var)) ? ' selected' : '';
}

function getError($v, $errorIdx) { // Выведем ошибку, если поле не заполнено или заполнено неправильно (background говорит об этом из validation();)
    return ($v == 'background: white;' || $v == '') ? '' : $GLOBALS['error'][$errorIdx];
}

function getErrorInput($v, $errorIdx) { // Выводим строку с ошибкой, которая нам нужна
    #return (!isset($_POST[$v]) && isset($_POST['accept']))  ? '' : $GLOBALS['error'][$errorIdx]; Я чет не додумался должно выводить только при 0 1
    if (!isset($_POST['accept'])) {
        return '';
    } else if (!isset($_POST[$v])) {
        return $GLOBALS['error'][$errorIdx];
    }
    return '';
}

function validation () {
    $name = '';
    $email = '';
    $birth = '';
    $sex = '';
    $topic = '';
    $comment = '';
    
    if (isset($_POST['accept']) && $_POST['accept'] == 'Отправить') { // Проверяем, что запрос пошел
        if(isset($_POST['agree'])) { // Дальше идут проверки, заполнены ли формы, если какая-то не заполнена, выведем сообщение
            $GLOBALS['ca'] = 1;
        } else {
            $GLOBALS['ca'] = 0;
            $GLOBALS['flag'] = 1; // Флаг нужен для того, чтобы определить ошибку (0 в случае успеха (больше для дебага))
        }
        
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $name = trim($name);
            preg_match('/([аА-яЯёЁ]{1,32}|[aA-zZ]{1,32})/mu', $name, $res);
            if (count($res) > 0 && $res[0] == $name) {
                $GLOBALS['cn'] = 'background: white;';
            } else {
                $GLOBALS['cn'] = 'background: red;';
                $GLOBALS['flag'] = 2;
            }   
        }
        if (isset($_POST['email'])) {
            $email = $_POST["email"];
            $email = trim($email);
            preg_match('/^[a-zA-Z0-9_\-.]{3,32}@[a-zA-Z0-9\-]{1,32}\.[a-z]{1,16}$/m', $email, $res);
            if (count($res) > 0 && $res[0] == $email) {
                 $GLOBALS['ce'] = 'background: white;';
            } else {
                $GLOBALS['ce'] = 'background: red;';
                $GLOBALS['flag'] = 3;
            }   
        }
        if(isset($_POST['birth'])) {
            $birth = $_POST['birth'];
            $birth = trim($birth);
            preg_match('/^[0-9]{4}$/m', $birth, $res);
            if (count($res) > 0 && $res[0] == $birth) {
                $GLOBALS['cb'] = 'background: white;';
            } else {
                $GLOBALS['cb'] = 'background: red;';
                $GLOBALS['flag'] = 4;
            }
        }
        if(isset($_POST['sex'])) {
            $sex = $_POST['sex'];
            $sex = trim($sex);
            preg_match('/^f?e?(male)$/m', $sex, $res);
            if (count($res) > 0 && $res[0] == $sex) {
                $GLOBALS['cs'] = 1;
            } else {
                $GLOBALS['cs'] = 0;
                $GLOBALS['flag'] = 5;
            }
        }
        
        if(isset($_POST['topic'])) {
            $topic = $_POST['topic'];
            $topic = trim($topic);
            preg_match('/^[аА-яЯ0-9aA-zZ "\'\/*+-,.?!;:()]{1,64}$/mu', $topic, $res);
            if (count($res) > 0 && $res[0] == $topic) {
                $GLOBALS['ct'] = 'background: white;';
            } else {
                $GLOBALS['ct'] = 'background: red;';
                $GLOBALS['flag'] = 6;
            }
        }
        
        if(isset($_POST['comment'])) {
            $comment = $_POST['comment'];
            $comment = trim($comment);
            preg_match('/^[аА-яЯ0-9aA-zZ "\'\/*+-,.?!;:()\n\r\t]{1,1024}$/mu', $comment, $res);
            if (count($res) > 0 && $res[0] == $comment) {
                $GLOBALS['cc'] = 'background: white;';
            } else {
                $GLOBALS['cc'] = 'background: red;';
                $GLOBALS['flag'] = 7;
            }
        }
        if ($GLOBALS['flag'] == 0) { // Здесь происходит запрос в таблицу
            $hostname="localhost";
	        $username="root";
	        $password="";
	        $dbname="mydb";
            $link = mysqli_connect($hostname,$username, $password, $dbname);
            if (!$link) {
                die('Не удалось соединиться: ' . mysql_error());
            }
            $query = 'INSERT INTO clients (name, email, birth, sex, topic, comment)
                      VALUES (\'' . $name . '\', \'' . $email . '\', ' . 
                $birth . ', \'' . $sex . '\', \'' . $topic . '\', \'' . $comment . '\')';
            $result = mysqli_query($link, $query);
            
            setrawcookie("name", $name); // Заносим в куки имя, почту, др и пол.
            setrawcookie("email", $email);
            setrawcookie("birth", $birth);
            setrawcookie("sex", $sex);

        }
    }
}

$error = array();
array_push($error, 
           'Имя должно состоять из букв кириллицы или латиницы без пробелов, дополнительных символов.',
           'E-mail должен состоять из латинских букв, цифр, а также точки, тире и нижнего подчеркивания',
           'Выберите год рождения',
           'Выберите пол',
           'Максимальное количество символов: 64',
           'Максимальное количество символов: 1024',
           'Необходимо принять контракт'); // Массив с строчками возможных ошибок

$cn = '';
$ce = '';
$cb = '';
$cs = '';
$ct = '';
$cc = '';
$ca = '';
$flag = 0;
?>
