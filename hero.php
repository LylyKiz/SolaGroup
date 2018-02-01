<? global $db;
require_once("function.php")
?>
<div id="hero_zag">МОЯ СУПЕР КОМАНДА</div>
<hr size=3px width=100px align="center" color="#e8aa4e">
<hr size=3px width=50px align="center" color="#ae8342">
<div class="tablica">
	<?
	$col     = $db -> getOne("SELECT COUNT(*) FROM hero");
	$kol     = 4;  //количество записей для вывода
	$str_pag = ceil($col / $kol);
	?>
	<div id="slideshow-wrap">
		<?php
		for ($i = 1; $i <= $str_pag; $i++) {
			print '<input type="radio" id="button-'.$i.'" name="controls"';
			if ($i == 1) {
				print 'checked="checked"';
			}
			print 'navigation="'.$i.'"/>
					<label for="button-'.$i.'"></label>';
		}
		for ($j = 1; $j <= $str_pag; $j++) {
			print '<label for="button-'.$j.'" class="arrows" id="arrow-'.$j.'">></label>';
		}
		?>
		<div id="slideshow-inner">
			<ul>
				<?php
				$m       = $kol + 1;
				$k       = 1;
				$kolproh = 0;
				$result  = $db -> query("SELECT * FROM hero");
				while ($row = $db -> fetch($result)) {
					if ($m > $kol) {
						print '<li id="slide'.$k.'">';
					}
					?>
					<div class="yacheika">
						<figure>
							<img src='/upload/<?= $row['foto']; ?>' style="width:100px;">
							<figcaption class="name_hero"><?= $row['name']; ?></figcaption>
							<figcaption class="title_hero"><?= $row['title']; ?></figcaption>
							<figcaption class="data_hero">Дата вступления в команду:</figcaption>
							<figcaption class="data_hero"><?= date('d.m.Y', strtotime($row['date'])); ?></figcaption>
						</figure>
					</div>
					<?
					$kolproh++;
					if ($kolproh == $kol) {
						print '</li>';
						$k++;
						$m       = $kol + 1;
						$kolproh = 0;
					}
					else {
						$m = 1;
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>


