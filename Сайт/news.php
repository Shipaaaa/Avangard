<?php
  Error_Reporting(E_ALL & ~E_NOTICE); 
?>
<html lang="en">
<? include('header.php'); ?>
  <body>
  <? include('menu.php'); ?>
    <div class="wrapper">
      <div>
        <table>
            <tr>
          <td style="border-width: 1px">
          <div class="main" >
           <div class="namepage">
           <div class="square" style="margin-top: 15px;"></div>НОВОСТИ <p class="link"><a href="news.php" class="link">показать все новости</a></p>
          <hr>
          </div>
            <?
                if (isset($_GET['id_news'])){
                }
            ?>
              <?php
                // Устанавлинваем соединение с базой данных
                require_once("config.php");

                // Проверяем параметр page, предотвращая SQL-инъекцию
                if(!preg_match("|^[\d]*$|",$_GET['page'])) puterror("Ошибка при обращении к блоку новостей");
                // Проверяем переменную $page, равную порядковому номеру первой новости на странице
                $page = $_GET['page'];
                if(empty($page)) $page = 1;
                $begin = ($page - 1)*$all_number_news;

                // Защита от инъекционных запросов
                if(!preg_match("|^[\d]*$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");

                // Запрашиваем новость id_news (она должна быть видимой hide='show')
                // Если скрипту передан первичный ключ выводимой новости отображаем только одну новость
                if(isset($_GET['id_news']))
                {
                  $query = "SELECT id_news,
                                 name,
                                 body,
                                 DATE_FORMAT(putdate,'%d.%m.%Y') as putdate_format,
                                 url,
                                 url_text,
                                 hide 
                                 FROM news WHERE hide='show' AND id_news=".$_GET['id_news'];
                }
                // если параметр id_news не установлен - выводим все новости
                else
                {
                  $query = "SELECT id_news,
                                 name,
                                 body,
                                 DATE_FORMAT(putdate,'%d.%m.%Y') as putdate_format,
                                 url,
                                 url_text,
                                 url_pict,
                                 hide
                            FROM news 
                            WHERE hide='show' AND putdate <= NOW()
                            ORDER BY putdate DESC 
                            LIMIT $begin, $all_number_news";
                }
                $new = mysql_query($query);
                if (!$new) puterror("Ошибка при обращении к блоку новостей");
                if(mysql_num_rows($new) > 0)
                {
                  while($news = mysql_fetch_array($new))
                  {
                      // Выводим заголовок новости
                      //echo "<p class='zagnews'>".$news['name']."</p>";    // Выводим тело новости перводя символы         
                      echo "<div class='zagnews'>".$news['name']."<em class='datanews'>".$news['putdate_format']."</em></div>";    // Выводим тело новости перводя символы         
                      // Выводим тело новости переводя символы 
                      // переноса строки в тег <br>
                      echo "<p class='text'>";
                      // Выводим изображение
                      if(trim($news['url_pict']) != "" && trim($news['url_pict']) != "-")
                      echo "<img align=right class=img src=".$news['url_pict'].">";
                      
                      // echo nl2br($news['body'])."</p>";
                      
                      // Выводим URL
                      if(trim($news['url']) != "" && trim($news['url']) != "-")
                      echo "<p class='linkr' style='width:960px'><a class='link' href=".$news['url']." ".$news['url_text']."</a></p>";        
                  }
                }

                // // Постраничная навигация
                // $page_link = 4;
                // $query = "SELECT COUNT(*) FROM news WHERE hide='show' AND putdate <= NOW()";
                // $tot = mysql_query($query);

                // $total = mysql_result($tot,0);
                // $number = (int)($total/$all_number_news);
                // if((float)($total/$all_number_news) - $number != 0) $number++;
                // echo "<br><table><tr><td><p>";
                // // Проверяем есть ли ссылки слева
                // if($page - $page_link > 1)
                // {
                //   echo "<a href=$_SERVER[PHP_SELF]?page=1>[1-$all_number_news]</a>&nbsp;&nbsp;...&nbsp;";
                //   // Есть
                //   for($i = $page - $page_link; $i<$page; $i++)
                //   {
                //       echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
                //   }
                // }
                // else
                // {
                //   // Нет
                //   for($i = 1; $i<$page; $i++)
                //   {
                //       echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
                //   }
                // }
                // // Проверяем есть ли ссылки справа
                // if($page + $page_link < $number)
                // {
                //   // Есть
                //   for($i = $page; $i<=$page + $page_link; $i++)
                //   {
                //     if($page == $i)
                //       echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
                //     else
                //       echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
                //   }
                //   echo "&nbsp;...&nbsp;<a href=$_SERVER[PHP_SELF]?page=$number>[".(($number - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
                // }
                // else
                // {
                //   // Нет
                //   for($i = $page; $i<=$number; $i++)
                //   {
                //     if($number == $i)
                //     {
                //       if($page == $i)
                //         echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-$total]&nbsp;";
                //       else
                //         echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
                //     }
                //     else
                //     {
                //       if($page == $i)
                //         echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
                //       else
                //         echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
                //     }
                //   }
                // }
                echo "</td></tr></table>";
              ?>
        </div>
        </td>   
        </tr>
    </table>
    </div>
    </div>
  </body>
</html>