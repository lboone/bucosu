	<!-- BEGIN: PAGE SCRIPTS -->
	
	<!-- begin: top -->
	<?php 
		if(isset($javascripts['top']))
		{ 
			foreach ($javascripts['top'] as $js)
			{ 
				echo $js; 
			}
		}
	?>
	<!-- end: top -->

	<!-- jQuery -->
	<?php 
		if(isset($javascripts['jquery']))
		{ 
			foreach ($javascripts['jquery'] as $js)
			{ 
				echo $js; 
			}
		}
	?>

	<!-- begin: mid -->
	<?php
		if(isset($javascripts['mid']))
		{
			foreach ($javascripts['mid'] as $js)
			{ 
				echo $js; 
			}
		}
	?>
	<!-- end: mid -->
	
	<!-- Theme Javascript -->
	<?php 
		if(isset($javascripts['theme']))
		{ 
			foreach ($javascripts['theme'] as $js)
			{ 
				echo $js; 
			}
		}
	?>
	
	<!-- begin: end -->
	<?php 
		if(isset($javascripts['end']))
		{
			foreach ($javascripts['end'] as $js)
			{ 
				echo $js; 
			}
		}
	?>
	<!-- end: end -->
	
	<!-- END: PAGE SCRIPTS -->
</body>
<!-- BEGIN: FOOTER -->
	<footer>
		<?php 
			if(isset($footer))
			{ 
				foreach ($footer as $foot)
				{ 
					echo $foot;
				}
			}
		?>

		<div id='dynamic_javascript_content'>
			<div id="dynamic_javascript_validation_content">
			</div>
		</div>
	</footer>
<!-- END: FOOTER -->
</html>