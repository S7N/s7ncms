<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php echo form::open('admin/page/edit/'.$page->id) ?>
<div class="box">
	<h3><?php echo __('Page Information') ?></h3>
	<div class="inside">
		<p>
			<?php echo form::label('form[info][type]', __('Redirect page or load Module')) ?>
			<?php echo form::radio('form[info][type]', 'none', empty($page->target))?> <?php echo __('Do nothing') ?><br />
			<?php echo form::radio('form[info][type]', 'module', $page->type === 'module')?> <?php echo __('Load module') ?>:

			<?php
				$select = array('' => __('No Module'));
				foreach ($modules as $module)
					$select[$module->name] = $module->name;

				echo form::dropdown('form[info][module_target]', $select, $page->target);
			?>
			<br />
			<?php echo form::radio('form[info][type]', 'redirect', $page->type === 'redirect')?> <?php echo __('Redirect to') ?>: <?php echo form::dropdown('form[info][redirect_target]', $page->paths(), $page->target) ?>
		</p>

	</div>
</div>
<?php foreach (Kohana::config('locale.languages') as $key => $lang): ?>
<div class="box">
	<h3><?php echo __('Content') ?> <small>(<?php echo $lang['name'] ?>)</small></h3>
	<div class="inside">
		<p><?php echo form::label('form['.$key.'][title]', __('Title')).form::input('form['.$key.'][title]', $form[$key]->title) ?></p>
		<p><?php echo form::label('form['.$key.'][content]', __('Content')).form::textarea('form['.$key.'][content]', $form[$key]->content) ?></p>
	</div>
</div>
<?php endforeach; ?>
<p><?php echo form::submit('submit', __('Save')) ?></p>
<?php echo form::close() ?>
