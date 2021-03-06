<?php
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Имя сервера базы данных, например $dblocation = "mysql28.noweb.ru"
  // сейчас выставлен сервер локальной машины
  $dblocation = "mysqlhost";
  // Имя базы данных, на хостинге или локальной машине
  $dbname = "news";
  // Имя пользователя базы данных
  $dbuser = "avan_news";
  // Пароль
  $dbpasswd = "avangard123";
  // Количество новостей, выводимых в анонсе
  $pnumber = 150;
  // Количество символов в одном аносе новостей
  $numchar = 500;
  // Количество новостей, выводимых на странице
  // все новости
  $all_number_news = 10;
  // Версия Web-приложения
  $version = "2.0.3";
  
  // Соединяемся с сервером базы данных
  $dbcnx = @mysql_connect($dblocation,$dbuser,$dbpasswd);
  if (!$dbcnx) exit("<P>В настоящий момент сервер базы данных не доступен, поэтому корректное отображение страницы невозможно.</P>");
  // Выбираем базу данных
  if (!@mysql_select_db($dbname,$dbcnx)) exit("<P>В настоящий момент база данных не доступна, поэтому корректное отображение страницы невозможно.</P>");

  // Определяем версию сервера
  $query = "SELECT VERSION()";
  $ver = mysql_query($query);
  if(!$ver) exit("Ошибка при определении версии MySQL-сервера");
  $version = mysql_result($ver, 0);
  list($major, $minor) = explode(".", $version);
  // Если версия выше 4.1 сообщаем серверу, что будем работать с
  // кодировкой cp1251
  $ver = $major.".".$minor;
  if((float)$ver >= 4.1)
  {
    mysql_query("SET NAMES 'utf8'");
  }

  // Небольшая вспомогательная функция, которая выводит сообщение об ошибке
  // в случае ошибки запроса к базе данных
  function puterror($message)
  {
    exit("<p>$message</p>");
  }
?>