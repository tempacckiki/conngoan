<?php
class bannertruot_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	function get_all_product($productIDArr, $city_id = 25) {			
		$this->db->select ('shop_product.productid,shop_product.productname,shop_product.productimg, shop_price.*' );		
		$this->db->join ( 'shop_price', 'shop_price.productid = shop_product.productid' );
		$this->db->where_in ('shop_product.productid', $productIDArr);	
		$this->db->where ( 'shop_price.city_id', $city_id );			
		$this->db->order_by ( 'shop_product.productid', 'DESC' );		
		return $this->db->get ( 'shop_product')->result ();
	
	}

}