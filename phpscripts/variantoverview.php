<?php require('config.php');?>
<?php require('functions.php');?>
<?php require('mysql.class.php');?>
<?php
$variant=strtoupper($_GET["variant"]);
#$gene="TP53";
//$cancer=strtoupper($_GET["cancer"]);
#$variant="1|227227937|G|A";
global $config;
$db = new c_mysql;

##########################################variant information in ESCC##################################
$variantRecord = $db ->select_one('Mutation_Summary',array('Mutation' => $variant));//obtain
##########################################Variant deleterious prediction#########################################
 $variantPrediction=$db->select_one('SNV_dbNFSP',array('Mutation' => $variant));


  $arr=Array();
  $subarray=Array();
  $subarray["variant"]= $variant;
  $subarray["numbmut"]= $variantRecord["Mutation_Numb"];
//  echo $subarray["numbmut"];
 $subarray["numbpatients"]= $variantRecord["Total_Sample"];
 $subarray["mutfreq"]= $variantRecord["Mutation_Frequency"];
 $subarray["cadd"]= $variantPrediction["dbNSFP_CADD_phred"];
 $subarray["mutationassessor"]= $variantPrediction["dbNSFP_MutationAssessor_score"];
 $subarray["fathmm"]= $variantPrediction["dbNSFP_FATHMM_score"];
 $subarray["mutationtester"]= $variantPrediction["dbNSFP_SLR_test_statistic"];
 $subarray["polyphen2"]= $variantPrediction["dbNSFP_Polyphen2_HDIV_score"];
 $subarray["sift"]= $variantPrediction["dbNSFP_SIFT_score"];
 $arr[0]=$subarray;
 echo json_encode($arr,JSON_UNESCAPED_SLASHES);
?>
