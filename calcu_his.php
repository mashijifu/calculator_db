<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

$dsn = 'mysql:host=localhost;unix_socket=/tmp/mysql.sock;dbname=calculator;charset=utf8';
$user = 'root';
$pass = '';
$sea_ope = $_POST['operator'];
$sea_ran = $_POST['range'];
$sea_num = (int)$_POST['search_num'];

try{
   // PDOインスタンスを生成
  $pdo = new PDO($dsn, $user, $pass,[
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
  <h1>検索</h1>
  <form action="calcu_his.php" method="post">
      演算子
      <select name="operator" id="" value="<?php echo $sea_ope ?>">
        <option value="">--演算子を選んでください--</option>
        <option value="＋">＋</option>
        <option value="−">−</option>
        <option value="✕">✕</option>
        <option value="÷">÷</option>
      </select>
      <br>
      計算結果値の範囲
      <input type="text" name="search_num" placeholder="数値を入力" value="<?php echo $sea_num ?>">
      <select name="range" id="" value="<?php echo $sea_ran ?>">
        <option value="">--範囲を選んでください--</option>
        <option value=">=">以上</option>
        <option value="<=">以下</option>
        <option value="=">同じ</option>
      </select>
      <br>
      <input type="submit" value="検索">
  </form>
  <hr>
  <div>
    <h2>検索結果</h2>
    <?php
      if($sea_ope != "" || ($sea_ran != "" && isset($sea_num))) {
        if($sea_ope != "" && $sea_ran != "" && isset($sea_num)) {
          $sqlsearch = $pdo->prepare("SELECT * FROM calcu_db WHERE ope LIKE :sea_ope AND result $sea_ran $sea_num ");
          $sqlsearch->bindValue(':sea_ope', '%'.$sea_ope.'%', PDO::PARAM_STR);
        } elseif($sea_ope != "") {
          $sqlsearch = $pdo->prepare("SELECT * FROM calcu_db WHERE ope LIKE :sea_ope");
          $sqlsearch->bindValue(':sea_ope', '%'.$sea_ope.'%', PDO::PARAM_STR);
          // echo "hello2";
        } else {
          $sqlsearch = $pdo->prepare("SELECT * FROM calcu_db WHERE result $sea_ran $sea_num ");
        }
        $sqlsearch->execute();
        // ここでPHPのforeachを使って結果をループさせる
        foreach ($sqlsearch->fetchAll() as $search_result) {
    ?>
          <form method="post" name="form1" action="./calcu_db.php">
            <input type="hidden" name="input1" value="<?php echo $search_result['input1']; ?>">
            <input type="hidden" name="ope" value="<?php echo $search_result['ope']; ?>">
            <input type="hidden" name="input2" value="<?php echo $search_result['input2']; ?>">
            <input type="hidden" name="result" value="<?php echo $search_result['result']; ?>">

            <input type="submit" class="btn btn-mid" value="<?php echo $search_result['input1'] . $search_result['ope'] . $search_result['input2'] . '=' . $search_result['result'] ?>">
          </form>
    <?php
        }
      }
    ?>
  </div>
  <hr>
  <h2>計算履歴</h2>
  <?php
    foreach ($stmt->fetchAll() as $row) {
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
