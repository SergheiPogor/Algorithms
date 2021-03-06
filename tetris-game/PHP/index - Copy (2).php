<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Document</title>
        <!-- <meta http-equiv="refresh" content="1"> -->
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
        [4, 4, 4, 4],
        [1, 1, 4, 4],
        [4, 1, 4, 4],
        [4, 1, 4, 4],
    ],
    [
        [4, 4, 4, 4],
        [1, 1, 4, 4],
        [1, 4, 4, 4],
        [1, 4, 4, 4],

    ],
];


$grid = [
    // 4 randuri in afara ecranului
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    // 
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
];

if (empty($_SESSION['tetris'])) {
   
    $figure_id = rand(0, count($figures)-1);
    $grid = insert_figure($figure_id, $figures, $grid);
}

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

    //insert_figure($figure_id,rotate($figures,$figure_id),$grid);
    $grid = rotate($grid);

}

function start_new_game()
{
    session_destroy();
    header("location: index.php");
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

            if (($grid[$row][$cell] == 1) OR ($grid[$row][$cell] == 4)) {
               
                $grid[$row + 1][$cell] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;            

            }
           

        }
    }
    return $grid;
}

// verifica daca treb oprita
function check_collision($figures,$grid){
    $figure_id = rand(0, count($figures)-1);
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if (($grid[$row][$cell] == 1) && $row == 23) {
                $grid = freeze_figure();
                $grid = insert_figure($figure_id, $figures, $grid);

            }elseif( ($grid[$row][$cell] == 4) && ($row == 23)) {
                //                
            }elseif( ($grid[$row][$cell] == 4) && ($grid[$row + 1][$cell] == 2) ) {
                $grid[$row + 1][$cell] = 2;
                $grid[$row][$cell] = 0;
                // $grid[$row][$cell] = $grid[$row - 1][$cell];
                
            }elseif ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 2) ) {
                $grid = freeze_figure();
                $grid = insert_figure($figure_id, $figures, $grid);
            }else{
                // print "else";
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

function insert_figure($n,$figures,$grid){
    for ($row=0; $row <= 3; $row++) {
        for ($cell = 0; $cell <= 3; $cell++) {
            $grid[$row][$cell + 3] = $figures[$n][$row][$cell];
            // var_dump($grid);
        }
    }
    return $grid;
}

function move_right(){
    global $grid;
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 11; $cell >= 0; $cell--) {

            if (($grid[$row][$cell] == 1) AND ($cell == 9)) {
                break;

            }else if (($grid[$row][$cell] == 4) AND ($cell == 11)) {
                // break;

            }elseif ((($grid[$row][$cell] == 1) OR ($grid[$row][$cell] == 4)) AND ($cell != 9)) {
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


            if ((($grid[$row][$cell] == 1) OR ($grid[$row][$cell] == 4)) AND ($cell == 0)) {
                break;
            }elseif ((($grid[$row][$cell] == 1) OR ($grid[$row][$cell] == 4)) AND ($cell != 0)) {
                $grid[$row][$cell - 1] = $grid[$row][$cell];
                $grid[$row][$cell] = 0;                               
            }

        }        
    }
    return $grid;
}

move_one_row_down();
$grid = check_collision($figures,$grid);

$_SESSION['tetris'] = $grid;

print "<body>";
print "<div class='tetris-container'>";
    update_screen();
print "</div>";
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
