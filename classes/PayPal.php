<?php

class PayPal {



	private $_environment = 'sandbox';




	private $_url_production = 'https://www.paypal.com/cgi-bin/webscr';
	private $_url_sandbox = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

	// url to be used

	private $_url;
	private $_cmd;
	private $_products = array();
	private $_fields = array();
	private $_business = 'patel_25@hotmail.co.uk';
	private $_page_style = null;
	private $_return;
	private $_cancel_payment;

	// notify url (IPN)

	private $_notify_url;

	// currency code

	private $_currency_code = 'GBP';

	//tax / vat amount for _cart purposes

	public $_tax_cart = 0;

	// tax / vat amount for _xclick

	public $_tax = 0;

    // prepopulted checkout pages
    // address1 , address 2 , city, , town , postcode , country, email, first_name, last_name,

     public $_populate = array();
	
	// data received from paypal
	private $_ipn_data = array();
	
	// path to the log file for ipn response
	private $_log_file = null;
	
	// result of sending data back to paypal after ipn
	private $_ipn_result;




     	public function __construct($cmd = '_cart') {
		
		$this->_url = $this->_environment == 'sandbox' ?
						$this->_url_sandbox :
						$this->_url_production;
						
		$this->_cmd = $cmd;
		
		$this->_return = SITE_URL."/?page=return";
		$this->_cancel_payment = SITE_URL."/?page=cancel";
		$this->_notify_url = SITE_URL."/?page=ipn";
		$this->_log_file = ROOT_PATH.DS."log".DS."ipn.log";
		
	}


		public function addProduct($number, $name, $price = 0, $qty = 1) {
	
		switch($this->_cmd) {
			
			case '_cart':
			$id = count($this->_products) + 1;
			$this->_products[$id]['item_number_'.$id] = $number;
			$this->_products[$id]['item_name_'.$id] = $name;
			$this->_products[$id]['amount_'.$id] = $price;
			$this->_products[$id]['quantity_'.$id] = $qty;
			break;
			case '_xclick':
			if (empty($this->_products)) {
				$this->_products[0]['item_number'] = $number;
				$this->_products[0]['item_name'] = $name;
				$this->_products[0]['amount'] = $price;
				$this->_products[0]['quantity'] = $qty;
			}
			break;
			
		}
	
	}
     


     	private function addField($name = null, $value = null) {
		if (!empty($name) && !empty($value)) {
			$field  = '<input type="hidden" name="'.$name.'" ';
			$field .= 'value="'.$value.'" />';
			$this->_fields[] = $field;
		}
	}


		private function standardFields() {
		$this->addField('cmd', $this->_cmd);
		$this->addField('business', $this->_business);
		if ($this->_page_style != null) {
			$this->addField('page_style', $this->_page_style);
		}
		$this->addField('return', $this->_return);
		$this->addField('notify_url', $this->_notify_url);
		$this->addField('cancel_payment', $this->_cancel_payment);
		$this->addField('currency_code', $this->_currency_code);
		$this->addField('rm', 2);
		
		switch($this->_cmd) {
			case '_cart':
			if ($this->_tax_cart != 0) {
				$this->addField('tax_cart', $this->_tax_cart);
			}
			$this->addField('upload', 1);
			break;
			case '_xclick':
			if ($this->_tax != 0) {
				$this->addField('tax', $this->_tax);
			}
			break;
		}
		
	}




		private function prePopulate() {
		if (!empty($this->_populate)) {
			foreach($this->_populate as $key => $value) {
				$this->addField($key, $value);
			}
		}
	}
	
























		private function processFields() {
		$this->standardFields();
		if (!empty($this->_products)) {
			foreach($this->_products as $product) {
				foreach($product as $key => $value) {
					$this->addField($key, $value);
				}
			}
		}
		$this->prePopulate();
	}




















	private function getFields() {
		$this->processFields();
		if (!empty($this->_fields)) {
			return implode("", $this->_fields);
		}
	}










     private function render() {
		$out  = '<form action="'.$this->_url.'" method="post" id="frm_paypal">';
		$out .= $this->getFields();
		$out .= '<input type="submit" value="Submit" />';
		$out .= '</form>';
		return $out;
	}











		public function run($transaction_id = null) {
		if (!empty($transaction_id)) {
			$this->addField('custom', $transaction_id);
		}
		return $this->render();
	}










}