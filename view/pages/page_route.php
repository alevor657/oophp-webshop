<?php
$route = $app->request->getGet('route');

$data = $app->content->getDataByPath($route);
?>

<article class="article">
    <header>
        <h1><?=esc($data->title)?></h1>
        <p><i>Latest update: <time datetime="<?= esc($data->modified_iso8601) ?>" pubdate><?= esc($data->modified) ?></time></i></p>
    </header>

    <?=$app->filter->doFilter($data->data, $data->filter)?>
</article>
