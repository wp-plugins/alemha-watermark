<?php 
global $dir_name;
if(isset($_GET['post'])){
	$image="images/index_".$_GET['post'].".jpg";
	$filepath = $dir_name.$image ;
	if(file_exists($filepath)){
		echo '<img src="' . plugins_url( $image , dirname(__FILE__) ) . '" > ';
	}else{
		echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';
	}
}
else
	echo '<img src="' . plugins_url( "images/index.jpg" , dirname(__FILE__) ) . '" > ';

?>
