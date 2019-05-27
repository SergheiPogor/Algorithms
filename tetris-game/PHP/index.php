<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Document</title>
        <meta http-equiv="refresh" content="1000">
    <style>
        body{
            width: 600px;
            margin: 30px auto;
        }
        div{
            display: inline-block;
        }
        .tetris-container{
            margin-right: 30px;
        }
        .button-container{
            vertical-align: top;
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
            /* background-color: #777;             */
        }
        .active{
            background-color: black;            
        }
        .frozen{
            background-color: red;            
        }

    </style>
</head>


<?php

session_start();

if (isset($_POST['start_new_game'])) {
    session_destroy();
}

$figures = [
    [
        [0, 0, 0, 0, 0],
        [0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 1, 1, 0, 0],
        [0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 1, 1, 0],
        [0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 1, 1, 0, 0],
        [0, 1, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 1, 0, 0, 0],
        [0, 1, 1, 0, 0],
        [0, 0, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 1, 0],
        [0, 0, 1, 1, 0],
        [0, 0, 1, 0, 0],
    ],
    [
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 1, 1, 1, 0],
        [0, 0, 1, 0, 0],
    ],
];


$grid = [
    // 4 randuri in afara ecranului
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    // 
    [0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0],
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
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
];

if (!empty($_SESSION['tetris'])) {
    $grid = $_SESSION['tetris'];
}

if (isset($_POST['move_right'])) {
    $grid = move_right($grid);
}
if (isset($_POST['move_left'])) {
    $grid = move_left($grid);
}
if (isset($_POST['rotate'])) {
    //$grid = rotate($grid);

    insert_figure($n,rotate($figures['']),$grid);
}
if (isset($_POST['move_down'])) {
    $grid = move_one_row_down($grid);
}

function start_new_game()
{
    session_destroy();
}

// afiseaza din nou
function update_screen($grid){    
    for($row = 4; $row <= 23; $row++){
        for($cell = 0; $cell <= 9; $cell++){
            if ($grid[$row][$cell] == 0){
                $grid[$row][$cell] ="<div class='empty cell'></div>";
            }
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] ="<div class='active cell'></div>";
            }
            if ($grid[$row][$cell] == 2) {
                $grid[$row][$cell] ="<div class='frozen cell'></div>";
            }
            print $grid[$row][$cell];
        }
        print "<br>";
    }    
    return $grid;
}

function move_one_row_down($grid){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row + 1][$cell] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;
            }
        }
    }
    return $grid;
}

// verifica daca treb oprita
function check_collision($figures,$grid)
{
    $figure_id = rand(0, count($figures)-1);

    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if (($grid[$row][$cell] == 1) && $row == 23) {
                $grid = freeze_figure($grid);
                $grid = insert_figure($figure_id, $figures, $grid);
            } elseif ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 2) ) {
                $grid = freeze_figure($grid);
                $grid = insert_figure($figure_id, $figures, $grid);
            }            
        }        
    }
    return $grid;
}

function freeze_figure($grid)
{
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] = 2;
            }
        }
    }
    return $grid;
}

function insert_figure($n,$figures,$grid)
{
    for ($r=0; $r<=4; $r++) {
        for ($c = 0; $c <= 4; $c++) {
            $grid[$r][$c] = $figures[$n][$r][$c];
        }
    }
    return $grid;
}

function move_right($grid){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 8; $cell >= 0; $cell--) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell + 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;
            }
        }        
    }
    return $grid;
}

function move_left($grid)
{
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 8; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell - 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;
            }
        }        
    }
    return $grid;
}

function rotate($figures)
{
    $matrix = array_values($figures);
    $matrix90 = array();

    // make each new row = reversed old column
    foreach (array_keys($matrix[0]) as $column) {
        $matrix90[] = array_reverse(array_column($matrix, $column));
    }
    $figures = $matrix90;
    return $figures;
}



$grid = move_one_row_down($grid);
$grid = check_collision($figures,$grid);

$_SESSION['tetris'] = $grid;
print "<body>";
print "<div class='tetris-container'>";
    update_screen($grid);
print "</div>";

// move left
// rotate
// verificare border stanga dreapta
?>

    <div class="button-container">
        <form method="post">
            <input type="submit" name="start_new_game" value="Start New Game" />
        </form>
        <form method="post">
            <input type="submit" name="move_right" value="Move Right" />
        </form>
        <form method="post">
            <input type="submit" name="move_left" value="Move Left" />
        </form>
        <form method="post">
            <input type="submit" name="rotate" value="Rotate" />
            <input type="submit" name="figure_id" value = "<?php print $figure_id ?>"/>
        </form>
        <form method="post">
            <input type="submit" name="move_down" value="Move Down" />
        </form>
    </div>

</body>


</html>


<script>
    document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
		if(keyCode == 97)
        {
            //Press 1
            echo "Call php function on onclick event.";

        }
		if(keyCode == 98)
        {
            //Press 2
            document.update_gender_match.submit();
        }       
    }
</script>
