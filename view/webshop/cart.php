<?php
var_dump($data);
?>
<section class="wrapper_cart">
    <?php foreach ($data as $row) : ?>
        <article class="cart_item">
            <div class="cart_image"><img src="<?=$row->img?>" alt="image"></div>
            <p class="cart_description">Description: <?=$row->description?></p>
            <p class="cart_category">Category: <?=$row->category?></p>
            <p class="cart_price">Price: <?=$row->price?> SEK</p>
            <p class="cart_quantity">Quantity: <?=$row->quantity?></p>
            <div class="cart_delete">
                <a href="<?=$app->url->create('webshop/cart/delete')?>?delete=<?=$row->id?>">Delete</a>
            </div>
        </article>
    <?php endforeach; ?>
</section>

<a href="<?=$app->url->create('webshop/checkout')?>">Proceed to checkout</a>
