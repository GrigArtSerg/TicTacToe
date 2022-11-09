<?php
$winCombinations = array(
    array(0,1,2),
    array(3,4,5),
    array(6,7,8),

    array(0,3,6),
    array(1,4,7),
    array(2,5,8),

    array(0,4,8),
    array(2,4,6)
);
$isWin = -1;

if (isset($_POST['a'], $_POST['b'], $_POST['c'],
            $_POST['d'], $_POST['e'], $_POST['f'],
            $_POST['g'], $_POST['h'], $_POST['k'])){

    $a = $_POST['a']; $b = $_POST['b']; $c= $_POST['c'];
    $d = $_POST['d']; $e= $_POST['e']; $f= $_POST['f'];
    $g = $_POST['g']; $h= $_POST['h']; $k= $_POST['k'];

    $serverTTT = array($a,$b,$c,$d,$e,$f,$g,$h,$k);

    #Определеине выигрыша
    for($i = 0; $i < count($winCombinations); $i++) {
        if ($serverTTT[$winCombinations[$i][0]] == 0 && $serverTTT[$winCombinations[$i][1]] == 0 && $serverTTT[$winCombinations[$i][2]] == 0) {
            $isWin = 1;
            echo 'Нолики выиграли';
        }
        else  if ($serverTTT[$winCombinations[$i][0]] == 1 && $serverTTT[$winCombinations[$i][1]] == 1 && $serverTTT[$winCombinations[$i][2]] == 1 && $isWin<0){
            $isWin = 0;
            echo 'Крестики выиграли';
        }
    }
    for($i = 0; $i<count($serverTTT) && $isWin!=1 && $isWin!=0; $i++){
        if($serverTTT[$i]<2){
            $isWin=2;
        }
        else{
            $isWin=-1;
            break;
        }
    }

    #Рассчет хода
    if ($isWin < 0){
        $answerSent = false;
        for($i = 0; $i < count($winCombinations); $i++){
            if($serverTTT[$winCombinations[$i][0]] == 1 && $serverTTT[$winCombinations[$i][1]] == 1 &&
               $serverTTT[$winCombinations[$i][2]] != 0)
            {
                $serverTTT[$winCombinations[$i][2]] = 0;
                $numChanged = $winCombinations[$i][2];
                $serverTTT[$numChanged] = 0;

                echo $numChanged;
                $answerSent = true;
                break;
            }
            else if($serverTTT[$winCombinations[$i][0]] == 1 && $serverTTT[$winCombinations[$i][1]] != 0 &&
                $serverTTT[$winCombinations[$i][2]] == 1)
            {
                $serverTTT[$winCombinations[$i][1]] = 0;
                $numChanged = $winCombinations[$i][1];
                $serverTTT[$numChanged] = 0;

                echo $numChanged;
                $answerSent = true;
                break;
            }
            else if($serverTTT[$winCombinations[$i][0]] != 0 && $serverTTT[$winCombinations[$i][1]] == 1 &&
                $serverTTT[$winCombinations[$i][2]] == 1)
            {
                $serverTTT[$winCombinations[$i][0]] = 0;
                $numChanged = $winCombinations[$i][0];
                $serverTTT[$numChanged] = 0;

                echo $numChanged;
                $answerSent = true;
                break;
            }
        }
        if(!$answerSent){
            while(true){
                $numChanged = random_int(0, 8);
                print(9);
                print($numChanged);
                print(9);
                if($serverTTT[$numChanged] != 1 && $serverTTT[$numChanged] != 0) break;
            }
            $serverTTT[$numChanged] = 0;

            echo $numChanged;
        }
    }
    else if($isWin == 2){
        echo 'Ничья';
    }
}
?>