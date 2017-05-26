<section class="wrapper webshop_checkout">
    <h1>Thank you for your purchase!</h1>
    <h4>Order date: <?=$data[0]->order_date?></h4>
    <?php foreach ($data as $row) : ?>
        <article class="cart_item">
            <div class="cart_image"><img src="<?=$row->img?>" alt="image"></div>
            <p class="cart_description">Description: <?=$row->description?></p>
            <p class="cart_price">Price: <?=$row->price?> SEK</p>
            <p class="cart_quantity">Quantity: <?=$row->item_qty?></p>
        </article>
    <?php endforeach; ?>
</section>
