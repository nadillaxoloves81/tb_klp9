<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Haha</title>
	<style>
		.hik {
			background-color: white;
		}

		.hiks {
			background-color: black;
			color: white;
		}
	</style>
</head>
<body>
	<table style="border: 1px solid black;" cellspacing="0" cellpadding="20" width="100%" height="100%">
		<?php for($i = 1; $i <= 4; $i++) : ?>
			<tr class="haha">
				<?php for($j = 1; $j <= 4; $j++) : ?>
					<td class="hik">Jungkook</td>
					<td class="hiks">Nadilla</td>
				<?php endfor; ?>
			</tr>
			<tr>
				<?php for($j = 1; $j <= 4; $j++) : ?>
					<td class="hiks">Nadilla</td>
					<td class="hik">Jungkook</td>
				<?php endfor; ?>
			</tr>
		<?php endfor; ?>
	</table>
	
</body>
</html>