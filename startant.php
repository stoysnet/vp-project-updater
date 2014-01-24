<?
$lockFile = sys_get_temp_dir() . '/build.lock';

if (file_exists($lockFile)) {
	echo <<<LOCK
Only one build tool can be operated at a time.
------------------------------------------------------------------------------
If you are receiving this message in error, please reboot the virtual machine.
LOCK;
	return;
} else {
	touch($lockFile);
	register_shutdown_function(function () use ($lockFile) {
		unlink($lockFile);
	});
}

require "includes/antTargetIterator.php";
ini_set('output_buffering', 'OFF');
ini_set('implicit_flush', 'OFF');

set_time_limit(0);
ignore_user_abort("TRUE");

foreach (antTargetIterator(__DIR__ . '/../viper/build.xml') as $target => $desc) {
	if ($_GET['task'] === $target) {
		header('Content-Type: text/plain');
		chdir(__DIR__ . '/../viper/');
		passthru('ant ' . escapeshellarg($target));
		break;
	}
}

