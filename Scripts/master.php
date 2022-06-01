<html>

<head>
<link rel="stylesheet" href="table.css">
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

</head>

<body>



<?php
$string2 = " ID doesnt exist";
$string = "At least one of the sequenceID does not exist!";
$gene_ID = $_POST["gene_ID"];
$gene_ID = explode(",", $gene_ID);



$serverName = "(local)";
$connectionInfo = array( "Database"=>"Praksa");
$dbh = sqlsrv_connect($serverName, $connectionInfo);

foreach ($gene_ID as $value) {
    $sql = "SELECT * FROM tableID
    WHERE geneID ='$value'
    UNION
    SELECT * FROM tableID
    WHERE pepID ='$value'";
    $result = sqlsrv_query($dbh,$sql);
    $getResults = sqlsrv_query($dbh, $sql);
    

if(sqlsrv_has_rows($result) === false){
   echo '<span style="color: aquamarine; font-size: 50px;"> ' . $value.  ' </span>';;
   echo '<span style="color: aquamarine; font-size: 50px;"> ' . $string2.  ' </span>';;
   
}
}

$gene_ID = array_unique($gene_ID);
$gene_ID = implode("', '", $gene_ID);

$radio_button = $_POST["select1"];



    

trim($gene_ID);
$serverName = "(local)";
$connectionInfo = array( "Database"=>"Praksa");

$database = "Praksa";
$dbh = sqlsrv_connect($serverName, $connectionInfo);
//$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $dbh === false  )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}

if (isset($_POST['gene_ID'])){
    if($radio_button == 'select1'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneid = [tableID].geneID
    WHERE cds IS NOT NULL AND select1 = '1' AND panID_L0  IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE  geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneID = [tableID].pepID
    WHERE cds IS NOT NULL AND select1 = '1' AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
    elseif($radio_button == 'select2'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneid = [tableID].geneID
    WHERE  (select1 = '1' OR select2 = '1') AND cds IS NOT NULL AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneID = [tableID].pepID
    WHERE (select1 = '1' OR select2 = '1') AND cds IS NOT NULL AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
    elseif($radio_button == 'All'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneid = [tableID].geneID
    WHERE cds IS NOT NULL AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].geneID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tableCDS].cds 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tableCDS]
    ON [tableCDS].geneID = [tableID].pepID
    WHERE cds IS NOT NULL AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
}


$getResults = sqlsrv_query($dbh, $tsql);
    //$tsql = "SELECT * FROM [Praksa].[dbo].[stu-pantranscriptome_v2020_2022-04-15_FIN]";
    //$stmt = sqlsrv_query( $conn, $tsql);
    if( $getResults === false )
    {
        echo "Error in executing query.</br>";
        die( print_r( sqlsrv_errors(), true));
    }
    
      
      
    
?>
<div class="container">
<h3 style="color:white;
font-family: monospace;
font-size: 30px">Results for: <?php echo $gene_ID ?></h3>
<table style="table-layout: fixed;" class="table table-bordered" id="example">

<thead>
    <tr>
    <th>geneID</th>
    <th>panID_L0</th>
    <th>classID_L1</th>
    <th>cvID_L1</th>
    <th>cds</th>
    </tr>
</thead>

<tbody>

<?php
    $i = 0;
    while ($rows = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $i++;
        
?>

    <tr>
        <td class="abc" ><?php echo $rows['geneID']?></td>
        <td><?php echo $rows['panID_L0']?></td>
        <td><?php echo $rows['classID_L1']?></td>
        <td><?php echo $rows['cvID_L1']?></td>
        <td style="word-break: break-all;" class="abc"><?php echo $rows['cds']?></td>
    </tr>
<?php
  }
  if ($i === 0){
    echo '<script> document.getElementById("example").deleteTHead();</script>';
    exit;
    }
  
?>
</tbody>
</table>
   

</div> 

<br><br><br>









   



<button  class="btn btn-danger1" id="export1"  style="background-color: rgb(71, 71, 71);
                           font-size: 24px;
                           font-family: monospace;
                           border-radius: 12px;
                           border-color: greenyellow;
                           color: white;" name="submit_button" type="submit" value="Submit">
                    Download fasta file</button>
  


<button class="btn btn-danger" id="export" style="background-color: rgb(71, 71, 71);
                           font-size: 24px;
                           font-family: monospace;
                           border-radius: 12px;
                           border-color: greenyellow;
                           color: white;" name="submit_button" type="submit" value="Submit">
                    Download tab delimited file</button>

                    <br><br><br>



                    
<?php
if (isset($_POST['gene_ID'])){
    if($radio_button == 'select1'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE select1 = '1' AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE select1 = '1' AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
    elseif($radio_button == 'select2'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE (select1 = '1' OR select2 = '1') AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE (select1 = '1' OR select2 = '1') AND panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
    elseif($radio_button == 'All'){
    $tsql = "SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE panID_L0 IN 
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE geneID IN ('$gene_ID'))
    UNION
    SELECT [Praksa].[dbo].[tableID].pepID, [Praksa].[dbo].[tableID].panID_L0, [Praksa].[dbo].[tableID].cvID_L1, [Praksa].[dbo].[tableID].classID_L1, [Praksa].[dbo].[tablePEP].pep 
    FROM [Praksa].[dbo].[tableID]
    LEFT JOIN [tablePEP]
    ON [tablePEP].geneid = [tableID].pepID
    WHERE panID_L0 IN  
    (SELECT  [panID_L0]
    FROM [Praksa].[dbo].[tableID]
    WHERE pepID IN ('$gene_ID'))";
    }
}


$getResults = sqlsrv_query($dbh, $tsql);
    //$tsql = "SELECT * FROM [Praksa].[dbo].[stu-pantranscriptome_v2020_2022-04-15_FIN]";
    //$stmt = sqlsrv_query( $conn, $tsql);
    if( $getResults === false )
    {
        echo "Error in executing query.</br>";
        die( print_r( sqlsrv_errors(), true));
    }
    
      
          

?>

<br>
<div class="container">
<table style="table-layout: fixed;" class="table table-bordered" id="example1">
<thead>
    <tr>
    <th>pepID</th>
    <th>panID_L0</th>
    <th>classID_L1</th>
    <th>cvID_L1</th>
    <th>pep</th>
    </tr>
</thead>
<tbody>
<?php
    $i = 0;
    while ($rows = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $i++;
        
?>
    <tr>
        <td class="abc" ><?php echo $rows['pepID']?></td>
        <td><?php echo $rows['panID_L0']?></td>
        <td><?php echo $rows['classID_L1']?></td>
        <td><?php echo $rows['cvID_L1']?></td>
        <td style="word-break: break-all;" class="abc"><?php echo $rows['pep']?></td>
    </tr>
<?php
  }
  if ($i === 0){
    echo '<script> document.getElementById("example").deleteTHead();</script>';
    exit;

    }
?>
</tbody>
</table>

<br><br><br>

<button  class="btn btn-danger1" id="export4"  style="background-color: rgb(71, 71, 71);
                           font-size: 24px;
                           font-family: monospace;
                           border-radius: 12px;
                           border-color: greenyellow;
                           color: white;" name="submit_button" type="submit" value="Submit">
                    Download fasta file</button>
  


<button class="btn btn-danger" id="export3" style="background-color: rgb(71, 71, 71);
                           font-size: 24px;
                           font-family: monospace;
                           border-radius: 12px;
                           border-color: greenyellow;
                           color: white;" name="submit_button" type="submit" value="Submit">
                    Download tab delimited file</button>

</body>



<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="jquery.cdstofasta.js"></script>
<script src="jquery.cdstotsv.js"></script>
<script src="jquery.peptotsv.js"></script>
<script src="jquery.peptofasta.js"></script>

<script>

$('#export1').on('click',function(){
  $('#example').tableToCsv2();
})
$('#export').on('click',function(){
  $('#example').tableToCsv();
})
$('#export3').on('click',function(){
  $('#example1').tableToCsv3();
})
$('#export4').on('click',function(){
  $('#example1').tableToCsv4();
})

</script>




</html>


