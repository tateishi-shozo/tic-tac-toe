<?php 
define("PIECE_O"," O ");
define("PIECE_X"," X " );
define("NONE"," n ");

$standardBoard = [
    [NONE,NONE,NONE],
    [NONE,NONE,NONE],
    [NONE,NONE,NONE]
];

function printBoard($board) {
    for ($i=0 ; $i <= 2 ; $i++) {
        for($j=0 ; $j <= 2 ; $j++) {
        echo $board[$i][$j];
        }
        echo "\n";
    }
}

function playerTurn(){
    do { 
        echo "Your turn!\n";
        $row = trim(fgets(STDIN));
        $col = trim(fgets(STDIN));
    } while(0>$row || $row>2 || 0>$col || $col>2 );
    return array($row,$col);
}

//引数の名前は関数内外で合わせた方が良い
function playerPut($row,$col,$board) {
        if($board[$row][$col] == NONE ) {
            $board[$row][$col] = PIECE_O;
            return $board;
        } else {
            echo "again!\n";
            return 0;
        }
}

//定数はシングルクォーテーション
function victoryJudgment(array $play_board): bool
{
    switch($play_board) {
        //横
        case $play_board[0][0] == ' O '  && $play_board[0][1] == ' O '  && $play_board[0][2] == ' O ':
        case $play_board[1][0] == ' O '  && $play_board[1][1] == ' O '  && $play_board[1][2] == ' O ':
        case $play_board[2][0] == ' O '  && $play_board[2][1] == ' O '  && $play_board[2][2] == ' O ':
        //縦
        case $play_board[0][0] == ' O '  && $play_board[1][0] == ' O '  && $play_board[2][0] == ' O ':
        case $play_board[0][1] == ' O '  && $play_board[1][1] == ' O '  && $play_board[2][1] == ' O ':
        case $play_board[0][2] == ' O '  && $play_board[1][2] == ' O '  && $play_board[2][2] == ' O ':
        //斜め
        case $play_board[0][0] == ' O '  && $play_board[1][1] == ' O '  && $play_board[2][2] == ' O ':
        case $play_board[0][2] == ' O '  && $play_board[1][1] == ' O '  && $play_board[2][0] == ' O ':
            echo "you win!\n";
            return 1;
        
        case $play_board[0][0] == ' X '  && $play_board[0][1] == ' X '  && $play_board[0][2] == ' X ':
        case $play_board[1][0] == ' X '  && $play_board[1][1] == ' X '  && $play_board[1][2] == ' X ':
        case $play_board[2][0] == ' X '  && $play_board[2][1] == ' X '  && $play_board[2][2] == ' X ':
        //縦
        case $play_board[0][0] == ' X '  && $play_board[1][0] == ' X '  && $play_board[2][0] == ' X ':
        case $play_board[0][1] == ' X '  && $play_board[1][1] == ' X '  && $play_board[2][1] == ' X ':
        case $play_board[0][2] == ' X '  && $play_board[1][2] == ' X '  && $play_board[2][2] == ' X ':
        //斜め
        case $play_board[0][0] == ' X '  && $play_board[1][1] == ' X '  && $play_board[2][2] == ' X ':
        case $play_board[0][2] == ' X '  && $play_board[1][1] == ' X '  && $play_board[2][0] == ' X ':
            echo "cpus win!\n";
            return 1;
        default:
            return 0;
    }
}

function cpuPut(array $board) {
    do {
        $cpu_row = rand(0,2);
        $cpu_col = rand(0,2);
        if($board[$cpu_row][$cpu_col] == NONE ){
            $board[$cpu_row][$cpu_col] = PIECE_X;
            echo "cpu turn!\n";
            return $board;
            break;
        }
    }while ($board[$cpu_row][$cpu_col] == PIECE_X || $board[$cpu_row][$cpu_col] == PIECE_O);
}

function topOrBottom() {
    echo "Do you want to be the first to start? yes or no.\n";
    $answer = trim(fgets(STDIN));
    if ($answer == "yes" || $answer == "y") {
        return true;
    } else {
        return false;
    }
}

function gameEnd() {
    echo "Continue? yes or no.\n";
    $answer = trim(fgets(STDIN));
    if($answer == "yes" || $answer == "y"){
        return true;
    }else{
        return false;
    }
}

//ボツ！！！
// function drawJudgement(array $board){
//     for( $a ; $a > 1 ; $a++ ){
//         for ($b=0 ; $b <= 2 ; $b++){
//             for($c=0 ; $c <= 2 ; $c++){
//                 if($board[$b][$c] == PIECE_O or $board[$b][$c] == PIECE_X ){

//                 }else{
//                     break 3;
//                 }
//             }
//         }
//         echo "Draw!";
//     }
// }

/////////////////////////////////////////////////////////////

do {
    if(topOrBottom()) {
        while (empty($judgement)) {
        
            if ($x == 0) {
                    $input =  playerTurn();
                    $playerBoard = playerPut($input[0],$input[1],$standardBoard);
            } else {
                do {
                    $input =  playerTurn();
                    $playerBoard = playerPut($input[0],$input[1],$cpuBoard);
                }while (empty($playerBoard));
            }

            printBoard($playerBoard);

            if($x == 4){
                if(victoryJudgment($playerBoard)){
                    break;
                }else{
                    echo "Draw!\n";
                    break;
                }
            }
        
            $cpuBoard = cpuPut($playerBoard);
        
            printBoard($cpuBoard);
        
            $judgement = victoryJudgment($cpuBoard);
        
            $x = $x + 1;
        
        }
    }else{
        while(empty($judgement)){

            if ($x == 0){
                $cpuBoard = cpuPut($standardBoard);
            }else {
                $cpuBoard = cpuPut($playerBoard);
            }

            printBoard($cpuBoard);

            if ($x == 4) {
                if(victoryJudgment($cpuBoard)){
                    break;
                }else {
                    echo "Draw!\n";
                    break;
                }
            }

            do{
                $input =  playerTurn();
                $playerBoard = playerPut($input[0],$input[1],$cpuBoard);
            }while(empty($playerBoard));
        
            printBoard($playerBoard);
        
            $judgement = victoryJudgment($playerBoard);

            $x = $x + 1;
        
        }
    }
}while(gameEnd());
