<?php
$data = $app->content->getBlogData();
?>
<?php if (!isset($route)) : ?>
    <article class="blog">
        <?php foreach ($data as $row) : ?>
            <section>
                <header>
                    <h1><a href="<?=$app->url->create("blog/" . esc($row->slug))?>"><?= esc($row->title) ?></a></h1>
                    <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
                </header>
                <?= $app->filter->doFilter($row->data, $row->filter) ?>
            </section>
        <?php endforeach; ?>
    </article>
<?php else : ?>
<?php
$data = $app->content->getBlogData($route)[0];
?>

<article class="blog_active">
    <section>
        <header>
            <h1><?= esc($data->title) ?></h1>
            <p><i>Published: <time datetime="<?= esc($data->published_iso8601) ?>" pubdate><?= esc($data->published) ?></time></i></p>
        </header>
        <?= $app->filter->doFilter($data->data, $data->filter) ?>
    </section>
</article>

<?php endif; ?>
