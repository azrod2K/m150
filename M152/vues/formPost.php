<br>
<br>
<div id="postModal" class="form" tabindex="-1" role="dialog" aria-hidden="true">
<?php
if($_SESSION['message']['type'] != null){ ?>
<div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<?= $_SESSION['message']['content'] ?>
</div>
<?php
  $_SESSION['message'] = [
    'type' => null,
    'content' => null
];
}
?>
	<div class="modal-content">
		<div class="modal-content">
			<div class="modal-header">
				<img id="logo" src="assets/img/logo.png" style="width: 50px; height: 50px;">
				New post
			</div>
			<div class="modal-body">
				<form class="form center-block" method="POST" action="index.php?uc=post&action=validate" enctype="multipart/form-data">
					<div class="form-group">
						<textarea class="form-control input-lg" name="description" placeholder="Write something..."></textarea>
					</div>
			</div>
			<div class="modal-footer">
				<div>
					<ul class="pull-left list-inline">
						<li><input class="glyphicon glyphicon-download-alt" type="file" id="avatar" accept="image/*,video/*,audio/*" multiple name="files[]"></li>
					</ul>
					<input type="submit" class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true" value="Publish">
				</div>
				</form>
			</div>
		</div>
	</div>
</div>