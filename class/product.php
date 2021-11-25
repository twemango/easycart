<?php
include_once("pdo/Db.class.php");

/**
 * 商品類
 * @author      ken <ken@gogotdi.com>
 */
Class Product
{
    public $db;
    public function __construct()
    {
        $this->db = new DB;
    }
    
    /**
     * 取得可顯示的商品分類
     *
     * @return array
     */
    public function getCategories()
    {
        $this->db->bindMore(array("display"=>1));
        $category_arr = $this->db->query("SELECT id, name FROM finder_transaction_commodity_category WHERE display = :display");
        //echo '<pre>category_arr'.print_r($category_arr, 1).'</pre>';
        return $category_arr;
    }

    /**
     * 取得某商品分類的上架商品(分頁)
     *
     * @param integer $cid  商品分類id
     * @return array
     */
    //public function getProducts($cid)
    public function getProducts($cid, $page=1, $page_size=10)
    {

        $this->db->bindMore(array("cid"=>$cid, "limit"=>$page, "offset"=>$page_size));
        $product_arr = $this->db->query("SELECT id, shop_price, shop_name, shop_image  FROM finder_transaction_commodity WHERE category_id = :cid AND shop_display = 1 LIMIT :limit, :offset");
        return $product_arr;
    }
    
    /**
     * 取得某商品分類的上架全部商品數量
     *
     * @param integer $cid  商品分類id
     * @return array
     */
    //public function getProducts($cid)
    public function getProductsCount($cid)
    {
        $this->db->bindMore(array("cid"=>$cid));
        $product_count = $this->db->query("SELECT COUNT(id) count FROM finder_transaction_commodity WHERE category_id = :cid AND shop_display = 1");
        return $product_count[0]['count'];
    }
} 
?>