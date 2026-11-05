<?php

function createBoard() {
    return array_fill(0, 6, array_fill(0, 7, 0));
}

function initializeGame() {
    return [
        'board' => createBoard(),
        'current_player' => 1,
        'game_over' => false,
        'winner' => null,
        'scores' => [
            1 => 0,
            2 => 0
        ]
    ];
}

function dropDisc(&$game, $column) {

    if ($game['game_over']) {
        return;
    }

    if ($column < 0 || $column >= 7) {
        return;
    }

    for ($row = 5; $row >= 0; $row--) {

        if ($game['board'][$row][$column] === 0) {

            $game['board'][$row][$column] = $game['current_player'];

            if (checkWin($game['board'], $row, $column)) {

                $game['game_over'] = true;
                $game['winner'] = $game['current_player'];

                $game['scores'][$game['current_player']]++;

            } elseif (isDraw($game['board'])) {

                $game['game_over'] = true;

            } else {

                $game['current_player'] =
                    $game['current_player'] === 1 ? 2 : 1;
            }

            return;
        }
    }
}

function isDraw($board) {

    foreach ($board[0] as $cell) {

        if ($cell === 0) {
            return false;
        }
    }

    return true;
}