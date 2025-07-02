<?php
header('Content-Type: text/xml');

$location = "http://".$_SERVER['HTTP_HOST'].str_replace("retranslator.php", "service.php", $_SERVER['PHP_SELF'])."?cert=".$_GET['cert'];


?><wsdl:definitions xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/" xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
	xmlns:tns="http://www.mygemini.com/schemas/mygemini" targetNamespace="http://www.mygemini.com/schemas/mygemini">

	<wsdl:types>
<xsd:schema xmlns="http://www.mygemini.com/schemas/mygemini" xmlns:xsd="http://www.w3.org/2001/XMLSchema" targetNamespace="http://www.mygemini.com/schemas/mygemini" elementFormDefault="qualified"
	attributeFormDefault="unqualified" xmlns:jxb="http://java.sun.com/xml/ns/jaxb" jxb:version="2.1">

	<xsd:annotation>
		<xsd:appinfo>
			<jxb:globalBindings>
				<jxb:javaType name="java.util.Date" xmlType="xsd:dateTime" parseMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.parseXSDDateTime" printMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.printXSDDateTime" />
				<jxb:javaType name="java.lang.Integer" xmlType="xsd:int" parseMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.parseXSDInt" printMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.printXSDInt" />
				<jxb:javaType name="java.lang.Long" xmlType="xsd:long" parseMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.parseXSDLong" printMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.printXSDLong" />
				<jxb:javaType name="java.lang.Boolean" xmlType="xsd:boolean" parseMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.parseXSDBoolean" printMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.printXSDBoolean" />
				<jxb:javaType name="java.util.Date" xmlType="xsd:date" parseMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.parseXSDDateTime" printMethod="cz.bsc.g6.components.base.integration.DatatypeIoConverterUtils.printXSDDateTime" />
			</jxb:globalBindings>
		</xsd:appinfo>
	</xsd:annotation>
	
      
	<xsd:complexType name="AbstractIo">
		<xsd:annotation>
			<xsd:documentation>Abstract predecessor for all interface objects.</xsd:documentation>
		</xsd:annotation>
	</xsd:complexType>
	
	<xsd:complexType name="MoneyIo">
		<xsd:annotation>
			<xsd:documentation>Wrapper object for money definition - value and currency together.</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="amount" type="xsd:decimal" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Numeric representation of amount</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="currency" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Currency ISO code</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="AdditionalAttributeIo">
		<xsd:annotation>
			<xsd:documentation>Additional attribute serves as non-invasive mechanism how to use more attributes in XML schema</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="name" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Attribute name</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="value" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Attribute value</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="BaseQueryResultIo">
		<xsd:annotation>
			<xsd:documentation>Base object for query results</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="pager" type="BasePagerIo" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Pager object</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="totalCount" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Total count of elements (on all pages together)</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="BasePagerIo">
		<xsd:annotation>
			<xsd:documentation>Object which holds information about paging.</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="pageIndex" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Index of page starting from zero</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="pageSize" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Number of elements on 1 page</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="BaseFilterIo">
		<xsd:annotation>
			<xsd:documentation>Predecessor for all filters. Holds paging wrapper object and additional attributes.</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="pager" type="BasePagerIo" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Wrapper object used for paging</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="additionalAttributes" type="AdditionalAttributeIo" minOccurs="0" maxOccurs="unbounded">
						<xsd:annotation>
							<xsd:documentation>List of additional attributes</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>
<xsd:complexType name="AccountMovementDetailIo">
		<xsd:annotation>
			<xsd:documentation>Account movement detail object.</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="movementId" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Movement ID assigned by my|GEMINI [ACCT30]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="paymentId" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Payment order ID assigned by my|GEMINI [ACCT10]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="externalPaymentId" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Payment order ID assigned by CBS [ACCT19]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="debitCredit" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Is Credit or Debit operation; 0 = Debit, 1 = Credit [ACCT5]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="valueDate" type="xsd:dateTime" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Operation date [ACCT3]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="description" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Description [ACCT24]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="amount" type="MoneyIo" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Amount and currency of movement [ACCT6, ACC4]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="accountNumber" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account number [ACCT32]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="accountName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account name [ACCT33]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="additionalInformation" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Additional information (partner info) [ACCT49]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="documentDate" type="xsd:dateTime" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Document date [ACCT4]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="documentNumber" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Document number [ACCT43]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerAccountNumber" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's account number [ACCT13]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's account name [ACCT14]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerTaxCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's tax code [ACCT38]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerBankCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's bank code [ACCT15]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerBank" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's bank [ACCT37]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="intermediaryBankCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Intermediary bank code [ACCT45]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="intermediaryBank" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Intermediary bank [ACCT46]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="chargeDetail" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Charge detail [ACCT42]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="taxpayerCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Taxpayer code [ACCT41]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="taxpayerName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Taxpayer name [ACCT40]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="treasuryCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Treasury code [ACCT39]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="operationCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Operation code [ACCT44]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="additionalDescription" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Additional description [ACCT31]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="exchangeRate" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Exchange rate (for currency exchange operations) [ACCT59]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerPersonalNumber" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's personal number (for cash withdrawal operations) [ACCT52]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerDocumentType" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's document type (for cash withdrawal operations) [ACCT53]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="partnerDocumentNumber" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Partner's document number (for cash withdrawal operations) [ACCT54]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="parentExternalPaymentId" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Payment order ID of parent movement assigned by CBS; e.g. this attribute
							can be filled for charge movements to link them with original payment movements [ACCT48]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="statusCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Status code in CBS [ACCT28]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="transactionType" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>CBS transaction type [ACCT8]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="AccountMovementFilterIo">
		<xsd:annotation>
			<xsd:documentation>Account movement filter object.</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="BaseFilterIo">
				<xsd:sequence>
					<xsd:element name="accountNumber" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account number [ACCT32]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="accountCurrencyCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account currency code [ACC4]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="periodFrom" type="xsd:dateTime" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Period interval from (inclusive) [ACCT3]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="periodTo" type="xsd:dateTime" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Period interval to (inclusive) [ACCT3]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="movementId" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Movement id assigned by my|GEMINI. If filled it has the highest priority and other attributes are ignored [ACCT25]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="lastMovementTimestamp" type="xsd:dateTime" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Last movement timestamp – system will return movements with higher timestamp only [---]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="AuthHeader">
		<xsd:sequence>
			<xsd:element minOccurs="1" maxOccurs="1" name="HeaderUsername" type="xsd:string" />
			<xsd:element minOccurs="1" maxOccurs="1" name="HeaderPassword" type="xsd:string" />
			<xsd:element minOccurs="0" maxOccurs="1" name="HeaderNonce" type="xsd:string" />
		</xsd:sequence>
	</xsd:complexType>
	
	<xsd:element name="GetAccountMovementsRequestIo">
		<xsd:annotation>
			<xsd:documentation>Main get account movement request object</xsd:documentation>
		</xsd:annotation>
		
        <xsd:complexType>
			<xsd:sequence>			
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="accountMovementFilterIo" type="AccountMovementFilterIo" minOccurs="1" maxOccurs="1" />
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetAccountMovementsResponseIo">
		<xsd:annotation>
			<xsd:documentation>Main get account movement response object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="result" type="BaseQueryResultIo" minOccurs="0" maxOccurs="1" />
				<xsd:element name="accountMovement" type="AccountMovementDetailIo" minOccurs="0" maxOccurs="unbounded" />
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:complexType name="PaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="singlePaymentRequestId" type="xsd:long" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Client's identifier of payment. System checks previous payment IDs for duplicity if specified.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="creditAccount" type="AccountIdentificationIo" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account TO which the payment should be made. Is not used for treasury transfers; for all other transfer types this element is mandatory.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="debitAccount" type="AccountIdentificationIo"	minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account FROM which the payment should be made. minOccurs is zero since this complex
							type is used for batch payments as well and there the debitAccount is only 1 for the whole batch.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="documentNumber" type="xsd:long" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Document number. Only integer numbers up to 2147483647 are accepted. In case external system does not send any value, bank system will generate it automatically based on timestamp.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="amount" type="MoneyIo" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Amount to transfer from debit account.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="position" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Position of Payment Order in request. Is mandatory for both single and batch payment orders.
							For batch payments this value is then returned in GetPaymentOrderStatus so that the calling system is able to match the provided paymentId-s and paymentStatus-es to each payment order sent in a batch.
							For single payments it is used again to match the paymentOrder data in response to those in request.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="additionalDescription" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Additional description</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="description" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Description of the payment. Is not used for treasury transfers (it is set automatically by bank system based on the treasuryCode element); for all other transfer types this element is mandatory.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="xsitype" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>XSI Type</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_beneficiaryName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner name</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_beneficiaryTaxCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Tax code of credit account owner</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_taxpayerCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Identification code of person or company, for which client makes treasury transfer (mandatory when payment is for other person/company)</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_taxpayerName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Name of person or company, for which client makes treasury transfer (mandatory when payment is for other person/company)</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_treasuryCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Code which is assigned by Department of Treasury</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_beneficiaryAddress" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner address</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_beneficiaryBankCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Beneficiary bank code</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_beneficiaryBankName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Optional if Bank SWIFT Code is specified</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_intermediaryBankCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Intermediary bank code</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_intermediaryBankName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Optional if Bank SWIFT Code is specified or code is not specified at all</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="Append_chargeDetails" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Detail of charge: SHA - Beneficiary pays intermediary bank charges or OUR - originator pays all charges.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="TransferToOwnAccountPaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="PaymentOrderIo"/>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="TransferWithinBankPaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="PaymentOrderIo">
				<xsd:sequence>
					<xsd:element name="beneficiaryName" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner name</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="beneficiaryTaxCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Tax code of credit account owner</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="TreasuryTransferPaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="PaymentOrderIo">
				<xsd:sequence>
					<xsd:element name="taxpayerCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Identification code of person or company, for which client makes treasury transfer (mandatory when payment is for other person/company)</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="taxpayerName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Name of person or company, for which client makes treasury transfer (mandatory when payment is for other person/company)</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="treasuryCode" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Code which is assigned by Department of Treasury</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="TransferToOtherBankNationalCurrencyPaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="PaymentOrderIo">
				<xsd:sequence>
					<xsd:element name="beneficiaryName" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner name</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="beneficiaryTaxCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Tax code of credit account owner</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="TransferToOtherBankForeignCurrencyPaymentOrderIo">
		<xsd:complexContent>
			<xsd:extension base="PaymentOrderIo">
				<xsd:sequence>
					<xsd:element name="beneficiaryName" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner name</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="beneficiaryAddress" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Credit account owner address</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="beneficiaryBankCode" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Beneficiary bank code</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="beneficiaryBankName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Optional if Bank SWIFT Code is specified</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="intermediaryBankCode" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Intermediary bank code</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="intermediaryBankName" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Optional if Bank SWIFT Code is specified or code is not specified at all</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="chargeDetails" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Detail of charge: SHA - Beneficiary pays intermediary bank charges or OUR - originator pays all charges.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="PaymentOrderResultIo">
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="position" type="xsd:int" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Position of given payment order in import request.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="paymentId" type="xsd:long" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Payment order ID assigned by my|GEMINI [ACCT10]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>

	<xsd:complexType name="AccountIdentificationIo">
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="accountNumber" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Account number</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="accountCurrencyCode" type="xsd:string" minOccurs="0" maxOccurs="1" >
						<xsd:annotation>
							<xsd:documentation>Account currency code. For single payment orders this field is mandatory.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>
	
	<xsd:complexType name="PaymentStatusDataIo">
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="position" type="xsd:int" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Position of given payment order in Batch import request.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>			
					<xsd:element name="paymentId" type="xsd:string" minOccurs="0" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Payment order ID assigned by my|GEMINI [ACCT10]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="paymentStatus" type="xsd:string" minOccurs="0" maxOccurs="1" >
						<xsd:annotation>
							<xsd:documentation>Current status of payment order.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="errorDetailEN" type="xsd:string" minOccurs="0" maxOccurs="1" >
						<xsd:annotation>
							<xsd:documentation>Detail of error in English language.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="errorDetailGE" type="xsd:string" minOccurs="0" maxOccurs="1" >
						<xsd:annotation>
							<xsd:documentation>Detail of error in Georgian language.</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>
	
	<xsd:element name="ImportBatchPaymentOrderResponseIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="mygeminiBatchId" type="xsd:long" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Internal ID of batch in myGemini []</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="ImportBatchPaymentOrderRequestIo">
		<xsd:complexType>
			<xsd:complexContent>
				<xsd:extension base="AbstractIo">
					<xsd:sequence>
						<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
							<xsd:annotation>
								<xsd:documentation>Auth Header</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
						<xsd:element name="batchPaymentRequestId" type="xsd:string" minOccurs="0" maxOccurs="1">
							<xsd:annotation>
								<xsd:documentation>Client's identifier of batch payment. System checks previous batch payment IDs for duplicity if specified.</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
						<xsd:element name="debitAccountIdentification" type="AccountIdentificationIo" minOccurs="1" maxOccurs="1">
							<xsd:annotation>
								<xsd:documentation>Debit account identification (account from which the payment should be made)</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
						<xsd:element name="batchName" type="xsd:string" minOccurs="1" maxOccurs="1">
							<xsd:annotation>
								<xsd:documentation>Name of batch []</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
						<xsd:element name="paymentOrder" type="PaymentOrderIo" minOccurs="1" maxOccurs="unbounded" >
							<xsd:annotation>
								<xsd:documentation></xsd:documentation>
							</xsd:annotation>
						</xsd:element>
					</xsd:sequence>
				</xsd:extension>
			</xsd:complexContent>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetSinglePaymentIdRequestIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="singlePaymentRequestId" type="xsd:long" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Client's ID of payment transaction request already sent to myGemini</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetSinglePaymentIdResponseIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="paymentId" type="xsd:long" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Internal ID of payment transaction in myGemini</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetBatchPaymentIdRequestIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="batchPaymentRequestId" type="xsd:long" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Client's ID of payment batch request already sent to myGemini</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetBatchPaymentIdResponseIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="batchId" type="xsd:long" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Internal ID of payment batch in myGemini</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:element name="ImportSinglePaymentOrdersRequestIo">
		<xsd:complexType>
					<xsd:sequence>
						<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
							<xsd:annotation>
								<xsd:documentation>Auth Header</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
						<xsd:element name="singlePaymentOrder" type="PaymentOrderIo" minOccurs="1" maxOccurs="unbounded" >
							<xsd:annotation>
								<xsd:documentation>List of all single payment orders</xsd:documentation>
							</xsd:annotation>
						</xsd:element>
					</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:element name="ImportSinglePaymentOrdersResponseIo">
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="PaymentOrdersResults" type="PaymentOrderResultIo" minOccurs="0" maxOccurs="unbounded">
					<xsd:annotation>
						<xsd:documentation>List of results for each single payment order</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:element name="GetPaymentOrderStatusRequestIo">
		<xsd:annotation>
			<xsd:documentation>Main get payment order status request object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="singlePaymentId" type="xsd:long" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Single payment ID []</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="batchPaymentId" type="xsd:long" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Batch payment ID []</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetPaymentOrderStatusResponseIo">
		<xsd:annotation>
			<xsd:documentation>Main get payment order status response object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="status" type="xsd:string" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Current payment status (either of the single payment or the batch payment) []</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="singlePaymentData" type="PaymentStatusDataIo" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>In case singlePaymentId is supplied in the GetPaymentOrderStatusRequestIo 
						and the single payment is in some error status, this element will be included in the response and will contain only error details.</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="batchPaymentData" type="PaymentStatusDataIo" minOccurs="0" maxOccurs="unbounded">
					<xsd:annotation>
						<xsd:documentation>In case batchPaymentId is supplied in the GetPaymentOrderStatusRequestIo 
						and the batch has been processed, one such element is provided for each payment in the imported batch.</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:element name="ChangePasswordRequestIo">
		<xsd:annotation>
			<xsd:documentation>Change password request object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="newPassword" type="xsd:string" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>New password. [---]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="ChangePasswordResponseIo">
		<xsd:annotation>
			<xsd:documentation>Change password response object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="message" type="xsd:string" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Informative message [---]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
	
	<xsd:complexType name="PostboxMessageIo">
		<xsd:annotation>
			<xsd:documentation>Message from postbox</xsd:documentation>
		</xsd:annotation>
		<xsd:complexContent>
			<xsd:extension base="AbstractIo">
				<xsd:sequence>
					<xsd:element name="messageId" type="xsd:long" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Unique message ID [CSIMSG01]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="messageText" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Textual message [CSIMSG02]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="messageType" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Message type [CSIMSG03]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="messageStatus" type="xsd:string" minOccurs="1" maxOccurs="1">
						<xsd:annotation>
							<xsd:documentation>Message status indicating whether message was already sent to client system [CSIMSG04]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
					<xsd:element name="additionalAttributes" type="AdditionalAttributeIo" minOccurs="0" maxOccurs="unbounded">
						<xsd:annotation>
							<xsd:documentation>Additional attributes for special types of messages [CSIMSG05]</xsd:documentation>
						</xsd:annotation>
					</xsd:element>
				</xsd:sequence>
			</xsd:extension>
		</xsd:complexContent>
	</xsd:complexType>
	
	<xsd:element name="GetPostboxMessagesRequestIo">
		<xsd:annotation>
			<xsd:documentation>Main get postbox messages request object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="messageType" type="xsd:string" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Message type catalog value [CSIMSG03]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="GetPostboxMessagesResponseIo">
		<xsd:annotation>
			<xsd:documentation>Main get postbox messages response object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="messages" type="PostboxMessageIo" minOccurs="0" maxOccurs="unbounded">
					<xsd:annotation>
						<xsd:documentation>List of postbox messages [---]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="PostboxAcknowledgementRequestIo">
		<xsd:annotation>
			<xsd:documentation>Main postbox acknowledgement request object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="AuthHeader" type="AuthHeader" minOccurs="0" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Auth Header</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
				<xsd:element name="messageIds" type="xsd:long" minOccurs="1" maxOccurs="unbounded">
					<xsd:annotation>
						<xsd:documentation>Postbox message IDs [CSIMSG01]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>

	<xsd:element name="PostboxAcknowledgementResponseIo">
		<xsd:annotation>
			<xsd:documentation>Main postbox acknowledgement response object</xsd:documentation>
		</xsd:annotation>
		<xsd:complexType>
			<xsd:sequence>
				<xsd:element name="responseText" type="xsd:string" minOccurs="1" maxOccurs="1">
					<xsd:annotation>
						<xsd:documentation>Message with acknowledgement result [---]</xsd:documentation>
					</xsd:annotation>
				</xsd:element>
			</xsd:sequence>
		</xsd:complexType>
	</xsd:element>
</xsd:schema>


	</wsdl:types>

	<wsdl:message name="GetAccountMovementsRequest">
		<wsdl:part element="tns:GetAccountMovementsRequestIo" name="parameters" />
	</wsdl:message>
	<wsdl:message name="GetAccountMovementsResponse">
		<wsdl:part element="tns:GetAccountMovementsResponseIo" name="parameters" />
	</wsdl:message>

	<wsdl:portType name="MovementService">
		<wsdl:operation name="GetAccountMovements">
			<wsdl:input message="tns:GetAccountMovementsRequest"/>
			<wsdl:output message="tns:GetAccountMovementsResponse"/>
		</wsdl:operation>
	</wsdl:portType>

	<wsdl:binding name="MovementServiceBinding" type="tns:MovementService">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
		<wsdl:operation name="GetAccountMovements">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/GetAccountMovements" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
	</wsdl:binding>

	<wsdl:service name="MovementService">
		<wsdl:port binding="tns:MovementServiceBinding" name="MovementServicePort">
			<soap:address location="<?php echo $location;?>" />
		</wsdl:port>
	</wsdl:service>
	
	<wsdl:message name="ChangePasswordRequest">
		<wsdl:part element="tns:ChangePasswordRequestIo" name="parameters" />
	</wsdl:message>
	<wsdl:message name="ChangePasswordResponse">
		<wsdl:part element="tns:ChangePasswordResponseIo" name="parameters" />
	</wsdl:message>

	<wsdl:portType name="ChangePasswordService">
		<wsdl:operation name="ChangePassword">
			<wsdl:input message="tns:ChangePasswordRequest" />
			<wsdl:output message="tns:ChangePasswordResponse" />
		</wsdl:operation>
	</wsdl:portType>

	<wsdl:binding name="ChangePasswordServiceBinding" type="tns:ChangePasswordService">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
		<wsdl:operation name="ChangePassword">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/ChangePassword" />
			<wsdl:input>
				<soap:body use="literal" />
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal" />
			</wsdl:output>
		</wsdl:operation>
	</wsdl:binding>

	<wsdl:service name="ChangePasswordService">
		<wsdl:port binding="tns:ChangePasswordServiceBinding" name="ChangePasswordServicePort">
			<soap:address location="<?php echo $location;?>" />
		</wsdl:port>
	</wsdl:service>
	
	<wsdl:message name="ImportSinglePaymentOrdersRequest">
		<wsdl:part element="tns:ImportSinglePaymentOrdersRequestIo" name="parameters1" />
	</wsdl:message>
	<wsdl:message name="ImportSinglePaymentOrdersResponse">
		<wsdl:part element="tns:ImportSinglePaymentOrdersResponseIo" name="parameters2" />
	</wsdl:message>

	<wsdl:message name="ImportBatchPaymentOrderRequest">
		<wsdl:part element="tns:ImportBatchPaymentOrderRequestIo" name="parameters3" />
	</wsdl:message>
	<wsdl:message name="ImportBatchPaymentOrderResponse">
		<wsdl:part element="tns:ImportBatchPaymentOrderResponseIo" name="parameters4" />
	</wsdl:message>

	<wsdl:message name="GetPaymentOrderStatusRequest">
		<wsdl:part element="tns:GetPaymentOrderStatusRequestIo" name="parameters5" />
	</wsdl:message>
	<wsdl:message name="GetPaymentOrderStatusResponse">
		<wsdl:part element="tns:GetPaymentOrderStatusResponseIo" name="parameters6" />
	</wsdl:message>

	<wsdl:message name="GetSinglePaymentIdRequest">
		<wsdl:part element="tns:GetSinglePaymentIdRequestIo" name="parameters7" />
	</wsdl:message>
	<wsdl:message name="GetSinglePaymentIdResponse">
		<wsdl:part element="tns:GetSinglePaymentIdResponseIo" name="parameters8" />
	</wsdl:message>

	<wsdl:message name="GetBatchPaymentIdRequest">
		<wsdl:part element="tns:GetBatchPaymentIdRequestIo" name="parameters9" />
	</wsdl:message>
	<wsdl:message name="GetBatchPaymentIdResponse">
		<wsdl:part element="tns:GetBatchPaymentIdResponseIo" name="parameters10" />
	</wsdl:message>
	
	<wsdl:portType name="PaymentService">
		<wsdl:operation name="ImportSinglePaymentOrders">
			<wsdl:input message="tns:ImportSinglePaymentOrdersRequest" />
			<wsdl:output message="tns:ImportSinglePaymentOrdersResponse" />
		</wsdl:operation>
		<wsdl:operation name="ImportBatchPaymentOrder">
			<wsdl:input message="tns:ImportBatchPaymentOrderRequest"/>
			<wsdl:output message="tns:ImportBatchPaymentOrderResponse"/>
		</wsdl:operation>
		<wsdl:operation name="GetPaymentOrderStatus">
			<wsdl:input message="tns:GetPaymentOrderStatusRequest"/>
			<wsdl:output message="tns:GetPaymentOrderStatusResponse"/>
		</wsdl:operation>
		<wsdl:operation name="GetSinglePaymentId">
			<wsdl:input message="tns:GetSinglePaymentIdRequest"/>
			<wsdl:output message="tns:GetSinglePaymentIdResponse"/>
		</wsdl:operation>
		<wsdl:operation name="GetBatchPaymentId">
			<wsdl:input message="tns:GetBatchPaymentIdRequest"/>
			<wsdl:output message="tns:GetBatchPaymentIdResponse"/>
		</wsdl:operation>
	</wsdl:portType>

	<wsdl:binding name="PaymentServiceBinding" type="tns:PaymentService">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
		<wsdl:operation name="ImportSinglePaymentOrders">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/ImportSinglePaymentOrders" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
		<wsdl:operation name="ImportBatchPaymentOrder">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/ImportBatchPaymentOrder" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
		<wsdl:operation name="GetPaymentOrderStatus">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/GetPaymentOrderStatus" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
		<wsdl:operation name="GetSinglePaymentId">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/GetSinglePaymentId" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
		<wsdl:operation name="GetBatchPaymentId">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/GetBatchPaymentId" />
			<wsdl:input>
				<soap:body use="literal"/>
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal"/>
			</wsdl:output>
		</wsdl:operation>
	</wsdl:binding>

	<wsdl:service name="PaymentService">
		<wsdl:port binding="tns:PaymentServiceBinding" name="PaymentServicePort">
			<soap:address location="<?php echo $location;?>" />
		</wsdl:port>
	</wsdl:service>
	
	<wsdl:message name="GetPostboxMessagesRequest">
		<wsdl:part element="tns:GetPostboxMessagesRequestIo" name="parameters" />
	</wsdl:message>
	<wsdl:message name="GetPostboxMessagesResponse">
		<wsdl:part element="tns:GetPostboxMessagesResponseIo" name="parameters" />
	</wsdl:message>
	<wsdl:message name="PostboxAcknowledgementRequest">
		<wsdl:part element="tns:PostboxAcknowledgementRequestIo" name="parameters" />
	</wsdl:message>
	<wsdl:message name="PostboxAcknowledgementResponse">
		<wsdl:part element="tns:PostboxAcknowledgementResponseIo" name="parameters" />
	</wsdl:message>

	<wsdl:portType name="PostboxService">
		<wsdl:operation name="GetMessagesFromPostbox">
			<wsdl:input message="tns:GetPostboxMessagesRequest" />
			<wsdl:output message="tns:GetPostboxMessagesResponse" />
		</wsdl:operation>
		<wsdl:operation name="AcknowledgePostboxMessages">
			<wsdl:input message="tns:PostboxAcknowledgementRequest" />
			<wsdl:output message="tns:PostboxAcknowledgementResponse" />
		</wsdl:operation>
	</wsdl:portType>

	<wsdl:binding name="PostboxServiceBinding" type="tns:PostboxService">
		<soap:binding style="document" transport="http://schemas.xmlsoap.org/soap/http" />
		<wsdl:operation name="GetMessagesFromPostbox">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/GetMessagesFromPostbox" />
			<wsdl:input>
				<soap:body use="literal" />
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal" />
			</wsdl:output>
		</wsdl:operation>
		<wsdl:operation name="AcknowledgePostboxMessages">
			<soap:operation soapAction="http://www.mygemini.com/schemas/mygemini/AcknowledgePostboxMessages" />
			<wsdl:input>
				<soap:body use="literal" />
			</wsdl:input>
			<wsdl:output>
				<soap:body use="literal" />
			</wsdl:output>
		</wsdl:operation>
	</wsdl:binding>

	<wsdl:service name="PostboxService">
		<wsdl:port binding="tns:PostboxServiceBinding" name="PostboxServicePort">
			<soap:address location="<?php echo $location;?>" />
		</wsdl:port>
	</wsdl:service>

</wsdl:definitions>