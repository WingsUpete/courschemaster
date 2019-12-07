<!DOCTYPE html>
<html>
<head>
	<title>Migration</title>
</head>
<body>

<h1><?php echo $success ? 'Migration Success<br />Wow, you can really update.' : 'Failed to migrate: WTF?'; ?></h1>

<h1><?php echo $success ? '' : $exception; ?></h1>

</body>
</html>
