<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <?php
	    	assets::script('jquery', theme::url('scripts/jquery/jquery-1.3.2.min.js'));
	    	assets::script('form', theme::url('scripts/jquery.forms.js'));
		?>
        <?php
        	assets::stylesheet(theme::url('styles/reset.css'));
        	assets::stylesheet(theme::url('styles/text.css'));
        	assets::stylesheet(theme::url('styles/960.css'));
        	assets::stylesheet(theme::url('styles/navigation.css'));
        	assets::stylesheet(theme::url('styles/layout.css'));
        ?>
        <?php echo assets::render() ?>
        <title>Welcome to S7N!</title>
    </head>
    <body>
        <div id="wrapper">
        	<div class="top"><?php echo Menu::breadcrumb(); ?></div>
            <div class="container_12">
                <div class="grid_12 header">
                	<div class="grid_4 omega">
                    	Logo
                    </div>
                    <div class="grid_8 alpha tabs">
                    	<?php echo new Menu('main', TRUE) ?>
                    </div>
                    <div class="clear"> </div>
                </div>
                <div class="grid_12 content">
                    <div class="grid_6 alpha top_left corner"></div>
                    <div class="grid_6 omega top_right corner"></div>
                    <div class="clear"> </div>
                	<div class="grid_12">
                    	<img src="/cms/themes/default/images/content/banner.png" alt="Welcome to S7N!" />
                    </div>
                    <div class="grid_3 omega">
                    	<div class="block">
                        	<div class="title">
                            	<h6>Block Title<h6>
                            </div>
                            <div class="body">
                            	Block Body
                            </div>
                        </div>
                        <div class="block">
                        	<div class="title">
                            	<h6>Block Title<h6>
                            </div>
                            <div class="body">
                            	Block Body
                            </div>
                        </div>
                    </div>
                    <div class="grid_9 alpha">
                    <h1><?php echo $title ?></h1>
                    <?php echo $content ?>
                    </div>
                    <div class="clear"> </div>
                    <div class="grid_6 alpha bottom_left corner"></div>
                    <div class="grid_6 omega bottom_right corner"></div>
                </div>
                <div class="clear"> </div>
                <div class="container_12">
                	<div class="grid_12 footer">
                    	I AM THE FOOTER
                    </div>
                </div>
                <div class="clear"> </div>
            </div>
        </div>
    </body>
</html>
