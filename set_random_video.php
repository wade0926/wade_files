<?php
if($_POST['search_words'] != '' && $_POST['res_num'] != '')
{	
	$search_words = $_POST['search_words'];
	$res_num = $_POST['res_num'];	
	
	$search_words_arr = explode(',',$search_words);
		
	//查詢目前所有playlist
	$url = 'https://api.dailymotion.com/playlists?owner=x1ob6ga';
	$res = exec_curl($url);
		
	foreach($res['list'] as $row)
	{
		//如果想要找的播放清單名稱有在目前擁有的播放清單
		if(array_search($row['name'],$search_words_arr) !== false)
		{
			$target_playlist_id[] = $row['id'];
		}	
	}
	
	$i = 0;
	
	//找出所有的video id
	foreach($target_playlist_id as $row)
	{
		$url = 'https://api.dailymotion.com/playlist/'.$row.'/videos';
		$res = exec_curl($url);		
		
		foreach($res['list'] as $row_video)
		{
			$target_video[$i]['id'] = $row_video['id'];
			$target_video[$i]['title'] = $row_video['title'];
			
			$i++;
		}
	}
	
	//========== random 取出指定量的video 資訊 op ==========
	//如果要取的影片數大於所有的影片數
	if($res_num > count($target_video))
	{
		$res_num = count($target_video);
	}	
			
	$rand_keys = array_rand($target_video,$res_num);	
	
	//如果只要一個值，把值設定進陣列
	if($res_num == 1)
	{
		$rand_keys = array($rand_keys);
	}
		
	for($i = 0;$i < $res_num;$i++)
	{		
		$res_video[]= $target_video[$rand_keys[$i]];		
	}	
		
	$res_json = json_encode($res_video);
	//========== random 取出指定量的video 資訊 op ==========
			
	$file = fopen("random_video.json","w");	
	fwrite($file,$res_json);	
	fclose($file);

	echo 'The ramdon data create, ok!';
	exit;	
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Set Random Video</title>

<style>
td
{
	height:35px;
}
</style>

</head>
<body style="margin-left:100px;">

<h2 align="center" style="margin-top:50px;">Wade 模仿 'Sanlih WebApp' 的更新隨機播放清單功能 By Dailymotion API </h2>

<form method="post">
<table align="center">
	<tr>
    	<td style="padding-right:250px;">名稱</td>
        <td>iSET官網影音_首頁&amp;活動</td>
    </tr>
    <tr>
    	<td>影片數量</td>
        <td>
        	<select name="res_num">
            	<?php
				for($i = 1;$i <= 20;$i++)
				{
					?>
					<option <?php if($i == 5) echo 'selected="selected"';?> value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php
				}
				?>
            </select>        	
        </td>
    </tr>
    <tr>
    	<td>播放清單：</td>
        <td>SETTV</td>
    </tr>
    <tr>
    	<td>
        	播放清單過濾字串(這個值是預設的)：
            <br />
			(用逗號 ',' 分隔想要尋找的播放清單)
		</td>
        <td>
        	<input type="text" name="search_words" style="width:600px" value="華流,新聞網" />
        </td>
    </tr>    
</table>

<br />
<div align="center">
	<button type="submit">執行</button>
</div>
</form>

</body>
</html>

<?php
function exec_curl($url)
{
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	$res_curl = curl_exec($ch);
	curl_close($ch);
	
	return json_decode($res_curl,true);
}
?>
