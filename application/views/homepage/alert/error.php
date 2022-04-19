<link rel="stylesheet" type="text/css" href="/css/alert/error.css">

<section>
	<h1>< Error Page ></h1>
	<div id = "error_div">
		<h3><?=$msg?></h3>
		<?php if(isset($error)): ?>
			<h5><?=$error?></h5>
		<?php endif; ?>		
	</div>
	
</section>