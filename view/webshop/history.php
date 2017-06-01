<section class="wrapper_cart wrapper">
    <h1>Your orders history</h1>
    <?php foreach ($data as $row) : ?>
        <h4>Order date: <?=$row[0]->order_date?></h4>
        <?php foreach ($row as $underrow) : ?>
            <article class="cart_item">
                <div class="cart_image"><img src="<?=$underrow->img?>" alt="image"></div>
                <p class="cart_description">Description: <?=$underrow->description?></p>
                <p class="cart_price">Price: <?=$underrow->price?> SEK</p>
                <p class="cart_quantity">Quantity: <?=$underrow->quantity?></p>
            </article>
        <?php endforeach; ?>
    <?php endforeach; ?>
</section>
