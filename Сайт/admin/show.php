<?php

  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Устанавливаем соединение с базой данных
  require_once("../config.php");

  // Проверяем параметр id_news, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]+$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");
  // Отображаем новость
  $query = "UPDATE news SET hide='show' 
            WHERE id_news=".$_GET['id_news'];
  if(mysql_query($query)) header("Location: admin_main.php?page=".$_GET['page']);
  else puterror("Ошибка при обращении к блоку новостей");
?>