<?php
$total_count = get_report_count();
$total_page = ceil($total_count / $_PAGE['list_num']); 
$total_block = ceil($total_page/$_PAGE['page_num']);
$block = ceil($page/$_PAGE['page_num']); //현재 블록
$first = ($block-1)*$_PAGE['page_num']; // 페이지 블록이 시작하는 첫 페이지
$last =$block*$_PAGE['page_num']; //페이지 블록의 끝 페이지

if($block >= $total_block) {
    $last = $total_page;
}
?>

<div class="w3-center">
    <div class="w3-bar">
    <!-- <a href="#" class="w3-bar-item w3-button">&laquo;</a>
    <a href="#" class="w3-button">&raquo;</a> -->

<? if($block > 1) { ?>
    <a class="w3-bar-item w3-button" href="list.php?page=1">≪</a>
<? }

if($page > 1) { ?>
    <!-- <a class="w3-button" href="list.php?page=<?=$page-1?>"><</a> -->
<? } 

for ($page_link=$first+1; $page_link<=$last; $page_link++) { 
    if($page_link == $page) { ?>
        <a class="w3-bar-item w3-button w3-dark-gray"><?=$page_link?></a>
    <? }
    else { ?>
        <a class="w3-bar-item w3-button" href="list.php?page=<?=$page_link?>"><?=$page_link?></a>
    <? }
}

if($block < $total_block) { ?>
    <a class="w3-bar-item w3-button" href="list.php?page=<?=$total_page?>">≫</a>
<? } ?>

</div>
