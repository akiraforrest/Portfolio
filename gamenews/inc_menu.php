<?php

$strHTML = "";

$strHTML .= "<div class='mypage-pc-menu'>";
$strHTML .= "    <div class='mypage-pc-menu-box'>";
$strHTML .= "        <div class='mypage-pc-menu-box-category'>管理機能</div>";
$strHTML .= "        <ul>";
$strHTML .= "            <li><a href='user_list.php'>会員管理</a></li>";
$strHTML .= "            <li><a href='news_list.php'>お知らせ管理</a></li>";
$strHTML .= "        </ul>";
$strHTML .= "    </div>";
/*
$strHTML .= "    <div class='mypage-pc-menu-box'>";
$strHTML .= "        <div class='mypage-pc-menu-box-category'>運営管理者</div>";
$strHTML .= "        <ul>";
$strHTML .= "            <li><a href='member.html'>ツナグーンアカウント</a></li>";
$strHTML .= "            <li><a href=''>イベント管理</a></li>";
$strHTML .= "            <li><a href=''>各種設定</a></li>";
$strHTML .= "        </ul>";
$strHTML .= "    </div>";
*/
$strHTML .= "</div>";

echo $strHTML;

?>