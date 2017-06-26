<?php require('config.php');?>
<?php require('functions.php');?>
<?php require('mysql.class.php');?>
<?php
$gene=strtoupper($_GET["gene"]);
//$gene="TP53";
$cancer=strtoupper($_GET["cancer"]);
global $config;
$db = new c_mysql;

##########################################Gene Mutation Information#########################################
$generecord=$db->select("SELECT * FROM SNV_Discription where Hugo_Symbol='".$gene."' and Cancer = '",$cancer,"'");
#Gene
#Genome Change
#Classification
#Type
#Exon
#Protein Change
#Transcript
#COSMIC_total_alterations_in_gene
#COSMIC_tissue_types_affected
#DrugBank
#ClinVar_HGMD_ID
#dbNSFP_CADD_phred
#Protein damage prediction summary

$arr=Array();
$nub=0;
foreach($generecord as $ge){
   $subarray=Array();
   $subarray["gene"]= $ge["Hugo_Symbol"];
   $subarray["genomechange"]= $ge["Genome_Change"];
   $subarray["class"]= $ge["Variant_Classification"];
   $subarray["type"]= $ge["Variant_Type"];
   $subarray["exon"]= $ge["Transcript_Exon"];
   $subarray["proteinchange"]= $ge["Protein_Change"];
   $subarray["refseqmrna"]= $ge["Refseq_mRNA_Id"];
   $subarray["numbmutincosmic"]= $ge["COSMIC_total_alterations_in_gene"];
   $subarray["afftissueincosmic"]= $ge["COSMIC_tissue_types_affected"];
   $subarray["clinvar"]= $ge["ClinVar_HGMD_ID"];
   $subarray["cadd"]= $ge["dbNSFP_CADD_phred"];
   #$subarray["numbdamage"]= ;
   $arr[$nub]=$subarray;
   $nub++;
}

echo json_encode($arr,JSON_UNESCAPED_SLASHES);

?>
