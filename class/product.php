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
        $category_arr = $this->db->query("SELECT id, name FROM finder_transaction_commodity_category WHERE display = :display GROUP BY name");
        return $category_arr;
    }
    
    /**
     * 取得單一商品分類
     *
     * @return array
     */
    public function getCategoryById($id)
    {
        $this->db->bindMore(array("id"=>$id));
        $category_arr = $this->db->query("SELECT * FROM finder_transaction_commodity_category WHERE id = :id");
        return count($category_arr)==0?null:$category_arr[0];
    }
    
    /**
     * 取得所有商品分類
     *
     * @return array
     */
    public function getAllCategories($page=1, $page_size=10, $member_id=0)
    {
        if ($member_id==0) {
            
            if ($page==-1) {
                $category_arr = $this->db->query("SELECT id, name, display FROM finder_transaction_commodity_category ORDER BY id DESC");
                return $category_arr;
            } else {
                $this->db->bindMore(array("rows"=>$page_size, "offset"=>($page-1) * $page_size));
                $category_arr = $this->db->query("SELECT id, name, display FROM finder_transaction_commodity_category ORDER BY id DESC LIMIT :offset, :rows");
                return $category_arr;
            }
        } else {
            if ($page==-1) {
                $this->db->bindMore(array("member_id"=>$member_id));
                $category_arr = $this->db->query("SELECT id, name, display FROM finder_transaction_commodity_category WHERE member_id=:member_id ORDER BY id DESC");
                return $category_arr;
            } else {
                $this->db->bindMore(array("member_id"=>$member_id, "rows"=>$page_size, "offset"=>($page-1) * $page_size));
                $category_arr = $this->db->query("SELECT id, name, display FROM finder_transaction_commodity_category WHERE member_id=:member_id ORDER BY id DESC LIMIT :offset, :rows");
                return $category_arr;
            }
        }
    }
    
    /**
     * 取得分類數量
     *
     * @return array
     */
    public function getCategoriesCount($member_id=0)
    {
        if ($member_id==0) {
            $category_count = $this->db->query("SELECT COUNT(id) count FROM finder_transaction_commodity_category");
            return $category_count[0]['count'];
        } else {
            $category_count = $this->db->query("SELECT COUNT(id) count FROM finder_transaction_commodity_category WHERE member_id=:member_id",
                array(
                    'member_id'=>$member_id
                )
            );
            return $category_count[0]['count'];
        }
    }
    
    /**
     * 新增分類
     *
     * @return bool
     */
    public function addCategory($category)
    {
        $insert = $this->db->query("INSERT INTO finder_transaction_commodity_category(member_id,name,display) VALUES(:member_id,:name,:display)", $category);
        return ($insert > 0);
    }
    
    /**
     * 修改分類
     *
     * @return int
     */
    public function editCategory($category_id, $category)
    {
        $category['id'] = $category_id;
        return $this->db->query("UPDATE finder_transaction_commodity_category SET member_id=:member_id, name=:name, display=:display WHERE id=:id", $category);
    }
    
    /**
     * 刪除分類
     *
     * @return void
     */
    public function deleteCategory($category_id, $member_id)
    {
        $this->db->query("DELETE FROM finder_transaction_commodity_category WHERE id=:id AND member_id=:member_id",
            array(
                "id"=>$category_id,
                "member_id"=>$member_id
            )
        );
    }


    /**
     * 取得某商品分類的上架商品(分頁)
     *
     * @param integer $cid  商品分類id
     * @return array
     */
    public function getProducts($cid, $page=1, $page_size=10)
    {
        $this->db->bindMore(array("cid"=>$cid, "rows"=>$page_size, "offset"=>($page-1) * $page_size));
        $product_arr = $this->db->query("SELECT id, shop_price, shop_name, shop_image  FROM finder_transaction_commodity WHERE category_id = :cid AND shop_display = 1 LIMIT :offset, :rows");
        return $product_arr;
    }

    
    /**
     * 取得單一商品
     *
     * @return array
     */
    public function getProductById($id)
    {
        $this->db->bindMore(array("id"=>$id));
        $product_arr = $this->db->query("SELECT * FROM finder_transaction_commodity WHERE id = :id");
        return count($product_arr)==0?null:$product_arr[0];
    }
    
    /**
     * 取得所有商品分類
     *
     * @return array
     */
    public function getAllProducts($page=1, $page_size=10, $member_id=0)
    {
        if ($member_id==0) {
            $this->db->bindMore(array("rows"=>$page_size, "offset"=>($page-1) * $page_size));
            $product_arr = $this->db->query("SELECT * FROM finder_transaction_commodity ORDER BY id DESC LIMIT :offset, :rows");
            return $product_arr;
        } else {
            $this->db->bindMore(array("member_id"=>$member_id, "rows"=>$page_size, "offset"=>($page-1) * $page_size));
            $product_arr = $this->db->query("SELECT * FROM finder_transaction_commodity WHERE member_id=:member_id ORDER BY id DESC LIMIT :offset, :rows");
            return $product_arr;
        }
    }

    /**
     * 取得某商品分類的上架全部商品數量
     *
     * @param integer $cid  商品分類id
     * @return array
     */
    //public function getProducts($cid)
    public function getProductsCount($cid=0, $display=-1, $member_id=0)
    {
        if ($cid==0 && $display==-1 && $member_id==0) {
            $product_count = $this->db->query("SELECT COUNT(id) count FROM finder_transaction_commodity");
            return $product_count[0]['count'];
        } else {
            $q = array();
            $q_str = '';
            if ($cid!=0) {
                $q['category_id'] = $cid;
                $q_str .= ' category_id=:category_id ';
            }
            if ($display!=-1) {
                $q['shop_display'] = $display;
                if ($q_str!='') $q_str .= ' AND ';
                $q_str .= ' shop_display=:shop_display ';
            }
            if ($member_id!=0) {
                $q['member_id'] = $member_id;
                if ($q_str!='') $q_str .= ' AND ';
                $q_str .= ' member_id=:member_id ';
            }

            $sql = "SELECT COUNT(id) count FROM finder_transaction_commodity WHERE " . $q_str;
            $product_count = $this->db->query($sql, $q);
            return $product_count[0]['count'];
        }
    }
    
    /**
     * 新增商品
     *
     * @return bool
     */
    public function addProduct($product)
    {
        $insert = $this->db->query("INSERT INTO finder_transaction_commodity(member_id,shop_name,shop_spec_mode,shop_price,shop_stock,category_id,shop_display,commodity_spec,commodity_price,shop_image,shop_brief,updataDate,createDate) VALUES(:member_id,:shop_name,:shop_spec_mode,:shop_price,:shop_stock,:category_id,:shop_display,:commodity_spec,:commodity_price,:shop_image,'',NOW(),NOW())", $product);
        return ($insert > 0);
    }
    
    /**
     * 修改商品
     *
     * @return int
     */
    public function editProduct($product_id, $product)
    {
        $product['id'] = $product_id;
        return $this->db->query("UPDATE finder_transaction_commodity SET member_id=:member_id, shop_name=:shop_name, shop_spec_mode=:shop_spec_mode, shop_price=:shop_price, shop_stock=:shop_stock, category_id=:category_id, shop_display=:shop_display, commodity_spec=:commodity_spec, commodity_price=:commodity_price, shop_image=:shop_image, shop_brief='', updataDate=NOW(), createDate=NOW() WHERE id=:id", $product);
    }

    /**
     * 修改商品數量
     *
     * @return int
     */
    public function editProductStock($product_id, $product)
    {
        $product['id'] = $product_id;
        return $this->db->query("UPDATE finder_transaction_commodity SET shop_stock=:shop_stock, updataDate=NOW() WHERE id=:id", $product);
    }
    
    /**
     * 刪除商品
     *
     * @return void
     */
    public function deleteProduct($product_id, $member_id)
    {
        $this->db->query("DELETE FROM finder_transaction_commodity WHERE id=:id AND member_id=:member_id",
            array(
                "id"=>$product_id,
                "member_id"=>$member_id
            )
        );
    }

    /**
     * 取得商品價格
     *
     * @return array
     */
    public function getProductPrice($product_id)
    {
        return $this->db->query("SELECT * FROM finder_transaction_commodity_price WHERE commodity_id=:commodity_id",
            array(
                "commodity_id"=>$product_id
            )
        );
    }

    /**
     * 取得商品規格
     *
     * @return array
     */
    public function getProductSpec($product_id)
    {
        $spec_arr = $this->db->query("SELECT * FROM finder_transaction_commodity_price WHERE commodity_id=:commodity_id GROUP BY order_spec,order_item ORDER BY order_spec,order_item",
            array(
                "commodity_id"=>$product_id
            )
        );
        
        $specs = array();
        $size=count($spec_arr);
        for($j=0; $j<$size; $j++){
            $s = $spec_arr[$j];
            $spec_name = $s['spec_name'];
            if (!isset($specs[$spec_name])) {
                $specs[$spec_name] = array();
            }
            array_push($specs[$spec_name], array(
                'item_name'=> $s['item_name'],
                'price'=> $s['price'],
                'stock'=> $s['stock']
            ));
        }
        return $specs;
    }

    /**
     * 依商品名稱取得某商品分類的上架商品(分頁)
     *
     * @param integer $cname  商品分類name
     * @return array
     */
    public function getProductsByName($cname, $page=1, $page_size=10)
    {
        $this->db->bindMore(array("cname"=>$cname, "rows"=>$page_size, "offset"=>($page-1) * $page_size));
        //$product_arr = $this->db->query("SELECT id, shop_price, shop_name, shop_image  FROM finder_transaction_commodity WHERE category_id = :cid AND shop_display = 1 LIMIT :offset, :rows");
        $product_arr = $this->db->query("SELECT p.id, p.shop_price, p.shop_name, p.shop_image FROM finder_transaction_commodity p LEFT JOIN finder_transaction_commodity_category c ON p.category_id = c.id WHERE c.name = :cname AND p.shop_display = 1 ORDER BY p.id DESC LIMIT :offset, :rows");
        
        return $product_arr;
    }
    
    /**
     * 依商品名稱取得某商品分類的上架全部商品數量
     *
     * @param integer $cname  商品分類name
     * @return array
     */
    public function getProductsCountByName($cname)
    {
        $this->db->bindMore(array("cname"=>$cname));
        //$product_count = $this->db->query("SELECT COUNT(id) count FROM finder_transaction_commodity WHERE category_id = :cid AND shop_display = 1");
        $product_count = $this->db->query("SELECT COUNT(p.id) count FROM finder_transaction_commodity p LEFT JOIN finder_transaction_commodity_category c ON p.category_id = c.id WHERE c.name = :cname AND p.shop_display = 1");
        return $product_count[0]['count'];
    }

    /**
     * 取得單一上架商品資料
     *
     * @param integer $pid  商品id
     * @return array
     */
    public function getProduct($pid)
    {
        $this->db->bindMore(array("pid"=>$pid));
        $product_arr = $this->db->row("SELECT * FROM finder_transaction_commodity WHERE id = :pid AND shop_display = 1");
        return $product_arr;
    }

} 
?>