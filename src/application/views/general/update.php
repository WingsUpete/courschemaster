<!DOCTYPE html>
<html>
<head>
	<title>Migration</title>

</head>
<script type="text/javascript">
	
	var color_ptr = 0;
	setInterval('changeColor()',20);
	function changeColor(){
		var component = document.getElementById('id1'); 
		var colorArr=['#00FF00','#33FF33','#CCFFCC','#0066FF','#333366', '#6633FF', '#FF0000', '#FFFF00', '#9999FF', '#FF3300']; 
		color_ptr = (color_ptr + 1)% colorArr.length;
		component.style.backgroundColor = colorArr[color_ptr]; 
	}
</script>
<body>
<audio id="id2" src="<?= asset_url('assets/bgm/Freaks.mp3') ?>" controls autoplay loop preload="auto" hidden></audio>

<h1 id="id1"><?php echo $success ? 'Migration Success<br />Wow, you can really update.&ensp;<a href="' . site_url('') . '" style="text-decoration:none;color:#fff;background-color: purple;padding:20px;">back to home page</a>' : 'Failed to migrate: WTF?'; ?></h1>

<h1><?php echo $success ? '' : $exception; ?></h1>

</body>
</html>
