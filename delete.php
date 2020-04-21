<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css/style.css">
<title>PHP FILE - Edit</title>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cancel-button').click(function(){
			window.location = 'index.php';
		});
	});
</script>
</head>
<body>
    <?php 
    require_once 'helper.php';
    $deleteSuccess = false;

    $id = $_GET['id'];
    $data = file_get_contents("./files/$id");
    $data = explode("||", $data);
    $title= $data[0];
    $description = $data[1];

    $fileName= str_replace(".txt","",$id);
    $img = scandir("./images");
    $img_arr = glob("./images/$fileName-*");

    if(isset($_POST['deleted'])){
        $id = $_POST['deleted'];
        @unlink("./files/$id.txt");
        $title= "";
        $description = "";
        foreach($img_arr as $key=>$imgName){
            @unlink($imgName);
        }
        $deleteSuccess = true;
    }

    function displayImg(){
        foreach ($GLOBALS['img_arr'] as $key=>$value){
            echo "<img src=$value rows='5' cols='100'/>";
        }
    }
    ?>

<div id="wrapper">
    	<div class="title">PHP FILE - EDIT</div>
        <div id="form">   
			<form action="#" method="post" name="add-form" enctype="multipart/form-data">
				<div class="row">
					<p>Title</p>
					<input type="text" name="title" value="<?php echo $title;?>">
				</div>
				
				<div class="row">
					<p>Description</p>
					<textarea name="description" rows="5" cols="100"><?php echo $description;?></textarea>
                </div>
                
                <div class="row">
					<p>Images</p>
					<input type="file" name="file-upload[]" multiple rows="5" cols="100">
                    <p id="pic" >
                    <?php displayImg(); ?>
                    </p>
				</div>
				
				<div class="row">
                    <input type="hidden" value=<?php echo $fileName; ?> name="deleted">
                    <input type="submit" value="Delete" name="submit" id="submit-button">
					<input type="button" value="Cancel" name="cancel" id="cancel-button">
				</div>
				
				<?php
					if ($deleteSuccess) echo "<p class='error'>Delete successfully</p>";
				?>
								
			</form>    
        </div>
        
    </div>
</body>
</html>