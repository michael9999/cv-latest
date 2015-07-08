<script type="text/javascript">
	
		
		function comment_delete(comment_id) {	  
		   if(!confirm('Are you sure?')) return;
		   
		   jQuery.post( ajaxurl, {
				action: 'admin_comment_remove',
				'cookie': encodeURIComponent(document.cookie),
				'comment_id': comment_id
		  },
		  function(data) {
				alert(data);
				location.reload();
		  });			  
		}
		
		function comment_approve(comment_id) {			   
		   jQuery.post( ajaxurl, {
				action: 'admin_comment_approve',
				'cookie': encodeURIComponent(document.cookie),
				'comment_id': comment_id
		  },
		  function(data) {
				alert(data);
				location.reload();
		  });			  
		}
	
</script>

<div id="add_language">
	<h3>Comments</h3>
</div>


<div class="add-new"> 
	<table class="form-table-list">
		<?php if($comments):?>
		<tr valign="top">
			<th scope="row" width="90"><label><?php _e( 'Date', 'bp-ktr' ) ?></label></th>
			<th scope="row" width="20"><label><?php _e( 'From', 'bp-ktr' ) ?></label></th>
			<th scope="row"><label><?php _e( 'Comment', 'bp-ktr' ) ?></label></th>
			<th scope="row"><label><?php _e( 'Actions', 'bp-ktr' ) ?></label></th>
        </tr>
		
		<?php foreach($comments as $c):?>
        <tr>
			<td>
				<?php 
					//$date = DateTime::createFromFormat('Y-m-d H:i:s', $c->date);  
					//echo $date->format("d M Y");
					echo date("d M Y", strtotime($c->date));
				?>
			</td>
			<td><?php echo $c->sender;  ?></td>
			<td><?php echo $c->comment;  ?></td>
			<td>
				<a href="javascript:comment_delete(<?php echo $c->id; ?>);">Delete</a>
				<?php if(!$c->approved):?>
				<a  href="javascript:comment_approve(<?php echo $c->id; ?>);">Approve</a>&nbsp;&nbsp;
				<?php endif; ?>
			</td>
        </tr>
		<?php endforeach;?>
		<?php endif; ?>
		
		<tr valign="top"><td scope="row" colspan="4"><br /></td></tr>
		<tr valign="top">
			<td scope="row" colspan="2"><b>New Comment</b></td>
			<td scope="row" colspan="2">
				<form action="" name="comment-form" id="comment-form" method="post">
					<textarea name="comment" id="comment" rows="4" cols="55"></textarea><br />
					<input type="hidden" name="return_url" value="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?> " />
					<input type="submit" name="send_comment" value="<?php _e( 'Send', 'bp-ktr' ) ?>" />
				</form>
			</td>
		</tr>
	</table>         
</div>


