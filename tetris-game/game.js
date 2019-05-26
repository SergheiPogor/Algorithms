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
// afiseaza din nou
function update_screen(){
    //document.body.innerHTML = '';
    $html = '';
    for($row = 4; $row <= 23; $row++){
        for($cell = 0; $cell <= 9; $cell++){
            // document.write($grid[$row][$cell]);
            if ($grid[$row][$cell] == 0){
                $html+="<span>&#9634;</span>";
            }
            if ($grid[$row][$cell] == 1) {
                $html+="<span>&#9640;</span>";
            }
            if ($grid[$row][$cell] == 2) {
                $html+="<span class='frozen'>&#9635;</span>";
            }
        }
        $html+="<br>";
    }
    document.body.innerHTML = $html;
}

function move_one_row_down(){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row + 1][$cell] = $grid[$row][$cell]
                $grid[$row][$cell] = 0;
            }
        }
        document.write("<br>");
    }
}

// verifica daca treb oprita
function check_collision(){
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if (($grid[$row][$cell] == 1) && $row == 23) {
                freeze_figure();
                insert_figure(parseInt(3*Math.random()));    
            } else if ( ($grid[$row][$cell] == 1) && ($grid[$row + 1][$cell] == 2) ){
                freeze_figure();
                insert_figure(parseInt(3 * Math.random()));
            }
        }
        document.write("<br>");
    }  
}

function freeze_figure() {
    for ($row = 23; $row >= 0; $row--) {
        for ($cell = 0; $cell <= 9; $cell++) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell] = 2;
            }
        }
        document.write("<br>");
    }
}

function insert_figure($n){
    for($r=0; $r<=2; $r++){
        for ($c = 0; $c <= 2; $c++) {
            $grid[$r][$c] = $figures[$n][$r][$c];
        }
    }
}
function move_right(){
    for ($row = 22; $row >= 0; $row--) {
        for ($cell = 8; $cell >= 0; $cell--) {
            if ($grid[$row][$cell] == 1) {
                $grid[$row][$cell + 1] = $grid[$row][$cell]
                $grid[$row][$cell] = 0;
            }
        }
        document.write("<br>");
    }
}

function action(){
    alert( event.keyCode)
    if (event.keyCode == 39) {
        move_right();
        
    }

}
insert_figure(0);

update_screen();
setInterval(function(){
    move_one_row_down();
    check_collision();
    update_screen();
}, 100);


// move left
// rotate
// verificare border stanga dreapta