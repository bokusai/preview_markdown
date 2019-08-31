<div id="markdown-data-provider"
	data-get-markdown-data-url = <?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'getMarkdownData']); ?>
>
</div>
<script>
jQueryDomReady(function(){
	let $dataProvider = $('#markdown-data-provider');

	let render = function(data){
		if(!data){ return false; }
		$('#markdown-body').html(data);
	}

	let getMarkdownData = function(){
		$.ajax({
			url: $dataProvider.data('getMarkdownDataUrl'),
			type: "POST",
			dataType: "json",
		})
		.done(function(responseData) {
			console.log(responseData);
			render(responseData.data.markdownData);
		})
		.fail(function() {
			console.log('通信失敗');
		});
	}
	window.setInterval(getMarkdownData, 3000);

});
</script>
<div class="container">
	<div class="row">
		<div class="col-9">
			<div id="markdown-body">
			</div>
		</div>
		<div class="col-3">
			<div id="markdown-pages">
			</div>
		</div>
	</div>
</div>
