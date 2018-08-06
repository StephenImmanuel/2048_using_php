<?php
namespace Game;

class Game
{
    CONST GAME_POINT = 2048;
    
    private static $instance = null;
    private $reachedGamePoint = false;
    private $gameStartTime = null;
    private $noMoreMove = false;

    public function __construct()
    {
        $this->board    = new Board();
        self::$instance = $this;
        $this->gameStartTime = date('H:i:s');
    }//end __construct()


    final public function instance()
    {
        return self::$instance;

    }//end instance()

    final public function initializeEmptyTile()
    {
        foreach ($this->board->layout() as $rowPosition => $row) {
            foreach ($row as $colPosition => $tile) {
                if(is_null($tile)) {
                    $emptyCells[$rowPosition][] = $colPosition;
                }
            }
        }

        if (empty($emptyCells)) {
            $this->noMoreMove = true;
        } else {
            $randomRow    = array_rand($emptyCells, 1);
            $randomColumn = array_rand(array_flip($emptyCells[$randomRow]), 1);
            $this->board->layout()[$randomRow][$randomColumn] = 2;
        }
    }//end initializeEmptyTile()


    final public function endGame()
    {
        echo PHP_EOL."Your are awesome!";

    }//end endGame()

    private function calculateTimeFromStart()
    {
        $start = new \DateTime($this->gameStartTime);
        $end = new \DateTime('now');
        $diff = $start->diff($end);
        return sprintf("%d Hours %d Minutes and %d Seconds", $diff->format('%h'), $diff->format('%i'), $diff->format('%s'));
    }

    final public function hasReachedGamePoint()
    {
        return $this->reachedGamePoint;
    }

    final public function hasNoValidMove()
    {
        return $this->noMoreMove;
    }

    final public function render()
    {
        system('clear');
        
        $this->initializeEmptyTile();
        
        echo PHP_EOL;
        foreach($this->board->layout() as $row) {
            foreach($row as $tile) {
                echo ' '.TileTheme::apply(sprintf("%4d", $tile));
            }
            
            echo PHP_EOL.PHP_EOL;
        }

        if($this->hasNoValidMove()) {
            exit('No more valid move :(. Please try again.'.PHP_EOL);
        }

        if ($this->reachedGamePoint) {
            echo 'You Won!. You\'re incredible :)'.PHP_EOL;
            echo "You took approx. ".$this->calculateTimeFromStart().' to complete.'.PHP_EOL;
            exit;
        }

    }//end render()


    final public function mergeTiles(&$row)
    {
        foreach ($row as $index => $column) {
            if(is_null($column)) { 
                continue;
            }

            if(isset($row[($index + 1)]) and ($column == $row[($index + 1)])) {
                $row[$index] = ($column * 2);
                $row[($index + 1)] = null;
            }
        }

        if(max($row) == self::GAME_POINT) {
            $this->reachedGamePoint = true;
        }

    }//end mergeTiles()


    final public function moveTilesToRight(&$row)
    {
        $noOfElements = count($row);

        $row = array_reverse(array_values(array_filter($row)));
        $this->mergeTiles($row);
        $row = array_pad(array_reverse(array_filter($row)), -$noOfElements, null);

    }//end moveTilesToRight()


    final public function moveTilesToLeft(&$row)
    {
        $noOfElements = count($row);

        $row = array_values(array_filter($row));
        $this->mergeTiles($row);
        $row = array_pad(array_filter($row), $noOfElements, null);

    }//end moveTilesToLeft()


    final public function transposeBoard()
    {
        foreach (array_keys($this->board->layout()[0]) as $colNo) {
            $updatedArray[] = array_column($this->board->layout(), $colNo);
        }

        $this->board->layout($updatedArray);

    }//end transposeBoard()


    final public function swipeRight()
    {
        foreach($this->board->layout() as &$row) {
            $this->moveTilesToRight($row);
        }

    }//end swipeRight()


    final public function swipeLeft()
    {
        foreach($this->board->layout() as &$row) {
            $this->moveTilesToLeft($row);
        }

    }//end swipeLeft()


    final public function swipeDown()
    {
        $this->transposeBoard();
        $this->swipeRight();
        $this->transposeBoard();

    }//end swipeDown()


    final public function swipeUp()
    {
        $this->transposeBoard();
        $this->swipeLeft();
        $this->transposeBoard();

    }//end swipeUp()


    final public function play()
    {
        $this->render();
        KeyboardController::listen();

    }//end play()


}//end class
