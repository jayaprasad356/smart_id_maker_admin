<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

if (isset($_GET['id'])) {
    $ID = $db->escapeString($_GET['id']);
} else {
    return false;
    exit(0);
}

if (isset($_POST['btnEdit'])) {
    $title = $db->escapeString($_POST['title']);
    $description = $db->escapeString($_POST['description']);
    $link = $db->escapeString($_POST['link']);
    
    $current_datetime = date('Y-m-d H:i:s'); 
    $sql_query = "UPDATE notifications SET title='$title', description='$description', link='$link', datetime='$current_datetime' WHERE id=$ID";
    $db->sql($sql_query);
    $result = $db->getResult();
    
    if (!empty($result)) {
        $error['update_languages'] = "<span class='label label-danger'>Failed</span>";
    } else {
        $error['update_languages'] = "<span class='label label-success'>Plans Updated Successfully</span>";
    }

    // Image upload and update
    $old_image = $db->escapeString($_POST['old_image']);
    $upload_image = $old_image ? $old_image : 'dist/img/icon.jpeg'; // Default image if no image provided

    if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
        $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        $result = $fn->validate_image($_FILES["image"]);
        $target_path = 'upload/images/';
        $filename = microtime(true) . '.' . strtolower($extension);
        $full_path = $target_path . $filename;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
            // Delete old image if it exists
            if (!empty($old_image) && file_exists($old_image)) {
                unlink($old_image);
            }
            $upload_image = $full_path; // Use the newly uploaded image
        } else {
            echo '<p class="alert alert-danger">Cannot upload image.</p>';
            return false;
        }
    }

    // Update the image in the database
    $sql = "UPDATE notifications SET image='$upload_image' WHERE id=$ID";
    $db->sql($sql);
    $update_result = $db->getResult();
    
    if (!empty($update_result)) {
        $update_result = 0;
    } else {
        $update_result = 1;
    }

    if ($update_result == 1) {
        $error['update_languages'] = "<section class='content-header'><span class='label label-success'>Notification Updated Successfully</span></section>";
    } else {
        $error['update_languages'] = "<span class='label label-danger'>Failed to update</span>";
    }
}

// Retrieve current data
$data = array();
$sql_query = "SELECT * FROM notifications WHERE id=$ID";
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
    <script>
        window.location.href = "notifications.php";
    </script>
<?php } ?>

<section class="content-header">
	<h1>
		Edit Notifications<small><a href='notifications.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Notifications</a></small></h1>
	<small><?php echo isset($error['update_languages']) ? $error['update_languages'] : ''; ?></small>
	<ol class="breadcrumb">
		<li><a href="reports.php"><i class="fa fa-home"></i> Home</a></li>
	</ol>
</section>
<section class="content">
	<!-- Main row -->

	<div class="row">
		<div class="col-md-10">

			<!-- general form elements -->
			<div class="box box-primary">
				<div class="box-header with-border">
				</div><!-- /.box-header -->
				<!-- form start -->
				<form id="edit_languages_form" method="post" enctype="multipart/form-data">
					<div class="box-body">
					<div class="box-body">
                    <input type="hidden" name="old_image" value="<?php echo isset($res[0]['image']) ? $res[0]['image'] : ''; ?>">
				    	<div class="row">
					  	  <div class="form-group">
                               <div class="col-md-6">
									<label for="exampleInputEmail1">Title</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="title" value="<?php echo $res[0]['title']; ?>">
								</div>
								<div class="col-md-6">
									<label for="exampleInputEmail1">Link</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="link" value="<?php echo $res[0]['link']; ?>">
								</div>
                            </div>
                         </div>
                         <br>
						 <div class="row">
                            <div class="form-group">
                            <div class="col-md-6">
									<label for="exampleInputEmail1">Description</label><i class="text-danger asterik">*</i>
                                    <textarea type="text" rows="3" class="form-control" name="description"><?php echo $res[0]['description']; ?></textarea>
								</div>
                                <div class="col-md-6">
                                    <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                    <input type="file" name="image" onchange="readURL(this);" accept="image/png, image/jpeg" id="image" /><br>
                                    <img id="blah" src="<?php echo $res[0]['image']; ?>" alt="" width="150" height="200" <?php echo empty($res[0]['image']) ? 'style="display: none;"' : ''; ?> />
                                </div>
                            </div>	 
						  </div>  
						 
						  <br>

                     </div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary" name="btnEdit">Update</button>

					</div>
				</form>
			</div><!-- /.box -->
		</div>
	</div>
</section>

<div class="separator"> </div>
<?php $db->disconnect(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200)
                    .css('display', 'block');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    var changeCheckbox = document.querySelector('#stock_button');
    var init = new Switchery(changeCheckbox);
    changeCheckbox.onchange = function() {
        if ($(this).is(':checked')) {
            $('#stock').val(1);

        } else {
            $('#stock').val(0);
        }
    };
</script>