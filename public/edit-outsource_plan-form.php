<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;
?>
<?php

if (isset($_GET['id'])) {
	$ID = $db->escapeString($_GET['id']);
} else {
	// $ID = "";
	return false;
	exit(0);
}
if (isset($_POST['btnEdit'])) {

    $name = $db->escapeString(($_POST['name']));
    $description = $db->escapeString(($_POST['description']));
	$demo_video = $db->escapeString(($_POST['demo_video']));
	$monthly_codes = $db->escapeString(($_POST['monthly_codes']));
	$per_code_cost = $db->escapeString(($_POST['per_code_cost']));
	$monthly_earnings = $db->escapeString(($_POST['monthly_earnings']));
    $yearly_earnings = $db->escapeString(($_POST['yearly_earnings']));
    $sync_cost = $db->escapeString(($_POST['sync_cost']));
	$price = $db->escapeString(($_POST['price']));
	$type = $db->escapeString(($_POST['type']));
	$min_refers = $db->escapeString(($_POST['min_refers']));
	$invite_bonus = $db->escapeString(trim($_POST['invite_bonus']));
	$num_sync = $db->escapeString(trim($_POST['num_sync']));
	$sub_description = $db->escapeString(trim($_POST['sub_description']));
	$active_link = $db->escapeString(trim($_POST['active_link']));
	$refund = $db->escapeString(trim($_POST['refund']));
	$refer_refund_amount = $db->escapeString(($_POST['refer_refund_amount']));
    
	$sql_query = "UPDATE outsource_plan SET name='$name',description='$description',demo_video='$demo_video',monthly_codes='$monthly_codes',per_code_cost='$per_code_cost',price='$price',monthly_earnings='$monthly_earnings',type = '$type',min_refers = '$min_refers',invite_bonus= '$invite_bonus',num_sync = '$num_sync',sub_description = '$sub_description',active_link = '$active_link', yearly_earnings = '$yearly_earnings' , sync_cost = '$sync_cost' , refund = '$refund' , refer_refund_amount = '$refer_refund_amount' WHERE id =  $ID";
		$db->sql($sql_query);
		$result = $db->getResult();             
		if (!empty($result)) {
			$error['update_languages'] = " <span class='label label-danger'>Failed</span>";
		} else {
			$error['update_languages'] = " <span class='label label-success'>Outsource Plans Updated Successfully</span>";
		}
		if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0 && !empty($_FILES['image'])) {
			//image isn't empty and update the image
			$old_image = $db->escapeString($_POST['old_image']);
			$extension = pathinfo($_FILES["image"]["name"])['extension'];
	
			$result = $fn->validate_image($_FILES["image"]);
			$target_path = 'upload/images/';
			
			$filename = microtime(true) . '.' . strtolower($extension);
			$full_path = $target_path . "" . $filename;
			if (!move_uploaded_file($_FILES["image"]["tmp_name"], $full_path)) {
				echo '<p class="alert alert-danger">Can not upload image.</p>';
				return false;
				exit();
			}
			if (!empty($old_image) && file_exists($old_image)) {
				unlink($old_image);
			}
	
			$upload_image = 'upload/images/' . $filename;
			$sql = "UPDATE outsource_plan SET `image`='$upload_image' WHERE `id`='$ID'";
			$db->sql($sql);
	
			$update_result = $db->getResult();
			if (!empty($update_result)) {
				$update_result = 0;
			} else {
				$update_result = 1;
			}
	
			if ($update_result == 1) {
				$error['update_languages'] = " <section class='content-header'><span class='label label-success'>Outsource Plan updated Successfully</span></section>";
			} else {
				$error['update_languages'] = " <span class='label label-danger'>Failed to update</span>";
			}
		}
	}


// create array variable to store previous data
$data = array();

$sql_query = "SELECT * FROM outsource_plan WHERE id =" . $ID;
$db->sql($sql_query);
$res = $db->getResult();

if (isset($_POST['btnCancel'])) { ?>
	<script>
		window.location.href = "outsource_plan.php";
	</script>
<?php } ?>
<section class="content-header">
	<h1>
		Edit Outsource Plan<small><a href='outsource_plan.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Outsource Plan</a></small></h1>
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
                               <div class="col-md-3">
									<label for="exampleInputEmail1">Name</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="name" value="<?php echo $res[0]['name']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Demo Video</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="demo_video" value="<?php echo $res[0]['demo_video']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Price</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="price" value="<?php echo $res[0]['price']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Min Refers</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="min_refers" value="<?php echo $res[0]['min_refers']; ?>">
								</div>
                            </div>
                         </div>
                         <br>
						 <div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="exampleInputFile">Image</label> <i class="text-danger asterik">*</i><?php echo isset($error['image']) ? $error['image'] : ''; ?>
                                    <input type="file" name="image" onchange="readURL(this);" accept="image/png, image/jpeg" id="image" /><br>
                                    <img id="blah" src="<?php echo $res[0]['image']; ?>" alt="" width="150" height="200" <?php echo empty($res[0]['image']) ? 'style="display: none;"' : ''; ?> />
                                </div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Monthly Codes</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="monthly_codes" value="<?php echo $res[0]['monthly_codes']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Per Code Cost</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="per_code_cost" value="<?php echo $res[0]['per_code_cost']; ?>">
								</div>
								<div class="col-md-3">
                                <label for="exampleInputEmail1">Select Type</label> <i class="text-danger asterik">*</i>
                                    <select id='type' name="type" class='form-control'>
                                     <option value='jobs' <?php if ($res[0]['type'] == 'jobs') echo 'selected'; ?>>jobs</option>
                                      <option value='senior_jobs' <?php if ($res[0]['type'] == 'senior_jobs') echo 'selected'; ?>>senior_jobs</option>
                                    </select>
								</div>
                            </div>	 
						  </div>  
						  <br><div class="row">
                            <div class="form-group">
                                <div class="col-md-3">
									<label for="exampleInputEmail1">Monthly Earnings</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="monthly_earnings" value="<?php echo $res[0]['monthly_earnings']; ?>">
								</div>
                                <div class="col-md-3">
									<label for="exampleInputEmail1">Yearly Earnings</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="yearly_earnings" value="<?php echo $res[0]['yearly_earnings']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Invite Bonus</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="invite_bonus" value="<?php echo $res[0]['invite_bonus']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Num Sync</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="num_sync" value="<?php echo $res[0]['num_sync']; ?>">
								</div>
                            </div>	 
						  </div> 
						  <br><div class="row">
                            <div class="form-group">
								<div class="col-md-3">
									<label for="exampleInputEmail1">Sub Description</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="sub_description" value="<?php echo $res[0]['sub_description']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Active Link</label><i class="text-danger asterik">*</i>
									<input type="text" class="form-control" name="active_link" value="<?php echo $res[0]['active_link']; ?>">
								</div>
                                <div class="col-md-3">
									<label for="exampleInputEmail1">Sync Cost</label><i class="text-danger asterik">*</i>
									<input type="number" class="form-control" name="sync_cost" value="<?php echo $res[0]['sync_cost']; ?>">
								</div>
								<div class="col-md-3">
									<label for="exampleInputEmail1">Refund</label><i class="text-danger asterik">*</i>
									<input type="number" step="0.01" class="form-control" name="refund" value="<?php echo $res[0]['refund']; ?>">
								</div>
                            </div>	 
						  </div> 
						  <br><div class="row">
                            <div class="form-group">
								<div class="col-md-3">
									<label for="exampleInputEmail1">Refer Refund Amount</label><i class="text-danger asterik">*</i>
									<input type="number" step="0.01" class="form-control" name="refer_refund_amount" value="<?php echo $res[0]['refer_refund_amount']; ?>">
								</div>
                            </div>	 
						  </div> 
						  <br>
						  <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                   <label for="description">Description :</label> <i class="text-danger asterik">*</i><?php echo isset($error['description']) ? $error['description'] : ''; ?>
                                    <textarea name="description" id="description" class="form-control" rows="8"><?php echo $res[0]['description']; ?></textarea>
                                    <script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
                                    <script type="text/javascript">
                                       CKEDITOR.replace('description');
                                    </script>
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