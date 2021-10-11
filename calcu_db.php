<?php

// 計算履歴を保存するファイルパス設定
// define('FILENAME', './calcu_history.txt');

// $disp_num = $_POST['disp_num'];
// $pre_num = $_POST['pre_num'];
// $input_num = $_POST['input_num'];
// $ope = $_POST['ope'];
// $button = $_POST['button'];
// $pre_button = $_POST['pre_button'];
$input1 = $_POST['input1'];
$input2 = $_POST['input2'];
$ope = $_POST['ope'];
$result = $_POST['result'];
$button = $_POST['button'];
$pre_button = $_POST['pre_button'];
$file_handle = null;
$messages = array();
// $input_check = $_POST['input_check'];
if (empty($input1)) {
    $input_check = "num1";
} else {
    $input_check = "num2";
}
$dsn = 'mysql:host=localhost;unix_socket=/tmp/mysql.sock;dbname=calculator;charset=utf8';
$user = 'root';
$pass = '';

// tryにPDOの処理を記述
try {

  // PDOインスタンスを生成
  $dbh = new PDO($dsn, $user, $password);

// エラー（例外）が発生した時の処理を記述
} catch (PDOException $e) {

  // エラーメッセージを表示させる
  echo 'データベースにアクセスできません！' . $e->getMessage();

  // 終了
  die();

}

if (isNumBtn($button) || empty($button)) {
        if (isOpeBtn($pre_button)) {
            if (preg_match('/\./', $button)) {
                $input2 = '0.';
            } else {
                $input2 = $button;
            }
            $input_check = "num2";
        } else {
            if ($input_check == "num1") {
                // $input_check = "num1";
                $input1 = $input1 . $button;
            } else {
                // $input_check = "num2";
                $input2 = $input2 . $button;
            }
        }
    // if ($judge == "num1") {
    //     // if (isOpeBtn($pre_button)) {
    //     //     // $pre_num = $disp_num;
    //     //     if (preg_match('/\./', $button)) {
    //     //         // $disp_num = '0.';
    //     //     } else {
    //     //         // $disp_num = $button;
    //     //     }
    //     // } else {
    //     //     // $disp_num = $disp_num . $button;
    //     //     $input1 = $input1 . $button;
    //     // }

    //     // $input_num = $disp_num;
    //     $input1 = $input1 . $button;
    // } else {
    //     // if (isOpeBtn($pre_button)) {
    //     //     $pre_num = $disp_num;
    //     //     if (preg_match('/\./', $button)) {
    //     //         $disp_num = '0.';
    //     //     } else {
    //     //         $disp_num = $button;
    //     //     }
    //     // } else {
    //     //     // $disp_num = $disp_num . $button;
    //     //     $input1 = $input1 . $button;
    //     // }
    //     // $input_num = $disp_num;
    //     $input2 = $input2 . $button;
    // }

// 数値や小数点ボタンが押された時または、ボタンが押されてない時
// if (isNumBtn($button) || empty($button)) {
//     if (isOpeBtn($pre_button)) {
//         $pre_num = $disp_num;
//         if (preg_match('/\./', $button)) {
//             $disp_num = '0.';
//         } else {
//             $disp_num = $button;
//         }
//     } else {
//         $disp_num = $disp_num . $button;
//     }

//     $input_num = $disp_num;

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
            if($input_check == "num1"){
                $input1 = -$input1;
            } else {
                $input2 = -$input2;
            }
            break;
        case '％':
            if($input_check == "num1"){
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
                        // if( $file_handle = fopen( FILENAME, "a")) {
                        //             // 書き込むデータ作成
                        //         $data = $pre_num."+".$input_num."=".$disp_num."\n";

                        //         // 書き込み
                        //         fwrite($file_handle, $data);

                        //         // ファイル閉じる
                        //         fclose($file_handle);
                        // }
                        break;
                    case '−':
                        $result = $input1 - $input2;
                        // if( $file_handle = fopen( FILENAME, "a")) {
                        //             // 書き込むデータ作成
                        //         $data = $pre_num."-".$input_num."=".$disp_num."\n";

                        //         // 書き込み
                        //         fwrite($file_handle, $data);

                        //         // ファイル閉じる
                        //         fclose($file_handle);
                        // }
                        break;
                    case '✕':
                        $result = $input1 * $input2;
                        // if( $file_handle = fopen( FILENAME, "a")) {
                        //             // 書き込むデータ作成
                        //         $data = $pre_num."*".$input_num."=".$disp_num."\n";

                        //         // 書き込み
                        //         fwrite($file_handle, $data);

                        //         // ファイル閉じる
                        //         fclose($file_handle);
                        // }
                        break;
                    case '÷':
                        $result = $input1 / $input2;
                        // if( $file_handle = fopen( FILENAME, "a")) {
                        //             // 書き込むデータ作成
                        //         $data = $pre_num."/".$input_num."=".$disp_num."\n";

                        //         // 書き込み
                        //         fwrite($file_handle, $data);

                        //         // ファイル閉じる
                        //         fclose($file_handle);
                        // }
                        break;
                    default:
                        break;
                }
            }
            $pre_num = $input_num;
            $ope = $button == '＝' ? $ope : $button;
            break;
    }

}

$pre_button = $button;

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
        <!-- <input type="hidden" name="disp_num" value="<?php echo $disp_num; ?>" />
        <input type="hidden" name="pre_num" value="<?php echo $pre_num; ?>" />
        <input type="hidden" name="input_num" value="<?php echo $input_num; ?>" />
        <input type="hidden" name="pre_button" value="<?php echo $pre_button; ?>" />
        <input type="hidden" name="ope" value="<?php echo $ope; ?>" /> -->
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
        <input type="text" name="input_check" value="<?php echo $input_check; ?>" />
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
    <a href="./calcu_history.txt" target="_blank">計算履歴</a>
</body>
</html>
