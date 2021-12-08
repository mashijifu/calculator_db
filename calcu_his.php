<?php

$dsn = 'mysql:host=localhost;unix_socket=/tmp/mysql.sock;dbname=calculator;charset=utf8';
$user = 'root';
$pass = '';

try{
   // PDOインスタンスを生成
  $pdo = new PDO($dsn, $user, $password,[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false,
            ]);

}catch( PDOException $error ){
  // エラーメッセージを表示させる
  echo 'データベースにアクセスできません！' . $e->getMessage();

  // 終了
  die();

}

$sql = 'select input1, input2, ope, result from calcu_db';
$stmt = $pdo->query( $sql );

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>calcu_his</title>
</head>
<body>
  <?php
    foreach ($stmt->fetchAll() as $row) {
      $num = 0;
  ?>
      <form method="post" name="form1" action="./calcu_db.php">
        <input type="hidden" name="input1" value="<?php echo $row['input1']; ?>">
        <input type="hidden" name="ope" value="<?php echo $row['ope']; ?>">
        <input type="hidden" name="input2" value="<?php echo $row['input2']; ?>">
        <input type="hidden" name="result" value="<?php echo $row['result']; ?>">
        <!-- <input type="hidden" name="flag_his" value="1"> -->
        <!-- echo '<input type="hidden" name="num" value="$num">'; -->
        <!-- <a href='calcu_db.php' onclick='document.form1.submit(); return false;'><?php echo "$row[input1]" . "$row[ope]" . "$row[input2]" . "=" . "$row[result]" ?></a> -->
        <input type="submit" class="btn btn-mid" value="<?php echo $row['input1'] . $row['ope'] . $row['input2'] . '=' . $row['result'] ?>">
      </form>
  <?php
    }
  ?>
</body>
</html>
