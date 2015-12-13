<?php
include_once './header.inc.php';

if ($_GET['restart_session'] && session_id() === $_GET['restart_session']) {
    $_SESSION = array();
    session_destroy();
    session_regenerate_id(true);
}

?>
    <h1>Logitrail Checkout Integration Example Shop</h1>
        
    <form action="cart.php" method="post">
        <table class="table">
            <?php foreach ($productDatabase as $product) { ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['ean']); ?></td>
                <td><?php echo htmlspecialchars($product['weight']); ?> g</td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><select name="qty[<?php echo $product['id']; ?>]">
                    <option value=""></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select></td>
            </tr>
            <?php } ?>
        </table>
        <button type="submit" name="action" value="add_to_cart">Order Products</button>
    </form>
    
    <hr />
    <p><a href="index.php?restart_session=<?php echo session_id(); ?>">Clear Session + Cart</a></p>