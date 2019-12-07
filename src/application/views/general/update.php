<!DOCTYPE html>
<html>
<head>
	<title>Migration</title>
</head>
<body>

<h1><?php echo $success ? 'Migration Success<br />Wow, you can really update.&ensp;<a href="' . site_url('') . '" style="text-decoration:none;color:#fff;background-color: purple;padding:20px;">back to home page</a>' : 'Failed to migrate: WTF?'; ?></h1>

<h1><?php echo $success ? '' : $exception; ?></h1>

</body>
</html>
