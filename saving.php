  <?php
//Get the file
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');

$json_file = file_get_contents('personalcare.json');
$jfo = json_decode($json_file,true);
foreach($jfo as $item)
{
        $content = file_get_contents($item['Image']);
        //echo $content;
        $fp=fopen("images/personalcare/".$item['Name'].".jpg",'w');
        fwrite($fp, $content);
        fclose($fp);
}
?>
