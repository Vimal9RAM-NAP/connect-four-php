<?php

session_start();

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/game.php';

if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = initializeGame();
}

$game = &$_SESSION['game'];

if (isset($_POST['restart'])) {

    $scores = $game['scores'];

    $game = initializeGame();
    $game['scores'] = $scores;
}