<?php
$data = $app->content->getBlockData();
?>

<?php if ($data) : ?>
    <div class="block">
        <h3><?=$data->title?></h3>
        <?=$app->filter->doFilter($data->data, $data->filter)?>
    </div>
<?php endif; ?>
