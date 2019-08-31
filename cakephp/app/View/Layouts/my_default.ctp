<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->fetch('title'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<?php echo $this->Html->css('default'); ?>
	<script>
		 window.jQueryDomReady = function(p){ (jQueryDomReady.procs = jQueryDomReady.procs || []).push(p); }
	</script>
</head>
<body>
	<div id="header">
	</div>
	<div id="content">

	<?php echo $this->Flash->render(); ?>

	<?php echo $this->fetch('content'); ?>
	</div>
	<div id="footer">
	</div>
	<script>
		(function(w){

		}(window));
	</script>

	<script>
		 jQueryDomReady.procs && jQueryDomReady.procs.map(function(p){ $(p); });
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</div>
</body>
</html>
