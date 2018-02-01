<?php
global $db;
require_once("function.php");

$action       = $_POST['action'];
$dan['name']  = $_POST['name'];
$dan['title'] = $_POST['title'];
$dan['date'] = date("Y-m-d");


if ($action === 'add') {


	if (!empty($dan['name']) && !empty($dan['title'])) {
		$db -> query("INSERT INTO hero SET ?u", $dan);

	}
}
?>
<div id="form_zag">ДОБАВИТЬ СВОЕГО <b>ГЕРОЯ</b></div>
<hr size=3px width=100px align="center" color="#e8aa4e">
<hr size=3px width=50px align="center" color="#ae8342">
<div class="wrapper">
	<form action="javascript:void(null);" onsubmit="authAjax()" method="post">
		<div class="tab">
			<div class="yacheika">
				Имя<span class="red_star">*</span><br>
				<input id="name" name="name" style="width:100%">

			</div>
			<div class="yacheika">
				Титул<span class="red_star">*</span><br>
				<input id="title" name="title" style="width:100%">
			</div>
		</div>


		<!--Фото<span class="red_star">*</span>-->

		<!--<div id="content">
			<div id="drop-zone">
				<span class="text">Нажмите сюда или перетащите файл для загрузки.</span>
				<input id="file" type="file">
			</div>
			<div id="showUpFile">
			</div>
		</div>-->

		<!--<div class="dropzone" id="dropzone">Перетащите файлы сюда</div>
-->
		<div style="text-align: right;"><input id="submit" type="submit" value="Принять" style="width:135px"></div>


	</form>
</div>

<script src="js/jquery-1.4.2.min.js"></script>
<script>
	function authAjax() {

		//Инициализируем переменные для удобного доступа к input полям
		var name = $("#name");
		var title = $("#title");

		//Инициализируем новые переменные и выдергиваем введеные данные в input поля
		var val1 = name.val();
		var val2 = title.val();

		//Если данные пустые, то добавляем класс error
		//Кликнув по input полю, класс error удаляется
		//Если данные не пустые, то удаляем класс error
		if (val1 === "") {
			name.addClass("error");
			name.click(function () {
				name.removeClass("error");
			});
		} else {
			name.removeClass("error");
		}

		//Если данные пустые, то добавляем класс error
		//Кликнув по input полю, класс error удаляется
		//Если данные не пустые, то удаляем класс error
		if (val2 === "") {
			title.addClass("error");
			title.click(function () {
				title.removeClass("error");
			});
		} else {
			title.removeClass("error");
		}


		//Если данные в двух input полях не пустые, то делаем ajax запрос
		if (val1 !== "" && val2 !== "") {
			$.ajax({
				url: 'form.php',
				data: 'action=add&name=' + val1 + '&title=' + val2,
				type: 'POST',
				success: function () {
					$('#hero').load('hero.php');
					$('#form').load('form.php');
					//$('ul').html(append);
					//location.reload('hero.php');
					//window.location = 'hero.php';

					//$("ul").append("<li><span class='span'>" + 1 + "</span><p>" + 2 + "</p></li><hr>");
					//alert(data + ', Добро пожаловать!');
				},
				error: function () {
					alert('ошибка');
				}
			});
		}

	}


	var dropZone = document.getElementById("drop-zone");
	var msgConteiner = document.querySelector("#drop-zone .text");

	var eventClear = function (e) {
		e.stopPropagation();
		e.preventDefault();
	}

	dropZone.addEventListener("dragenter", eventClear, false);
	dropZone.addEventListener("dragover", eventClear, false);

	dropZone.addEventListener("drop", function (e) {
		if (!e.dataTransfer.files) return;
		e.stopPropagation();
		e.preventDefault();

		sendFile(e.dataTransfer.files[0]);
	}, false);

	document.getElementById("file").addEventListener("change", function (e) {
		sendFile(e.target.files[0]);
	}, false);


	var statChange = function (e) {
		if (e.target.readyState == 4) {
			if (e.target.status == 200) {
				msgConteiner.innerHTML = "Загрузка успешно завершена!";
				dropZone.classList.remove("error");
				dropZone.classList.add("success");

				document.getElementById("showUpFile").innerHTML = this.responseText;
			} else {
				msgConteiner.innerHTML = "Произошла ошибка!";
				dropZone.classList.remove("success");
				dropZone.classList.add("error");
			}
		}
	};

	var showProgress = function (e) {
		if (e.lengthComputable) {
			var percent = Math.floor((e.loaded / e.total) * 100);
			msgConteiner.innerHTML = "Загрузка... (" + percent + "%)";
		}
	};

	var sendFile = function (file) {
		dropZone.classList.remove("success");
		dropZone.classList.remove("error");

		var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
		if (!re.exec(file.name)) {
			msgConteiner.innerHTML = "Недопустимый формат файла!";
			dropZone.classList.remove("success");
			dropZone.classList.add("error");
		}
		else {
			var fd = new FormData();
			fd.append("upfile", file);

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "./upload.php", true);

			xhr.upload.onprogress = showProgress;
			xhr.onreadystatechange = statChange;

			xhr.send(fd);
		}
	}


	(function () {
		var dropzone = document.getElementById("dropzone");

		dropzone.ondrop = function (e) {
			this.className = 'dropzone';
			this.innerHTML = 'Перетащите файлы сюда';
			e.preventDefault();
			upload(e.dataTransfer.files);
		};

		var displayUploads = function (data) {
			var uploads = document.getElementById("uploads"),
				anchor,
				x;

			for (x = 0; x < data.length; x++) {
				anchor = document.createElement('li');
				anchor.innerHTML = data[x].name;
				uploads.appendChild(anchor);
			}
		};

		var upload = function (files) {
			var formData = new FormData(),
				xhr = new XMLHttpRequest(),
				x;

			for (x = 0; x < files.length; x++) {
				formData.append('file[]', files[x]);
			}

			xhr.onload = function () {
				var data = JSON.parse(this.responseText);
				displayUploads(data);
			};

			xhr.open('post', 'upload.php');
			xhr.send(formData);
		};

		dropzone.ondragover = function () {
			this.className = 'dropzone dragover';
			this.innerHTML = 'Отпустите мышку';
			return false;
		};

		dropzone.ondragleave = function () {
			this.className = 'dropzone';
			this.innerHTML = 'Перетащите файлы сюда';
			return false;
		};

	}());
</script>