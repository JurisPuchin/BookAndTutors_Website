<?php

class CartModelxl {

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

    public function createInvoice($usr_id, $invoice_data) {
        $cid = $this->getUserCart($usr_id);

        //add an invoice entry to the invoice table
        $sql = "INSERT INTO invoice (customer_id, cart_id, order_date, total, shipping_cost, tax, grand_total) VALUES (:uid, :cid, :date, :total, :ship, :tax, :g_total)";
        $query = $this->db->prepare($sql);
        $parameters = array(':uid' => $usr_id,
            ':cid' => $cid,
            ':date' => $invoice_data['date'],
            ':total' => $invoice_data['total'],
            ':ship' => $invoice_data['shipping'],
            ':tax' => $invoice_data['tax'],
            ':g_total' => $invoice_data['g_total']);
        $query->execute($parameters);

        //make the cart an invoice
        $sql2 = "UPDATE cart SET name = :invoice WHERE id = :cid";
        $query2 = $this->db->prepare($sql2);
        $parameters2 = array(':invoice' => "invoice", ':cid' => $cid);
        $query2->execute($parameters2);
    }

    public function getUserCart($usr_id) {
        $sql = "SELECT id FROM cart AS id WHERE name = :current AND customer_id = :usr_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':current' => "current", ':usr_id' => $usr_id);
        $query->execute($parameters);
        $cid = $query->fetch();

        if ($cid == NULL) {
            $sql2 = "SELECT COUNT(id) AS num_carts FROM cart";
            $query2 = $this->db->prepare($sql2);
            $parameters2 = array(':cid' => $cid);
            $query2->execute($parameters2);
            $max_cid = $query2->fetch()->num_carts;

            $cid = $max_cid + 1;

            $sql3 = "INSERT INTO cart (id, customer_id, name) VALUES (:cid, :usr_id, :current)";
            $query3 = $this->db->prepare($sql3);
            $parameters3 = array(':cid' => $cid, ':usr_id' => $usr_id, ':current' => "current");
            $query3->execute($parameters3);
            return $cid;
        } else {
            return $cid->id;
        }
    }

    public function addCartItem($uid, $pid, $qty) {
        $cid = $this->getUserCart($uid);
        $sql = "INSERT INTO cart_item (cart_id, product_id, item_qty) VALUES (:cid, :pid, :iqty)";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':pid' => $pid, ':iqty' => $qty);
        $query->execute($parameters);
    }

    public function deleteCartItem($uid, $pid) {
        $cid = $this->getUserCart($uid);
        $sql = "DELETE FROM cart_item WHERE cart_id = :cid AND product_id = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':pid' => $pid);
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function getCartItems($uid) {
        $cid = $this->getUserCart($uid);
        $sql = "SELECT cart_id, product_id, item_qty FROM cart_item WHERE cart_id = :cid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getCartItemsCID($cid) {
        $sql = "SELECT cart_id, product_id, item_qty FROM cart_item WHERE cart_id = :cid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function updateCartItem($uid, $pid, $qty) {
        $cid = $this->getUserCart($uid);
        $sql = "UPDATE cart_item SET item_qty = :qty WHERE cart_id = :cid AND product_id = :pid";
        $query = $this->db->prepare($sql);
        $parameters = array(':cid' => $cid, ':pid' => $pid, ':qty' => $qty);
        //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

}
