<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=export.xls");
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
    <td align="center">DB ID</td>
    <td align="center">Staff Name</td>
    <td align="center">Email 1</td>
    <td align="center">Email 2</td>
    <td align="center">DOB</td>
    <td align="center">Contact Number 1</td>
    <td align="center">Contact Number 2</td>
    <td align="center">Role</td>
    <td align="center">Date Added</td>
    <td align="center">Last Updated</td>
    
    
  </tr>
  
  <?php 
	  	if($user_export){
			foreach ($user_export->result_array() as $key => $row){

      		?>

        <tr>
          <td><?php echo $row["user_id"]; ?></td>
          <td><?php echo $row["staff_name"]; ?></td>
          <td><?php echo $row["email"]; ?></td>
          <td><?php echo $row["email_2"]; ?></td>
          <td><?php echo make_user_system_date($row["birth_date"]); ?></td>
          <td><?php echo $row["contact_number_1"]; ?></td>
          <td><?php echo $row["contact_number_2"]; ?></td>
          <td><?php echo $row["user_roll_name"]; ?></td>
          <td><?php echo make_user_system_date($row["created_date"]); ?></td>
          <td><?php echo make_user_system_date($row["updated_date"]); ?></td>
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
