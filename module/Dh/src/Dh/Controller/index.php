<?php
/*******************************************************
*   配置信息
*   
*   
*******************************************************/
//--程序开始，忽略警告提示
date_default_timezone_set("PRC");
error_reporting(E_ALL & ~E_NOTICE);
//--载入需要的频道信息
include "wztvlist.php";
//--载入需要的方法信息
include "function.php";
//--文件输入输出路径
$in_xml_folder = "d:/wamp/www/xmll/";
$out_xml_folder = "d:/wamp/www/xmll/";
// $in_xml_folder = "/home/xml/";
// $out_xml_folder = "/root/reco/data/";

/*******************************************************
*   主程序开始
*           @ 获取基本信息
*           @ 进行循环
*   循环内容包括：1.读取数据到数组    2.数据处理过程
*                 3.XML格式化所有数据 4.写入文件
*******************************************************/
//--获取文件夹目录下的文件名
$listname = _GETLISTNAME ($in_xml_folder);
//--获取今天系统应当生成的文件名
$listtoday = _GETLISTTODAY ($wztvlist);
//--通过比较，获取需要生成的文件名
$writelist = _GETWRITELIST($listname, $listtoday);
//--调用函数，输出列表中的文件，以xml格式
for ($num=0; $num < count($writelist); $num++) { 
    $loadname = $writelist[$num][name];
    $loadid = $writelist[$num][id];
    //--通过加载的频道ID获取相应的频道节目数组
    $sub = _GETSUB ($loadid);
    //--对载入的文件名进行判断，对infor名赋值
    $infor = _GETINFOR($loadid);
    //--获取标签个数
    $xml = new DOMDocument();
    $xml->load($loadname);
    $SItem = $xml->getElementsByTagName('SItem');
    $len = $SItem->length;
    $program = array();
    $lenn = '30';
    $w = 0;
    //--获取初始化时间点
    for ($i=0; $i < $lenn; $i++) { 
        if ($SItem->item(0)->attributes->item($i)->nodeName == 'EPTm') {
            $fristtime = $SItem->item(0)->attributes->item($i)->nodeValue;
            $fristtime = _CLEAN ($fristtime);
        }
    }


    /*******************************************************
    *   1.读取数据到数组
    *   
    *   
    *******************************************************/
    for($i=0;$i<$len;$i++){
        $program[$w] = array();
        $program[$w]['pname'] = $SItem->item($i)->attributes->item(0)->nodeValue;
        for ($j=0; $j < $lenn; $j++) { 
            $ss = $SItem->item($i)->attributes->item($j);
            if ($ss->nodeName == 'Dura') {$program[$w]['Dura'] = $ss->nodeValue;}
            if ($ss->nodeName == 'CID') {$program[$w]['CID'] = $ss->nodeValue;}
            if ($ss->nodeName == 'ID') {$program[$w]['ID'] = $ss->nodeValue;}
            if ($ss->nodeName == 'CTID') {$program[$w]['CTID'] = $ss->nodeValue;}
            if ($ss->nodeName == 'PMode') {$program[$w]['PMode'] = $ss->nodeValue;}
            if ($ss->nodeName == 'EPTm') {$program[$w]['EPTm'] = $ss->nodeValue;}
            if ($program[$w]['CID'] == $program[$w]['ID']) { $program[$w]['rerun'] = "直播";}else{ $program[$w]['rerun'] = "重播";}
        }
        if (($SItem->item($i)->getElementsByTagName('InsertedItem')->length) != ''){
            $len3 = $SItem->item($i)->getElementsByTagName('InsertedItem')->length;
            for ($k=0; $k < $len3; $k++) { 
                $w = $w + 1;
                $program[$w]['pname'] = $SItem->item($i)->getElementsByTagName('InsertedItem')->item($k)->attributes->item(0)->nodeValue;
                for ($h=0; $h < $lenn; $h++) { 
                    $kk = $SItem->item($i)->getElementsByTagName('InsertedItem')->item($k)->attributes->item($h);
                    if ($kk->nodeName == 'Dura') {$program[$w]['Dura'] = $kk->nodeValue;}
                    if ($kk->nodeName == 'CID') {$program[$w]['CID'] = $kk->nodeValue;}
                    if ($kk->nodeName == 'ID') {$program[$w]['ID'] = $kk->nodeValue;}
                    if ($kk->nodeName == 'CTID') {$program[$w]['CTID'] = $kk->nodeValue;}
                    if ($kk->nodeName == 'PMode') {$program[$w]['PMode'] = $kk->nodeValue;}
                    if ($kk->nodeName == 'EPTm') {$program[$w]['EPTm'] = $kk->nodeValue;}
                    if ($program[$w]['CID'] == $program[$w]['ID']) { $program[$w]['rerun'] = "直播";}else{ $program[$w]['rerun'] = "重播";}
                }
            }
        }
        $w = $w + 1;
    }
    // print_r($program);


    /*******************************************************
    *   2.数据处理过程
    *   
    *   
    *******************************************************/
    $len = count($program);
    for ($i=0; $i < $len; $i++) { 
        $program[$i]['EPTm'] = _CLEAN ($program[$i]['EPTm']);
        $program[$i]['pname'] = _NEWPNAME ($program[$i]['pname'], $sub);
        $program[$i]['prefix_name'] = _GETFIXNAME ($program[$i]['pname'], $sub);
        $program[$i]['CTIDname'] = _CTIDNAME ($program[$i]['CTID']);
        $program[$i]['starttime'] = $fristtime;
        $sumdura = $sumdura + $program[$i]['Dura'];
        $program[$i]['sumdura'] = $sumdura;
        if ($program[$i+1]['PMode'] == '1'){
            $sumdura = 0;
            $fristtime = _CLEAN ($program[$i+1]['EPTm']);
        }
        $program[$i]['frontdura'] = $program[$i-1]['Dura'];
        $tmpdura = $program[$i]['Dura'];
        if ($program[$i+1]['PMode'] == '5'){
            for ($j=$i; $j < $len; $j++) { 
                if ($program[$j+1]['PMode'] == '5') 
                    {$tmpdura = $tmpdura + $program[$j+1]['Dura'];}
                else{$program[$i]['tmpdura'] = $tmpdura; break; }
            }
        }
        if ($program[$i-1]['PMode'] == '5'){
            $program[$i]['realstart'] = _REALTIME ($program[$i-1]['realstart'], $program[$i]['EPTm']);
        }
        $program[$i]['overtime'] = _ADDTIME ($program[$i]['starttime'],$program[$i]['sumdura']);
        $program[$i]['realstart'] = $program[$i-1]['overtime'];
        if ($program[$i]['PMode'] == '5'){
            $program[$i]['realstart'] = _REALTIME ($program[$i-1]['realstart'], $program[$i]['EPTm']);
        }
    }
    // print_r($program);


    /*******************************************************
    *   3.XML格式化所有数据
    *   
    *   
    *******************************************************/
    $outxml = '<?xml version="1.0" encoding="utf-8"?>';
    $outxml .= '<programs>';
    $outxml .= '<infor>'.$infor.'</infor>';
    for($i=0;$i<$len;$i++){
        $outxml .= "<program>";
        $outxml .= "<pname>".$program[$i]['pname']."</pname>";
        $outxml .= "<prefix_name>".$program[$i]['prefix_name']."</prefix_name>";
        $outxml .= "<CTIDname>".$program[$i]['CTIDname']."</CTIDname>";
        if ($program[$i+1]['PMode'] == 5) { 
            $outxml .= "<Dura>".$program[$i]['tmpdura']."</Dura>";
        }else { $outxml .= "<Dura>".$program[$i]['Dura']."</Dura>";}
        if ($program[$i]['PMode'] == 1) { $outxml .= "<start_time>".$program[$i]['starttime']."</start_time>";}
        else { $outxml .= "<start_time>".$program[$i]['realstart']."</start_time>";}
        $outxml .= "<rerun>".$program[$i]['rerun']."</rerun>"; 
        $outxml .= "</program>";
    }
    $outxml .= '</programs>';
    // print_r($outxml);


    /*******************************************************
    *   4.写入文件
    *   
    *   
    *******************************************************/
    $filename=$loadid."-".date('Ymd').".xml";
    file_put_contents($out_xml_folder.$filename, $outxml);
}
?>