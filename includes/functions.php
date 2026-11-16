<?php

function countDirection($board, $row, $column, $rowStep, $columnStep, $player) {

    $count = 0;

    $row += $rowStep;
    $column += $columnStep;

    while (
        $row >= 0 &&
        $row < 6 &&
        $column >= 0 &&
        $column < 7 &&
        $board[$row][$column] === $player
    ) {

        $count++;

        $row += $rowStep;
        $column += $columnStep;
    }

    return $count;
}

function checkWin($board, $row, $column) {

    $player = $board[$row][$column];

    $directions = [
        [0, 1],
        [1, 0],
        [1, 1],
        [1, -1]
    ];

    foreach ($directions as $direction) {

        $rowStep = $direction[0];
        $columnStep = $direction[1];

        $count = 1;

        $count += countDirection(
            $board,
            $row,
            $column,
            $rowStep,
            $columnStep,
            $player
        );

        $count += countDirection(
            $board,
            $row,
            $column,
            -$rowStep,
            -$columnStep,
            $player
        );

        if ($count >= 4) {
            return true;
        }
    }

    return false;
}