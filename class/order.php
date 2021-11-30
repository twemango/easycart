<?php
include_once("pdo/Db.class.php");

/**
 * 訂單
 * @author      ken <ken@gogotdi.com>
 */
Class Order
{
    public $db;
    public function __construct()
    {
        $this->db = new DB;
    }

    /**
     * 新增訂單
     *
     * @param array $order_data  訂單資料
     * @return bool
     */
    public function addOrder($order_data)
    {
        $insert = $this->db->query("INSERT INTO finder_transaction_order(`id`, `order_No`, `buyer_id`, `seller_id`, `book_id`, `status`, `shipping_type`, `buy_type`, `pay_type`, `pay_status`, `dilivery`, `cvs_store_no`, `cvs_store_name`, `pay_way`, `invoice_type`, `amount`, `shipping_fee`, `remarks`, `createDate`, `note`, `connect_place`) VALUES
        (NULL, :order_No, :buyer_id, 23141, 0, 2, 0, 1, 0, 1, 'cvs2', '184737', '大華', 'scan2pay', 2, :amount, '0.00', '', NOW(), NULL, -1)", $order_data);
        return $this->db->lastInsertId();
    }

    /**
     * 新增訂單明細
     *
     * @param array $order_detail_data  訂單明細
     * @return bool
     */
    public function addOrderCommodity($order_detail_data)
    {
        $insert = $this->db->query("INSERT INTO `finder_transaction_order_commodity` (`order_id`, `commodity_id`, `price`, `qty`, `originalData`) VALUES
        (:order_id, :commodity_id, :price, :qty, :originalData)", $order_detail_data);
        return ($insert > 0);
    }

    /**
     * 依會員ID取得訂單資料
     *
     * @param integer $member_id  會員id
     * @return array
     */
    public function getOrderByMemberId($member_id)
    {
        $this->db->bindMore(array("member_id"=>$member_id));
        $orders = $this->db->query("SELECT * FROM finder_transaction_order WHERE buyer_id = :member_id ORDER BY id DESC");
        return $orders;
    }

    /**
     * 依訂單ID取得訂單明細資料
     *
     * @param integer $member_id  會員id
     * @param integer $order_id   訂單id
     * @return array
     */
    public function getOrderDetailByOrderId($member_id, $order_id)
    {
        $this->db->bindMore(array("member_id"=>$member_id, "order_id"=>$order_id));
        $order_details = $this->db->query("SELECT * FROM finder_transaction_order_commodity oc LEFT JOIN finder_transaction_order o ON oc.order_id = o.id WHERE oc.order_id = :order_id AND o.buyer_id = :member_id");
        return $order_details;
    }
    
} 
?>