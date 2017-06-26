<?php require('config.php');?>
<?php require('functions.php');?>
<?php require('mysql.class.php');?>
<?php
#$gene=strtoupper($_GET["gene"]);
$gene="TP53";
#$cancer=strtoupper($_GET["cancer"]);
$cancer ="ESCC";
global $config;
$db = new c_mysql;

##########################################Association with ESCC##################################
#Collected Sample Size
#Number of Mutations
#Mutation Frequency
#Significantly Mutated Genes
#MutSigCV q value (Combind Analysis)
#MUTSIG_Published_Results

#mutation frequency
if($cancer=="ESCC"){
$mutfreq=$genenumber/$config['db']['ESCC'];
}
if($cancer=="EA"){
$mutfreq=$genenumber/$config['db']['EA'];
}
#mutation classification summary
$missense=$db->getvariantsnumber($cancer,"Missense",$gene);
$frame_shift_indel=$db->getvariantsnumber($cancer,"Frame_Shift_Indel",$gene);
$nonsense=$db->getvariantsnumber($cancer,"Nonsense",$gene);
$splicing=$db->getvariantsnumber($cancer,"Splicing",$gene);
$in_frame_indel=$db->getvariantsnumber($cancer,"In_Frame_Indel",$gene);
$silent=$db->getvariantsnumber($cancer,"Silent",$gene);
#$nonstop=$db->getvariantsnumber($cancer,"Nonstop",$gene);

##########################################Gene Information#########################################
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
 $subarray=Array();
 $subarray["SMG"]= "Yes";
 $subarray["mutsigPublish"]= 10;
 $subarray["mutsigCombind"]= 20;
 $subarray["sampleSize"]= 30;
 $subarray["mutationNumb"]= "Yes";
 $subarray["mutationFreq"]= $mutfreq;
 $subarray["missense"]= $missense;
 $subarray["frame_shift_indel"]= $frame_shift_indel;
 $subarray["nonsense"]= $nonsense;
 $subarray["splicing"]= $splicing;
 $subarray["in_frame_indel"]= $in_frame_indel;
 $subarray["silent"]= $silent;
 $arr[0]=$subarray;

echo json_encode($arr,JSON_UNESCAPED_SLASHES);
/*
#driscription
$geneRecord = $db ->select_one($cancer.'_SNV_Discription',array('Hugo_Symbol' => $gene));//obtain
$genediscrip=$geneRecord['Description'].";".$geneRecord['HGNC_Locus.Group'];
#number of mutation
$genenumber=$geneHugo[0]['count_t'];
#uscs
$geneucsc=$geneRecord['Chromosome']."-".$geneRecord['Start_position']."-".$geneRecord['End_position'];
#gene card
$genecard=$gene;
#omimID
$geneomim=$geneRecord['HGNC_OMIM.ID.supplied.by.NCBI.'];
#mutation frequency
if($cancer=="ESCC"){
$mutfreq=$genenumber/$config['db']['ESCC'];
}
if($cancer=="EA"){
$mutfreq=$genenumber/$config['db']['EA'];
}
*/
//echo $config['db']['EA_FILE_PATH'];
##########################################Hipathia Analysis######################################
##########################################Mutation Table#########################################

/*$arr = array ('name'=>$gene,
              'description'=>$genediscrip,
              'varnum'=>$genenumber,
              'ucsc'=>$geneucsc,
              'card'=>$genecard,
              'omim'=>$geneomim,
              'expdiscrip'=>$expdiscrip,
              'exp_path'=>$exp_path,
              'mutsurvival'=>$mutsurvival_pth
            );
echo json_encode($arr,JSON_UNESCAPED_SLASHES);
*/
?>
