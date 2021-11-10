<?php 
define("O","o");
define("X","x" );
define("N","n");

$game_count = 0;
$basicBoard = [
    [N,N,N],
    [N,N,N],
    [N,N,N]
];
$basicInput = [];



/**
 * ボードの出力
 */
function printBoard(array $board): void
{
    foreach($board as $row) {
        foreach($row as $val) {
            echo $val;
        }
        echo "\n";
    }
}

/**
 * プレイヤー入力
 */
function playerTurn(array &$input, array &$board): void
{
    echo "Your turn!\n";
    while (1) {
        echo "行を指定して下さい\n";
        $input[0] = trim(fgets(STDIN));
        echo "列を指定して下さい\n";
        $input[1] = trim(fgets(STDIN));

        if (0 <= $input[0] && $input[0]<=2 && 0 <= $input[1] && $input[1] <= 2 && $board[$input[0]][$input[1]] == N){
            break;
        }
        echo "again!\n";
    }
    putBoard(O, $input, $board);
    printBoard($board);
}

/**
 * ロボット入力
 */
function robotTrun(&$board): void 
{
    echo "Robot turn!\n";
    $input = [];
    while (1) {
        $input = [mt_rand(0, 2), mt_rand(0, 2)];
        if ($board[$input[0]][$input[1]] == N){
            break;
        }
    }
    putBoard(X, $input, $board);
    printBoard($board);
}

/**
 * 更新
 */
function putBoard(string $mark, array $input,array &$board): void 
{
    $board[$input[0]][$input[1]] = $mark;
}

/**
 * 先攻後攻
 */
function isPlayerfirst(): bool 
{
    return mt_rand(0, 1);
}

/**
 * 終了条件
 */
function isEnd(array $board): bool
{
    foreach($board as $row) {
        foreach($row as $val) {
            if ($val == N) {
                return false;
            }
        }
    }
    return true;
}

/**
 * 判定処理
 */
function check(array $data, string $mark, string $message): void
{
    if ($data[0] == $data[1] && $data[1] == $data[2]) {
        if ($data[0] == $mark && $data[1] == $mark && $data[2] == $mark) {
            echo $message;
            exit();
        }
    }
}

/**
 * 行判定
 */
function rowCheck(array $board): void
{
    foreach ($board as $row) {
        check($row, O, "YOU WIN\n");
        check($row, X, "YOU LOSE\n");
    }
}

/**
 * クロス判定
 */
function crossCheck(array $board): void
{
    $pickIndex = 0;
    $pickData = [];
    foreach ($board as $row) {
        $pickData[$pickIndex] = $row[$pickIndex];
        $pickIndex++;
    }

    check($pickData, O, "YOU WIN\n");
    check($pickData, X, "YOU LOSE\n");

    $pickIndex = 0;
    $endRowIndex = count($board[0]) - 1;

    foreach ($board as $row) {
        $pickData[$pickIndex] = $row[$endRowIndex - $pickIndex];
        $pickIndex++;
    }

    check($pickData, O, "YOU WIN\n");
    check($pickData, X, "YOU LOSE\n");
}

/**
 * 行列反転
 */
function swap(array $board): array
{
    for ($i = 0; $i < count($board[0]); $i++) {
        foreach ($board as $val) {
            $swaps[$i][] = $val[$i];
        }
    }
    return $swaps;
}

/**
 * 勝敗判定
 */
function result(array $board): void
{
    // 行判定
    rowCheck($board);
    // クロス
    crossCheck($board);
    // 列判定
    rowCheck(swap($board));

    if (isEnd($board)){
        echo "DROW\n";
        exit(); 
    }  
}

///////////////////////////////////
$board        = &$basicBoard;
$input        = &$basicInput;
$setTrun      = isPlayerfirst();

while (1) {
    if ($setTrun) {
        robotTrun($board);
    }else {
        playerTurn($basicInput, $basicBoard);
    }
    result($board);
    $setTrun = !$setTrun;
}

result($board);

unset($basicBoard);
unset($basicInput);