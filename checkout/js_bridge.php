<?php

include_once './product_database.inc.php';

$totalWeight = 0;
foreach ($_SESSION['cart'] as $productId => $qty) {
    $totalWeight += $qty * $productDatabase[$productId];
}

$requestValues = array(
    "merchant" => "testi.verkkokauppavarasto.fi",
    "request" => "new_order",
    "order_id" => 'TEST-' . session_id(),
    "customer_fn" => $_SESSION['contact']['firstname'],
    "customer_ln" => $_SESSION['contact']['lastname'],
    "customer_addr" => $_SESSION['contact']['address'],
    "customer_pc" => $_SESSION['contact']['postalcode'],
    "customer_city" => $_SESSION['contact']['city'],
    "customer_country" => "FI",
    "customer_email" => $_SESSION['contact']['email'],
    "customer_phone" => $_SESSION['contact']['phone'],
    "ok_url" => "https://help.logitrail.com/php-integration-examples/return.php?return=ok",
    "error_url" => "https://help.logitrail.com/php-integration-examples/return.php?return=error",
    "cancel_url" => "https://help.logitrail.com/php-integration-examples/return.php?return=cancel",
    "weight" => $totalWeight,
    "layout" => "default",
);

ksort($requestValues);

$macValues = [];
foreach ($requestValues as $key => $value) {
    if ($key === 'mac') {
        continue;
    }
    $macValues[] = $value;
}

$macValues[] = 'hyvis';

$macSource = join('|', $macValues);
$correctMac = base64_encode(hash('sha512', $macSource, true));
$requestValues['mac'] = $correctMac;

?>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body>
    <form action="<?php echo htmlspecialchars('https://checkout.logitrail.com/go'); ?>" method="post" id="form">
        <?php foreach ($requestValues as $key => $value) { ?>
            <input type="hidden" name="<?php echo htmlspecialchars($key); ?>" value="<?php echo htmlspecialchars($value); ?>" />
        <?php } ?>
        <button type="submit" style="display: none;">Please wait...</button>
    </form>
    <script>
    document.getElementById('form').submit();
    </script>
</body>
</html>