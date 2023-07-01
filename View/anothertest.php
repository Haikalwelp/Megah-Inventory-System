<?php
session_start();

require_once "../config/autoload.php";
include "adminnavigation.php";

$productController = new ProductController();

if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array(
                    $productByCode[0]["code"] => array(
                        'name' => $productByCode[0]["name"],
                        'code' => $productByCode[0]["code"],
                        'quantity' => $_POST["quantity"],
                        'price' => $productByCode[0]["price"]
                    )
                );

                if (!empty($_SESSION["cart_item"])) {
                    if (array_key_exists($productByCode[0]["code"], $_SESSION["cart_item"])) {
                        $_SESSION["cart_item"][$productByCode[0]["code"]]["quantity"] = $_POST["quantity"];
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
    }
}
?>

<HTML>
<HEAD>
    <TITLE>Simple PHP Shopping Cart</TITLE>
    <link href="../Styles/style.css" type="text/css" rel="stylesheet"/>
</HEAD>
<BODY>
<?php
$session_items = 0;
if (!empty($_SESSION["cart_item"])) {
    $session_items = count($_SESSION["cart_item"]);
}
?>
<div id="product-grid">
    <div class="top_links">
        <a href="shopping_cart.php" title="Cart">View Cart</a><br>
        Total Items = <?php echo $session_items; ?>
    </div>
    <div class="txt-heading">Products</div>
    <?php
    $product_array = $productController->getProductsController();
    if (!empty($product_array)) {
        foreach ($product_array as $product) {
            ?>
            <div class="product-item">
                <form method="post"
                      action="index.php?action=add&code=<?php echo $product["product_code"]; ?>">
                      <div class="product-image">
                        <img src="data:image/jpeg;base64,<?php echo $product["productphoto"]; ?>"
                             class="card-img-top" alt="Product Image">
                    </div>
                    <div><strong><?php echo $product["product_name"]; ?></strong></div>
                    <div class="product-price"><?php echo "$" . $product["selling"]; ?></div>
                    <div><input type="text" name="quantity" value="1" size="2"/><input type="submit"
                                                                                       value="Add to cart"
                                                                                       class="btnAddAction"/>
                    </div>
                </form>
            </div>
            <?php
        }
    }
    ?>
</div>
</BODY>
</HTML>
