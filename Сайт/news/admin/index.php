<?php
  ///////////////////////////////////////////////////
  // Áëîê "Íîâîñòè"
  // 2003-2006 (C) IT-ñòóäèÿ SoftTime (http://www.softtime.ru)
  // Ñèìäÿíîâ È.Â. (simdyanov@softtime.ru)
  // Ãîëûøåâ Ñ.Â. (softtime@softtime.ru)
  ///////////////////////////////////////////////////
  // Âûñòàâëÿåì óðîâåíü îáðàáîòêè îøèáîê (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Óñòàíàâëèâàåì ñîåäèíåíèå ñ áàçîé äàííûõ
  require_once("../config.php");
  // Ôîðìèðóåì çàãîëîâîê ñòðàíèöû è ïîäñêàçêó
  $titlepage="Óïðàâëåíèå áëîêîì\n \"Íîâîñòè\" $version";
  $helppage='Åñëè ó âàñ íå ðàáîòàåò ýòî Web-ïðèëîæåíèå, âû âñåãäà ìîæåòå íàéòè ïîìîùü ïî åãî óñòàíîâêå è íàñòðîéêå íà íàøåì ôîðóìå <a href=http://www.softtime.ru/forum/>http://www.softtime.ru/forum/</a> Âîçìîæíî âàì òàêæå ïîòðåáóåòñÿ äîïîëíèòåëüíàÿ ôóíêöèîíàëüíîñòü, â ýòîì ñëó÷àå Âû òàêæå ìîæåòå ïîñåòèòü íàø ôîðóì è âûññêàçàòü ñâîè ïðåäëîæåíèÿ. Åñëè Âàøå ïðåäëîæåíèå äåéñòâèòåëüíî àêòóàëüíî è èíòåðåñíî, ìû äîðàáîòàåì ïðèëîæåíèå ñ ó÷åòîì Âàøèõ ïîæåëàíèé.';
  // Âûâîäèì øàïêó ñòðàíèöû
  include "../util/topadmin.php";  


  // Ïðîâåðÿåì ïàðàìåòð page, ïðåäîòâðàùàÿ SQL-èíúåêöèþ
  if(!preg_match("|^[\d]*$|",$_POST['page'])) puterror("Îøèáêà ïðè îáðàùåíèè ê áëîêó íîâîñòåé");
  // Ïðîâåðÿåì ïåðåìåííóþ $page, ðàâíóþ ïîðÿäêîâîìó íîìåðó ïåðâîé íîâîñòè íà ñòðàíèöå
  $page = $_GET['page'];
  if(empty($page)) $page = 1;
  $begin = ($page - 1)*$all_number_news;

  // Âîñïðîèçâîäèì íîâîñòè, òàêèì îáðàçîì, êàê îíè âûãëÿäÿò íà 
  // ãëàâíîé ñòðàíèöå, íî îòîáðàæàåì òàê æå íåâèäèìûå íîâîñòè
  $query = "SELECT id_news,
                   name,
                   body,
                   DATE_FORMAT(putdate,'%d.%m.%Y') as putdate_format,
                   url,
                   url_text,
                   url_pict,
                   hide
            FROM news
            ORDER BY putdate DESC 
            LIMIT $begin, $all_number_news";
  $new = mysql_query($query);
  if ($new)
  {
    // Âûâîäèì ññûëêè óïðàâëåíèÿ íîâîñòÿìè, äîáàâëåíèå, óäàëåíèå è ðåäàêòèðîâàíèå
    ?>
<table cellpadding="0" cellspacing="0" border="0" >
        <tr>
        <?php
    echo "<td class=boxmenu><a class=menu href=addnewsform.php?start=$start title='Äîáàâèòü íîâóþ íîâîñòü íà ñàéò' >Äîáàâèòü íîâîñòü</a></td>";
    ?>
    </tr>
    </table><br>
    <table width=100% class=bodytable border=1 align=center cellpadding=5 cellspacing=0 bordercolorlight=gray bordercolordark=white>
      <tr class=tableheadercat align="center">
        <td width=120><p class=zagtable>Äàòà</p></td>
        <td width=60%><p class=zagtable>Íîâîñòü</p></td>
        <td width=40><p class=zagtable><nobr>Èçáð-å</nobr></p></td>
        <td colspan=3><p class=zagtable>Äåéñòâèÿ</p></td>
      </tr>
    <?php
    while($news = mysql_fetch_array($new))
    {
    
      // Åñëè íîâîñòü îòìå÷åíà êàê íåâèäèìàÿ (hide='hide'), âûâîäèì
      // ññûëêó "îòîáðàçèòü", åñëè êàê âèäèìèÿ (hide='show') - "ñêðûòü"
      $colorrow = "";
      if($news['hide']=='show') $showhide = "<p><a href=hide.php?id_news=".$news['id_news']."&start=$start title='Ñêðûòü íîâîñòü â áëîêå íîâîñòåé'>Ñêðûòü</a>";
      else  {
        $showhide = "<p><a href=show.php?id_news=".$news['id_news']."&start=$start title='Îòîáðàçèòü íîâîñòü â áëîêå íîâîñòåé'>Îòîáðàçèòü</a>";
        $colorrow = "class='hiddenrow'";
      }
      // Ïðîâåðÿåì íàëè÷èå èçîáðàæåíèÿ
      if ($news['url_pict'] != '' && $news['url_pict'] != '-') $url_pict="<b><a href=../".$news['url_pict'].">åñòü</a></b>";
      else $url_pict="íåò";
      
      if (($news['url']!='-') and ($news['url']!='')) $news_url="<br><b>Ññûëêà:</b> <a href='".$news['url']."'>".$news['url_text']."</a>";
      else $news_url="";
      // Âûâîäèì íîâîñòü
      echo "<tr $colorrow >
              <td><p class=help align=center>".$news['putdate_format']."</p></td>
              <td><p><a title='Ðåäàêòèðîâàòü òåêñò íîâîñòè' href=editnewsform.php?id_news=".$news['id_news']."&start=$start>".$news['name']."</a><br>".nl2br($news['body'])." ". $news_url." </td>
              <td><p>".$url_pict."</p></td>
              <td align=center>".$showhide."</td>
              <td align=center><p><a href=delnews.php?start=$start&id_news=".$news['id_news']." title='Óäàëèòü íîâîñòü'>Óäàëèòü</a></td>
              <td align=center><p><a href=editnewsform.php?start=$start&id_news=".$news['id_news']." title='Ðåäàêòèðîâàòü òåêñò íîâîñòè'>Èñïðàâèòü</a></td>
            </tr>";
    }
    echo "</table>";
  }
  else puterror("Îøèáêà ïðè îáðàùåíèè ê áëîêó íîâîñòåé");

  // Ïîñòðàíè÷íàÿ íàâèãàöèÿ
  $page_link = 4;
  $query = "SELECT COUNT(*) FROM news";
  $tot = mysql_query($query);

  $total = mysql_result($tot,0);
  $number = (int)($total/$all_number_news);
  if((float)($total/$all_number_news) - $number != 0) $number++;
  echo "<br><table><tr><td><p>";
  // Ïðîâåðÿåì åñòü ëè ññûëêè ñëåâà
  if($page - $page_link > 1)
  {
    echo "<a href=$_SERVER[PHP_SELF]?page=1>[1-$all_number_news]</a>&nbsp;&nbsp;...&nbsp;";
    // Åñòü
    for($i = $page - $page_link; $i<$page; $i++)
    {
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
  }
  else
  {
    // Íåò
    for($i = 1; $i<$page; $i++)
    {
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
  }
  // Ïðîâåðÿåì åñòü ëè ññûëêè ñïðàâà
  if($page + $page_link < $number)
  {
    // Åñòü
    for($i = $page; $i<=$page + $page_link; $i++)
    {
      if($page == $i)
        echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
      else
        echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
    }
    echo "&nbsp;...&nbsp;<a href=$_SERVER[PHP_SELF]?page=$number>[".(($number - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
  }
  else
  {
    // Íåò
    for($i = $page; $i<=$number; $i++)
    {
      if($number == $i)
      {
        if($page == $i)
          echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-$total]&nbsp;";
        else
          echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-$total]</a>&nbsp;";
      }
      else
      {
        if($page == $i)
          echo "&nbsp;[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]&nbsp;";
        else
          echo "&nbsp;<a href=$_SERVER[PHP_SELF]?page=".$i.">[".(($i - 1)*$all_number_news + 1)."-".$i*$all_number_news."]</a>&nbsp;";
      }
    }
  }
  echo "</td></tr></table>";
  // Âûâîäèì çàâåðøåíèå ñòðàíèöû
  include "../util/bottomadmin.php";
?>