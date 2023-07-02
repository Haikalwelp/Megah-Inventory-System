<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <title>Orders with Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .order-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .order-status.pending {
            background-color: yellow;
        }
        .order-status.shipped {
            background-color: green;
            color: white;
        }
        .order-status.cancelled {
            background-color: red;
            color: white;
        }
        .order-status.refund {
            background-color: blue;
            color: white;
        }
    </style>
</head>
<body>
    <?php include "adminnavigation.php"; ?>
    <br><br><br><br>
    <div class="container">
        <h1>Order Management</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Order Status</th>
                    <th></th> <!-- Empty header for the edit button -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Include necessary files and initialize classes
                require_once "../config/autoload.php";
                $orderController = new OrderController();
                $userController = new UserController();

                // Get all orders
                $orders = $orderController->getOrdersController();

                if ($orders) {
                    foreach ($orders as $order) {
                        $orderId = $order['orderid'];
                        $userId = $order['userid'];

                        // Get user details based on user ID
                        $user = $userController->getUserByIdController($userId);

                        if ($user) {
                            $userName = $user['username'];
                        } else {
                            $userName = "User Not Found";
                        }

                        $orderStatus = $order['orderstatus'];
                        $statusClass = '';

                        switch ($orderStatus) {
                            case 'Pending':
                                $statusClass = 'pending';
                                break;
                            case 'Shipped':
                                $statusClass = 'shipped';
                                break;
                            case 'Cancelled':
                                $statusClass = 'cancelled';
                                break;
                            case 'Refund':
                                $statusClass = 'refund';
                                break;
                            default:
                                $statusClass = '';
                        }

                        // Generate a unique ID for the edit modal
                        $editModalId = "editModal_$orderId";

                        echo "<tr>";
                        echo "<td>$orderId</td>";
                        echo "<td>$userId</td>";
                        echo "<td>$userName</td>";
                        echo "<td>{$order['address']}</td>";
                        echo "<td>{$order['paymentmethod']}</td>";
                        echo "<td><span class='order-status $statusClass'>$orderStatus</span></td>";

                        // Add the Edit button
                        echo "<td><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#$editModalId'>Edit</button></td>";

                        echo "</tr>";

                        // Create the Edit modal
                        echo "<div class='modal fade' id='$editModalId' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog' role='document'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='editModalLabel'>Edit Order</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<form action='editorder.php' method='post'>";
                        // Add input fields for editing the order details
                        echo "<label for='orderId'>Order ID:</label>";
                        echo "<input type='text' id='orderId' name='orderId' value='$orderId' readonly>";
                        echo "<label for='userId'>User ID:</label>";
                        echo "<input type='text' id='userId' name='userId' value='$userId' readonly>";
                        echo "<label for='userName'>User Name:</label>";
                        echo "<input type='text' id='userName' name='userName' value='$userName'>";
                        echo "<label for='address'>Address:</label>";
                        echo "<input type='text' id='address' name='address' value='{$order['address']}'>";
                        echo "<label for='paymentMethod'>Payment Method:</label>";
                        echo "<input type='text' id='paymentMethod' name='paymentMethod' value='{$order['paymentmethod']}'>";
                        echo "<label for='orderStatus'>Order Status:</label>";
                        echo "<select id='orderStatus' name='orderStatus'>";
                        echo "<option value='Pending' " . ($orderStatus == 'Pending' ? 'selected' : '') . ">Pending</option>";
                        echo "<option value='Shipped' " . ($orderStatus == 'Shipped' ? 'selected' : '') . ">Shipped</option>";
                        echo "<option value='Cancelled' " . ($orderStatus == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>";
                        echo "<option value='Refund' " . ($orderStatus == 'Refund' ? 'selected' : '') . ">Refund</option>";
                        echo "</select>";
                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
