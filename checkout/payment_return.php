<?php
include_once './header.inc.php';

if ($_POST['result'] === 'ok') {
    // Order is successfully paid. We will now notify Logitrail that order is now OK
    // TODO: Redirection
    
    $orderId = time();

    ?>
    <h1>Order Confirmation #<?php echo $orderId; ?></h1>

    <p>This page simulates the order confirmation. Thank you for your order.</p>
    
    <p><a href="index.php">Start again.</a></p>

    <hr />
    <?php
    exit;
}

if ($_POST['result'] === 'rejected') {
    // Order was not paid. Cancelling the order from Logitrail.
    // TODO: Redirection
    
    ?>
    <script>
    document.location = 'cart.php?cancelled=1';
    </script>
    <?php
    exit;
}