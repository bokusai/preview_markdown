<div id="markdown-list-data-provider"
	data-set-directory-url = <?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'setDirectory']); ?>
>
</div>
<script>
jQueryDomReady(function(){
	let $dataProvider = $('#markdown-list-data-provider');

	let setDirectoryPath = function(){
		let directory = $('#markdown-directory-input').val().trim();
		let data = {directory: directory};
		$.ajax({
			url: $dataProvider.data('setDirectoryUrl'),
			type: "POST",
			dataType: "json",
			data: data,
		})
		.done(function(responseData) {
			if(responseData.data.success){
				window.location.href = window.location.href;
			}
		})
		.fail(function() {
			console.log('通信失敗');
		});
	}

	$('#markdown-directory-add-btn').on('click', setDirectoryPath);
});
</script>
<div class="container">
	<div class="row">
		<div class="col-11">
			<input type="text" id="markdown-directory-input" class="form-control" placeholder="プレビューするmarkdownのディレクトリを入力">
		</div>
		<div class="col-1">
			<input type="submit" id="markdown-directory-add-btn" class="btn btn-primary" value="追加">
		</div>
	</div>
	<div class="row">
		<div class="col-9">
			<ul id="markdown-project-list">
				<?php foreach($directoryArray as $directory): ?>
					<?php $directory = array_shift($directory); ?>
					<li class="">
						<a href="<?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'preview', 'directory' => $directory]);?>">
							<?php echo h($directory);?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="col-3">
			<div id="">
			</div>
		</div>
	</div>
</div>
