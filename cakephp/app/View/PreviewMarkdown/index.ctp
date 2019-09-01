<div id="markdown-preview-data-provider"
	data-get-markdown-data-url = <?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'getMarkdownData']); ?>
	data-set-directory-path-url = <?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'setDirectoryPath']); ?>
>
</div>
<script>
jQueryDomReady(function(){
	let canPoolingFlag = true;
	let $dataProvider = $('#markdown-preview-data-provider');

	let render = function(data){
		if(!data){ return false; }
		$('#markdown-body').html(data);
	}

	let getMarkdownData = function(){
		if(!canPoolingFlag){ return; }
		canPoolingFlag = false;
		$.ajax({
			url: $dataProvider.data('getMarkdownDataUrl'),
			type: "POST",
			dataType: "json",
		})
		.done(function(responseData) {
			render(responseData.data.markdownData);
		})
		.fail(function() {
			console.log('通信失敗');
		})
		.always(function(){
			canPoolingFlag = true;
		});
	}
	//window.setInterval(getMarkdownData, 3000);

	let setDirectoryPath = function(){
		data = {directoryPath: $('#markdown-directory-path-input').val().trim()};
		$.ajax({
			url: $dataProvider.data('setDirectoryPathUrl'),
			type: "POST",
			dataType: "json",
			data: data,
		})
		.done(function(responseData) {
			console.log(responseData);
		})
		.fail(function() {
			console.log('通信失敗');
		});
	}

	$('#markdown-directory-path-add-btn').on('click', setDirectoryPath);
});
</script>
<div class="container">
	<div class="row">
		<div class="col-11">
			<input type="text" id="markdown-directory-path-input" class="form-control" placeholder="プレビューするmarkdownのパスを入力">
		</div>
		<div class="col-1">
			<input type="submit" id="markdown-directory-path-add-btn" class="btn btn-primary" value="追加">
		</div>
	</div>
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
