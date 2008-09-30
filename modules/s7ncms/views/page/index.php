<script type="text/javascript">
	$(document).ready(function(){

	$("ul.sortable").tree({
		sortOn: "li",
		dropOn: ".folder",
		dropHoverClass: "hover",
		handle: ".movehandle"
	});
	
	$('#save_sort').click(function(){
		$.post('<?php echo url::site('admin/page/save_tree') ?>', '&tree='+$("ul.sortable").tree('serialize'), function(data, status) {
			window.location.reload();
			//console.log(data);
			//console.log(status);
		});
		
		
	});

	});
</script>

<?php
function create_list() {}
?>

<ul class="sortable">
<?php if($pages) foreach($pages as $page): ?>
	<li id="page-<?php echo $page->id ?>">
		<div class="folder">
		    <div style="float: left;">
		    <span class="movehandle">[Move]</span>
		    <?php echo html::anchor('admin/page/edit/'.$page->id, '<span>'.$page->title.'</span>'); ?>
		    </div>
		    <div style="position:absolute;right:30px;">(<strong>Last updated:</strong> <?php echo $page->modified; ?>)</div>
		    <div class="deleter" style="position:absolute;right:10px;">
		    <?php echo html::anchor('admin/page/delete/'.$page->id, html::image(
				'media/admin/images/delete.png',	
				array(
					'alt' => 'Delete Page',
					'title' => 'Delete Page'
					)
				));
			?>
		    </div>
		</div>
	</li>
<?php endforeach ?>
</ul>

<button id="save_sort">Save Changes</button>