
<style type="text/css">
body { width: 42em; margin: 0 auto; font-family: sans-serif; font-size: 90%; }

#tests table { border-collapse: collapse; width: 100%; }
	#tests table th,
	#tests table td { padding: 0.2em 0.4em; text-align: left; vertical-align: top; }
	#tests table th { width: 12em; font-weight: normal; font-size: 1.2em; }
	#tests table tr:nth-child(odd) { background: #eee; }
	#tests table td.pass { color: #191; }
	#tests table td.fail { color: #911; }
		#tests #results { color: #fff; }
		#tests #results p { padding: 0.8em 0.4em; }
		#tests #results p.pass { background: #191; }
		#tests #results p.fail { background: #911; }
</style>

<h1>Environment Tests</h1>

<p>The following tests have been run to determine if Kohana will work in your environment. If any of the tests have failed, consult the <a href="http://docs.kohanaphp.com/installation">documentation</a> for more information on how to correct the problem.</p>

<div id="tests">

<table cellspacing="0">

	<tr>
		<th>PHP Version</th>
		<?php if ($php_version): ?>
		<td class="pass"><?php echo PHP_VERSION ?></td>
		<?php else: ?>
		<td class="fail">Kohana requires PHP 5.2 or newer, this version is <?php echo PHP_VERSION ?>.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>System Directory</th>
		<?php if ($system_directory): ?>
		<td class="pass"><?php echo SYSPATH ?></td>
		<?php else: ?>
		<td class="fail">The configured <code>system</code> directory does not exist or does not contain required files.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>Application Directory</th>
		<?php if ($application_directory): ?>
		<td class="pass"><?php echo APPPATH ?></td>
		<?php else: ?>
		<td class="fail">The configured <code>application</code> directory does not exist or does not contain required files.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>Modules Directory</th>
		<?php if ($modules_directory): ?>
		<td class="pass"><?php echo MODPATH ?></td>
		<?php else: ?>
		<td class="fail">The configured <code>modules</code> directory does not exist or does not contain required files.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>PCRE UTF-8</th>
		<?php if ( $pcre_utf8): ?>
		<td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with UTF-8 support.</td>
		<?php elseif ( $pcre_unicode ): ?>
		<td class="fail"><a href="http://php.net/pcre">PCRE</a> has not been compiled with Unicode property support.</td>
		<?php else: ?>
		<td class="pass">Pass</td>
		<?php endif ?>
	</tr>
	
	<tr>
		<th>Reflection Enabled</th>
		<?php if ($reflection_enabled): ?>
		<td class="pass">Pass</td>
		<?php else: ?>
		<td class="fail">PHP <a href="http://www.php.net/reflection">reflection</a> is either not loaded or not compiled in.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>Filters Enabled</th>
		<?php if ($filters_enabled): ?>
		<td class="pass">Pass</td>
		<?php else: ?>
		<td class="fail">The <a href="http://www.php.net/filter">filter</a> extension is either not loaded or not compiled in.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>Iconv Extension Loaded</th>
		<?php if ($iconv_loaded): ?>
		<td class="pass">Pass</td>
		<?php else: ?>
		<td class="fail">The <a href="http://php.net/iconv">iconv</a> extension is not loaded.</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>Mbstring Not Overloaded</th>
		<?php if ($mbstring): ?>
		<td class="fail">The <a href="http://php.net/mbstring">mbstring</a> extension is overloading PHP's native string functions.</td>
		<?php else: ?>
		<td class="pass">Pass</td>
		<?php endif ?>
	</tr>

	<tr>
		<th>URI Determination</th>
		<?php if ($uri_determination): ?>
		<td class="pass">Pass</td>
		<?php else: ?>
		<td class="fail">Neither <code>$_SERVER['REQUEST_URI']</code> or <code>$_SERVER['PHP_SELF']</code> is available.</td>
		<?php endif ?>
	</tr>

</table>



<div id="results">
	<?php if ($failed === TRUE): ?>
	<p class="fail">Kohana may not work correctly with your environment.</p>
	<?php else: ?>
	<p class="pass">Your environment passed all requirements. Remove or rename the <code>install<?php echo EXT ?></code> file now.</p>
	<?php endif ?>
</div>

</div>

</body>
</html>
