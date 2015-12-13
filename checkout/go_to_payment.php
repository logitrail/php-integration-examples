<?php
include_once './header.inc.php';

$_SESSION['logitrail_order_id'] = $_POST['logitrail_order_id'];

?>
<h1>Going to Payment...</h1>

<p>This page simulates the redirection to the payment operator.</p>

<p>Logitrail's Order ID is <?php echo $_SESSION['logitrail_order_id']; ?>.</p>

<hr />

<div class="text-center">
    <form action="payment_return.php" method="post">
        <button type="submit" name="result" value="ok" style="color: green; font-weight: bold;">Return as Successfully Paid</button>
        <button type="submit" name="result" value="rejected" style="color: red;">Return as Not Paid</button>
    </form>
</div>