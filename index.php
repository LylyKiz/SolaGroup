<?
include("function.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="css/bootstrap.min.css" >
</head>
<body>
<button type="button" id="dan" class="btn btn-success">Сформировать данные</button>
<button type="button" id="bd" class="btn btn-primary">Добавить в бд</button>
<table class="table">
	<thead>
	<tr>
		<th>#</th>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>Дата рождения</th>
		<th>Счет</th>
		<th>Сумма</th>
	</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<nav aria-label="Page navigation example">
	<ul class="pagination">
	</ul>
</nav>';
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/myjs.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>