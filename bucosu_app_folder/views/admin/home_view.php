<h1><?php echo $title ;?></h1>

<?php if (!empty($view_object)): ?>

	<a href="<?php echo site_url($link_url['edit']) ;?>">Edit</a> | <a href="<?php echo site_url($link_url['new']) ;?>">New</a>
	<hr />
	<pre>
		<?php var_dump($view_object); ?>
	</pre>
<?php endif; ?>



<?php if (!empty($edit_object)): ?>

	<a href="<?php echo site_url($link_url['new']) ;?>">New</a>
	<hr />
	<?php echo $edit_object; ?>
<?php endif; ?>


<?php if (!empty($new_object)): ?>

	<a href="<?php echo site_url($link_url['new']) ;?>">New</a>
	<hr />
	<pre>
		<?php var_dump($new_object); ?>
	</pre>
<?php endif; ?>


<?php if (!empty($list_objects)): ?>
	
	<?php echo $list_objects; ?>
<?php endif; ?>