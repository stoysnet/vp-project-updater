<?
require "includes/antTargetIterator.php";

function xWide($x, $g) {
	while ($g->valid()) {
		echo '<div class="row">';
		$c = $x;
		while ($c > 0 && $g->valid()) {
			$k = $g->key();
			$v = $g->current();
			echo '<div class="col-md-' . intval(12 / $x) . '">';
			$c -= 1;
			yield $k => $v;
			$g->next();
			echo '</div>';
		}
		echo '</div>';
	}
}

$buildFile = __DIR__ . '/../viper/build.xml';

$targets = antTargetIterator($buildFile);
$threeWide = xWide(6, $targets);
$buttons = antGetButtons($buildFile);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Simple Project Updater/Builder</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style>
			body .container{
				text-align:center;
			}
			a.btn{
				margin-top:20px
			}
			body.loading:after{
				content: 'running task';
				width:100%;
				height:100%;
				top:0;
				left:0;
				color:#000;
				text-align:center;
				font-size:72px;
				font-weight:bold;
				font-style:italic;
				box-sizing:border-box;
				padding-top:25%;
				line-height:0;
				display:inline-block;
				position:fixed;
				background-color: rgba(255, 255, 255, 0.9);
			}
			#output .modal-dialog{
				width: 800px;
			}
			#output .modal-dialog .modal-body pre{
				white-space:pre;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<h1>Simple Project Updater/Builder</h1>
			<div class="btn-group">
				<a href="../" class="btn btn-info"><span class="glyphicon glyphicon-circle-arrow-up"></span></a>
				<?
				$colors = ['primary', 'success', 'warning', 'danger'];
				$x = 0;
				foreach ($buttons as $label => $url) {
					$t = $colors[$x % count($colors)];
					$x += 1;
					echo '<a href="',
						htmlspecialchars($url),
						'" class="btn btn-', $t, '">',
						htmlspecialchars($label),
						'</a>';
				}
				?>
			</div>
		<?
		$x = 0; 
		foreach ($threeWide as $name => $desc) {
			//echo '<div>', $desc, '</div>', "\n";
			echo '<a href="#', htmlspecialchars($name), '" class="btn btn-default" ',
				' data-toggle="tooltip" ',
				'title="', htmlspecialchars($desc), '"',
				'>',
				htmlspecialchars($name),
				'</a>',
				"\n";
		}
		?>
		</div>
		<!-- Modal -->
		<div id="output" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Task results (<span id="taskname"></span>)</h4>
			  </div>
			  <div class="modal-body">
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/underscore-min.js"></script>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/app.js"></script>
	</body>
</html>
