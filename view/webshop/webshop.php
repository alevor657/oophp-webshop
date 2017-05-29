<?php
$cols = $app->shop->getColumnNames();
// var_dump($data);
?>

<div class="pages_wrapper">
    <table class="dashboard_table">
        <tr>
            <th>Id</th>
            <th>description</th>
            <th>img link</th>
            <th>category</th>
            <th>price</th>
            <th>quantity</th>

            <th colspan="2">Actions</th>
        </tr>

        <?php foreach ($data as $row) :?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->description?></td>
            <td><?=$row->img?></td>
            <td><?=$row->category?></td>
            <td><?=$row->price?></td>
            <td><?=$row->quantity?></td>
            <td>
                <a href="<?=$app->url->create('webshop/edit/delete')?>?delete=<?=$row->id?>">Delete</a>
                <a href="<?=$app->url->create('webshop/edit/')?>?edit=<?=$row->id?>">Edit</a>
            </td>
            <td>
                <a href="<?=$app->url->create('webshop/cart/addToCart')?>?add=<?=$row->id?>">Add to cart</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <a href='<?=$app->url->create('webshop/edit/addItem')?>'>Add items to stock</a>

</div>
