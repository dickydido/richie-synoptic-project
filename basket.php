<?php

    include 'header.php';

    // Display basket info if there is any.
    if (isset($_SESSION['basket'])) : ?>
        <?php
            // Calculate basket subtotal
            $basket_weights = array();
            $basket_prices  = array();

            foreach($_SESSION['basket'] as $item) {
                array_push($basket_weights, $item['item_weight']);
                array_push($basket_prices, $item['item_price']);
            }

            $total_weight   = array_sum($basket_weights);
            $subtotal_price    = array_sum($basket_prices);

            // Determine postage price
            if ($total_weight < 40) {
                $postage = 0;
            } elseif ($total_weight < 251) {
                $postage = 1.5;
            } elseif ($total_weight < 501) {
                $postage = 2;
            } else {
                $postage = 2.5;
            }

            // Calculate total after Postage
            $total_price = $subtotal_price + $postage;
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
                        <td><?=number_format($item['item_weight'], 1)?>g</td>
                        <td>£<?=number_format($item['item_price'], 2)?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">SubTotal</th>
                    <td class="<?=($total_weight < 40) ? 'error' : ''?>"><?=number_format($total_weight, 1)?>g</td>
                    <th>£<?=number_format($subtotal_price, 2)?></th>
                </tr>
                <tr>
                    <th colspan="4">Postage & Packaging</th>
                    <td>£<?=number_format($postage, 2)?></td>
                </tr>
                <tr>
                    <th colspan="4">Total</th>
                    <th>£<?=number_format($total_price, 2)?></th>
                </tr>
            </tfoot>
        </table>

        <div class="basket-buttons">
            <form action="basket.php?action=clear" method="post">
                <input type="submit" value="Clear Basket" name="clear" />
            </form>
            <?php if ($total_weight < 40) : ?>
                <?php
                    $needed_weight = number_format((40 - $total_weight), 1);
                ?>
                <button disabled="true" class="checkout">Checkout</button>
                <p class="error">Please note: The total weight of your basket is <strong><?=$needed_weight?>g</strong> below the minimum requirement of <strong>40.0g</strong>.</p>
            <?php else : ?>
                <button class="checkout">Checkout</button>
            <?php endif; ?>

            <?php else : ?>
                <h2>Basket empty.</h2>
            <?php endif; ?>
        </div>


<?php include 'footer.php'; ?>
