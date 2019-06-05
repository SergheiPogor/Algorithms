
<?php

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



    $new = [];
    $new2 = [];

    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $new[$row][$cell] = 1;
                
                array_push($new2,[$row,$cell]);


            } else {
                $new[$row][$cell] = 0;
            }
        }
    }



    print_r($new2);
    
    for($row = 0; $row <= 23; $row++){
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 0) {
                print "<div class='empty cell'></div>";
            }
            if ($grid[$row][$cell] == 1) {
                print "<div class='active cell'></div>";
            }
            if ($grid[$row][$cell] == 2) {
                print "<div class='frozen cell'></div>";
            }

        }
        print "<br>";
    }

    print "<hr>";

    for($row = 0; $row <= 23; $row++){
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($new[$row][$cell] == 0) {
                print "<div class='empty cell'></div>";
            }
            if ($new[$row][$cell] == 1) {
                print "<div class='active cell'></div>";
            }
            if ($new[$row][$cell] == 2) {
                print "<div class='frozen cell'></div>";
            }

        }
        print "<br>";
    }


    ?>

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