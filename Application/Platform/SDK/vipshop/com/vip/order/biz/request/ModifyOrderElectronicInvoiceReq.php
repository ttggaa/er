<?php


/*
* Copyright (c) 2008-2016 vip.com, All Rights Reserved.
*
* Powered by com.vip.osp.osp-idlc-2.5.11.
*
*/

namespace com\vip\order\biz\request;

class ModifyOrderElectronicInvoiceReq {
	
	static $_TSPEC;
	public $orderElectronicInvoiceVO = null;
	
	public function __construct($vals=null){
		
		if (!isset(self::$_TSPEC)){
			
			self::$_TSPEC = array(
			1 => array(
			'var' => 'orderElectronicInvoiceVO'
			),
			
			);
			
		}
		
		if (is_array($vals)){
			
			
			if (isset($vals['orderElectronicInvoiceVO'])){
				
				$this->orderElectronicInvoiceVO = $vals['orderElectronicInvoiceVO'];
			}
			
			
		}
		
	}
	
	
	public function getName(){
		
		return 'ModifyOrderElectronicInvoiceReq';
	}
	
	public function read($input){
		
		$input->readStructBegin();
		while(true){
			
			$schemeField = $input->readFieldBegin();
			if ($schemeField == null) break;
			$needSkip = true;
			
			
			if ("orderElectronicInvoiceVO" == $schemeField){
				
				$needSkip = false;
				
				$this->orderElectronicInvoiceVO = new \com\vip\order\common\pojo\order\vo\OrderElectronicInvoiceVO();
				$this->orderElectronicInvoiceVO->read($input);
				
			}
			
			
			
			if($needSkip){
				
				\Osp\Protocol\ProtocolUtil::skip($input);
			}
			
			$input->readFieldEnd();
		}
		
		$input->readStructEnd();
		
		
		
	}
	
	public function write($output){
		
		$xfer = 0;
		$xfer += $output->writeStructBegin();
		
		if($this->orderElectronicInvoiceVO !== null) {
			
			$xfer += $output->writeFieldBegin('orderElectronicInvoiceVO');
			
			if (!is_object($this->orderElectronicInvoiceVO)) {
				
				throw new \Osp\Exception\OspException('Bad type in structure.', \Osp\Exception\OspException::INVALID_DATA);
			}
			
			$xfer += $this->orderElectronicInvoiceVO->write($output);
			
			$xfer += $output->writeFieldEnd();
		}
		
		
		$xfer += $output->writeFieldStop();
		$xfer += $output->writeStructEnd();
		return $xfer;
	}
	
}

?>