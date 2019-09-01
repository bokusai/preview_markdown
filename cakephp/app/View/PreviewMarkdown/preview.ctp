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
	$(".markdown-page[data-file-name='" + $(".markdown-body:first").data('fileName') + "']").addClass('active');
	$("#file-name").text($(".markdown-body:first").data('fileName'));

	let selectMarkdownBody = function(e){
		$(".markdown-body").each(function(){
			$(this).hide();
		});
		$(".markdown-page").each(function(){
			$(this).removeClass('active');
		});
		let fileName = $(e.target).data('fileName');
		$(".markdown-body[data-file-name='" + fileName + "']").show();
		$(".markdown-page[data-file-name='" + fileName + "']").addClass('active');
		$("#file-name").text(fileName);
		$dataProvider.data('fileName', fileName);

		canPoolingFlag = true;
		update = false;
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
				if(data.update - update > 60){
					canPoolingFlag = false;
					update = false;
					return;
				}
			}
			data.fileName = $dataProvider.data('fileName');
			render(data);
			canPoolingFlag = true;
			console.log('dddd');
		})
		.fail(function() {
			console.log('通信失敗');
			canPoolingFlag = true;
		});
	}
	window.setInterval(getMarkdownData, 3000);

	let reload = function(){
		canPoolingFlag = true;
		update = false;
		getMarkdownData();
	}

	$('.markdown-page').on('click', selectMarkdownBody);
	$('.markdown-page-reload').on('click', reload);
});
</script>

<a href="<?php echo $this->Html->url(['controller' => 'PreviewMarkdown', 'action' => 'index']);?>">一覧へ戻る</a>
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li id="file-name" class="breadcrumb-item active" aria-current="page">file_name.md</li>
		</ol>
	</nav>
	<div class="row">
		<div class="col-9">
			<?php foreach($contentArray as $content): ?>
				<div class="markdown-body" data-file-name="<?php echo h($content['fileName']);?>" style="display: none;">
					<?php echo $content['filePath']; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="position-absolute" style="max-width:400px; margin-left:20px;">
			<button type="button" class="markdown-page-reload btn btn-primary" style="margin-top:40px; margin-left:10px;">リロード</button>
			<div class="card" style="margin-top:25px">
				<div class="card-header">ファイル</div>
				<div id="markdown-page-list" class="list-group">
					<?php foreach($contentArray as $content): ?>
						<button class="markdown-page list-group-item list-group-item-action" data-file-name="<?php echo h($content['fileName']);?>">
							<?php echo h($content['fileName']);?>
						</button>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</div>
