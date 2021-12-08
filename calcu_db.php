<?php

$input1 = $_POST['input1'];
$input2 = $_POST['input2'];
$ope = $_POST['ope'];
$result = $_POST['result'];
$button = $_POST['button'];
$pre_button = $_POST['pre_button'];
$file_handle = null;
$messages = array();
$dsn = 'mysql:host=localhost;unix_socket=/tmp/mysql.sock;dbname=calculator;charset=utf8';
$user = 'root';
$pass = '';

// tryにPDOの処理を記述
try {

  // PDOインスタンスを生成
  $pdo = new PDO($dsn, $user, $password,[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES=>false,
            ]);

// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {

  // エラーメッセージを表示させる
  echo 'データベースにアクセスできません！' . $e->getMessage();

  // 終了
  die();

}

// テーブル作成
$tb_name='calcu_db';

$sql= "CREATE TABLE IF NOT EXISTS $tb_name (
id INT AUTO_INCREMENT PRIMARY KEY,
input1 DECIMAL(10, 1),
input2 DECIMAL(10, 1),
ope TEXT,
result DECIMAL(15, 1)
)ENGINE=InnoDB DEFAULT CHARSET=utf8";

$stmt=$pdo->prepare($sql);
$stmt->execute();

$sql = 'select input1, input2, ope, result from calcu_db';
$stmt = $pdo->query( $sql );

if (isNumBtn($button) || empty($button)) {
        if (isOpeBtn($pre_button)) {
            if (preg_match('/\./', $button)) {
                $input2 = '0.';
            } else {
                $input2 = $button;
            }
        } else {
            if (empty($ope)) {
                $input1 = $input1 . $button;
            } else {
                $input2 = $input2 . $button;
            }
        }

// 数値ボタン以外が押された時（演算子や記号）
} else {
    switch ($button) {
        case 'C':
            $input1 = '';
            $input2 = '';
            $ope = '';
            $result = '';
            $pre_button = '';
            break;
        case '+/-':
            if(empty($ope)){
                $input1 = -$input1;
            } else {
                $input2 = -$input2;
            }
            break;
        case '％':
            if(empty($ope)){
                $input1 = $input1 / 100;
            } else {
                $input2 = $input2 / 100;
            }
            break;
        default:
            // if (!empty($pre_num) && (preg_match('/＝/', $button) || (isOpeBtn($button) && isNumBtn($pre_button)))) {
            if (!empty($input1) && !empty($input2) && (preg_match('/＝/', $button) || (isOpeBtn($button) && isNumBtn($pre_button)))) {
                switch ($ope) {
                    case '＋':
                        $result = $input1 + $input2;
                        try {
                            $stmt = $pdo->prepare('INSERT INTO calcu_db (
                                                    input1, input2, ope, result
                                                  ) VALUES (
                                                    :input1, :input2, :ope, :result
                                                  )');
                            // 値をセット
                            $stmt->bindParam(':input1', $input1, PDO::PARAM_INT);
                            $stmt->bindParam(':input2', $input2, PDO::PARAM_INT);
                            $stmt->bindParam(':ope', $ope);
                            $stmt->bindParam(':result', $result, PDO::PARAM_INT);
                            // SQL実行
                            $res = $stmt->execute();
                            // コミット
                            // if( $res ) {
                            //     $pdo->commit();
                            // }
                        } catch(PDOException $e) {
                        // エラーメッセージを出力
                            echo $e->getMessage();
                        // ロールバック
                            $pdo->rollBack();
                        }
                        break;
                    case '−':
                        $result = $input1 - $input2;
                        try {
                            $stmt = $pdo->prepare('INSERT INTO calcu_db (
                                                    input1, input2, ope, result
                                                  ) VALUES (
                                                    :input1, :input2, :ope, :result
                                                  )');
                            // 値をセット
                            $stmt->bindParam(':input1', $input1, PDO::PARAM_INT);
                            $stmt->bindParam(':input2', $input2, PDO::PARAM_INT);
                            $stmt->bindParam(':ope', $ope);
                            $stmt->bindParam(':result', $result, PDO::PARAM_INT);
                            // SQL実行
                            $res = $stmt->execute();
                            // コミット
                            // if( $res ) {
                            //     $pdo->commit();
                            // }
                        } catch(PDOException $e) {
                        // エラーメッセージを出力
                            echo $e->getMessage();
                        // ロールバック
                            $pdo->rollBack();
                        }
                        break;
                    case '✕':
                        $result = $input1 * $input2;
                        try {
                            $stmt = $pdo->prepare('INSERT INTO calcu_db (
                                                    input1, input2, ope, result
                                                  ) VALUES (
                                                    :input1, :input2, :ope, :result
                                                  )');
                            // 値をセット
                            $stmt->bindParam(':input1', $input1, PDO::PARAM_INT);
                            $stmt->bindParam(':input2', $input2, PDO::PARAM_INT);
                            $stmt->bindParam(':ope', $ope);
                            $stmt->bindParam(':result', $result, PDO::PARAM_INT);
                            // SQL実行
                            $res = $stmt->execute();
                            // コミット
                            // if( $res ) {
                            //     $pdo->commit();
                            // }
                        } catch(PDOException $e) {
                        // エラーメッセージを出力
                            echo $e->getMessage();
                        // ロールバック
                            $pdo->rollBack();
                        }
                        break;
                    case '÷':
                        $result = $input1 / $input2;
                        try {
                            $stmt = $pdo->prepare('INSERT INTO calcu_db (
                                                    input1, input2, ope, result
                                                  ) VALUES (
                                                    :input1, :input2, :ope, :result
                                                  )');
                            // 値をセット
                            $stmt->bindParam(':input1', $input1, PDO::PARAM_INT);
                            $stmt->bindParam(':input2', $input2, PDO::PARAM_INT);
                            $stmt->bindParam(':ope', $ope);
                            $stmt->bindParam(':result', $result, PDO::PARAM_INT);
                            // SQL実行
                            $res = $stmt->execute();
                            // コミット
                            // if( $res ) {
                            //     $pdo->commit();
                            // }
                        } catch(PDOException $e) {
                        // エラーメッセージを出力
                            echo $e->getMessage();
                        // ロールバック
                            $pdo->rollBack();
                        }
                        break;
                    default:
                        break;
                }
            }
            // $pre_num = $input_num;
            // if ($result && isOpeBtn($pre_button)) {
            //     $input1 = $result;
            // }
            $ope = $button == '＝' ? $ope : $button;
            break;
    }

}

$pre_button = $button;
if ($result && isOpeBtn($pre_button)) {
    $input1 = $result;
}

function convertDispNum($num) {
    preg_match('/(-?)(\d+)(\.?\d*)/', $num, $matches);

    return $matches[1] . number_format($matches[2]) . $matches[3];
}
function isOpeBtn($btn) {
    return preg_match('/(＋|−|✕|÷)/', $btn);
}

function isNumBtn($btn) {
    return preg_match('/(\d|\.)/', $btn);
}

// 接続を閉じる
$dbh = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>

    <title>Calculator</title>
</head>
<body>
    <h2>Calculator</h2>
    <!-- <p><?php echo convertDispNum($disp_num); ?></p> -->
    <form action="calcu_db.php" method="post">
        <!-- 入力値1 -->
        <input type="text" name="input1" value="<?php echo $input1; ?>" />
         <!-- 演算子 -->
        <input type="text" name="ope" value="<?php echo $ope; ?>" />
        <!-- 入力値2 -->
        <input type="text" name="input2" value="<?php echo $input2; ?>" />
        =
        <!-- 計算結果値 -->
        <input type="text" name="result" value="<?php echo $result; ?>" />
        <!-- ボタン値判別 -->
        <input type="text" name="pre_button" value="<?php echo $pre_button; ?>" />
        <table>
            <tr>
                <td><button type="submit" name="button" value="C">C</button></td>
                <td><button type="submit" name="button" value="+/-">+/-</button></td>
                <td><button type="submit" name="button" value="％">％</button></td>
                <td><button type="submit" name="button" value="÷">÷</button></td>
            </tr>
            <tr>
                <td><button type="submit" name="button" value="7">7</button></td>
                <td><button type="submit" name="button" value="8">8</button></td>
                <td><button type="submit" name="button" value="9">9</button></td>
                <td><button type="submit" name="button" value="✕">✕</button></td>
            </tr>
            <tr>
                <td><button type="submit" name="button" value="4">4</button></td>
                <td><button type="submit" name="button" value="5">5</button></td>
                <td><button type="submit" name="button" value="6">6</button></td>
                <td><button type="submit" name="button" value="−">−</button></td>
            </tr>
            <tr>
                <td><button type="submit" name="button" value="1">1</button></td>
                <td><button type="submit" name="button" value="2">2</button></td>
                <td><button type="submit" name="button" value="3">3</button></td>
                <td><button type="submit" name="button" value="＋">＋</button></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" name="button" value="0">0</button></td>
                <td><button type="submit" name="button" value=".">.</button></td>
                <td><button type="submit" name="button" value="＝">＝</button></td>
            </tr>
    </form>
    <hr>
    <a href="./calcu_his.php" target="_blank">計算履歴</a>
</body>
</html>
