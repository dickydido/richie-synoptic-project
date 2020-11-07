<?php

    session_start();

    include 'header.php';

    // connect to database.
    $link = mysqli_connect("localhost", "root", "root", "richie-synoptic-project");
    // check if connection was established.
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    // Fetch all sweet data from database.
    $sql = "SELECT * FROM rw_sweets";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Store output of each row into array.
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "\nError: ". $sql . "<br>" . mysqli_error($link) . "\n";
    }

    // Free result set.
    mysqli_free_result($result);

    // close connection to database.
    mysqli_close($link);

    // Check if "add to basket" form has been sent.
    if (isset($_POST['add'])) {
        $product_id     = $_POST['product-id'];
        $product_qty    = $_POST['qty'];

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
    }

    echo count($_SESSION['basket']);

    print_nice($_SESSION['basket']);
?>

<section class="product-section">
    <div class="products">
        <?php foreach ($products as $product) : ?>
            <?php $price = number_format($product['PricePerGram'] * $product['Weight'], 2); ?>
            <div class="product">
                <div class="product-card">
                    <img src="assets/images/<?=$product['Image']?>" />
                    <h4><?=$product['Name']?></h4>
                    <p class="weight" data-weight="<?=$product['Weight']?>">Weight: <span><?=number_format($product['Weight'], 1)?></span>g</p>
                    <p class="price" data-price="<?=$price?>">Price: £<span><?=$price?></span></p>
                    <form action="index.php?action=add&id=<?=$product['ID']?>" method="post" data->
                        <label for="qty">Qty</label>
                        <input type="hidden" name="hidden-name" class="hidden-name" value="<?=$product['Name']?>" />
                        <input type="hidden" name="hidden-weight" class="hidden-weight" value="<?=number_format($product['Weight'], 1)?>" />
                        <input type="hidden" name="hidden-price" class="hidden-price" value="<?=$price?>" />
                        <input type="hidden" name="hidden-image" class="hidden-image" value="<?=$product['Image']?>" />
                        <input type="number" name="qty" class="qty" min="1" value="1" />
                        <input type="submit" name="add" value="Add to Basket" />
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php

    include 'footer.php';

?>
