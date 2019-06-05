
<?php


$figures = [
    [
        [1, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0],
    ],
   
];

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

function rotate($n, $figures)
{
    $figures_90deg = array();
     
    foreach ($figures[$n] as $row => $columns) {
        foreach ($columns as $row2 => $column2) {
            $figures_90deg[$row2][$row] = $column2;
        }
    }
    # code...
    
    print_r($figures[$n]);
    print "<hr>";
    print_r($figures_90deg);

    $figures = $figures_90deg;
    return $figures;
}

print_r (rotate($figures['0']));
