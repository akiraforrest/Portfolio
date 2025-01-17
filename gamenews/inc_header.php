<?php

$strHTML = "";
$strHTML .= "<header>";
$strHTML .= "	  <!-- Global Navigation -->";
$strHTML .= "	  <nav class='header-box'>";
$strHTML .= "		  <div id='header-box-mb'>";
$strHTML .= "			  <div class='header-box-mb-left'>";
$strHTML .= "				  <input id='nav-input' type='checkbox' class='nav-unshown'>";
$strHTML .= "				  <label id='nav-open' for='nav-input'><span></span></label>";
$strHTML .= "				  <label class='nav-unshown' id='nav-close' for='nav-input'></label>";
$strHTML .= "				  <div id='nav-content'>";
$strHTML .= "					  <div class='hamburger-top'><label class='cancel' for='nav-input'><img src='img/menu-close48-48.png' alt='close' style='width:16px;height:auto;' ></label></div>";
$strHTML .= "					  <div class='hamburger-border'></div>";
$strHTML .= "					  <div class='header-box-mb-menu'>";
$strHTML .= "						  <div class='header-box-mb-menu-box'>";
$strHTML .= "							  <div class='header-box-mb-menu-category'>管理機能</div>";
$strHTML .= "							  <div class='header-box-mb-menu-item'><a href='user_list.php'>会員管理</a></div>";
$strHTML .= "							  <div class='header-box-mb-menu-item'><a href='news_list.php'>お知らせ管理</a></div>";
$strHTML .= "						  </div>";
$strHTML .= "						  <div class='header-box-mb-signin'><a href='logoff.php'>ログアウト</a></div>";
$strHTML .= "					  </div>";
$strHTML .= "				  </div>";
$strHTML .= "			  </div>";
$strHTML .= "			  <div class='header-box-mb-center'>";
$strHTML .= "				  <div class='header-box-mb-logo'><a href=''><img src='img/TSUNAGOON-Logo.png' alt='TSUNAGOON（ツナグーン）'></a></div>";
$strHTML .= "			  </div>";
$strHTML .= "			  <div class='header-box-mb-right'>";
$strHTML .= "			  </div>";
$strHTML .= "		  </div>";
$strHTML .= "		  <div id='header-box-pc'>";
$strHTML .= "			  <div class='header-box-pc-left'>";
$strHTML .= "				  <div class='header-box-pc-left-logo'><a href=''><img src='img/TSUNAGOON-Logo.png' alt='TSUNAGOON（ツナグーン）'></a></div>";
$strHTML .= "			  </div>";
$strHTML .= "			  <div class='header-box-pc-right'>";
$strHTML .= "				  <div class='header-box-pc-right-menu'><a href='logoff.php'>ログアウト</a></div>";
$strHTML .= "			  </div>";
$strHTML .= "		  </div>";
$strHTML .= "	  </nav>";
$strHTML .= "  <!-- /Global Navigation -->";
$strHTML .= "  </header>";

echo $strHTML;

?>