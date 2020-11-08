<?php

    session_start();

    include 'functions.php';

    // Check if "add to basket" form has been sent.
    if (isset($_POST['add'])) {
        // Store sessions of last submitted item for success message.
        $_SESSION['last-qty'] = $_POST['qty'];
        $_SESSION['last-name'] = $_POST['hidden-name'];

        if (isset($_SESSION['basket'])) {
            $item_array_id = array_column($_SESSION['basket'], 'item_id');
            if (!in_array($_GET['id'], $item_array_id)) {
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
                foreach ($_SESSION['basket'] as &$item) {
                    if ($item['item_id'] == $_GET['id']) {
                        $item['item_qty'] += $_POST['qty'];
                        $item['item_price'] += $_POST['hidden-price'];
                        $item['item_weight'] += $_POST['hidden-weight'];
                    }
                }
            }
        } else {
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
        $redirect = true;
        $_SESSION['item-added'] = true;
    }

    if (isset($_POST['clear'])) {
        $redirect = true;
        unset($_SESSION['basket']);
    }

?>

<!DOCTYPE>
<html>
<head>
    <title>Richie Synoptic Project</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header class="<?=$redirect ? ' redirect' : ''?>">
        <a href="index.php" class="logo">Sweet Shop</a>
        <a href="basket.php" class="basket">Basket: <?=$_SESSION['basket'] ? count($_SESSION['basket']) : 0 ?></a>
    </header>
    <main>
        <?php if (!$redirect && isset($_SESSION['item-added'])) : ?>
            <?php unset($_SESSION['item-added']); ?>
            <div class="success">
                <p><?=($_SESSION['last-qty'] > 1) ? $_SESSION['last-qty'] . ' items were' : $_SESSION['last-qty'] . ' item was'?> successfully added to your basket - <strong><?=$_SESSION['last-name']?></strong></p>
            </div>
        <?php endif; ?>
