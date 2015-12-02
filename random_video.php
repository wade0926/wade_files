<?php
$json_data = file_get_contents('random_video.json');
$data = json_decode($json_data,true);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<title>Random Video</title>
<body>

<input type="hidden" id="current_video_num" value="0" />

<div align="center" style="margin-top:150px;">
	<a id="video_source_url" href="http://www.dailymotion.com/video/<?php echo $data[0]['id'];?>" target="_blank">
    	<?php echo $data[0]['title'];?>
    </a>
    <br />    
    <iframe
    	id="random_video_iframe"
        src="//www.dailymotion.com/embed/video/<?php echo $data[0]['id'];?>"        
        height="172.125"
        frameborder="0"    
        allowfullscreen
    >
    </iframe>
    <br />    
    <a href="javascript:void(0);" onClick="pre_video();">
        &lt;&lt;上一則
    </a>
    <a href="javascript:void(0);" onClick="next_video();" style="margin-left:90px">
    	下一則&gt;&gt;
    </a>
</div>
    
</body>
</html>

<script>
data = <?php echo $json_data;?>;

function next_video()
{	
	var current_video_num = parseInt($('#current_video_num').val()) + 1;	
	change_video(current_video_num);	
}

function pre_video()
{	
	var current_video_num = parseInt($('#current_video_num').val()) - 1;	
	change_video(current_video_num);
}

function change_video(current_video_num)
{
	if(current_video_num < 0)
	{
		current_video_num = data.length - 1;
	}
	
	if(current_video_num > data.length - 1)
	{
		current_video_num = 0;
	}	
	
	$('#current_video_num').val(current_video_num);		
	$('#random_video_iframe').attr('src','//www.dailymotion.com/embed/video/'+data[$('#current_video_num').val()]['id']);
	$('#video_source_url').text(data[$('#current_video_num').val()]['title']);
	$('#video_source_url').attr('href','http://www.dailymotion.com/video/'+data[$('#current_video_num').val()]['id']);
}
</script>
