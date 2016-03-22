<h1><?php echo $session_user_data['username']; ?></h1>
<hr />
<div class="row mt20">
  <div class="col-md-6">
    <div class="bs-component">
      <div class="tab-block mb25">
        <ul class="nav tabs-right tabs-border">
        	<?php $active = 'active'; ?>
			<?php foreach ($session_user_data as $key => $value): ?>	
				<?php if (!is_array($value) && !is_object($value)): ?>
					<li class="<?php echo $active; ?>">
			        	<a href="#<?php echo $key; ?>" data-toggle="tab"><?php echo $key; ?></a>
			        </li>
				<?php $active = ''; ?>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
        <div class="tab-content">
	   		<?php $active = 'active'; ?>
			<?php foreach ($session_user_data as $key => $value): ?>	
				<?php if (!is_array($value) && !is_object($value)): ?>
					<div id="<?php echo $key; ?>" class="tab-pane <?php echo $active; ?>">
						<?php echo $value; ?>
					</div>
				<?php $active = ''; ?>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="bs-component">
      <div class="tab-block mb25">
        <ul class="nav tabs-left tabs-border">
        	<?php $active = 'active'; ?>
			<?php foreach ($session_user_data as $key => $value): ?>	
				<?php if (is_array($value) || is_object($value)): ?>
					<li class="<?php echo $active; ?>">
			        	<a href="#<?php echo $key; ?>" data-toggle="tab"><?php echo $key; ?></a>
			        </li>
				<?php $active = ''; ?>
				<?php endif; ?>
			<?php endforeach; ?>
        </ul>
        <div class="tab-content">
	   		<?php $active = 'active'; ?>
			<?php foreach ($session_user_data as $key => $value): ?>	
				<?php if (is_array($value) || is_object($value)): ?>
					<div id="<?php echo $key; ?>" class="tab-pane <?php echo $active; ?>">
						<pre>
							<?php var_dump($value); ?>
						</pre>
					</div>
				<?php $active = ''; ?>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>