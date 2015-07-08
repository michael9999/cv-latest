<?php global $comments; ?>

<h2>Comments</h2>
<table class="form-table-list">
	<tr valign="top">
		<th scope="row"><label for="target_uri"><?php _e( 'From', 'bp-ktr' ) ?></label></th>
		<th scope="row"><label for="target_uri"><?php _e( 'Comment', 'bp-ktr' ) ?></label></th>
	   <th scope="row"><label for="target_uri"><?php _e( 'Date', 'bp-ktr' ) ?></label></th>
	</tr>
	<?php if($comments):?>
		<?php foreach($comments as $c):?>
		<?php if(!$c->approved) continue; ?>
		<tr valign="top">
			<td scope="row"><?php echo $c->sender;  ?></td>
			<td scope="row"><?php echo $c->comment;  ?></td>
			<td scope="row">
				<?php 
					//$date = DateTime::createFromFormat('Y-m-d H:i:s', $c->date);  
					//echo $date->format("d M Y");
					echo date("d M Y", strtotime($c->date));
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	<tr valign="top">
		<td scope="row">New Comment</td>
		<td scope="row">
			<form action="" name="comment-form" id="comment-form" method="post">
				<textarea name="comment" id="comment" rows="4" cols="55"></textarea><br />
				<input type="hidden" name="return_url" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?> " />
				<input type="submit" name="send_comment" value="<?php _e( 'Send', 'bp-ktr' ) ?>" />
			</form>
		</td>
	    <td scope="row"></td>
	</tr>
</table>