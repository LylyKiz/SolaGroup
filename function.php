<?
$db ="SolaGroup";
$user="root";
$pass="";

include 'js/safemysql.class.php';
$db = new SafeMysql(array('user' => $user, 'pass' => $pass,'db' => $db, 'charset' => 'utf8'));

$action       = $_REQUEST['action'];
$page = isset($_REQUEST['pag']) ? (int)$_REQUEST['pag'] : 1;


class User
{
	public $db;


	//private $data;
	private $data = array();
	private $table  = "user";


	private $f_write=false;
	public function __set($name, $value) {
		$this->data[$name] = $value;
		$this->f_write=true; // признак, что нужно сохранить данные
	}

	public function __get($name) {
		if(empty($data)){
			// читаем запись из БД в data
		}
		return $this->data[$name];
	}
	function __destruct()
	{
		if(!empty($data)&&$this->f_write){
			global $db;
			$db->query("INSERT INTO ?n SET ?u", $this->table, $this->data);
			// сохраняем изменения в БД
		}
	}
	public function insert($data, $table) {
		global $db;
		$db->query("INSERT INTO ?n SET ?u", $table, $data);
		return mysql_insert_id();
	}
}
$user=new User();
//$user->site='http://kdg.htmlweb.ru/';        //присваеваем переменной
//echo $user->site;        //выводим значение переменной
// записываем в БД. Можно это явно не делать, т.к. при окончании работы скрипта это поизойдет автоматически
//unset($user);

if ($action == 'add') {

	$json2 = file_get_contents('dan/array-2.json');
	$json2 = json_decode($json2);
	$json2=$json2[5];

	$json = file_get_contents('dan/array-1.json');
	$json = json_decode($json);
	foreach($json as $key => $value) {
		$dan['Name']       = "Василий".$key;
		$dan['Surname']    = "Пупкин".($key+6);
		$dan['Patronymic'] = "Александрович".$value;

		$date = date("Y-m-d");
		$date = strtotime($date);
		$date = date('Y-m-d', strtotime("-".$key." days -21 years ", $date));
		//echo date('Y-m-d', $date);
		$dan['Birthdate']  = $date;
		$dan['Expense']    = 1; //$_POST['title']; mysql_insert_id()
		$dan['Sum']        = $value+$json2;
	}
	$user->insert($dan, "user");




			//$db -> query("INSERT INTO user SET ?u", $dan);
	//$this->db->truncate('login_history');


}

if ($action == 'dan') {

	function array_fill_rand($limit, $min=false, $max=false)
	{
		$limit = (int)$limit;
		$array = array();

		if ($min !== false && $max !== false)
		{
			$min = (int)$min;
			$max = (int)$max;
			for ($i=0; $i<$limit; $i++){
				$array[$i] = rand($min, $max);
			}
		}

		return $array;
	}
	$rand_array = array_fill_rand(100, 0, 5685);
	file_put_contents('dan/array-1.json',json_encode($rand_array));
	$num = 0;
	foreach($rand_array as $value){
		if(($num % 2 == 0) || ($num % 4 == 0)){
			$znach=($value-23)*2;
			if($znach>=2450 && $znach< 4031){
				$array2[]=$znach;
			}
		}
		$num ++;
	}
	file_put_contents('dan/array-2.json',json_encode($array2));

}

if ($action == 'page') {

	//print_r($_POST);
	$col     = $db -> getOne("SELECT COUNT(*) FROM user");
	$kol     = 8;  //количество записей для вывода
	$str_pag = ceil($col / $kol);
	$result  = $db -> query("SELECT * FROM user limit ".$page.", ".$kol);
	$i       = 1;
	while ($row = $db -> fetch($result)) {
		$rez[] = array(
			'np'         => $i,
			'Surname'    => $row['Surname'],
			'Name'       => $row['Name'],
			'Patronymic' => $row['Patronymic'],
			'Birthdate'  => $row['Birthdate'],
			'Expense'    => $row['Expense'],
			'Sum'        => $row['Sum']
		);
		$i++;
	};
	$rez3=array(
		'us'=>$rez,
	    'kol'=>$str_pag
	);

	//print_r($rez);
	echo json_encode($rez3);
	//exit();
}