<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Document</title>
        <meta http-equiv="refresh" content="1000">
    <style>
        body{

        }
    </style>
</head>
<body>
    
    
</body>
</html>

<?php
session_start();

// 0 - loc gol
// 1 - figura dinamica
// 2 - figura statica

$figures = [
    [
        [0, 1, 0],
        [1, 1, 1],
        [0, 1, 0],
    ],
    [
        [1, 0, 0],
        [1, 1, 0],
        [0, 0, 1],
    ],
    [
        [0, 1, 1],
        [0, 0, 1],
        [0, 0, 1],
    ],
];

$grid = [
    // 4 randuri in afara ecranului
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    // 
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0]
];

if (!empty($_SESSION['tetris'])) {
    $grid = $_SESSION['tetris'];

    print "SESSION<hr>";
    show($_SESSION['tetris']);
    //print_r($_SESSION['tetris']);
    //var_dump($_SESSION['tetris']);
    print "<hr>";

}

print "GRID<hr>";
show($grid);
print "<hr>";

// var_dump($grid);


// afiseaza din nou
function update_screen($figures,$grid){

    for($row = 0; $row <= 23; $row++){
        for($cell = 0; $cell <= 9; $cell++){
            if ($grid[$row][$cell] == 0){
                $grid[$row][$cell] ="<span>&#9634;</span>";
            }
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] ="<span>&#9640;</span>";
            }
            if ($grid[$row][$cell] == 2) {
                $grid[$row][$cell] ="<span class='frozen'>&#9635;</span>";
            }
            print $grid[$row][$cell];
        }
        print "<br>";
        //$html.="<br>";       
    }    
    return $grid;
}

function move_one_row_down($figures,$grid){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row + 1][$cell] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;
            }
        }
        //print "<br>";
    }
    return $grid;
}

// verifica daca treb oprita
function check_collision($figures,$grid){
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if (($grid[$row][$cell] == 1) && $row == 23) {
                freeze_figure($figures,$grid);
                insert_figure(rand(0,count($figures)-1),$figures,$grid);    
            } else if ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 2) ){
                freeze_figure($figures,$grid);
                insert_figure(rand(0, count($figures)-1), $figures, $grid);
            }
        }
        //print "<br>";
    }  
}

function freeze_figure($figures,$grid) {
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] = 2;
            }
        }
        //print "<br>";
    }
    return $grid;
}

function insert_figure($n,$figures,$grid){
    for($r=0; $r<=2; $r++){
        for ($c = 0; $c <= 2; $c++) {
            $grid[$r][$c] = $figures[$n][$r][$c];
        }
    }
    return $grid;
}
function move_right($figures,$grid){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 8; $cell >= 0; $cell--) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell + 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;
            }
        }
        //print "<br>";
    }
    return $grid;
}

function show($grid)
{
    for ($row = 4; $row <= 23; $row++) {
        for ($cell = 0; $cell <= 9; $cell++) {
            // document.write($grid[$row][$cell]);
            if ($grid[$row][$cell] == 0) {
                print "<span>&#9634;</span>";
            }
            if ($grid[$row][$cell] == 1) {
                print "<span>&#9640;</span>";
            }
            if ($grid[$row][$cell] == 2) {
                print "<span class='frozen'>&#9635;</span>";
            }
        }
        print "<br>";
        //$html.="<br>";
    }
    return $grid;
}


function action(){

}

insert_figure(0,$figures,$grid);

// var_dump($grid);

move_one_row_down($figures,$grid);
check_collision($figures,$grid);

//$_SESSION['tetris'] = update_screen($figures,$grid);

update_screen($figures, $grid);


// move left
// rotate
// verificare border stanga dreapta
?>