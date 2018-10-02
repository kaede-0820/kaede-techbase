<DOCTYPE html>
<html lang = "ja">

<head>
<meta charset = "UTF-8">
</head>

<body>

<?php

// データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password);

// テーブルを削除
// $sql = "DROP TABLE mission4";
// $result = $pdo -> query($sql);

// テーブルの作成
$sql = "CREATE TABLE mission4"
." ("
. "id INT NOT NULL AUTO_INCREMENT,"
. "name char(32),"
. "comment TEXT,"
. "time TEXT,"
. "password TEXT,"
. "PRIMARY KEY (id)"
.");";
$stmt = $pdo -> query($sql);

// データの受け取り
$nam = $_POST["名前"];
$com = $_POST["コメント"];
$display = $_POST["表示欄"];
$delete = $_POST["削除"];
$edit = $_POST["編集"];
$pass1 = $_POST["パスワード1"];
$pass2 = $_POST["パスワード2"];
$pass3 = $_POST["パスワード3"];

// データの中身を削除
// $sql = "TRUNCATE TABLE mission4";
// $result = $pdo -> query($sql);

// データの入力
if(!empty($nam) and !empty($com) and empty($display) and !empty($pass1)){
	$sql = $pdo -> prepare("INSERT INTO mission4 (name, comment, time, password) VALUES (:name, :comment, :time, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':time', $time, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$name = $nam;
	$comment = $com;
	$time = date("Y年m月d日H時i分");
	$password = $pass1;
	$sql -> execute();
}

// データの削除
if(!empty($pass2)){
	$sql = 'SELECT * FROM mission4 where id = (select max(id) from mission4)';
	$result = $pdo -> query($sql);
	foreach($result as $row){
		$lastid = $row['id'];
		if($pass2 == $row['password']){
		// 	$sql = 'SELECT password FROM mission4 where id = $delete';
// 			$result = $pdo -> query($sql);
			if($lastid == $delete){
				$sql = "delete from mission4 where id = $delete";
				$result = $pdo -> query($sql);
				$sql = "ALTER TABLE mission4 AUTO_INCREMENT = $delete";
				$result = $pdo -> query($sql);
			}
			else{
				$sql = "delete from mission4 where id = $delete";
				$result = $pdo -> query($sql);
			}
		}
	}
}	

// データの編集
if(!empty($pass3)){
	$sql = "SELECT * FROM mission4 where id = $edit";
	$result = $pdo -> query($sql);
	foreach($result as $row){
		if($pass3 == $row['password']){
			$data1 = $row['name'];
			$data2 = $row['comment'];
			$data3 = $row['id'];
		}
	}
}
if(!empty($display)){
	$sql = $pdo -> prepare("UPDATE mission4 set name = :nm, comment = :kome, time = :tm where id = $display");
	$sql -> bindParam(':nm', $nm, PDO::PARAM_STR);
	$sql -> bindParam(':kome', $kome, PDO::PARAM_STR);
	$sql -> bindParam(':tm', $tm, PDO::PARAM_STR);
	$nm = $nam;
	$kome = $com;
	$tm = date("Y年m月d日H時i分");
	$sql -> execute();
}

?>

<form method = "post" action = "mission_4.php">
<input type = "text" name = "名前" placeholder = "名前" value = "<?php echo $data1; ?>"><br />
<input type = "text" name = "コメント" placeholder = "コメント" value = "<?php echo $data2; ?>"><br />
<input type = "hidden" name = "表示欄" value = "<?php echo $data3; ?>">
<input type = "text" name = "パスワード1" placeholder = "パスワード">
<input type = "submit"><br />
<p>
<input type = "text" name = "削除" placeholder = "削除対象番号"><br />
<input type = "text" name = "パスワード2" placeholder = "パスワード">
<input type = "submit" value = "削除">
</p>
<p>
<input type = "text" name = "編集" placeholder = "編集"><br />
<input type = "text" name = "パスワード3" placeholder = "パスワード">
<input type = "submit" value = "編集">
</p>
</form>

<?php

// データの表示
$sql = 'SELECT * FROM mission4 ORDER BY id ASC';
$results = $pdo -> query($sql);
foreach ($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['time'].'<br>';
}

?>

</body>

</html>