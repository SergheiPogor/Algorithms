<?php
$speed = $_GET['speed'] ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Tetris PHP</title>
    <meta http-equiv="refresh" content="<?php print $speed ?>">
    <style>
        body{
            width: 240px;
            margin: 30px auto;
        }
        div{
            display: inline-block;
        }
        .tetris-container{
            /* margin-right: 30px; */
        }
        .button-container{
            vertical-align: top;
        }
        form{
            float: left;
            margin: 5px;
        }
        input{
            margin: 5px 0;
        }
        .cell{
            border: 2px solid #999;
            width: 20px;
            height: 20px;            
            margin: -2px 0;
            padding: 0;
        }
        .empty{
            /* background-color: #777; */
        }
        .active{
            background-color: #555;            
        }
        .frozen{
            background-color: red;            
        }
        .figure-area{
            background-color: #888;            
        }
    </style>
</head>


<?php

session_start();

if (isset($_POST['start_new_game'])) {
    start_new_game();
}

$figures = [
    [
        [1, 1],
        [4, 1],
        [4, 1],
    ],
    [
        [1, 1],
        [1, 4],
        [1, 4],
    ],
    [
        [1],
        [1],
        [1],
        [1],
    ],
    [
        [1,1],
        [1,1],        
    ],

];

$grid = [
    // 4 randuri in afara ecranului
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 0
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 1
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 2
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 3
    //  
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 4
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 5
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 6
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 7
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 8
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 9
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 10
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 11
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 12
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 13
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 14
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 15
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 16
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 17
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 18
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 19
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 20
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 21
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],    // 22
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]     // 23
];

if (empty($_SESSION['current_figure'])) {
    $_SESSION['current_figure'] = $figures[rand(0, count($figures) - 1)]; 
}

if (!empty($_SESSION['tetris'])) {
    $grid = $_SESSION['tetris'];  
}else {
    insert_figure(0, 4, $_SESSION['current_figure']);
}


if (isset($_POST['move_right'])) {
    move_right();
}
if (isset($_POST['move_left'])) {
    move_left();
}
if (isset($_POST['rotate'])) {
    rotate();
}

function start_new_game(){
    session_destroy();
    header("location: index2.php");
}

// afiseaza din nou
function update_screen(){    
    global $grid;
    for($row = 4; $row <= 23; $row++){
        for($cell = 0; $cell <= 9; $cell++){
            if ($grid[$row][$cell] == 0){
                $grid[$row][$cell] ="<div class='empty cell'>".$grid[$row][$cell]."</div>";
            }
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] ="<div class='active cell'>".$grid[$row][$cell]."</div>";
            }
            if ($grid[$row][$cell] == 2) {
                $grid[$row][$cell] ="<div class='frozen cell'>".$grid[$row][$cell]."</div>";
            } 
            if ($grid[$row][$cell] == 4) {
                $grid[$row][$cell] ="<div class='figure-area cell'>".$grid[$row][$cell]."</div>";
            } 
            print $grid[$row][$cell];
        }
        print "<br>";
    }    
    return $grid;
}

function move_one_row_down(){
    global $grid;
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ( ($grid[$row][$cell] == 1) || ($grid[$row][$cell] == 4) ) {               
                $grid[$row + 1][$cell] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;      
            }         
        }
    }
    return $grid;
}

// verifica daca treb oprita
function check_collision(){
    global $grid;
    global $figures;

    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if (($grid[$row][$cell] == 1) && $row == 23) {
                freeze_figure();
                $_SESSION['current_figure'] = $figures[rand(0, count($figures) - 1)]; 
                insert_figure(1,4, $_SESSION['current_figure']);

            }elseif( ($grid[$row][$cell] == 4) && ($grid[$row + 1][$cell] == 2) ) { // error here at bottom
                $grid[$row + 1][$cell] = 2;
                $grid[$row][$cell] = 0;                
            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 2) ) {
                freeze_figure();
                $_SESSION['current_figure'] = $figures[rand(0, count($figures) - 1)]; 
                insert_figure(1,4, $_SESSION['current_figure']);
            }      
        }        
    }
    return $grid;
}

function freeze_figure(){
    global $grid;
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] = 2;
            }elseif ($grid[$row][$cell] == 4) {
                $grid[$row][$cell] = 0;
            }
        }
    }
    return $grid;
}

function insert_figure($r, $c, $current_figure){
    global $grid; 
    for ($row=0; $row < count($current_figure); $row++) {
        for ($cell = 0; $cell < count($current_figure[$row]); $cell++) {
            $grid[$row+$r][$cell+$c] = $current_figure[$row][$cell];
        }
    }
    return $grid;
}

function move_right(){
    global $grid;
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 9; $cell >= 0; $cell--) {
            if ( (($grid[$row][$cell] == 1) || ($grid[$row][$cell] == 4)) AND ($cell == 9) ) {
                break;
            }elseif ( (($grid[$row][$cell] == 1) || ($grid[$row][$cell] == 4)) AND ($cell != 9)) {
                $grid[$row][$cell + 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0; 
            } 
        }        
    }
    return $grid;
}

function move_left(){
    global $grid;
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ( (($grid[$row][$cell] == 1) || ($grid[$row][$cell] == 4)) AND ($cell == 0) ) {
                break;
            }elseif ( (($grid[$row][$cell] == 1) || ($grid[$row][$cell] == 4)) AND ($cell != 0) ) {
                $grid[$row][$cell - 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;                               
            }
        }        
    }
    return $grid;
}

function rotate90() {   
    $matrix = $_SESSION['current_figure'];
    array_unshift($matrix, null);
    $matrix = call_user_func_array('array_map', $matrix);
    $matrix = array_map('array_reverse', $matrix);
    $_SESSION['current_figure'] = $matrix;
    return $matrix;
}

function rotate(){    
    global $grid;
    for ($row = 22; $row > 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            
            // for figure 1 |
            if ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 1) && ($grid[$row + 2][$cell] == 1) && ($grid[$row + 3][$cell] == 1) ) {
                clean_figure();
                if ($cell > 6) {
                    insert_figure($row, 6, rotate90());
                }else{
                    insert_figure($row, $cell, rotate90());                   
                }
                    
            // ERROR HERE
            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row][$cell + 1] == 1) && ($grid[$row][$cell + 2] == 1) && ($grid[$row][$cell + 3] == 1) ) {
                clean_figure();                
                insert_figure($row, $cell, rotate90());               
            }
       

            // for figure 3 |---
            if ( ($grid[$row][$cell] == 1) && ($grid[$row][$cell + 1] == 1) && ($grid[$row + 1][$cell + 1] == 1) && ($grid[$row + 2][$cell + 1] == 1) ) { 
                clean_figure();
                insert_figure($row, $cell, rotate90());

            }elseif ( ($grid[$row+1][$cell] == 1) && ($grid[$row+1][$cell + 1] == 1) && ($grid[$row+1][$cell + 2] == 1) && ($grid[$row][$cell + 2] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());

            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row+1][$cell] == 1) && ($grid[$row+2][$cell] == 1) && ($grid[$row+2][$cell + 1] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());
            
            }elseif ( ($grid[$row+1][$cell] == 1) && ($grid[$row][$cell] == 1) && ($grid[$row][$cell+1] == 1) && ($grid[$row][$cell+2] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());
            }

            // for figure 4 |---
            if ( ($grid[$row-1][$cell+1] == 1) && ($grid[$row-1][$cell] == 1) && ($grid[$row][$cell] == 1) && ($grid[$row+1][$cell] == 1) ) { 
                clean_figure();
                insert_figure($row, $cell, rotate90());

            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row][$cell + 1] == 1) && ($grid[$row][$cell + 2] == 1) && ($grid[$row+1][$cell + 2] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());

            }elseif ( ($grid[$row+1][$cell] == 1) && ($grid[$row+1][$cell+1] == 1) && ($grid[$row][$cell+1] == 1) && ($grid[$row-1][$cell+1] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());
            
            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row+1][$cell] == 1) && ($grid[$row+1][$cell+1] == 1) && ($grid[$row+1][$cell+2] == 1) ) {
                clean_figure();
                insert_figure($row, $cell, rotate90());
            }
        }        
    }
    return $grid;
}

function clean_figure(){ // replace 1 and 4 with 0 
    global $grid;
    for ($row = 22; $row > 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {                
                $grid[$row][$cell] = 0;                
            }
        }        
    }
    return $grid;
}

function line_completed(){
    global $grid;
    $line_completed = true;
    for ($row = 23; $row > 0; $row--) {

        if ($grid[$row][0] == 2 && 
            $grid[$row][1] == 2 && 
            $grid[$row][2] == 2 && 
            $grid[$row][3] == 2 && 
            $grid[$row][4] == 2 && 
            $grid[$row][5] == 2 && 
            $grid[$row][6] == 2 && 
            $grid[$row][7] == 2 && 
            $grid[$row][8] == 2 && 
            $grid[$row][9] == 2)
        {           
            // print "COMPLETED";
            // $grid[$row] = [0,0,0,0,0,0,0,0,0,0];
            // sleep(1);
            for ($i=0; $i <= 9 ; $i++) { 
                $grid[$row] = $grid[$row-1];
            }

        }
     
    }
    return $grid;
}
move_one_row_down();
check_collision();
line_completed();

$_SESSION['tetris'] = $grid;

print "<body>";
print "<div class='tetris-container'>";
    update_screen();
print "</div>";
?>
<hr>
    <div class="button-container">
        <form method="post">
            <button style="font-size: 24px;" type="submit" name="start_new_game">START NEW GAME</button>

        </form>

        <form method="post">
            <button type="submit" name="move_left"><img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/48/Actions-go-previous-view-icon.png"></button>
        </form>

        <form method="post">
            <button type="submit" name="rotate"><img src="http://icons.iconarchive.com/icons/alecive/flatwoken/48/Apps-Rotate-Right-icon.png"></button>
        </form>  

        <form method="post">          
            <button type="submit" name="move_right"><img src="http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/48/Actions-go-next-view-icon.png"></button>
        </form>

    </div>

</body>


</html>