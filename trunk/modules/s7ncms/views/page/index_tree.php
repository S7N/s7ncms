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

<ul class="sortable">
<?php
$level = 0;

foreach ($pages as $node):
	$has_children = (($node->rgt - $node->lft - 1) > 0 );
	$id = 'page-'.$node->id;
	
	$value = View::factory('page/index_tree_value')->set(array('page' => $node))->render();
	
	if($has_children) {
		if($level > $node->level) {
			echo str_repeat("</ul></li>\n",($level - $node->level));
			echo '<li id="'.$id.'">'.$value."\n";
			echo '<ul>'."\n";
		} else {
			echo '<li id="'.$id.'">'.$value."\n";
			echo '<ul>'."\n";
		}
	} elseif ($level > $node->level) {
		echo str_repeat("</ul></li>\n",($level - $node->level));
		echo '<li id="'.$id.'">'.$value.'</li>'."\n";
	} else {
		echo '<li id="'.$id.'">'.$value.'</li>'."\n";
	}
	$level = $node->level;
endforeach;
echo str_repeat("</ul></li>\n",$level-1);
?>
</ul>

<p>
<button id="save_sort">Save Changes</button>
</p>