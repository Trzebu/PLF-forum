<!-- PHP light framework - paginate -->

<?php

$current_page = 0;

if (Libs\Http\Request::urlVar("page") !== null) {
    $current_page = Libs\Http\Request::urlVar("page");
}

$links = 7;
$last = ceil($this->allRowCount / $this->pageLimit);
$start = (($current_page - $links) > 0) ? $current_page - $links : 0;
$end = (($current_page+ $links) < $last) ? $current_page + $links : $last;

?>

<link rel="stylesheet" href="<?= Route("/") ?>/public/framework/css/paginator.css">

<ul id="plf_paginate_container" role="navigation">

    <?php if (($current_page - 1) < 0): ?>
        <li class="plf_disable"><span>&laquo;</span></li>
    <?php else: ?>
        <li><a href="<?= Libs\Http\Request::url() ?>/?page=<?= $current_page - 1 ?>">&laquo;</a></li>
    <?php endif; ?>
    <?php if ($start > 0): ?>
        <li><a href="<?= Libs\Http\Request::url() ?>/?page=0">1</a></li>
        <li class="plf_disable"><span>...</span></li>
    <?php
        endif;

        for ($i = $start; $i < $end; $i++) {
            if ($current_page == $i) {
                echo "<li class='plf_active'><span>" . ($i + 1) . "</span></li>";
            } else {
                echo "<li><a href=" . Libs\Http\Request::url() . "/?page={$i}>" . ($i + 1) . "</a></li>";
            }
        }

        if ($end < $last):
    ?>
        <li class="plf_disable"><span>...</span></li>
        <li><a href="<?= Libs\Http\Request::url() ?>/?page=<?= $last - 1 ?>"><?= $last ?></a></li>
    <?php endif; ?>

    <?php if (($current_page + 1) == $last): ?>
        <li class="plf_disable"><span>&raquo;</span></li>
    <?php else: ?>
        <li><a href="<?= Libs\Http\Request::url() ?>/?page=<?= $current_page + 1 ?>">&raquo;</a></li>
    <?php endif; ?>

</ul>