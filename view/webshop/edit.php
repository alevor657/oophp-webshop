<a href="<?=$app->url->create('webshop/cart')?>" class="webshop_cart_sideblock">Go to cart &gt;</a>

<?php
$cols = $app->shop->getColumnNames();
// var_dump($data);
?>

<div class="pages_wrapper">
    <form class="" action="<?=$app->url->create('webshop/edit/updateStock')?>" method="post">
        <table class="dashboard_table">
            <tr>
                <th>Id</th>
                <th>description</th>
                <th>img link</th>
                <th>category</th>
                <th>price</th>
                <th>quantity</th>
            </tr>

            <?php foreach ($data as $row) :?>
            <tr>
                <td><?=$row->id?></td>
                <td><input type="text" name="description" value="<?=$row->description?>" required></td>
                <td><input type="text" name="img" value="<?=$row->img?>" required></td>

                <td><select class="" name="category" required>
                    <option value="1" <?= $row->category == 'plate' ? 'selected' : null?>>plate</option>
                    <option value="2" <?= $row->category == 'mug' ? 'selected' : null?>>mug</option>
                </select></td>

                <td><input type="text" name="price" value="<?=$row->price?>" required></td>
                <td><input type="text" name="quantity" value="<?=$row->quantity?>" required></td>
                <input type="text" name="id" value="<?=$row->id?>" hidden>
            </tr>
            <?php endforeach; ?>

        </table>
        <input class="edit_data_submit" type="submit" value="Save">
    </form>
</div>
