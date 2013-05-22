<?php

/**
 * CreditNotes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CreditNotes extends BaseCreditNotes
{
	/**
	 * Create the configuration of the grid
	 */	
	public static function grid($rowNum = 10) {
		
		$translator = Zend_Registry::getInstance ()->Zend_Translate;
		
		$config ['datagrid'] ['columns'] [] = array ('label' => null, 'field' => 'cn.creditnote_id', 'alias' => 'creditnote_id', 'type' => 'selectall' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'ID' ), 'field' => 'cn.creditnote_id', 'alias' => 'creditnote_id', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Credit Note' ), 'field' => 'cn_number', 'alias' => 'cn_number', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Invoice Number' ), 'field' => 'i.number', 'alias' => 'cn_number', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Order Number' ), 'field' => 'o.order_id', 'alias' => 'o_number', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Date' ), 'field' => 'cn.creationdate', 'alias' => 'creationdate', 'sortable' => true, 'searchable' => true, 'type' => 'date' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Customer' ), 'field' => "CONCAT(c.firstname,' ', c.lastname, ' ', IFNULL('', c.company))", 'alias' => 'fullname', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		$config ['datagrid'] ['columns'] [] = array ('label' => $translator->translate ( 'Grand Total' ), 'field' => "cn.total", 'alias' => 'total', 'sortable' => true, 'searchable' => true, 'type' => 'string' );
		
		$config ['datagrid'] ['fields'] =  "creditnote_id, i.invoice_id,
											DATE_FORMAT(cn.creationdate, '%d/%m/%Y') as creationdate, 
											cn.number as cn_number, 
											cn.total as total, 
											i.number as i_number, 
											o.order_id as o_number, 
											CONCAT(c.firstname,' ', c.lastname, ' ', IFNULL('', c.company) ) as fullname";
		
		$config ['datagrid'] ['dqrecordset'] = Doctrine_Query::create ()
							                            ->select ( $config ['datagrid'] ['fields'] )
							                            ->from ( 'CreditNotes cn' )
							                            ->leftJoin ( 'cn.Invoices i' )
							                            ->leftJoin ( 'i.Customers c' )
							                            ->leftJoin ( 'i.Orders o' )
							                            ->orderBy ( 'cn.creationdate desc' );		
		
		$config ['datagrid'] ['rownum'] = $rowNum;
		
		$config ['datagrid'] ['basepath'] = "/admin/creditnotes/";
		$config ['datagrid'] ['index'] = "creditnote_id";
		$config ['datagrid'] ['rowlist'] = array ('10', '50', '100', '1000' );
		
		$config ['datagrid'] ['buttons'] ['edit'] ['label'] = $translator->translate ( 'Edit' );
		$config ['datagrid'] ['buttons'] ['edit'] ['cssicon'] = "edit";
		$config ['datagrid'] ['buttons'] ['edit'] ['action'] = "/admin/creditnotes/edit/id/%d";
		
		$config ['datagrid'] ['buttons'] ['delete'] ['label'] = $translator->translate ( 'Delete' );
		$config ['datagrid'] ['buttons'] ['delete'] ['cssicon'] = "delete";
		$config ['datagrid'] ['buttons'] ['delete'] ['action'] = "/admin/creditnotes/delete/id/%d";
		$config ['datagrid'] ['massactions'] = array ('bulk_export'=>'Pdf List','bulk_delete'=>'Mass Delete');
		return $config;
	}
	
	 /**
     * Get a record by invoice number
     * 
     * 
     * @param $number
     * @return Doctrine Record
     */
    public static function find_by_number($number) {
        return Doctrine::getTable ( 'CreditNotes' )
        ->findOneBy ( 'number', $number );
    }
	
    /**
     * Get all the records
     * 
     * 
     * @return Doctrine Record
     */
    public static function getAll() {
        return Doctrine::getTable ( 'CreditNotes' )->findAll(Doctrine_Core::HYDRATE_ARRAY);
    }
	
    /**
     * Update Credit note
     * 
     * 
     * @return Boolean
     */
    public static function updateTotals($id) {
    	$total_price = 0;
    	$total_vat = 0;
    	$total = 0;
    	
    	if(!empty($id) && is_numeric($id)){
	        $cn = CreditNotesItems::getDetails($id);
	        
	        foreach ($cn as $item) {
	        	$total_price += $item['price'];
	        	$total_vat += $item['vat'];
	        	$total += $item['total'];
	        }
	        
	        $creditnote = self::find($id);
			$creditnote['total_net'] = $total_price;
			$creditnote['total_vat'] = $total_vat;
			$creditnote['total'] = $total;
			return $creditnote->trySave();
    	}
    	
    	return false;
    }
    
    
    /**
     * Get all the credit notes for a select object
     */
    public static function getList($empty=false) {
        $items = array ();
        $arrTypes = Doctrine::getTable ( 'CreditNotes' )->findAll ();
        if($empty){
            $items[] = "";
        }
        foreach ( $arrTypes->getData () as $c ) {
            $items [$c ['creditnote_id']] = $z = sprintf("%03d", $c ['number']) . " - " . Shineisp_Commons_Utilities::formatDateOut($c ['creationdate']);
        }
        return $items;
    }

    /**
     * Save all the data
     * 
     * 
     * @param array $data
     */
    public static function saveAll($id, $data){
    	
    	// Set the new values
		if (is_numeric ( $id )) {
			$creditnote = self::find($id);
		}else{
			$creditnote = new CreditNotes();
		}
		
		$creditnote['creationdate'] = Shineisp_Commons_Utilities::formatDateIn($data['creationdate']);
		$creditnote['number'] = $data['number'];
		$creditnote['invoice_id'] = $data['invoice_id'];
		$creditnote['total_net'] = $data['total_net'];
		$creditnote['total_vat'] = $data['total_vat'];
		$creditnote['total'] = $data['total'];
		$creditnote['note'] = $data['note'];
		
    	if($creditnote->trySave()){
    		
    		if(!empty($data['description']) && !empty($data['price'])){
    			$creditnoteitem = new CreditNotesItems();
	    		$creditnoteitem['creditnote_id'] = $creditnote['creditnote_id'];
	    		$creditnoteitem['quantity'] = $data['quantity'];
	    		$creditnoteitem['description'] = $data['description'];
	    		$creditnoteitem['price'] = $data['price'];
	    		$creditnoteitem['vat'] = $data['vat'];
	    		$creditnoteitem['total'] = $data['price'] + $data['vat'];
	    		$creditnoteitem->save();
    		}
    		
    		self::updateTotals($creditnote['creditnote_id']);
    	}
    	
    	return $creditnote['creditnote_id'];
    }
    
	/**
     * Get a doctrine record by ID
     * 
     * 
     * @param $id
     * @return Doctrine Record
     */
    public static function find($id) {
        return Doctrine::getTable ( 'CreditNotes' )->findOneBy ( 'creditnote_id', $id );
    }
    
	/**
     * Get a array record by ID
     * 
     * 
     * @param $id
     * @return ArrayObject 
     */
    public static function get_by_id($id) {
    	$record = Doctrine_Query::create ()->from ( 'CreditNotes c' )
            		    					->where('c.creditnote_id = ?', $id)
            								->execute ( array (), Doctrine_Core::HYDRATE_ARRAY );		
		
        return !empty($record) ? $record[0] : array();
    }
    
    /**
     * Delete an credit note using its ID
     * 
     * 
     * @param $id
     * @return boolean
     */
    public static function DeleteByID($id) {
    	if(is_numeric($id)){
	        return Doctrine_Query::create ()->delete ()->from ( 'CreditNotes i' )->where ( 'creditnote_id = ?', $id )->execute ();
    	}
        return false;
    }
    
	/**
	 * delete the customer selected 
	 * @param array
	 * @return Boolean
	 */
	public static function massdelete($items) {
		$retval = Doctrine_Query::create ()->delete ()->from ( 'CreditNotes i' )->whereIn ( 'creditnote_id', $items )->execute ();
		return $retval;
	}    
	
	
	/**
	 * Get a credit note by id lists 
	 * 
	 * @param array $ids [1,2,3,4,...,n]
	 * @param string $fields
	 * @return Array
	 */
	public static function get_items($ids, $fields="*", $sortby=null) {
		return Doctrine_Query::create ()->select($fields)
										->from ( 'CreditNotes cn' )
										->leftJoin ( 'cn.Invoices i' )
										->leftJoin ( 'i.Orders o' )
										->leftJoin ( 'o.Customers c' )
										->leftJoin ( 'o.Statuses s' )
										->whereIn( "creditnote_id", $ids)
										->orderBy(!empty($sortby) ? $sortby : "")
										->execute ( array (), Doctrine::HYDRATE_ARRAY );
	}	

	
    /**
     * print the credit note
     * @param integer $creditnoteId
     */
    public static function PrintPDF($creditnoteId, $show=true) {
    		$currency = Zend_Registry::getInstance ()->Zend_Currency;
    		$pdf = new Shineisp_Commons_PdfOrder ( );
    		$translator = Zend_Registry::getInstance ()->Zend_Translate;
    		
    		$creditnote = Doctrine_Query::create ()->from ( 'CreditNotes cn' )
				                           ->leftJoin ( 'cn.CreditNotesItems cni' )
				                           ->leftJoin ( 'cn.Invoices i' )
				                           ->leftJoin ( 'i.Customers c' )
				                           ->leftJoin ( 'c.Addresses a' )
				                           ->leftJoin ( 'a.Countries co' )
				                           ->leftJoin ( 'i.Orders o' )
				                           ->leftJoin ( 'o.OrdersItems oi' )
				                           ->leftJoin ( 'o.Isp isp' )
				                           ->leftJoin ( 'o.Payments p' )
				                           ->leftJoin ( 'p.Banks b' )
				                           ->leftJoin ( 'o.Statuses s' )
				                           ->leftJoin ( 'o.Customers oc' )
				                           ->where( "cn.creditnote_id = ?", $creditnoteId)
				                           ->execute ( array (), Doctrine::HYDRATE_ARRAY );
				                           
    		if(empty($creditnote)){
    			return false;
    		}
    		
			$invoice  = $creditnote[0]['Invoices'];
			$customer = $creditnote[0]['Invoices']['Customers'];
			$payments = $creditnote[0]['Invoices']['Orders']['Payments'];
			$order    = $creditnote[0]['Invoices']['Orders'];
			$items    = $creditnote[0]['CreditNotesItems'];
			
			$database ['header'] ['label'] = $translator->translate('Credit Note No.') . " " . sprintf("%03d", $creditnote[0]['number']) . " - " . Shineisp_Commons_Utilities::formatDateOut ($creditnote[0]['creationdate']);
			$database ['columns'] [] = array ("value" => "Description" );
			$database ['columns'] [] = array ("value" => "Qty", "size" => 30, "align" => "center" );
			$database ['columns'] [] = array ("value" => "Unit", "size" => 30 );
			$database ['columns'] [] = array ("value" => "Tax Free Price", "size" => 60, "align" => "right" );
			$database ['columns'] [] = array ("value" => "VAT", "size" => 40, "align" => "right" );
			$database ['columns'] [] = array ("value" => "Total", "size" => 50, "align" => "right" );
			
			if (isset ( $order  )) {
				$info ['order_number'] = $order ['order_id'];
				$info ['invoice_number'] = $invoice ['number'];
				$info ['date'] = Shineisp_Commons_Utilities::formatDateOut ( $invoice ['invoice_date'] );
				
				//if customer comes from reseller
				if ($order ['Customers'] ['parent_id']) {
					$reseller = Customers::getAllInfo($order ['Customers'] ['parent_id']);
					$info ['customer'] ['customer_id'] = $reseller ['customer_id'];
					$info ['customer'] ['company'] = $reseller ['company'];
					$info ['customer'] ['firstname'] = $reseller ['firstname'];
					$info ['customer'] ['lastname'] = $reseller ['lastname'];
					$info ['customer'] ['vat'] = $reseller ['vat'];
					$info ['customer'] ['email'] = $reseller ['email'];
					
					if (isset ( $reseller ['Addresses'] [0] )) {
						$info ['customer'] ['address'] = $reseller ['Addresses'] [0] ['address'];
						$info ['customer'] ['city'] = $reseller ['Addresses'] [0] ['city'];
						$info ['customer'] ['code'] = $reseller ['Addresses'] [0] ['code'];
						$info ['customer'] ['country'] = !empty($reseller ['Addresses'] [0] ['Countries'] ['name']) ? $reseller ['Addresses'] [0] ['Countries'] ['name'] : "";
					}
				} else {
					$info ['customer'] ['customer_id'] = $customer  ['customer_id'];
					$info ['customer'] ['company'] = $customer  ['company'];
					$info ['customer'] ['firstname'] = $customer  ['firstname'];
					$info ['customer'] ['lastname'] = $customer  ['lastname'];
					$info ['customer'] ['vat'] = $customer  ['vat'];
					$info ['customer'] ['email'] = $customer  ['email'];
					
					if (isset ( $customer  ['Addresses'] [0] )) {
						$info ['customer'] ['address'] = $customer ['Addresses'] [0] ['address'];
						$info ['customer'] ['city'] = $customer ['Addresses'] [0] ['city'];
						$info ['customer'] ['code'] = $customer ['Addresses'] [0] ['code'];
						$info ['customer'] ['country'] = $customer ['Addresses'] [0] ['Countries'] ['name'];
					}
				}
				
				if (count ( $payments ) > 0) {
					$info ['payment_date'] = Shineisp_Commons_Utilities::formatDateOut ( $payments [0] ['paymentdate'] );
					$info ['payment_mode'] = $payments [0] ['Banks'] ['name'];
					$info ['payment_description'] = $payments [0] ['description'];
					$info ['payment_transaction_id'] = $payments [0] ['reference'];
				}
				
				$info ['invoice_id'] = $invoice ['number'];
				
				$info ['company'] ['name'] = $order  ['Isp'] ['company'];
				$info ['company'] ['vat'] = $order  ['Isp'] ['vatnumber'];
				$info ['company'] ['bankname'] = $order  ['Isp'] ['bankname'];
				$info ['company'] ['iban'] = $order  ['Isp'] ['iban'];
				$info ['company'] ['bic'] = $order  ['Isp'] ['bic'];
				$info ['company'] ['address'] = $order  ['Isp'] ['address'];
				$info ['company'] ['zip'] = $order  ['Isp'] ['zip'];
				$info ['company'] ['city'] = $order  ['Isp'] ['city'];
				$info ['company'] ['country'] = $order  ['Isp'] ['country'];
				$info ['company'] ['telephone'] = $order  ['Isp'] ['telephone'];
				$info ['company'] ['fax'] = $order  ['Isp'] ['fax'];
				$info ['company'] ['website'] = $order  ['Isp'] ['website'];
				$info ['company'] ['email'] = $order  ['Isp'] ['email'];
				$info ['company'] ['slogan'] = $order  ['Isp'] ['slogan'];
				
				$info ['subtotal'] = $currency->toCurrency($creditnote[0] ['total_net'], array('currency' => Settings::findbyParam('currency')));
				$info ['grandtotal'] = $currency->toCurrency($creditnote[0] ['total'], array('currency' => Settings::findbyParam('currency')));
				$info ['vat'] = $currency->toCurrency($creditnote[0] ['vat'], array('currency' => Settings::findbyParam('currency')));
				$info ['delivery'] = 0;
				
				$database ['records'] = $info;
				
//				Zend_Debug::dump($creditnote);
//				die;
				foreach ( $items as $item ) {
					$item ['price'] = $currency->toCurrency($item ['price'], array('currency' => Settings::findbyParam('currency')));
					$item ['vat'] = $currency->toCurrency($item ['vat'], array('currency' => Settings::findbyParam('currency')));
					$item ['total'] = $currency->toCurrency($item ['total'], array('currency' => Settings::findbyParam('currency')));
					$database ['records'] [] = array ($item ['description'], $item ['quantity'], 'nr', $item ['price'], $item ['vat'], $item ['total']);
				}

				if (isset ( $order  )) {
					$pdf->CreatePDF (  $database, $creditnote[0] ['creationdate'] . " - " . $creditnote[0] ['number'] . ".pdf", $show, "/documents/creditnotes", true);
				}
			}
		}
	######################################### BULK ACTIONS ############################################
	
	
	/**
	 * delete the credit notes selected 
	 * 
	 * @param array
	 * @return Boolean
	 */
	public static function bulk_delete($items) {
		if(!empty($items)){
			return self::massdelete($items);
		}
		return false;
	}
		
	/**
	 * export the content in a pdf file
	 * @param array $items
	 */
	public function bulk_export($items) {
		$isp = Isp::getActiveISP();
		$pdf = new Shineisp_Commons_PdfList();
		$translator = Zend_Registry::getInstance ()->Zend_Translate;
		
		// Get the records from the order table
		$creditnotes = self::get_items($items, "creditnote_id, i.number as invoicenum, DATE_FORMAT(o.order_date, '%d/%m/%Y') as orderdate, c.company as company, CONCAT(c.firstname, ' ', c.lastname) as fullname, cn.total as total, cn.total_vat as vat, cn.total as grandtotal, s.status as status", 'cn.creationdate');

		// Create the PDF header
		$grid['headers']['title'] = $translator->translate('Credit Notes List');
		$grid['headers']['subtitle'] = $translator->translate('List of the credit notes');
		$grid['footer']['text'] = $isp['company'] . " - " . $isp['website'];
		 
		if(!empty($creditnotes[0]))

			// Create the columns of the grid
			$grid ['columns'] [] = array ("value" => $translator->translate('Credit Note'), 'size' => 50);
			$grid ['columns'] [] = array ("value" => $translator->translate('Invoice'), 'size' => 50);
			$grid ['columns'] [] = array ("value" => $translator->translate('Date'), 'size' => 100);
			$grid ['columns'] [] = array ("value" => $translator->translate('Company'));
			$grid ['columns'] [] = array ("value" => $translator->translate('Fullname'));
			$grid ['columns'] [] = array ("value" => $translator->translate('Total'), 'size' => 50);
			$grid ['columns'] [] = array ("value" => $translator->translate('VAT'), 'size' => 50);
			$grid ['columns'] [] = array ("value" => $translator->translate('Grand Total'), 'size' => 50);
			$grid ['columns'] [] = array ("value" => $translator->translate('Status'), 'size' => 100);
			
			// Getting the records values and delete the first column the customer_id field.
			foreach ($creditnotes as $item){
				$values = array_values($item);
				$grid ['records'] [] = $values;
			}
				
			// Create the PDF
			die($pdf->create($grid));
		
		return false;	
	}    
    	
}