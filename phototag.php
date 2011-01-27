<?php 
/*
Plugin Name: Phototag
Plugin URI: http://www.webania.net/phototag/
Description: Phototag - Tag people on photos in your blog posts (Facebook like tagging).
Version: 1.0.3
Author: Elvin Haci
Author URI: http://www.e-haci.net
License: GPL2
*/
/*  Copyright 2010,  Elvin Haci  (email : elvinhaci@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function phototag ()
{

if (is_numeric($GLOBALS['content_width'])) {$gcw=$GLOBALS['content_width'];}else {$gcw=640;}
$allowed_types=array ("jpg","gif","png","bmp");
echo '<h2><a href="?page=phototag/phototag.php">People tagger</a></h2>';
if (!isset($_POST["imgpath"]))
{
	echo '
	
	<form action="" method="post">Paste the path of the image here ( ex. http://example.com/images/image.jpg):
	<br> <input size="100" type="text" name="imgpath" value=""> <br>
	<br><sup>Image width (Maximum image width for your blog is '.$gcw.', so if you want the plugin to work fine don\'t set the value greater than '.$gcw.'. If you leave this field blank, then the width will be set to '.$gcw.'.) </sup><input type="text" size="5" value="" name="imgwidth"> 
	<br>
	
	<br>
	<input type="Submit" value=" Let\'s go "></form><br>
	';
}
elseif (  in_array(substr($_POST["imgpath"],-3),$allowed_types ) ) 
{
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script>
var ci=1;


  $(window).load(function(){
  $(document).ready(function(e) {
   
    $("#B").click(function(e) {
       
	   if ($("#users").val()=='')
	{
		ci=1; 
	}
	else if (ci==1)
	{
	ci=2;
	}

	
	if (ci==1) 
	{
		alert('Type the name of the object!');
	}
	else 
	{
		ci=ci+1;
		process=1;
		var posX = $(this).offset().left, posY = $(this).offset().top;
		$("#users").val($("#users").val()+','+(e.pageX - posX)+','+(e.pageY - posY));
		if (ci==4) 
		{
			$("#users2").val($("#users2").val()+$("#users").val()+';');
			$("#users").val('');
			ci=1;
		}
		
    }
	   
	   
	   
	   
    });
   
});
  });

</script>
<style>
#B { cursor:pointer;background:#2f2f2f;top:50px;color:#fff; }
</style>
<?php 
if (is_numeric( $_POST["imgwidth"]) and $_POST["imgwidth"]<=$gcw) {$wdt= $_POST["imgwidth"];}else {$wdt=$gcw;}
if (!isset($_POST["users2"])) {
?>
<table> <tr><td>
<img src="<?php echo $_POST["imgpath"];?>" border="0" id="B" width="<?php echo $wdt; ?>"   >
</td>
<td valign="top" style="padding-left:10px"><br>
<form action="" method="post">
<h2>Start tagging</h2>
<input id="imgpath" name="imgpath" type="hidden"  value="<?php echo $_POST["imgpath"]; ?>"/>
<input id="imgwidth" name="imgwidth" type="hidden"  value="<?php echo $wdt; ?>"/><br>
<input name="users2" id="users2" type="hidden" width="50" />
1. <span id="guide">Type name of object for tagging here:</span> <input name="users" id="users" type="text" width="50"/> 
<br><br>
2. Then click on object twice (for example: at first click on the top-left then click on the bottom-right of human face)<br><br>
3. First tagging is ready. If you want to tag second object then go to (1.) and start this procedure again, else go to (4.) <br><br>
4. Finished tagging? <input type="submit" name="but" value="Get the code"> . If something wrong in tagging, then <input  name="butt" value="Clear" onclick="clear()" type="reset"> and start again with (1.)


</form>
</td></tr></table>

<?php
}
else
{   
	//Ata,271,52,332,143;ogul,46,255,109,312;
	
	$tags=explode(";",$_POST["users2"]);
	
	$style_js='<style>
	.classs {
	background-color:#000000;color:#FFF;font-weight:bold; 
	position:relative;
	float:left;
}
.classs .text {
	position:absolute;
	top:1px; 
	left:1px;

}
	</style>

	<script>

	function showuser (name,xco,yco)
	{ 
		$("#taggedun").show();
		$("#taggedun").text(name);
		$("#taggedun").css("top",yco+"px");
		$("#taggedun").css("left",xco+"px");
			
	}
	</script>';
	$code='<div  class="classs"><div class="text" id="taggedun"></div><img  id="taggedpic" src="'.$_POST["imgpath"].'" ';  
	if (is_numeric($_POST["imgwidth"])) {$code=$code.'alt="'.$_POST["imgwidth"].'" width="'.$_POST["imgwidth"].'" ';} else {$code=$code.'alt="'.$gcw.'" width="'.$gcw.'" ';}
	$code=$code.' border="0" usemap="#Map"  ><map name="Map" id="Map">';
	$inphoto='';
	for ($i=1;$i<=(count($tags)-1);$i++)
	{
		//echo substr($tags[$i-1], 0, strpos($tags[$i-1],",")).'<br>';
		$coords=explode(",",$tags[$i-1]);
		$code=$code.'<area onmouseout="taghide()"  onmouseover="showuser(\' '.substr($tags[$i-1], 0, strpos($tags[$i-1],",")).' \',\''.$coords[1].'\',\''.$coords[2].'\')" shape="rect" coords="'.
		substr($tags[$i-1], strpos($tags[$i-1],",")+1).'"  />';
		$inphoto=$inphoto.' <a onmouseout="taghide()"  onmouseover="showuser(\' '.substr($tags[$i-1], 0, strpos($tags[$i-1],",")).' \',\''.$coords[1].'\',\''.$coords[2].'\')">'.substr($tags[$i-1], 0, strpos($tags[$i-1],",")).'</a>';
			
	}
	$code=$code.'</map>	</div><br>';
	$inphoto="In this photo: ".$inphoto;		

	
	//echo $style_js.$code.$inphoto;
	echo '<div ><br><b>Done!!!</b> Now copy this code and paste it anywhere in your blog:<br> <br><textarea cols="50" rows="10" name="cs">'.$code.$inphoto.'</textarea></div>';

}

}//$_POST["imgpath"]else
else
{
echo "Invalid file type, <a href=''>return home</a>";
}

}//function
function phototag_start ()
{
add_menu_page('admin-menu', 'Tag new photo', 5, __FILE__, 'phototag');
}
function inlude_js_css ()
{
$inc=file_get_contents(WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__))."/add_js_css.php");
echo $inc ;
}

add_action('admin_menu', 'phototag_start');
add_filter('get_footer', 'inlude_js_css');
?>