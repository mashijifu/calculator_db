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

<form method="post" name="form1" action="link.php">
    <input type="hidden" name="user_name" value="名前">
    <a href="javascript:form1.submit()">リンク名</a>

while( $res = $stmt->fetch( PDO::FETCH_ASSOC ) ){
  $input1 = $res['input1'];
  $input2 = $res['input2'];
  $ope = $res['ope'];
  $result = $res['result'];
  echo "<a href='calcu_db.php?data=<?=$input1, $input2, $ope, $result?>'>" . "{$res['input1']}" . "{$res['ope']}" . "{$res['input2']}" . "=" . "{$res['result']}" . "<br>" . "</a>";
}
</form>

?>
