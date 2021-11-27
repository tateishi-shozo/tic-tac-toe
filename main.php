<?php 
class MrTicTacToe
{
    CONST PICE_O = " O ";
    CONST PICE_X = " X ";
    CONST NONE = " n ";

    public $standard_board = [
        ['NONE','NONE','NONE'],
        ['NONE','NONE','NONE'],
        ['NONE','NONE','NONE']
    ];
    
    public function printBoard($board){
        for ($i=0 ; $i <= 2 ; $i++){
            for($j=0 ; $j <= 2 ; $j++){
            echo $board[$i][$j];
            }
            echo "\n";
        }
    }

    public function victoryJudgment(array $play_board): bool
    {
        switch($play_board){
            //横
            case $play_board[0][0] == ' O '  and $play_board[0][1] == ' O '  and $play_board[0][2] == ' O ':
            case $play_board[1][0] == ' O '  and $play_board[1][1] == ' O '  and $play_board[1][2] == ' O ':
            case $play_board[2][0] == ' O '  and $play_board[2][1] == ' O '  and $play_board[2][2] == ' O ':
            //縦
            case $play_board[0][0] == ' O '  and $play_board[1][0] == ' O '  and $play_board[2][0] == ' O ':
            case $play_board[0][1] == ' O '  and $play_board[1][1] == ' O '  and $play_board[2][1] == ' O ':
            case $play_board[0][2] == ' O '  and $play_board[1][2] == ' O '  and $play_board[2][2] == ' O ':
            //斜め
            case $play_board[0][0] == ' O '  and $play_board[1][1] == ' O '  and $play_board[2][2] == ' O ':
            case $play_board[0][2] == ' O '  and $play_board[1][1] == ' O '  and $play_board[2][0] == ' O ':
                echo "you win!\n";
                return 1;
            
            case $play_board[0][0] == ' X '  and $play_board[0][1] == ' X '  and $play_board[0][2] == ' X ':
            case $play_board[1][0] == ' X '  and $play_board[1][1] == ' X '  and $play_board[1][2] == ' X ':
            case $play_board[2][0] == ' X '  and $play_board[2][1] == ' X '  and $play_board[2][2] == ' X ':
            //縦
            case $play_board[0][0] == ' X '  and $play_board[1][0] == ' X '  and $play_board[2][0] == ' X ':
            case $play_board[0][1] == ' X '  and $play_board[1][1] == ' X '  and $play_board[2][1] == ' X ':
            case $play_board[0][2] == ' X '  and $play_board[1][2] == ' X '  and $play_board[2][2] == ' X ':
            //斜め
            case $play_board[0][0] == ' X '  and $play_board[1][1] == ' X '  and $play_board[2][2] == ' X ':
            case $play_board[0][2] == ' X '  and $play_board[1][1] == ' X '  and $play_board[2][0] == ' X ':
                echo "cpus win!\n";
                return 1;
            default:
                return 0;
        }
    }
}

class User
{
    public function topOrBottom(){
        echo "Do you want to be the first to start? yes or no.\n";
        $answer = trim(fgets(STDIN));
        if($answer == "yes" or $answer == "y"){
            return true;
        }else{
            return false;
        }
    }

    public function playerTurn(){
        do{ 
            echo "Your turn!\n";
            $row = trim(fgets(STDIN));
            $col = trim(fgets(STDIN));
        }while(0>$row or $row>2 or 0>$col or $col>2 );
        return array($row,$col);
    }

    public function playerPut($row,$col,$board){
        if($board[$row][$col] == NONE ){
            $board[$row][$col] = PIECE_O;
            return $board;
        }else{
            echo "again!\n";
            return 0;
        }
    }

    public function gameEnd(){
        echo "Continue? yes or no.\n";
        $answer = trim(fgets(STDIN));
        if($answer == "yes" or $answer == "y"){
            return true;
        }else{
            return false;
        }
    }
}

class Cpu
{
    public function cpuPut(array $board){
        do {
            $cpu_row = rand(0,2);
            $cpu_col = rand(0,2);
            if($board[$cpu_row][$cpu_col] == NONE ){
                $board[$cpu_row][$cpu_col] = PIECE_X;
                echo "cpu turn!\n";
                return $board;
                break;
            }
        }while( $board[$cpu_row][$cpu_col] == PIECE_X or $board[$cpu_row][$cpu_col] == PIECE_O );
    }
}

//////////////////////////////////////////////////////////////////

$user = new User;
$tictactoe = new MrTicTacToe;
$cpu = new Cpu;

do{
    if($user->topOrBottom()){
        while(empty($judgement)){
        
            if($x==0){
                    $input =  $user->playerTurn();
                    $player_board = $user->playerPut($input[0],$input[1],$standard_board);
            }else{
                do{
                    $input =  $user->playerTurn();
                    $player_board = $user->playerPut($input[0],$input[1],$cpu_board);
                }while(empty($player_board));
            }

            $tictactoe->printBoard($player_board);

            if( $x == 4 ){
                if($tictactoe->victoryJudgment($player_board)){
                    break;
                }else{
                    echo "Draw!\n";
                    break;
                }
            }
        
            $cpu_board = $cpu->cpuPut($player_board);
        
            $tictactoe->printBoard($cpu_board);
        
            $judgement = $tictactoe->victoryJudgment($cpu_board);
        
            $x = $x + 1;
        }
    }else{
        while(empty($judgement)){

            if( $x == 0 ){
                $cpu_board = $cpu->cpuPut($standard_board);
            }else{
                $cpu_board = $cpu->cpuPut($player_board);
            }

            $tictactoe->printBoard($cpu_board);

            if( $x == 4 ){
                if($tictactoe->victoryJudgment($cpu_board)){
                    break;
                }else{
                    echo "Draw!\n";
                    break;
                }
            }

            do{
                $input =  $user->playerTurn();
                $player_board = $user->playerPut($input[0],$input[1],$cpu_board);
            }while(empty($player_board));
        
            $tictactoe->printBoard($player_board);
        
            $judgement = $tictactoe->victoryJudgment($player_board);

            $x = $x + 1;
        
        }
    }
}while($tictactoe->gameEnd());


