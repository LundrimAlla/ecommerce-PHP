<?php
    include('includes/header.php');
    $_SESSION['page'] = 'cart';


    if(isset($_GET['action']) && ($_GET['action'] === 'empty_cart')) {
        $_SESSION['cart'] = [];
        header('Location: cart.php');
    }

    if(isset($_GET['action']) && ($_GET['action'] === 'increase')) {
        if(isset($_GET['id'])) {
            $cproduct = $_SESSION['cart'][$_GET['id']];
            $cproduct['qty'] += 1;
            $_SESSION['cart'][$_GET['id']] = $cproduct;
            header('Location: cart.php');
        }
    }


    if(isset($_GET['action']) && ($_GET['action'] === 'decrease')) {
        if(isset($_GET['id'])) {
            $_SESSION['id'] = $_GET['id'];
            $cproduct = $_SESSION['cart'][$_GET['id']];
            $cproduct['qty'] -= 1;

            if($cproduct['qty'] <= 0) {
                unset($_SESSION['cart'][$_SESSION['id']]);
            } else {
                $_SESSION['cart'][$_GET['id']] = $cproduct;
            }

            header('Location: cart.php');
        }
    }
?>

<div class="cart my-5">
    <div class="container">
        <?php if(count($_SESSION['cart']) > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <tr>
                    <?php 
                    $total = 0.00;
                    foreach($_SESSION['cart'] as $product) {
                        $total += ($product['qty'] * $product['price']);
                    ?>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td>
                            <a href="?action=decrease&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">-</a>
                            <span class="d-inline-block mx-2"><?= $product['qty'] ?></span>
                            <a href="?action=increase&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">+</a>
                        </td>
                        <td><?= $product['price'] ?> EUR</td>
                        <td><?= $product['qty'] * $product['price'] ?> EUR</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td><b><?= $total ?> EUR</b></td>
                </tr>
            </table>
        </div>
        <?php
        } else {
        ?>
        <p>Cart is empty!</p>
        <?php
        }
        ?>
        <?php if(isset($_SESSION['cart']) && (count($_SESSION['cart']) > 0)) { ?>
         <a href="checkout.php" class="btn btn-sm btn-success">Checkout</a>
        <a href="?action=empty_cart" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">Empty cart</a>
        <?php } ?>
    </div>
</div>  

<?php include('includes/footer.php') ?>