<?php 
define("piece_o"," o ");
define("piece_x"," x " );
define("none"," n ");
define("randam_play","");

$game_count = 0;
$standard_board = [
    [none,none,none],
    [none,none,none],
    [none,none,none]
];

function printBoard($board){
    for ($i=0 ; $i <= 2 ; $i++){
        for($j=0 ; $j <= 2 ; $j++){
        echo $board[$i][$j];
        }
        echo "\n";
    }
}

function playerTurn(){
    echo "Your turn!\n";
    $row = trim(fgets(STDIN));
    $col = trim(fgets(STDIN));
    return array($row,$col);
}

//引数の名前は関数内外で合わせた方が良い
function playerPut($row,$col,$board){
    if(0<=$row && $row<=2 && 0<=$col&& $col<=2 ){
        $board[$row][$col] = piece_o;
        return $board;
    } else{
        echo "again!";
    }
}

function victoryJudgment(array $play_board){
    if($play_board[0][0] == none and $play_board[0][1] == none and $play_board[0][2] == none){
        echo "you win!\n";
    }else{
        echo "you lose!\n";
    }
}

function cpuPut($board){
    $cpu_row = rand(0,2);
    $cpu_col=rand(0,2);
    if($board[$cpu_row][$cpu_col] == none ){
        $board[$cpu_row][$cpu_col] = piece_x;
        echo "cpu turn!\n";
        return $board;
    }else{
        return cpu_put($board);
    }
}

function topOrBottom(){
    echo "Do you want to be the first to start? yes or no.\n";
    $answer = trim(fgets(STDIN));
    if($answer == "yes" or $answer == "y"){
        return true;
    }else{
        return false;
    }
}

function nExists(){
    for ($a=0 ; $a <= 2 ; $a++){
        for($b=0 ; $b <= 2 ; $b++){
        echo $board[$a][$b];
        }
        echo "\n";
    }
}

///////////////////////////////////

// if(top_or_bottom()){
//     echo '先攻じゃぁぁぁ';
// }else{
//     echo '後攻じゃぁぁぁ';
// }

for($x=0 ; $x <= 2 ; $x++){

$input =  player_turn();

$player_board = player_put($input[0],$input[1],$standard_board);

print_board($player_board);

// victory_judgment($player_board);

$cpu_board = cpu_put($now_board);

print_board($cpu_board);

}
