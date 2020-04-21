<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>PHP FILE - Index</title>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>

<body>
	<?php
	require_once('helper.php');

	$uploadSuccess = false;

	$titleError="";
	$descriptionError="";
	$imageError="";

	$title = "";
	$description = "";

	if(isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['file-upload'])){

		$title = $_POST['title'];
		$description = $_POST['description'];
		$image = $_FILES['file-upload'];
		// echo "<pre>";
		// print_r($image);
		// echo "</pre>";

		$titleError="";
		if (checkLength("title", 2, 4)) $titleError="<p class ='error'>Have to be between 2 and 4 words</p>";
	
		$descriptionError="";
		if (checkLength("description", 5, 100)) $descriptionError="<p class ='error'>Have to be between 5 and 100 words</p>";

		$imageError="";
		if(imageLimit("file-upload",2)) $imageError="<p class ='error'>Can only upload 1 to 2 images</p>";

		if ($titleError=="" && $descriptionError==""){
			
			$data = $title ."||". $description;
			$name = randomString(5);
			$fileName = "./files/" . $name . ".txt";

			// image
			$i =0;
			foreach($image['name'] as $key => $value){
				$i++;
				$imgExt = pathinfo($image['name'][$key],PATHINFO_EXTENSION);
				@move_uploaded_file($image['tmp_name'][$key], './images/'. $name .'-'. $i . "." .$imgExt) ;
			}

			// title description
			if(file_put_contents($fileName,$data)){
				$title = "";
				$description= "";
				$uploadSuccess = true;
			}
		}
	} 
	?>
	<div id="wrapper">
    	<div class="title">PHP FILE - ADD</div>
        <div id="form">   
			<form action="#" method="post" name="add-form" enctype="multipart/form-data">
				<div class="row">
					<p>Title</p>
					<input type="text" name="title" value="<?php echo $title;?>">
					<?php echo $titleError; ?>
				</div>
				
				<div class="row">
					<p>Description</p>
					<textarea name="description" rows="5" cols="100"><?php echo $description;?></textarea>
					<?php echo $descriptionError; ?>
				</div>

				<div class="row">
					<p>Images</p>
					<input type="file" name="file-upload[]" multiple rows="5" cols="100">
					<?php echo $imageError; ?>
				</div>
				
				<div class="row">
					<input type="submit" value="Save" name="submit">
					<input type="button" value="Cancel" name="cancel" id="cancel-button">
				</div>

				<div class="row">
				<?php 
				if ($uploadSuccess) echo "<p class='error'>Upload successfully</p>"
				?>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript">

	var cancel= document.getElementById('cancel-button');
	cancel.addEventListener('click',function(){
		window.location="index.php";
	})

</script>

</body>