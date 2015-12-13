<?php
include_once './header.inc.php';

if ($_POST['action'] === 'add_to_cart') {
    $_SESSION['cart'] = array();
    foreach ($_POST['qty'] as $productId => $qty) {
        if ((int)$qty > 0) {
            $_SESSION['cart'][$productId] = (int)$qty;
        }
    }
}

?>

<h1>Cart</h1>

<?php if (!$_SESSION['cart']) { ?>
    <p>Cart is empty.</p>
    <?php
    exit;
} ?>

<form action="cart.php" method="post">
    <table class="table">
        <?php
        $totalEur = 0;
        foreach ($_SESSION['cart'] as $productId => $qty) {
            $product = $productDatabase[$productId];
            $totalEur += $qty * $product['price'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($productId); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['ean']); ?></td>
                <td><?php echo number_format($product['price'], 2, ',', ''); ?> €</td>
                <td><?php echo $qty; ?> x</td>
                <td><?php echo number_format($qty * $product['price'], 2, ',', ''); ?> €</td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="5">Total before delivery</td>
            <td><?php echo number_format($totalEur, 2, ',', ''); ?> €</td>
        </tr>
    </table>
</form>

<div class="row">
    <div class="col-xs-6">
        <form id="contactForm">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" name="firstname" id="firstName" placeholder="First Name" value="<?php echo htmlspecialchars($_SESSION['contact']['firstname']); ?>">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" name="lastname" id="lastName" placeholder="Last Name" value="<?php echo htmlspecialchars($_SESSION['contact']['lastname']); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo htmlspecialchars($_SESSION['contact']['address']); ?>">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-3">
                        <input type="text" class="form-control" id="postalCode" name="postalcode" placeholder="Postal Code" value="<?php echo htmlspecialchars($_SESSION['contact']['postalcode']); ?>">
                    </div>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo htmlspecialchars($_SESSION['contact']['city']); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($_SESSION['contact']['email']); ?>">
            </div>
            <div class="form-group">
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php echo htmlspecialchars($_SESSION['contact']['phone']); ?>">
            </div>
        </form>
    </div>
    <div class="col-xs-6">
        <div id="logitrailMessage"></div>
        <div id="logitrailContainer"></div>
        
        <div id="paymentBlock" style="display: none;">
            <form action="go_to_payment.php" method="post">
            
                <div style="text-center">
                    <div>Total</div>
                    <div id="totalEurBlock" style="font-size: 200%;">-,-- €</div>
                </div>
            
                <input type="hidden" name="logitrail_order_id" value="" id="logitrailOrderIdField" />
                
                <button type="submit">Go to Payment</button>
            </form>
        </div>
    </div>
</div>

<script>

var currentCheckout = {
    totalEurWithoutDeliveryFee: <?php echo $totalEur; ?>
}

function doCheckout()
{
    $('#paymentBlock').slideUp();
    Logitrail.checkout({
        containerId: 'logitrailContainer',
        bridgeUrl: 'js_bridge.php',
        success: function(logitrailResponse) {
            $('#logitrailOrderIdField').val(logitrailResponse.order_id);
            $('#totalEurBlock').html(currentCheckout.totalEurWithoutDeliveryFee + logitrailResponse.delivery_fee);
            $('#paymentBlock').slideDown();
        },
        error: function(error) {
            console.error(error);
            alert('Logitrail Error occurred.');
        }
    });
}

function saveContactDetailsToServer() {
    // Saving the contact details to the session with Ajax request
    var datastring = $("#contactForm").serialize();
    $.ajax({
        type: "POST",
        url: "cart_save_contact.php",
        data: datastring,
        dataType: "json",
        success: function(data) {
            if (data.ready) {
                $('#logitrailMessage').html('');
                doCheckout();
                return;
            }
            
            $('#logitrailMessage').html(data.info_for_user);
        },
        error: function(){
          alert('error handing here');
        }
    });
}

$(document).on('change', '#contactForm input', function() {
    saveContactDetailsToServer();
});
$(function() {
    saveContactDetailsToServer();
    });
    </script>
