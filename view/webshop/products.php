<?php if ($app->users->isLoggedIn()) : ?>
    <a href="<?=$app->url->create('webshop/cart')?>" class="webshop_cart_sideblock">Go to cart &gt;</a>
<?php endif; ?>

<section class="wrapper_cart">
<?php foreach ($data as $row) : ?>
    <article class="cart_item">
        <div class="cart_image"><img src="<?=$row->img?>" alt="image"></div>
        <p class="cart_description">Description: <?=$row->description?></p>
        <p class="cart_category">Category: <?=$row->category?></p>
        <p class="cart_price">Price: <?=$row->price?> SEK</p>
        <p class="cart_quantity">Quantity: <?=$row->quantity?></p>
        <div class="cart_delete cart_add">
            <a href="<?=$app->url->create('webshop/cart/addToCart')?>?add=<?=$row->id?>">Add to cart</a>
        </div>
    </article>
<?php endforeach; ?>
</section>
