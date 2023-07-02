    <?php
   class Order extends Connection
   {
       public function getOrders()
       {
           $connection = $this->getConnection();
   
           // Assuming the table name is 'orders'
           $query = "SELECT orderid, userid, address, paymentmethod, orderstatus FROM orders";
           $result = mysqli_query($connection, $query);
   
           if ($result) {
               $orders = array();
   
               while ($row = mysqli_fetch_assoc($result)) {
                   $orders[] = $row;
               }
   
               return $orders;
           } else {
               return false;
           }
       }
   
       public function deleteOrders($orderIds)
       {
           $connection = $this->getConnection();
   
           // Assuming the table name is 'orders'
           $deleteQuery = "DELETE FROM orders WHERE orderid IN (";
           $deleteQuery .= implode(',', array_fill(0, count($orderIds), '?'));
           $deleteQuery .= ")";
           $deleteStatement = mysqli_prepare($connection, $deleteQuery);
   
           if ($deleteStatement) {
               $types = str_repeat('i', count($orderIds));
               mysqli_stmt_bind_param($deleteStatement, $types, ...$orderIds);
   
               $deleteSuccess = mysqli_stmt_execute($deleteStatement);
   
               if ($deleteSuccess) {
                   return true;
               }
   
               return false;
           }
   
           return false;
       }
   
       public function editOrder($orderId, $address, $paymentMethod, $orderStatus)
       {
           $connection = $this->getConnection();
   
           $query = "UPDATE orders SET address = ?, paymentmethod = ?, orderstatus = ? WHERE orderid = ?";
           $statement = mysqli_prepare($connection, $query);
   
           if ($statement) {
               mysqli_stmt_bind_param($statement, 'sssi', $address, $paymentMethod, $orderStatus, $orderId);
               $updateSuccess = mysqli_stmt_execute($statement);
   
               if ($updateSuccess) {
                   return true;
               }
           }
   
           return false;
       }
   
       public function addOrder($orderData)
       {
           $connection = $this->getConnection();
   
           $userid = $orderData['userid'];
           $address = $orderData['address'];
           $paymentmethod = $orderData['paymentmethod'];
           $orderstatus = $orderData['orderstatus'];
   
           // Assuming the table name is 'orders'
           $query = "INSERT INTO orders (userid, address, paymentmethod, orderstatus) 
               VALUES (?, ?, ?, ?)";
           $statement = mysqli_prepare($connection, $query);
   
           if ($statement) {
               mysqli_stmt_bind_param($statement, 'isss', $userid, $address, $paymentmethod, $orderstatus);
               $insertSuccess = mysqli_stmt_execute($statement);
   
               if ($insertSuccess) {
                   return true;
               }
           }
   
           return false;
       }
   
       public function getOrderByOrderId($orderId)
       {
           $connection = $this->getConnection();
   
           // Assuming the table name is 'orders'
           $query = "SELECT orderid, userid, address, paymentmethod, orderstatus FROM orders WHERE orderid = ?";
           $statement = mysqli_prepare($connection, $query);
   
           if ($statement) {
               mysqli_stmt_bind_param($statement, 'i', $orderId);
               mysqli_stmt_execute($statement);
   
               mysqli_stmt_bind_result($statement, $orderid, $userid, $address, $paymentmethod, $orderstatus);
   
               if (mysqli_stmt_fetch($statement)) {
                   $result = [
                       'orderid' => $orderid,
                       'userid' => $userid,
                       'address' => $address,
                       'paymentmethod' => $paymentmethod,
                       'orderstatus' => $orderstatus
                   ];
   
                   return $result;
               }
           }
   
           return false;
       }

       public function createOrder($userId, $address, $paymentMethod, $orderStatus)
       {
           $connection = $this->getConnection();
   
           $query = "INSERT INTO orders (userid, address, paymentmethod, orderstatus) 
               VALUES (?, ?, ?, ?)";
           $statement = mysqli_prepare($connection, $query);
   
           if ($statement) {
               mysqli_stmt_bind_param($statement, 'isss', $userId, $address, $paymentMethod, $orderStatus);
               $insertSuccess = mysqli_stmt_execute($statement);
   
               if ($insertSuccess) {
                   return true;
               }
           }
   
           return false;
       }
   

   }
   
    ?>