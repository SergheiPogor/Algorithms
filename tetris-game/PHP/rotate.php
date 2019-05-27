
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

print_r (rotate($figures['0']));
