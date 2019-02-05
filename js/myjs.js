window.onload = function () {

		$.ajax({
			url: '../function.php', // путь к одработчику (прописать свой)
			data: "action=page&pag=1", // передаваемые параметры в обработчик
			type: 'POST', // или GET - метод передачи данных
			dataType: 'json', // тип данных в ожидаемом ответе
			success: function (data) {
				//data = JSON.parse(data);
				//console.log(data.us);
				var table = "";
				for (i = 0; i < data.us.length; i++) {
					table += '<tr>';
					table += '<th scope="row">' + data.us[i].np + '</th>';
					table += '<td>' + data.us[i].Surname + '</td>';
					table += '<td>' + data.us[i].Name + '</td>';
					table += '<td>' + data.us[i].Patronymic + '</td>';
					table += '<td>' + data.us[i].Birthdate + '</td>';
					table += '<td>' + data.us[i].Expense + '</td>';
					table += '<td>' + data.us[i].Sum + '</td>';
					table += '</tr>';

				}
				$('tbody').append(table);//console.log($table);

				var pag = "";
				for (f = 1; f <= data.kol; f++) {
					pag += '<li class="page-item"><a class="page-link" href="#">' + f + '</a></li>';
				}
				//console.log(pag);
				$('.pagination').append(pag);//console.log($table);

			},
			error: function () {
				alert('ошибка');
			}
		});



		$("#bd").click(function () {
				// берем нужные данные для передачи в обработчик
		// предположим, что эти данные в атрибуте rel


		$.ajax({
			url: '../function.php', // путь к одработчику (прописать свой)
			data: "action=add", // передаваемые параметры в обработчик
			type: 'POST', // или GET - метод передачи данных
			dataType: 'html', // тип данных в ожидаемом ответе
			success: function (data) {
				// на самом деле, в data находится именно ваш ожидаемы ответ
				// от обработчика, но т.к. мы тут реальный ответ
				// использовать не можем, то используем ответ
				// созданный вручную - переменная ajaxResponse
				//console.log(data);
			}
		});
	});

	$("#dan").click(function () {
		$.ajax({
			url: '../function.php',
			data: "action=dan",
			type: 'POST',
			dataType: 'html',
			success: function (data) {
				//console.log(data);
			}
		});
	});


};