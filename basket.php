<?php

    include 'header.php';

    // Display basket info if there is any.
    if ($_SESSION['basket']) : ?>
        <?php
            // Calculate basket total
            $basket_weights = array();
            $basket_prices  = array();

            foreach($_SESSION['basket'] as $item) {
                array_push($basket_weights, $item['item_weight']);
                array_push($basket_prices, $item['item_price']);
            }

            $total_weight   = array_sum($basket_weights);
            $total_price    = array_sum($basket_prices);
        ?>
        <table class="basket-table">
            <thead>
                <tr>
                    <th colspan="2">Product</th>
                    <th>Qty</th>
                    <th>Weight</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['basket'] as $item) : ?>
                    <tr>
                        <td>
                            <img src="assets/images/<?=$item['item_image']?>" style="max-width: 50px;" />
                        </td>
                        <td><?=$item['item_name']?></td>
                        <td><?=$item['item_qty']?></td>
                        <td><?=$item['item_weight']?>g</td>
                        <td><?=$item['item_price']?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <th colspan=
            </tfoot>

        <?php else : ?>
            <h2>Basket empty.</h2>
        <?php endif; ?>


<?php include 'footer.php'; ?>
