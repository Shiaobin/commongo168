<?php
// 商品項目類別
class CartItem
{
	var $_car_num;
	var $_ord_id;
	var $_MM_Username;
	var $_goods_id;
	var $_goods_name;
	var $_goods_price;
	var $_goods_stand;
	var $_goods_img;
	var $_goods_total;
	var $_goods_quantity;
	var $_goods_spec_1;
	var $_goods_spec_2;

	function CartItem($md5, $_ord_id, $_MM_Username, $_goods_id, $_goods_name, $_goods_price, $_goods_stand, $_goods_img, $_goods_spec_1, $_goods_spec_2, $_goods_quantity)
	{
		$this->_init();

		$this->_car_num = $md5;
		$this->_ord_id = $_ord_id;
		$this->_MM_Username = $_MM_Username;
		$this->_goods_id = $_goods_id;
		$this->_goods_name = $_goods_name;
		$this->_goods_price = $_goods_price;
		$this->_goods_stand = $_goods_stand;
		$this->_goods_img = $_goods_img;
		$this->_goods_quantity = $_goods_quantity;
		$this->_goods_spec_1 = $_goods_spec_1;
		$this->_goods_spec_2 = $_goods_spec_2;
		
		$this->_calc();
	}

	// 更新商品項目的數量
	function updateItem($_goods_quantity)
	{
		$this->_goods_quantity = $_goods_quantity;
		$this->_calc();
	}

	// 取得該項商品的價格小計
	function getSubTotal()
	{
		return $this->_goods_total;
	}

	// 取得該項商品的資訊
	function getItem()
	{
		$item = array();

		$item['car_num'] = $this->_car_num;
		$item['ord_id'] = $this->_ord_id;
		$item['MM_Username'] = $this->_MM_Username;
		$item['goods_id'] = $this->_goods_id;
		$item['goods_name'] = $this->_goods_name;
		$item['goods_price'] = $this->_goods_price;
		$item['goods_stand'] = $this->_goods_stand;
		$item['goods_img'] = $this->_goods_img;
		$item['goods_quantity'] = $this->_goods_quantity;
		$item['goods_total'] = $this->_goods_total;
		$item['goods_spec_1'] = $this->_goods_spec_1;
		$item['goods_spec_2'] = $this->_goods_spec_2;
		
		return $item;
	}

	function _init()
	{
		$_car_num = "";
		$_ord_id = "";
		$_MM_Username = "";
		$_goods_id = "";
		$_goods_name = "";
		$_goods_price = 0;
		$_goods_stand = "";
		$_goods_img = 0;
		$_goods_total = 0;
		$_goods_quantity = 0;
		$_goods_spec_1 = 0;
		$_goods_spec_2 = 0;

	}

	// 計算該項商品的小計價格
	function _calc()
	{
		$this->_goods_total = $this->_goods_quantity * $this->_goods_price;
	}

}

// 購物車主類別
class Cart
{
	var $_items = array();
	var $_total = 0;

	function Cart()
	{
		$this->_init();
	}

	// 新增一項商品
	function addItem($ord_id, $MM_Username, $goods_id, $goods_name, $goods_price, $goods_stand, $goods_img, $goods_spec_1, $goods_spec_2, $goods_quantity)
	{
		/* 以商品ID加入資料庫
		if( !isset($this->_items[$goods_id]) )
		{
			$this->_items[$goods_id] = null;
		}
		
		$is_used = false;
		foreach ($this->_items as $key => $item)
		{
			if( isset($item->goods_id ) )
			{
				$i_goods_id = $item->goods_id;
				if( strcmp( $goods_id, $i_goods_id ) == 0 )
				{
					$is_used = true;
					break;
				}
			}
		}
	  	*/
		$md5 = md5(uniqid(rand()));
		if( !isset($this->_items[$md5]) )
		{
			$this->_items[$md5] = null;
		}
		if ( !is_object($this->_items[$md5]) /*&& !$is_used*/ )
		{	
			$this->_items[$md5] = new CartItem($md5, $ord_id, $MM_Username, $goods_id, $goods_name, $goods_price, $goods_stand, $goods_img, $goods_spec_1, $goods_spec_2, $goods_quantity);

			$this->_refresh();
			$_SESSION['Cart'] = $this;
		}
	}

	// 更新某項商品的數量
	function updateItem($md5, $goods_quantity)
	{
		if (is_object($this->_items[$md5]))
		{
			$this->_items[$md5]->updateItem($goods_quantity);
			//$_SESSION['Cart']['items'][$sn] = $this->_items[$sn]->getItem();
			$this->_refresh();
			$_SESSION['Cart'] = $this;
		}
	}

	// 移除某項商品
	function removeItem($md5)
	{
		if (is_object($this->_items[$md5]))
		{
			unset ($this->_items[$md5]);
			//unset ($_SESSION['Cart']['items'][$sn]);
			$this->_refresh();
			$_SESSION['Cart'] = $this;
		}
	}

	// 清空購物車
	function clearCart()
	{
		unset ($this->_items);
		unset ($_SESSION['Cart']);
		$this->_init();
	}

	// 取得總價
	function getTotal()
	{
		$this->_refresh();
		return $this->_total;
	}
	
	// 取得所有的商品項目
	function getAllItems()
	{

		if(count($this->_items))
		{

			return $this->_items;

		}
		else
		{
			return false;
		}
	}

	// 初始化
	function _init()
	{
		// 如果購物車資料已經存在了

		 if(!isset($_SESSION['Cart']))
     	{
			//echo "cart is exit!";
        	$this->_items = array();
			$this->_total = 0;
        	$_SESSION['Cart']= $this;
        	
    	 }
   		else
   		{
   			//echo "cart is not exit!";
   			$cart = $_SESSION['Cart'];
			
			
   			$this->_items = $cart->_items;
   			$this->_total = $cart->_total;
   			$this->_refresh();
   			
   		}
		
	}

	// 重新計算總價
	function _refresh()
	{
		$this->_total = 0;

		reset ($this->_items);
		foreach ($this->_items as $key => $item)
		{
			$this->_total += $item->getSubTotal();
		}
		reset ($this->_items);

	}
}

?>