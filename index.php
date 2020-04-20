<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>PHP FILE - Index</title>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#multy-delete').click(function(){
			$('#main-form').submit();
		});
	});
</script>
</head>
<body>
<div id="wrapper">
    	<div class="title">PHP FILE - Index</div>
        <div class="list">   
			<form action="multy-delete.php" method="post" name="main-form" id="main-form">
<?php
	$data = scandir('./files');
	$img = scandir('./images');

	if(file_exists('./files')) chmod('./files', 0666); //file permission

	foreach($data as $key => $name){
		if(preg_match('#.txt$#imsU', $name) == false) {
			$title = "";
			$description = "";
			$id = "";
			$size = "";
			continue;
		}
		$content = file_get_contents("./files/$name");
		$content= explode('||', $content);
		$title = $content[0];
		$description = $content[1];
		$id = substr($name, 0, 5);
		$size = filesize("./files/$name");
		
		//image name == file name, only -number is different
		$partOfImgName= str_replace(".txt","",$name);
		$imageName= "./images/$partOfImgName-1";
		$imageFile = glob("$imageName.*");
?>
	
	         	<div class="row <?php echo $class;?>">
	            	<p class="no">
	            		<input type="checkbox" name="checkbox[]" value="<?php echo $id;?>">
	            	</p>
					<p class="name"><?php echo $title;?><span><?php echo $description;?></span></p>
	                <p class="id"><?php echo $id; ?></p>
	                <p class="size"><?php echo $size; ?></p>
					<img class="size" src=<?php echo $imageFile[0];?> placeholder=<?php echo $imageFile[0];?>/>
	                <p class="action">
	                	<a href="edit.php?id=<?php echo $name;?>">Edit</a> |
	                	<a href="delete.php?id=<?php echo $name;?>">Delete</a>
	                </p>
	            </div>
<?php 
	}
?>
	    	</form>
		</div>
	        <div id="area-button">
	        	<a href="add.php">Add File</a>
	        	<a id="multy-delete" href="#">Delete File</a>
	        </div>
    
    </div>
</body>
</html>
