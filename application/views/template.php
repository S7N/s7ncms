<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>My Website</title>
    <?php echo html::stylesheet('media/css/layout') ?>
</head>

<body>
    <div id="header">
        <h1>My Website</h1>
    </div>

    <div id="content">
        <div id="left">
            <div id="menu">
                <ul>
                    <li><?php echo html::anchor('home', 'Home') ?></li>
                    <li><?php echo html::anchor('products', 'Products') ?></li>
                    <li><?php echo html::anchor('blog', 'Blog') ?></li>
                    <li><?php echo html::anchor('about-me', 'About Me') ?></li>
                    <li><?php echo html::anchor('contact-me', 'Contact Me') ?></li>
                </ul>
            </div>

            <div class="left_column">
                <h1>Lorem Ipsum</h1>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore</p>
                <p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            </div>
        </div>

        <div id="right">
            <?php echo $content; ?>
        </div>

        <div style="clear: both;">&nbsp;</div>
    </div>

    <div id="footer">
        <p>powered by <a href="http://www.s7n.de">S7Ncms</a></p>
    </div>
</body>
</html>
