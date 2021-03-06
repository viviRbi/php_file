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
    $uploadSuccess = false;

    $id = $_GET['id'];
    $data = file_get_contents("./files/$id");
    $data = explode("||", $data);
    $title= $data[0];
    $description = $data[1];

    $fileName= str_replace(".txt","",$id);
    $img = scandir("./images");
    $img_arr = glob("./images/$fileName-*");
  
    $titleError = '';
    $descriptionError = '';
    $imageError="";
    // print_r($_FILES['file-upload']);
    $trueImageExtension = false;

    if(isset($_FILES['file-upload'])){
        $i =0;
        $image= $_FILES['file-upload'];

        // Cannot save if image haven't been change
        
        $imageError="";


        foreach($image['name'] as $key => $value){
            $i++;
            $imgExt = pathinfo($image['name'][$key],PATHINFO_EXTENSION);
            if(in_array(strtolower($imgExt),array("jpg","png","jpeg"))){
                $trueImageExtension = true;
                @move_uploaded_file($image['tmp_name'][$key], './images/'. $name .'-'. $i . "." .$imgExt) ;
            }else{
                $trueImageExtension = false;
                $imageError .= "<p class='error'>Only accept jpg, jpeg, png</p>";
            }
            if($i>2){
                $imageError="<p class ='error'>Can only upload 1 to 2 images</p>";
                break;
            } 
        }
        if ($i ==0){
            $imageError="<p class ='error'>Can only upload 1 to 2 images</p>";
        }
     }

    if(isset($_POST['title']) && isset($_POST['description']) ){
      
		$title			= $_POST['title'];
        $description	= $_POST['description'];

        // Error Title
        $titleError = '';
		if(checkLength("title", 2, 100)) $titleError = '<p class="error">Tiêu đề dài từ 2 đến 100 tu</p>';
		
        // Error Description
        $descriptionError = '';
        if(checkLength("description", 5, 5000)) $descriptionError .= '<p class="error">Nội dung dài từ 5 đến 5000 ký tự</p>';

        if($titleError == "" && $descriptionError==""){
            $data = $title."||".$description;
            $file = "./files/$id";

            if ($trueImageExtension == true){
				if($imageError=="" && $titleError=="" && $descriptionError==""){
					if(file_put_contents($file,$data)){
                        echo
						$title = "";
						$description= "";
						$uploadSuccess = true;
					}
				}
			}
        }
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
					<?php echo $titleError; ?>
				</div>
				
				<div class="row">
					<p>Description</p>
					<textarea name="description" rows="5" cols="100"><?php echo $description;?></textarea>
					<?php echo $descriptionError;?>
                </div>
                
                <div class="row">
					<p>Images</p>
					<input type="file" name="file-upload[]" multiple rows="5" cols="100">
                    <?php echo $imageError; ?>
                    <p id="pic" >
                    <?php displayImg(); ?>
                    </p>
				</div>
				
				<div class="row">
					<input type="submit" value="Save" name="submit">
					<input type="button" value="Cancel" name="cancel" id="cancel-button">
				</div>
				
				<?php
					if ($uploadSuccess) echo "<p class='error'>Upload successfully</p>";
				?>
								
			</form>    
        </div>
        
    </div>
</body>
</html>