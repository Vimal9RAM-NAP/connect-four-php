<?php

session_start();

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/game.php';


if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = initializeGame();
}

$game = &$_SESSION['game'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['column'])) {

        $column = filter_var(
            $_POST['column'],
            FILTER_VALIDATE_INT
        );

        if ($column !== false) {
            dropDisc($game, $column);
        }
    }

    
    if (isset($_POST['restart'])) {

        $scores = $game['scores'];

        $game = initializeGame();
        $game['scores'] = $scores;
    }

    
    if (isset($_POST['reset'])) {
        $game = initializeGame();
    }

    
    header('Location: index.php');
    exit;
}

$board = $game['board'];
$currentPlayer = $game['current_player'];
$winner = $game['winner'];
$gameOver = $game['game_over'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Connect Four</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<main class="container">

    <header>
        <p class="subtitle">THE CLASSIC STRATEGY GAME</p>

        <h1>CONNECT <span>FOUR</span></h1>

        <p class="description">
            Four in a row. One winner.
        </p>
    </header>


    

    <section class="scoreboard">

        <div class="player red-player">

            <div class="player-info">
                <span class="disc red"></span>

                <div>
                    <h3>Player 1</h3>
                    <p>RED</p>
                </div>
            </div>

            <strong>
                <?= $game['scores'][1] ?>
            </strong>

        </div>


        <div class="player yellow-player">

            <div class="player-info">
                <span class="disc yellow"></span>

                <div>
                    <h3>Player 2</h3>
                    <p>YELLOW</p>
                </div>
            </div>

            <strong>
                <?= $game['scores'][2] ?>
            </strong>

        </div>

    </section>


    

    <div class="status">

        <?php if ($winner !== null): ?>

            <h2>
                <?= $winner === 1 ? 'Player 1' : 'Player 2' ?>
                Wins!
            </h2>

        <?php elseif ($gameOver): ?>

            <h2>It's a Draw!</h2>

        <?php else: ?>

            <h2>
                <?= $currentPlayer === 1 ? 'Player 1' : 'Player 2' ?>'s Turn
            </h2>

        <?php endif; ?>

    </div>


    

    <section class="game-area">

        

        <div class="column-controls">

            <?php for ($col = 0; $col < 7; $col++): ?>

                <form method="POST">

                    <button
                        type="submit"
                        name="column"
                        value="<?= $col ?>"
                        <?= $gameOver || $board[0][$col] !== 0 ? 'disabled' : '' ?>
                    >
                        ↓
                    </button>

                </form>

            <?php endfor; ?>

        </div>


        

        <div class="board">

            <?php for ($row = 0; $row < 6; $row++): ?>

                <?php for ($col = 0; $col < 7; $col++): ?>

                    <?php $cell = $board[$row][$col]; ?>

                    <div class="cell">

                        <div class="slot
                            <?= $cell === 1 ? 'red' : '' ?>
                            <?= $cell === 2 ? 'yellow' : '' ?>">
                        </div>

                    </div>

                <?php endfor; ?>

            <?php endfor; ?>

        </div>

    </section>


    

    <div class="controls">

        <form method="POST">

            <button type="submit" name="restart" class="restart">
                Restart Game
            </button>

        </form>


        <form method="POST">

            <button type="submit" name="reset" class="reset">
                Reset Scores
            </button>

        </form>

    </div>


    <footer>
        BUILT WITH PHP · HTML · CSS
    </footer>

</main>

</body>
</html>