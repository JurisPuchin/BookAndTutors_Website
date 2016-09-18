<?php

class ProductsModelxl {

    /**
     * @var null Database Connection
     */
    public $db = null;

    function __construct() {
        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection() {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    public function addProduct($parameters) {
        $sql = "INSERT INTO product (customer_id, name, description, price, stock_qty, category_id, img1, img2, img3, img4) VALUES (:customer_id, :name, :description, :price, :stock_qty, :category_id, :img1, :img2, :img3, :img4)";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function deleteProduct($parameters) {
        $sql = "DELETE FROM product WHERE id = :product_id";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function updateProduct($parameters) {
        $sql = "UPDATE product SET name = :name, description = :description, price = :price , stock_qty = :stock_qty, category_id = :category_id  WHERE id = :product_id";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function updateProductImg($imgnumber, $parameters) {
        $sql = "UPDATE product SET img" . $imgnumber . " = :img WHERE id = :product_id";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }
    
    public function updateProductQty($parameters) {
        $sql = "UPDATE product SET stock_qty = :stock_qty WHERE id = :product_id";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function getAllProducts() {
        $sql = "SELECT id, name, description, price, stock_qty, img1, img2, img3, img4, category_id FROM product";
        $query = $this->db->prepare($sql);
        $query->execute();
        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getProduct($parameters) {
        $sql = "SELECT id, name, description, price, stock_qty, img1, img2, img3, img4, category_id FROM product WHERE id = :product_id LIMIT 1";
        $query = $this->db->prepare($sql);
        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

}
