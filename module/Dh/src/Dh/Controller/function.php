<?php 
/*******************************************************
*   程序函数
*   1.读取文件夹目录，获取文件名
*   2.获取今天生成的文件名
*   3.需要生成的文件名
*   4.获取频道所有节目数组信息
*   5.获取此频道的文件名称
*   6.获取此栏目拼音简称
*   7.更换栏目名称
*   8.清除格式
*   9.时间相加，第一个参数为时间，第二个参数为帧
*   10.时间相加，第一个参数为时间，第二个参数为时间
*   11.更换节目备注
*******************************************************/
//--1.读取文件夹目录，获取文件名
function _GETLISTNAME ($in_xml_folder){
    $fp=opendir($in_xml_folder);
    while(false!=$file=readdir($fp)){
        if($file!='.' &&$file!='.'){
            $file="$file";
            $arr_file[]=$file;
        }
    }
    $listname = array();
    $i='0';
    if(is_array($arr_file)){
        echo 'Get file name success!'.'\n';
        while(list($key,$value)=each($arr_file)){
            $listname[$i] = $value;
            $i = $i+1;
        }
    }else {echo 'There is no file, loading fall'.'\n';}
    closedir($fp);
    return $listname;
}
//--2.获取今天生成的文件名
function _GETLISTTODAY ($wztvlist) {
    for ($i=0; $i < count($wztvlist); $i++) { 
        $listtoday[$i] = $wztvlist[$i]['id'].(string)date('Y-m-d')."ListA.lis";
    }
    return $listtoday;
}
//--3.需要生成的文件名
function _GETWRITELIST ($listname, $listtoday){
    $k = '0';
    for ($i=0; $i < count($listname); $i++) {
        for ($j=0; $j < count($listtoday); $j++) 
        { 
            if($listtoday[$j] == $listname[$i]){
                $writelist[$k][name] = $listname[$i];
                $writelist[$k][id] = substr($listname[$i],0,4);
                $k = $k+1;
            }
        }
    }
    return $writelist;
}
//--4.获取频道所有节目数组信息
function _GETSUB ($value){
    include "wztvlist.php";
    $value = intval(substr($value, 3));
    if ($value == 1){ $val = $value; $value = $sub_1;}
    elseif ($value == 2){ $val = $value; $value = $sub_2;}
    elseif ($value == 3){ $val = $value; $value = $sub_3;}
    elseif ($value == 4){ $val = $value; $value = $sub_4;}
    elseif ($value == 5){ $val = $value; $value = $sub_5;}
    else {$val = $value; $value = 0; }
    if ($value) {
        echo 'TVlist CH0'.$val.' in wztvlist.php loading success!'.'\n';
        return $value;
    }else{ echo 'Can not find CH0'.$val.' in wztvlist.php, loading fall.'.'\n';}
    
}
//--5.获取此频道的文件名称
function _GETINFOR ($value){
    include "wztvlist.php";
    for ($i=0; $i < count($wztvlist); $i++) { 
        if($wztvlist[$i]['id'] == $value){ $val=1; $value = $wztvlist[$i]['name']; $i = count($wztvlist)-1;}
        else { $val = 0;}
    }
    if($val){
        echo 'TVname infor in wztvlist.php loading success!'.'\n';
        return $value;
    }else{ echo 'Can not find TVname infor in wztvlist.php, loading fall.'.'\n';}
}
//--6.获取此栏目拼音简称
function _GETFIXNAME ($value, $sub){
    for ($i=0; $i < count($sub); $i++) { 
        if ($value == $sub[$i]['pname']){
            return $sub[$i]['prefix_name'];
        }
    }
}
//--7.更换栏目名称
function _NEWPNAME ($value, $sub){
    for ($i=0; $i < count($sub); $i++) { 
        if (substr_count($value, $sub[$i]['pname'])>'0') {
            return $sub[$i]['pname'];
            echo 'The pname in wztvlist sub,success!'.'\n';
        }
        else{ return $value; echo 'Can not find pname in wztvlist sub'.'\n';}
    }
}
//--8.清除格式
function _CLEAN ($value){
    list($xxx, $value) = explode(' ', $value);
    $value = substr($value, 0, 8);
    return $value;
}
//--9.时间相加，第一个参数为时间，第二个参数为帧
function _ADDTIME ($val_a, $val_b){
    $val_a = strtotime($val_a);
    list($val_b, $xxx) = explode('.', round(($val_b/25),3));
    return date('H:i:s', ($val_a + $val_b));
}
//--10.时间相加，第一个参数为时间，第二个参数为时间
function _REALTIME ($val_a, $val_b){
    $val_a = strtotime($val_a);
    list($a ,$b ,$c) = explode(':', $val_b);
    $val_b = intval($a)*3600 + intval($b)*60 + intval($c);
    return date('H:i:s', ($val_a + $val_b));
}
//--11.更换节目备注
function _CTIDNAME ($value){
    if ($value == '001') { return '新闻'; }
    elseif ($value == '002') { return '电视剧'; }
    elseif ($value == '003') { return '导视'; }
    elseif ($value == '004') { return '栏目'; }
    elseif ($value == '005') { return '005'; }
    elseif ($value == '006') { return '白天广告'; }
    elseif ($value == '007') { return '晚上广告'; }
    elseif ($value == '008') { return '其他'; }
    elseif ($value == '009') { return '广告素材'; }
    elseif ($value == '010') { return '日晚播广告'; }
    else { return '空值';}
}
?>