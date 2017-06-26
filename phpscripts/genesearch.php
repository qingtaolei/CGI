<?php require('config.php');?>
<?php require('functions.php');?>
<?php require('mysql.class.php');?>
<?php
#$gene=strtoupper($_GET["gene"]);
$gene="TP53";
$cancer="ESCC";
global $config;
$db = new c_mysql;
##########################################Gene Information#########################################
#Disease Type
#Name
#Discription
#UCSC Browser
#COSMIC Gene
#GeneCard
#OMIM
#Molecular_Function
#Biological_Process
#HGNC_Gene family description

$geneHugo=$db->select("SELECT count(*) count_t FROM SNV_Discription where Hugo_Symbol='".$gene."' and Cancer = '",$cancer,"'");
#driscription
$geneRecord = $db ->select_one('SNV_Discription',array('Hugo_Symbol' => $gene,'Cancer'=>$cancer));//obtain
$genediscrip=$geneRecord['Description'].";".$geneRecord['HGNC_Locus.Group'];
#Molecular_Function
$genefunction=$geneRecord['GO_Molecular_Function'];
#Biological_Process
$genebiology=$geneRecord['GO_Biological_Process'];
#HGNC_Gene family description
$genefamily=$geneRecord['HGNC_Gene family description'];
#COSMIC
$cosmicnumber=$geneRecord['COSMIC_total_alterations_in_gene'];
if($cosmicnumber >= 1){
$genecosmic="Yes";
}else{
$genecosmic="No";
}
#uscs
$geneucsc=$geneRecord['Chromosome']."-".$geneRecord['Start_position']."-".$geneRecord['End_position'];
#gene card
$genecard=$gene;
#omimID
$geneomim=$geneRecord['HGNC_OMIM.ID.supplied.by.NCBI.'];

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
#mutation classification summary
$silent=$db->getvariantsnumber($cancer,"Silent",$gene);
$missense=$db->getvariantsnumber($cancer,"Missense",$gene);
$nonsense=$db->getvariantsnumber($cancer,"Nonsense",$gene);
$frame_shift_indel=$db->getvariantsnumber($cancer,"Frame_Shift_Indel",$gene);
$splicing=$db->getvariantsnumber($cancer,"Splicing",$gene);
$in_frame_indel=$db->getvariantsnumber($cancer,"In_Frame_Indel",$gene);
#$nonstop=$db->getvariantsnumber($cancer,"Nonstop",$gene);



#number of mutation
$genenumber=$geneHugo[0]['count_t'];


##########################################Gene Expression########################################
if($cancer=="ESCC"){
$expdiscrip=$config['db']['ESCC_EXP_DISP'];
$exp_path=$config['db']['ESCC_FILE_PATH']."geneExp/".$gene."_Dateset2.png";
}
if($cancer=="EA"){
$expdiscrip=$config['db']['EA_EXP_DISP'];
$exp_path=$config['db']['EA_FILE_PATH']."geneExp/".$gene."_Dateset2.png";
}
//echo $exp_path;
##########################################Survival Information###################################
if($cancer=="ESCC"){
$mutsurvival_pth=$config['db']['ESCC_FILE_PATH']."genesurvival/".$gene.".png";
}
if($cancer=="EA"){
$mutsurvival_pth=$config['db']['EA_FILE_PATH']."genesurvival/".$gene.".png";
}
//echo $config['db']['EA_FILE_PATH'];
##########################################Involved Pathways######################################
#Pathway Name
#Number of Gene
#Number of Altered
#Number of Patients Affected
#Survival Log Rank Test
#Survival Figure



##########################################Mutation Table#########################################
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

$arr = array ('cancer'=>$cancer,
              'name'=>$gene,
              'description'=>$genediscrip,
              'varnum'=>$genenumber,
              'ucsc'=>$geneucsc,
              'function'=>$genefunction,
              'biology'=>$genebiology,
              'family'=>$genefamily,
              'cosmic'=>$genecosmic,
              'card'=>$genecard,
              'omim'=>$geneomim,
              'expdiscrip'=>$expdiscrip,
              'exp_path'=>$exp_path,
              'mutsurvival'=>$mutsurvival_pth
            );
echo json_encode($arr,JSON_UNESCAPED_SLASHES);
?>
