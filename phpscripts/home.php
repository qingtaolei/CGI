<?php require('config.php');?>
<?php require('functions.php');?>
<?php require('mysql.class.php');?>
<?php
global $config;
//echo $config['db']['datebase']."\n";
$db = new c_mysql;

$escc=$db->select("SELECT count(distinct Tumor_Sample_Barcode) count_t FROM (SELECT * FROM ESCC_SNV_Discription) a");
$esccnumber=$escc[0]['count_t'];

$pagecout = $db ->select("SELECT COUNT(*) num FROM `".$config['db']['pre']."ESCC_SNV_Discription`");
$numvariants = $pagecout[0]['num'];

$esccgene=$db->select("SELECT count(distinct Hugo_Symbol) count_t FROM (SELECT * FROM ESCC_SNV_Discription) a");
$genenumber=$esccgene[0]['count_t'];

$esccgene=$db->select("SELECT count(distinct Hugo_Symbol) count_t FROM (SELECT * FROM ESCC_SNV_Discription) a");
$genenumber=$esccgene[0]['count_t'];

$esccdrug=$db->select("SELECT count(distinct DrugBank) count_t FROM (SELECT * FROM ESCC_SNV_Discription) a");
$drugnumber=$esccdrug[0]['count_t'];

//echo $drugnumber;

#echo json_encode($result);
$arr = array ('patients'=>$esccnumber,'variants'=>$numvariants,'genes'=>$genenumber,'drugs'=>$drugnumber);
//$arr = array ('a'=>442,'b'=>29223,'c'=>10803,'d'=>2245);
echo json_encode($arr);
?>
