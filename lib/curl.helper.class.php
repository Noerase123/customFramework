<?php

class CurlHelper{
	
	function do_curl($data="",$post_url="",$soap_action_url="",$post_req="",$soap_req=""){
	
		$tuCurl = curl_init();
		curl_setopt($tuCurl, CURLOPT_URL, $post_url.$post_req);
		curl_setopt($tuCurl, CURLOPT_PORT , 80);
		curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
		curl_setopt($tuCurl, CURLOPT_HEADER, 0);
		curl_setopt($tuCurl, CURLOPT_SSLVERSION, 3);
		curl_setopt($tuCurl, CURLOPT_SSLCERT, getcwd() . "/client.pem");
		curl_setopt($tuCurl, CURLOPT_SSLKEY, getcwd() . "/keyout.pem");
		curl_setopt($tuCurl, CURLOPT_CAINFO, getcwd() . "/ca.pem");
		curl_setopt($tuCurl, CURLOPT_POST, 1);
		curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($tuCurl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml","SOAPAction: \"".$soap_action_url.$soap_req."\"", "Content-length: ".strlen($data)));

		$tuData = curl_exec($tuCurl);
		$c=0;
		if(!curl_errno($tuCurl)){
			$c++;
		}else{
			$cerror = 'Curl error: ' . curl_error($tuCurl);
		}
		curl_close($tuCurl);
		
		if($c>0){
			return $tuData;
		}else{
			return 0;
		}
		
	
	}
	
	function getpropertyname($property_code=""){
		
		$today  	=  mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		$today		= date("Y-m-d", $today);
		$tomorrow  	= mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
		$tomorrow	= date("Y-m-d", $tomorrow);
		
		$property = "";
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		$xmlfooter = '</soap:Body>
		</soap:Envelope>';
		
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$today.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$tomorrow.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		 
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');

			 foreach ($xml->xpath('//hc:HotelReference') as $item) {
				$property = (string) $item;
				
			}
		
		return $property;
		
	}
	
	function checkavailability($start_date="",$end_date="",$property_code=""){
		
		$c=0;
		
		$start_date	= date('Y-m-d',strtotime($start_date));
		$end_date  	= date('Y-m-d',strtotime($end_date));
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		
		$xmlfooter = '</soap:Body></soap:Envelope>';
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		
		
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$start_date.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$end_date.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		 
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');

			foreach ($xml->xpath('//hc:HotelReference') as $item) {
				$c=1;	
			}
			$rooms=0;
			if($c==1){
				foreach ($xml->xpath('//hc:RoomType') as $item){
					$rooms++;			
				}
			}
		
		return $rooms;
		
	}
	
	function iscorporate($corporate_code="",$property_code=""){
		
		$today  	=  mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		$start_date		= date("Y-m-d", $today);
		$tomorrow  	= mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
		$end_date	= date("Y-m-d", $tomorrow);
		
		
		$isvalid = 0;
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		$xmlfooter = '</soap:Body>
		</soap:Envelope>';
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$start_date.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$end_date.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:RatePlanCandidates>
				<a:RatePlanCandidate qualifyingIdType="CORPORATE" qualifyingIdValue="'.$corporate_code.'" />
			</a:RatePlanCandidates>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		 
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');
			
			$x=0;
			foreach ($xml->xpath('//hc:RatePlan') as $item) {
				if((string)$item['ratePlanCategory']=='NEG'){
					$isvalid = 1;
				}else{
					$x++;
				}
			}
			$isvalid = $x>0 ? 0 : $isvalid;
		return $isvalid;
		
	}
	
	function getrooms($property_code="",$start_date="",$end_date=""){
		
		$start_date	= date('Y-m-d',strtotime($start_date));
		$end_date  	= date('Y-m-d',strtotime($end_date));
		
		unset($roomcodes);
		$roomcodes = array();
		
		$c = 0;
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		$xmlfooter = '</soap:Body>
		</soap:Envelope>';
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$start_date.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$end_date.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		 
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');
			
			foreach ($xml->xpath('//hc:HotelReference') as $item) {
				
				if( (string) $item['hotelCode'] == $property_code ){
					$c=1;
				}
			}
			
			 if($c==1){
				
				foreach ($xml->xpath('//hc:RoomType') as $item) { 
					$roomcodes[] = (string)$item['roomTypeCode']; 
				}	
			}
			
		return $roomcodes;
		
	}
	
	function getroomname($property_code="",$roomcode=""){
		
		$today  	=  mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		$start_date		= date("Y-m-d", $today);
		$tomorrow  	= mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
		$end_date	= date("Y-m-d", $tomorrow);
		
		$roomname = "";
		
		$c = 0;
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		$xmlfooter = '</soap:Body>
		</soap:Envelope>';
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$start_date.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$end_date.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		 
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');
			
			foreach ($xml->xpath('//hc:HotelReference') as $item) {
				
				if( (string) $item['hotelCode'] == $property_code ){
					$c=1;
				}
			}
			
			 if($c==1){
				
				foreach ($xml->xpath('//hc:RoomType') as $item) { 
					if ((string)$item['roomTypeCode']==$roomcode){
						$roomname = (string)$item['roomTypeName'] == ' ' ? $item : (string)$item['roomTypeName'];
					}
				}	
			}
			
		
		return $roomname;
		
	}
	
	function getroominfo($property_code="",$roomcode=""){
		
		$today  	=  mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		$start_date		= date("Y-m-d", $today);
		$tomorrow  	= mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
		$end_date	= date("Y-m-d", $tomorrow);
		
		unset($roominfo);
		$roominfo = array();
		
		$c = 0;
		
		$xmlheader = '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
		<soap:Header>
			<OGHeader transactionID="000032" primaryLangID="E" timeStamp="2008-12-09T09:55:16.3618750-05:00" xmlns="http://webservices.micros.com/og/4.3/Core/">
			  <Origin entityID="OWS" systemType="WEB" />
			  <Destination entityID="TI" systemType="PMS" />
			</OGHeader>
		</soap:Header>
		<soap:Body>';
		
		$functionsoapreq = 'Availability.wsdl#Availability';
		$functionpostreq = 'Availability.asmx';
		
		$xmlfooter = '</soap:Body>
		</soap:Envelope>';
		
		$xmlreq = '<AvailabilityRequest xmlns:a="http://webservices.micros.com/og/4.3/Availability/" xmlns:hc="http://webservices.micros.com/og/4.3/HotelCommon/" summaryOnly="true" xmlns="http://webservices.micros.com/ows/5.1/Availability.wsdl">
		  <a:AvailRequestSegment availReqType="Room" numberOfRooms="1" totalNumberOfGuests="1" totalNumberOfChildren="0">
			<a:StayDateRange>
			  <hc:StartDate>'.$start_date.'T00:00:00.0000000-05:00</hc:StartDate>
			  <hc:EndDate>'.$end_date.'T00:00:00.0000000-05:00</hc:EndDate>
			</a:StayDateRange>
			<a:HotelSearchCriteria>
			  <a:Criterion>
				<a:HotelRef chainCode="CHA" hotelCode="'.$property_code.'" />
			  </a:Criterion>
			</a:HotelSearchCriteria>
		  </a:AvailRequestSegment>
		</AvailabilityRequest>';
		
		$dataxml = $xmlheader.$xmlreq.$xmlfooter;
					
		$xmldata = $this->do_curl($dataxml,POST_URL,SOAP_ACTION_URL,$functionpostreq,$functionsoapreq);
		 
		
		
		$x=0;
		$y=0;
		$j=0;
		
		 $xml = simplexml_load_string($xmldata); 
		 //$xml = simplexml_load_file('GeneralAvailability.resp.xml'); 
		 $xml->registerXPathNamespace('hc', 'http://webservices.micros.com/og/4.3/HotelCommon/');
			
			foreach ($xml->xpath('//hc:HotelReference') as $item) {
				
				if( (string) $item['hotelCode'] == $property_code ){
					$c=1;
				}
			}
			
			 if($c==1){
				
				foreach ($xml->xpath('//hc:RoomType') as $item) { 
					if ((string)$item['roomTypeCode']==$roomcode){
						
						$roominfo[] = (string)$item['roomTypeName'];
						$y=$x;
						$j++;
					}
					$x++;
				}
				if($j>0){
				$i=0;
					foreach ($xml->xpath('//hc:RoomType/hc:RoomTypeDescription/hc:Text') as $item) {
						
						if ($i==$y){
							$roominfo[] = (string)$item;
						}
						$i++;
					}
					$i=0;
					foreach ($xml->xpath('//hc:RoomRate/hc:Rates/hc:Rate/hc:Base') as $item) {
						
						if ($i==$y){
							$roominfo[] = (string)$item;
						}
						$i++;
					}
				}
			}
			
		
		return $roominfo;
		
	}

}

?>