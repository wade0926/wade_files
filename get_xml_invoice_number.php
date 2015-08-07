<?php
set_time_limit(0);

$dir_name = '20150703111447-6d';

$d = dir($dir_name);
$i = 1;
$j = 1;

//先拿掉. 跟..
$d->read();
$d->read();

while(false !== ($entry = $d->read())) 
{
   	$arr_file_name[] = $entry;    
}

$d->close();
?>
<table border="1">
	<?php
	foreach($arr_file_name as $row)
	{		
		$file = simplexml_load_string(file_get_contents($dir_name.'/'.$row));
		
		//xml 轉 array 
		foreach($file as $value) 
		{			
			$arr_xml[] = json_decode(json_encode($value),true);		
		}		
		?>
        <tr>
            <td><?php echo $arr_xml[0]['InvoiceNumber'];?></td>
            <td><?php echo $arr_xml[0]['RandomNumber'];?></td>  
        </tr>		
        <?php
		unset($arr_xml);
	}	
	?>	
</table>



