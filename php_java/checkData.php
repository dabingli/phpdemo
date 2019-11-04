<?php
 	function checkSignValue($jsonStr)
    {
        $jsonArray = json_decode($jsonStr,true);
        $checkValue = $jsonArray['checkValue'];
        $jsonData = SHA256Hex($jsonArray['jsonData'].'CHINAPNR');
        if($jsonData === $checkValue)
        {
            echo '验证通过';
            return true;
        }
        else
        {
            return false;
        }
    }

    function SHA256Hex($str){
        $re=hash('sha256', $str, true);
        return bin2hex($re);
    }

   $jsonStr =  [
  "checkValue"=>"f42b13b5a6b6552374d87404d2cb62515bac1b7044e7a9052984221e621b93ab",
  "jsonData"=>[
  	"feeAmt"=>"4.7",
  	"agentLevel"=>"1",
  	"tradeType"=>"1001",
  	"tsFlag"=>"0",
  	"tradeStatus"=>"S",
  	"extSeqId"=>"1561964621838",
  	"agentNo"=>"3100045000000084",
  	"tradeTime"=>"20190701150340",
  	"terminalNo"=>"11311130000002028",
  	"usrMobileMask"=>"1501520****",
  	"tradeTypeSecond"=>"",
  	"cardType"=>"D",
  	"isVipTrade"=>"2",
  	"orderNo"=>"201907011001030701",
  	"isTestPay"=>"1",
  	"agentName"=>"代理商开钱三",
  	"merchantName"=>"美国进口",
  	"feeFormula"=>"AMT*0.0047",
  	"method"=>"TradeInformation",
  	"merchantNo"=>"3100046000065637",
  	"tradeAmt"=>"1000"
  ]
];
var_dump(var_export(json_encode($jsonStr)));die;

    checkSignValue(json_encode($jsonStr));die;
 //    $b = urldecode("checkValue=f42b13b5a6b6552374d87404d2cb62515bac1b7044e7a9052984221e621b93ab&jsonData=%7B%22feeAmt%22%3A%224.7%22%2C%22agentLevel%22%3A%221%22%2C%22tradeType%22%3A%221001%22%2C%22tsFlag%22%3A%220%22%2C%22tradeStatus%22%3A%22S%22%2C%22extSeqId%22%3A%221561964621838%22%2C%22agentNo%22%3A%223100045000000084%22%2C%22tradeTime%22%3A%2220190701150340%22%2C%22terminalNo%22%3A%2211311130000002028%22%2C%22usrMobileMask%22%3A%221501520****%22%2C%22tradeTypeSecond%22%3A%22%22%2C%22cardType%22%3A%22D%22%2C%22isVipTrade%22%3A%222%22%2C%22orderNo%22%3A%22201907011001030701%22%2C%22isTestPay%22%3A%221%22%2C%22agentName%22%3A%22%E4%BB%A3%E7%90%86%E5%95%86%E5%BC%80%E9%92%B1%E4%B8%89%22%2C%22merchantName%22%3A%22%E7%BE%8E%E5%9B%BD%E8%BF%9B%E5%8F%A3%22%2C%22feeFormula%22%3A%22AMT*0.0047%22%2C%22method%22%3A%22TradeInformation%22%2C%22merchantNo%22%3A%223100046000065637%22%2C%22tradeAmt%22%3A%221000%22%7D"); //等同于javascript decodeURI("%E7%94%B5%E5%BD%B1");
	// echo $b;
