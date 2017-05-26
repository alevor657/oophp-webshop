<div class="pages_wrapper">
    <table class="dashboard_table">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Published</th>
            <th>Deleted</th>
            <th>Status</th>
            <th>Path</th>
            <th>Slug</th>
            <?php if ($app->users->isAdmin()) : ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>

        <?php foreach ($app->content->getData() as $row) :?>

        <tr>
            <td><?=esc($row->id)?></td>
            <td><a href="?route=<?=esc($row->path)?>"><?=esc($row->title)?></a></td>
            <td><?=esc($row->type)?></td>
            <td><?=esc($row->created)?></td>
            <td><?=esc($row->updated)?></td>
            <td><?=esc($row->published)?></td>
            <td><?=esc($row->deleted)?></td>
            <td><?=esc($row->status)?></td>
            <td><?=esc($row->path)?></td>
            <td><?=esc($row->slug)?></td>
            <?php if ($app->users->isAdmin()) : ?>
                <td>
                    <a href='<?=$app->url->create('content/edit') . "?id=$row->id"?>'>Edit</a>
                    <br>
                    <a href='<?=$app->url->create('content/edit/delete') . "?delete=$row->id"?>'>Delete</a>
                    <br>
                    <a href='<?=$app->url->create('content/edit/purge') . "?purge=$row->id"?>'>Purge</a>
                </td>
            <?php endif; ?>
        </tr>

        <?php endforeach; ?>

    </table>

    <?php if ($app->users->isAdmin()) : ?>
        <a href='<?=$app->url->create('content/edit/addContent')?>'>Add content</a>
    <?php endif; ?>

</div>
