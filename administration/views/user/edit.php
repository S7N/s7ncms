<h1>User - Edit</h1>
<?php echo form::open('user/edit'); ?>
<?php echo form::hidden('id', $user->id) ?>

<p>Username:<br /><?php echo form::input('username', $user->username); ?></p>
<p>New password:<br /><?php echo form::password('password'); ?></p>
<p>Email:<br /><?php echo form::input('email', $user->email); ?></p>
<p>Homepage:<br /><?php echo form::input('homepage', $user->homepage); ?></p>
<p>First name:<br /><?php echo form::input('first_name', $user->first_name); ?></p>
<p>Last name:<br /><?php echo form::input('last_name', $user->last_name); ?></p>

<p>Roles:<br />
<?php foreach($roles as $role): ?>
<?php echo form::checkbox('roles[]', $role->name, in_array($role->name, $usermodel->roles)); ?>
<?php echo $role->name; ?> (<?php echo $role->description; ?>)<br />
<?php endforeach;?>
</p>

<p><?php echo form::submit('submit', 'Save'); ?></p>
</form>