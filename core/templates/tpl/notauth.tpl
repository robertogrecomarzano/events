<!DOCTYPE html>
<html lang="{Config::$defaultLocale|substr:0:2}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{$title}">
<link
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	rel="stylesheet">
<link href="{$siteUrl}/core/templates/css/error.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:100"
	rel="stylesheet" type="text/css">
</head>
<title>{form_lang value="PAGE_NOT_AUTH"}</title>
<body>

	<div class="site-wrapper">

		<div class="site-wrapper-inner">

			<div class="cover-container">

				<div class="inner cover">
					<div class="title">{$title}</div>
					<p class="lead">{form_lang value="PAGE_NOT_AUTH"}</p>
					<p class="lead">
						<a href="{$siteUrl}" class="btn btn-lg btn-default">Home</a>
					</p>
				</div>

			</div>

		</div>

	</div>
</body>

</html>