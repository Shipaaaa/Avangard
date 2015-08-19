<!doctype html>
<html lang="en">
<? include('header.php'); ?>	
	<body>
	<? include('menu.php'); ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<!-- the mousewheel plugin -->
	<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
	<!-- the jScrollPane script -->
	<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="js/scroll-startstop.events.jquery.js"></script>
	<script type="text/javascript" language="javascript" src="js/jquery.carouFredSel-5.2.3-packed.js"></script>
	<script type="text/javascript" language="javascript">
			$(function() {
				

			$('#carousel ul').carouFredSel({
				prev: '#prev',
				next: '#next',
				pagination: "#pager",
				auto: true,
				scroll: 1000,
				pauseOnHover: true
			});

			$('#carousel1 ul').carouFredSel({
				prev: '#prev1',
				next: '#next1',
				pagination: "#pager1",
				auto: true,
				scroll: 1000,
				pauseOnHover: true
			});

				// the element we want to apply the jScrollPane
				var $el					= $('#jp-container').jScrollPane({
					verticalGutter 	: -16
				}),
						
				// the extension functions and options 	
					extensionPlugin 	= {
						
						extPluginOpts	: {
							// speed for the fadeOut animation
							mouseLeaveFadeSpeed	: 500,
							// scrollbar fades out after hovertimeout_t milliseconds
							hovertimeout_t		: 1000,
							// if set to false, the scrollbar will be shown on mouseenter and hidden on mouseleave
							// if set to true, the same will happen, but the scrollbar will be also hidden on mouseenter after "hovertimeout_t" ms
							// also, it will be shown when we start to scroll and hidden when stopping
							useTimeout			: true,
							// the extension only applies for devices with width > deviceWidth
							deviceWidth			: 980
						},
						hovertimeout	: null, // timeout to hide the scrollbar
						isScrollbarHover: false,// true if the mouse is over the scrollbar
						elementtimeout	: null,	// avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar
						isScrolling		: false,// true if scrolling
						addHoverFunc	: function() {
							
							// run only if the window has a width bigger than deviceWidth
							if( $(window).width() <= this.extPluginOpts.deviceWidth ) return false;
							
							var instance		= this;
							
							// functions to show / hide the scrollbar
							$.fn.jspmouseenter 	= $.fn.show;
							$.fn.jspmouseleave 	= $.fn.fadeOut;
							
							// hide the jScrollPane vertical bar
							var $vBar			= this.getContentPane().siblings('.jspVerticalBar').hide();
							
							/*
							 * mouseenter / mouseleave events on the main element
							 * also scrollstart / scrollstop - @James Padolsey : http://james.padolsey.com/javascript/special-scroll-events-for-jquery/
							 */
							$el.bind('mouseenter.jsp',function() {
								
								// show the scrollbar
								$vBar.stop( true, true ).jspmouseenter();
								
								if( !instance.extPluginOpts.useTimeout ) return false;
								
								// hide the scrollbar after hovertimeout_t ms
								clearTimeout( instance.hovertimeout );
								instance.hovertimeout 	= setTimeout(function() {
									// if scrolling at the moment don't hide it
									if( !instance.isScrolling )
										$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
								}, instance.extPluginOpts.hovertimeout_t );
								
								
							}).bind('mouseleave.jsp',function() {
								
								// hide the scrollbar
								if( !instance.extPluginOpts.useTimeout )
									$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
								else {
								clearTimeout( instance.elementtimeout );
								if( !instance.isScrolling )
										$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
								}
								
							});
							
							if( this.extPluginOpts.useTimeout ) {
								
								$el.bind('scrollstart.jsp', function() {
								
									// when scrolling show the scrollbar
								clearTimeout( instance.hovertimeout );
								instance.isScrolling	= true;
								$vBar.stop( true, true ).jspmouseenter();
								
							}).bind('scrollstop.jsp', function() {
								
									// when stop scrolling hide the scrollbar (if not hovering it at the moment)
								clearTimeout( instance.hovertimeout );
								instance.isScrolling	= false;
								instance.hovertimeout 	= setTimeout(function() {
									if( !instance.isScrollbarHover )
											$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
									}, instance.extPluginOpts.hovertimeout_t );
								
							});
							
								// wrap the scrollbar
								// we need this to be able to add the mouseenter / mouseleave events to the scrollbar
							var $vBarWrapper	= $('<div/>').css({
								position	: 'absolute',
								left		: $vBar.css('left'),
								top			: $vBar.css('top'),
								right		: $vBar.css('right'),
								bottom		: $vBar.css('bottom'),
								width		: $vBar.width(),
								height		: $vBar.height()
							}).bind('mouseenter.jsp',function() {
								
								clearTimeout( instance.hovertimeout );
								clearTimeout( instance.elementtimeout );
								
								instance.isScrollbarHover	= true;
								
									// show the scrollbar after 100 ms.
									// avoids showing the scrollbar when moving from inside the element to outside, passing over the scrollbar								
								instance.elementtimeout	= setTimeout(function() {
									$vBar.stop( true, true ).jspmouseenter();
								}, 100 );	
								
							}).bind('mouseleave.jsp',function() {
								
									// hide the scrollbar after hovertimeout_t
								clearTimeout( instance.hovertimeout );
								instance.isScrollbarHover	= false;
								instance.hovertimeout = setTimeout(function() {
										// if scrolling at the moment don't hide it
									if( !instance.isScrolling )
											$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
									}, instance.extPluginOpts.hovertimeout_t );
								
							});
							
							$vBar.wrap( $vBarWrapper );
							
						}
						
						}
						
					},
					
					// the jScrollPane instance
					jspapi 			= $el.data('jsp');
					
				// extend the jScollPane by merging	
				$.extend( true, jspapi, extensionPlugin );
				jspapi.addHoverFunc();
			
			});
		</script>
				<style type="text/css" media="all">
			#carousel {
				/*margin: 0 0 30px 30px;*/
				margin-top: 20px;
				width: 270px;
				height: 370px;
				position:relative;
			}
			#carousel ul {
				margin: 0;
				padding: 0;
				list-style: none;
				display: block;
			}
			#carousel li {
				padding-left: 10px;
				padding-right: 10px;
				font-size: 40px;
				color: #999;
				text-align: center;
				width: 270px;
				height: 370px;
				padding: 0;
				margin: 0px;
				display: block;
				float: left;
				/*background: transparent url('images/carousel_polaroid.png') no-repeat 0 0;*/
				position:relative;
			}

			#carousel li img {
				width: 270px;
				height: 370px;
				margin-top:0px;
			}

			#carousel li a {
				width: 270px;
				height: 370px;
				position:absolute;
				display:block;
				top:14px;
				left:16px;
				/*background: transparent url('images/carousel_shine.png') no-repeat 0 0;*/
				text-indent:-999em;
			}	
			/*----------------------Партнёры--------------------*/
			#carousel1 {
				margin: 10px 0 10px 30px;
				width: 835px;
				height: 150px;
				position:relative;
			}

			#carousel1 ul {
				margin: 0;
				padding: 0;
				list-style: none;
				display: block;
			}
			#carousel1 li {
				padding-left: 5px;
				padding-right: 5px;
				font-size: 40px;
				color: #999;
				text-align: center;
				width: 150px;
				height: 150px;
				margin: 0px;
				display: block;
				float: left;
				/*background: transparent url('images/carousel_polaroid.png') no-repeat 0 0;*/
				position:relative;
			}

			#carousel1 li img {
				width: 150px;
				height: 150px;
				margin-top:0px;
				/*margin-left: 20px;
				margin-right: 20px;*/
			}

			#carousel1 li a {
				width: 150px;
				height: 150px;
				/*margin-left: 20px;
				margin-right: 20px;*/
				position:absolute;
				display:block;
				top:14px;
				left:16px;
				/*background: transparent url('images/carousel_shine.png') no-repeat 0 0;*/
				text-indent:-999em;
			}					

			.clearfix {
				float: none;
				clear: both;
			}

			#carousel1 .prev, #carousel1 .next {
				margin-left: 10px;
				width:11px;
				height:21px;			
				display:block;				
				text-indent:-999em;
				position:absolute;
				top:65px;		
			}
			#carousel1 .prev {
				left:-40px;
				background: url('images/afisha/leftScroll.png') no-repeat;
			}
				#carousel1 .prev:hover {
					left:-40px;
				}			
			#carousel1 .next {
				background: url('images/afisha/rightScroll.png') no-repeat;
				right:-30px;
			}

			#carousel1 .next:hover {
				right:-30px;
			}

			#carousel .pager {
				margin-top: 10px;
				text-align: center;
			}
			#carousel .pager a {
				margin: 0 5px 0 0;
				text-decoration: none;
				display:inline-block;
				width:9px;
				height:9px;
				background: url('images/afisha/pager.png') no-repeat;
				text-indent:-999em;
			}
			#carousel .pager a.selected {
				text-decoration: underline;
				}
	</style>
		<div class="wrapper">
			<div class="content">
				<div class="ss">
					<div class="square"></div>СОЦИАЛЬНЫЕ СЕТИ
					<hr>
					<TABLE class="tableSS">
				        <TR class="tableSSTR">
		                	<TD><a href="https://www.facebook.com/cki.avangard"><img src="images/icon/FB.png"/></a></TD> <TD><a href="http://vk.com/centr_avangard"><img src="images/icon/VK.png"/></a></TD> <TD><a href="https://twitter.com/Centr_Avangard"><img src="images/icon/TW.png"/></a></TD><TD><a href=""><img src="images/icon/SK.png"/></a></TD>
				        </TR>
				        <TR class="tableSSTR">
		                	<TD><a href="http://ok.ru/centravangard"><img src="images/icon/OD.png"/></a></TD> <TD><a href="https://www.youtube.com/channel/UC6mqeV2vtMqVLoQ0coZY81A/videos"><img src="images/icon/YT.png"/></a></TD> <TD><a href="https://plus.google.com/u/0/112774963304481606959/posts"><img src="images/icon/GP.png"/></a></TD><TD><a href="https://instagram.com/centr_avangard/"><img src="images/icon/IN.png"/></a></TD>
				        </TR>
					</TABLE>
				</div>
				<div class="news">
					<div class="square"></div>НОВОСТИ
					<hr>
					<div id="jp-container" class="jp-container">
					<?php
						  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
						  Error_Reporting(E_ALL & ~E_NOTICE); 

						  // Этот файл выводит первые $pnumber новостей
						  // Устанавлинваем соединение с базой данных
						  require_once("config.php");
						?>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						<?php
						  // Выясняем общее количество новостей в базе данных, для того чтобы
						  // правильно отображать ссылки на последующие новости.
						  $tot = mysql_query("SELECT count(*) FROM news WHERE hide='show' AND putdate <= NOW()");
						  if ($tot)
						  {
						    $total = mysql_result($tot,0);
						    // Если в базе новостей меньше чем $pnumber
						    // выводим их без вывода ссылки "Все новости".
						    if($pnumber < $total) echo "<p class='linkblock'><a href=news.php class='linkblock'>Все новости</a>";
						  }
						  else puterror("Ошибка при обращении к блоку новостей");
						  // Запрашиваем все видимые новости, т.е. те, у которых в базе данных hide='show',
						  // если это поле будет равно 'hide', новость не будет отображаться на странице
						  $query = "SELECT * FROM news 
						            WHERE hide='show' AND putdate <= NOW()
						            ORDER BY putdate DESC
						            LIMIT $pnumber";
						  $new = mysql_query($query);
						  if(!$new) puterror("Ошибка при обращении к блоку новостей");
						  if(mysql_num_rows($new) > 0)
						  {
						    while($news = mysql_fetch_array($new))
						    {
						      // Выводим заголовок новости
						      echo "<p class=newsblockzag><b>".$news['name']."</b></p>";
						      // Формируем анонс
						      // Переменная $numchar содержит примерное
						      // количество символов в анонсе
						      $pos = strpos(substr($news['body'],$numchar), " ");
						      // Если новость длинная, то выводим троеточие...
						      if(strlen($news['body'])>$numchar) $srttmpend = "...";
						      else $strtmpend = "";
						      // Выводим анонс
						      echo "<p class=newsblock>".substr($news['body'], 0, $numchar+$pos).$srttmpend;
						      echo "<br><a class=anewsblock href=news.php?id_news=".$news['id_news'].">подробнее</a></p>";
						    }
						  }
					?>
					</div>
					<div class="clr"></div>
				</div>
				<div class="poster">
				<div class="square"></div>АФИША
					<hr>
					<div id="carousel">
						<ul>
							<li><img src="images/afisha/afisha.png"/></li>
							<li><img src="images/afisha/day_jam.png"/></li>				
						</ul>
						<div class="clearfix"></div>
						<!-- <a id="prev" class="prev" href="#">&lt;</a>
						<a id="next" class="next" href="#">&gt;</a> -->
						<div id="pager" class="pager"></div>
					</div>
				</div>
				<div class="TimePadeWidget">
						<div class="square"></div>СОБЫТИЯ
						<hr>
					<script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="11626" data-timepad-widget-v2="event_list3" src="https://timepad.ru/js/tpwf/loader/min/loader.js"></script>
				</div>
				<div class="inwiget">
				</div>
				<div class="timetable">
				<TABLE>
				        <TR>
		                	<TD><a href="https://docs.google.com/document/d/1O5e0wEjlIniErTEPYS7YrXaFBvnsRhMrZ5GeZtiB1H8/pub"><img src="images/ico1.png"/></a></TD> <TD class="timetableBG"><a href="https://docs.google.com/document/d/1O5e0wEjlIniErTEPYS7YrXaFBvnsRhMrZ5GeZtiB1H8/pub">РАСПИСАНИЕ ЗАНЯТИЙ</a></TD>
				        </TR>
				         <TR>
		                	<TD><a href="https://docs.google.com/document/d/1vofWUNNQAJjUYM-4ALGEtJsSQT9upmmIy9hYzdHcUZY/pub"><img src="images/ico2.png"/></a></TD> <TD class="timetableBG"><a href="https://docs.google.com/document/d/1vofWUNNQAJjUYM-4ALGEtJsSQT9upmmIy9hYzdHcUZY/pub">ПРЕЙСКУРАНТ ЦЕН</a></TD>
				        </TR>
				         <TR>
		                	<TD><a href="https://docs.google.com/forms/d/1CvDgOpGw93xBfA9GYmAvjNeysA1JK6EUaMXQRk4iRWE/viewform?c=0&w=1"><img src="images/ico3.png"/></a></TD> <TD class="timetableBG"><a href="https://docs.google.com/forms/d/1CvDgOpGw93xBfA9GYmAvjNeysA1JK6EUaMXQRk4iRWE/viewform?c=0&w=1">ОН-ЛАЙН ЗАПИСЬ</a></TD>
				        </TR>
					</TABLE>
				</div>
				<div class="partners">
					<div class="square"></div>ПАРТНЕРЫ
					<hr>
					<div id="carousel1">
						<ul>
							
							<li><img src="images/partners/logos.png"/><a href="http://kultura.mos.ru/">Image1</a></li>
							<li><img src="images/partners/uao.png"/><a href="http://uao.mos.ru/">Image1</a></li>
							<li><img src="images/partners/ugorexovo.png"/><a href="http://orehovo-borisovo-juzhnoe.mos.ru/">Image1</a></li>
							<li><img src="images/partners/orexovo_borisovo_sev.png"/><a href="http://sevorehovo-borisovo.mos.ru/">Image1</a></li>
							<li><img src="images/partners/etnomir.png"/><a href="http://ethnomir.ru/">Image1</a></li>
							<li><img src="images/partners/arkona.png"/><a href="https://vk.com/arkona_druzhina">Image1</a></li>
							<li><img src="images/partners/logo_bor.png"><a href="http://www.borisovskie.park­kuzminki.ru/">Image1</a></li>
							<li><img src="images/partners/mosart.png"/><a href="http://mosartagency.com/">Image1</a></li>
							<li><img src="images/partners/danceTH.png"/><a href="http://dtsansara.ucoz.ru/">Image1</a></li>
							<li><img src="images/partners/activeGR.png"/><a href="http://ag.mos.ru/">Image1</a></li>
							<li><img src="images/partners/mechta.png"/><a href="http://teatr-mechta.ru/">Image1</a></li>
							<li><img src="images/partners/tc_dom.png"/><a href="http://www.domodedovskiy.ru/">Image1</a></li>			
						</ul>
						<div class="clearfix"></div>
						<a id="prev1" class="prev" href="#">&lt;</a>
						<a id="next1" class="next" href="#">&gt;</a>
						<!-- <div id="pager1" class="pager"></div> -->
					</div>
				</div>
			</div>
		</div>
		<script src="js/lightbox.min.js"></script>
	</body>
</html>