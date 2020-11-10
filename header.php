<?php

    session_start();

    include 'functions.php';

    // Check if "add to basket" form has been submitted .
    if (isset($_POST['add'])) {

        // Store sessions of last submitted item for success message.
        $_SESSION['last-qty'] = $_POST['qty'];
        $_SESSION['last-name'] = $_POST['hidden-name'];

        // Check if anything exists in user's basket already.
        if (isset($_SESSION['basket'])) {

            // Create array of all product ids in the basket and check if new submission id exists.
            $item_array_id = array_column($_SESSION['basket'], 'item_id');

            if (!in_array($_GET['id'], $item_array_id)) {
                // If new submission isn't in basket, create new item and add to the basket session.
                $count = count($_SESSION['basket']);
                $item_array = array(
                    'item_id'       => $_GET['id'],
                    'item_name'     => $_POST['hidden-name'],
                    'item_weight'   => $_POST['hidden-weight'],
                    'item_price'    => $_POST['hidden-price'],
                    'item_image'    => $_POST['hidden-image'],
                    'item_qty'      => $_POST['qty']
                );
                $_SESSION['basket'][$count] = $item_array;
            } else {
                // Update price, qty & weight of new submission.
                foreach ($_SESSION['basket'] as &$item) {
                    if ($item['item_id'] == $_GET['id']) {
                        $item['item_qty'] += $_POST['qty'];
                        $item['item_price'] += $_POST['hidden-price'];
                        $item['item_weight'] += $_POST['hidden-weight'];
                    }
                }
            }

        } else {

            // If basket session doesn't exist, create with new submission.
            $item_array = array(
                'item_id'       => $_GET['id'],
                'item_name'     => $_POST['hidden-name'],
                'item_weight'   => $_POST['hidden-weight'],
                'item_price'    => $_POST['hidden-price'],
                'item_image'    => $_POST['hidden-image'],
                'item_qty'      => $_POST['qty']
            );
            $_SESSION['basket'][0] = $item_array;

        }

        $redirect = true; // Triggers page redirect, preventing resubmission.
        $_SESSION['item-added'] = true; // triggers success message after redirect.
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Richie Synoptic Project</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.12.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <header class="<?=$redirect ? ' redirect' : ''?>">
        <div class="container">
            <div class="header-content">
                <h1>
                    <a href="index.php" class="logo">Sweet Shop</a>
                </h1>
                <a href="basket.php" class="basket"><i class="fas fa-shopping-basket"></i> Basket (<?=$_SESSION['basket'] ? count($_SESSION['basket']) : 0 ?>)</a>
            </div>
        </div>
    </header>

    <main>

        <!-- Add success message when item is added to basket -->
        <?php if (!$redirect && isset($_SESSION['item-added'])) : ?>
            <?php unset($_SESSION['item-added']); ?>
            <div class="success">
                <p><?=($_SESSION['last-qty'] > 1) ? $_SESSION['last-qty'] . ' items were' : $_SESSION['last-qty'] . ' item was'?> successfully added to your basket - <strong><?=$_SESSION['last-name']?></strong></p>
            </div>
        <?php endif; ?>
