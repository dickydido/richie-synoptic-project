<?php

    include 'header.php';

?>

    <?php

    // Display basket info if there is any.
    if (isset($_SESSION['basket'])) : ?>
        <?php
            // Calculate basket subtotal.
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

            $total_price = $subtotal_price + $postage; // Calculate total after Postage

            // Check if gift options were submitted & update.
            if (isset($_POST['gift-options'])) {
                $_SESSION['gift-options'] = array(
                    'gift-message'  => $_POST['message'],
                    'gift-wrap'     => $_POST['gift-wrap']
                );
            }

            // Clear gift options button function.
            if (isset($_POST['clear-gift'])) {
                unset($_SESSION['gift-options']);
                echo '<div class="redirect"></div>';
            }

            // Clear basket button function.
            if (isset($_POST['clear'])) {
                unset($_SESSION['basket']);
                echo '<div class="redirect"></div>';
            }
        ?>

        <div class="basket-table">
            <h2>Your Basket</h2>
            <table>
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
                                <img src="assets/images/<?=$item['item_image']?>" />
                            </td>
                            <td><?=$item['item_name']?></td>
                            <td><?=$item['item_qty']?></td>
                            <td><?=number_format($item['item_weight'], 1)?>g</td>
                            <td class="price">£<?=number_format($item['item_price'], 2)?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">SubTotal</th>
                        <td class="<?=($total_weight < 40) ? 'error' : ''?>"><?=number_format($total_weight, 1)?>g<?=($total_weight < 40) ? '*' : ''?></td>
                        <th>£<?=number_format($subtotal_price, 2)?></th>
                    </tr>
                    <tr>
                        <th colspan="4">Postage & Packaging</th>
                        <td>£<?=number_format($postage, 2)?></td>
                    </tr>
                    <tr>
                        <th colspan="4">Total</th>
                        <th class="price">£<?=number_format($total_price, 2)?></th>
                    </tr>
                </tfoot>
            </table>

            <form action="basket.php?action=clear" method="post">
                <input type="submit" value="Clear Basket" class="btn btn-clear" name="clear" />
            </form>
        </div>

        <div class="gift-options">
            <h3>Gift Options</h3>

        <!-- Check if gift options exist & display. -->
        <?php if (!isset($_SESSION['gift-options'])) : ?>

            <p class="description">Sending to someone special? Why not gift wrap it and send them a personal message?</p>
            <form action="basket.php" method="post">
                <div class="options">
                    <div class="option-container">
                        <label for="message">Special Message</label>
                        <textarea rows="3" name="message"></textarea>
                    </div>
                    <div class="option-container">
                        <label for="gift-wrap">Gift wrap?</label>
                        <input type="checkbox" name="gift-wrap" />
                    </div>
                </div>
                <input type="submit" name="gift-options" class="btn" value="Submit Gift Options" />
            </form>

        <?php else : ?>

            <p>Special Message: <?=$_SESSION['gift-options']['gift-message']?></p>
            <p>Gift wrapped? <?=$_SESSION['gift-options']['gift-wrap'] ? 'Yes' : 'No' ?></p>
            <form action="basket.php?action=clear-gift-options" method="post">
                <input type="submit" name="clear-gift" class="btn btn-clear" value="Remove Gift Options" />
            </form>

        <?php endif; ?>

        </div>

        <!-- Display error message if minimum order weight not reached. -->
        <?php if ($total_weight < 40) : ?>
            <?php
                $needed_weight = number_format((40 - $total_weight), 1);
            ?>
            <button disabled="true" class="checkout">Checkout</button>
            <p class="error">*Please note: The total weight of your basket is <strong><?=$needed_weight?>g</strong> below the minimum order requirement of <strong>40.0g</strong>.</p>
        <?php else : ?>
            <button class="checkout">Checkout</button>
        <?php endif; ?>

    <?php else : ?>
        <h2>Basket empty.</h2>
    <?php endif; ?>


<?php include 'footer.php'; ?>
