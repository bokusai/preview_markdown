<div id="markdown-preview-data-provider"
	data-directory="<?php echo h($directory); ?>"
	data-file-name=""
	data-get-markdown-data-url="<?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'getMarkdownData']); ?>"
>
</div>
<script>
jQueryDomReady(function(){
	let canPoolingFlag = true;
	let $dataProvider = $('#markdown-preview-data-provider');
	let update = false;

	$dataProvider.data('fileName', 'clinic_test.md');

	$dataProvider.data('fileName', $(".markdown-body:first").data('fileName'));
	$(".markdown-body[data-file-name='" + $(".markdown-body:first").data('fileName') + "']").show();

	let selectMarkdownBody = function(e){
		$(".markdown-body").each(function(){
			$(this).hide();
		});
		let fileName = $(e.target).data('fileName');
		$(".markdown-body[data-file-name='" + fileName + "']").show();
		$dataProvider.data('fileName', fileName);

		canPoolingFlag = true;
	}

	let render = function(data){
		if(!data){ return false; }
		$(".markdown-body[data-file-name='" + data.fileName + "']").html(data.markdownData);
	}

	let getMarkdownData = function(){
		if(!canPoolingFlag){ return; }
		canPoolingFlag = false;

		let data = {directory: $dataProvider.data('directory'), fileName: $dataProvider.data('fileName')};
		$.ajax({
			url: $dataProvider.data('getMarkdownDataUrl'),
			type: "POST",
			dataType: "json",
			data: data,
		})
		.done(function(responseData) {
			data = responseData.data;
			if(!update){ update = data.update; }
			if(!data.markdownData){
				if(data.update - update > 10){
					canPoolingFlag = false;
					update = false;
					return;
				}
			}
			data.fileName = $dataProvider.data('fileName');
			render(data);
			canPoolingFlag = true;
		})
		.fail(function() {
			console.log('通信失敗');
			canPoolingFlag = true;
		});
	}
	window.setInterval(getMarkdownData, 2000);

	$('.markdown-page').on('click', selectMarkdownBody);
});
</script>
<div class="container">
	<div class="row">
		<div class="col-9">
			<?php foreach($contentArray as $content): ?>
				<div class="markdown-body" data-file-name="<?php echo h($content['fileName']);?>" style="display: none;">
					<?php echo h($content['filePath']); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="col-3">
			<ul id="markdown-page-list">
				<?php foreach($contentArray as $content): ?>
					<li class="markdown-page" data-file-name="<?php echo h($content['fileName']);?>">
						<?php echo h($content['fileName']);?>
					</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
	<a href="<?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'index']);?>">一覧へ戻る</a>
</div>
