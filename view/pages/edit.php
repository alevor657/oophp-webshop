<?php
$data = $app->content->getData($app->request->getGet('id'));

?>

<div class="edit_wrapper">
    <form class="" action="<?=$app->url->create('content/edit/updateContent')?>" method="post">
        <table class="dashboard_table">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Type</th>
                <th>Path</th>
                <th>Slug</th>
                <th>Filters</th>
                <th>Published</th>
                <th>Deleted</th>
            </tr>

            <?php foreach ($data as $row) :?>

            <tr>
                <td><?=esc($row->id)?></td>

                <td>
                    <input type="text" name="title" value="<?=esc($row->title)?>">
                </td>
                <td>
                    <select name="type">
                        <option value="page" <?=$row->type === 'page' ? 'selected' : ''?>>page</option>
                        <option value="post" <?=$row->type === 'post' ? 'selected' : ''?>>blog/post</option>
                        <option value="block" <?=$row->type === 'block' ? 'selected' : ''?>>block</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="formPath" value="<?=esc($row->path)?>">
                </td>
                <td>
                    <input type="text" name="slug" value="<?=esc($row->slug)?>">
                </td>
                <td>
                    <input type="text" name="filter" value="<?=esc($row->filter)?>">
                </td>
                <td>
                    <input type="date" name="published" value="<?=date('Y-m-d')?>">
                </td>
                <td>
                    <input type="date" name="deleted" value="">
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
            <textarea class="edit_data_input" name="data" rows="8" cols="80"><?=esc($row->data)?></textarea>
            <input type="text" name="id" value="<?=esc($row->id)?>" hidden>
            <input class="edit_data_submit" type="submit" value="Save">
    </form>
</div>





<!-- <td>
    <div class="td_filters_wrapper">
        <label for="nl2br">nl2br</label>
        <input id="nl2br" type="checkbox" name="nl2br" value="nl2br">
    </div>

    <div class="td_filters_wrapper">
        <label for="markdown">md</label>
        <input id="markdown" type="checkbox" name="markdown" value="markdown">
    </div>

    <div class="td_filters_wrapper">
        <label for="bbcode">bbcode</label>
        <input id="bbcode" type="checkbox" name="bbcode" value="bbcode">
    </div>

    <div class="td_filters_wrapper">
        <label for="clickable">clickable</label>
        <input id="clickable" type="checkbox" name="clickable" value="clickable">
    </div>
</td> -->
