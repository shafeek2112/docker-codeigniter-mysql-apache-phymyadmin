<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=language_settings.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php

if(isset($user_export) && count($user_export) > 0)
{
?>
<table border="1">
  <tr>
    <td align="center">ID</td>
	<td align="center">lable_info</td>
	<td align="center">english</td>
	<td align="center">chinese</td>
	<td align="center">thai</td>
	<td align="center">vietnamese</td>
	<td align="center">filipino</td>
	<td align="center">burmese</td>
    
  </tr>
  
  <?php 
	  	if($user_export){
			foreach ($user_export->result_array() as $key => $row){

      		?>

        <tr>
          <td><?php echo $row["id"]; ?></td>
          <td><?php echo $row["lang_key_info"]; ?></td>
          <td><?php echo $row["english"]; ?></td>
          <td><?php echo $row["chinese"]; ?></td>
          <td><?php echo $row["thai"]; ?></td>
          <td><?php echo $row["vietnamese"]; ?></td>
          <td><?php echo $row["filipino"]; ?></td>
          <td><?php echo $row["burmese"]; ?></td>
        </tr>
        <?php
				}
				
			} 
			?>
</table>
<?php
}
else 
{
	echo "Data not found";
}
?>
</body>
</html>
