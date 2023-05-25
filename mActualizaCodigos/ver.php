<?php
$gtin = $_POST['gtin'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://wsproxy.syncfonia.com/apiServices/tradeItemService.svc/Search',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "PageNumber": 1,
    "PageSize": 1000,
    "GtinList": [
        "'.$gtin.'"
    ],
    "TradeItemKey": {
        "TargetMarketCountryCode": "484"
    },
    "TradeItemModules": [
        "TradeItemMeasurements",
        "TradeItemDescriptionInformation",
        "ReferencedFileDetailInformation",
        "PackagingInformation",
        "PackagingMarking",
        "Extension",
        "CertificationAuthorityInformation",
        "DeliveryPurchasingInformation",
        "InternalTargetMarketCompany",
        "InternalBusinessInformation",
        "MarketingInformation",
        "PlaceOfItemActivity",
        "SalesInformation"
    ]
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic NzUwODAwNjMzMDUwMTpBZG1pbnNpczIxISo=',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>