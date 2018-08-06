<?php
namespace Game\GameTest;

use Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    protected $game = null;

    public function setup()
    {
        $this->game = new Game();
    }

    public function testBoardLayout()
    {
        $this->assertEquals(array_fill(0, 4, array_fill(0, 4, null)), $this->game->board->layout());
    }

    public function testInvalidBoardSizeCaseOne()
    {
        try {
            $this->game->board->resizeLayout('1X1');
        } catch (\Exception $e) {
            $this->assertEquals("Invalid size. Please follow the example '5x5'.", $e->getMessage());
        }
    }

    public function testInvalidBoardSizeCaseTwo()
    {
        try {
            $this->game->board->resizeLayout('11x1');
        } catch (\Exception $e) {
            $this->assertEquals("Size cannot be greater than '10x10'.", $e->getMessage());
        }
    }

    public function testRandomValueSetOnTile(){
        $this->game->board->resizeLayout('1x5');
        $this->game->initializeEmptyTile();
        $this->assertEquals(array(2), array_values(array_filter($this->game->board->layout()[0])));
    }

    public function testRandomValueSetOnAllTilesCaseOne(){
        $this->game->board->resizeLayout('1x5');
        array_map(function() { $this->game->initializeEmptyTile(); }, range(0,4));
        $this->assertEquals(array(array(2,2,2,2,2)), $this->game->board->layout());
    }

    public function testRandomValueSetOnAllTilesCaseTwo(){
        $this->game->board->resizeLayout('2x5');
        array_map(function() { $this->game->initializeEmptyTile(); }, range(1,10));
        $this->assertEquals(array(array(2,2,2,2,2), array(2,2,2,2,2)), $this->game->board->layout());
    }

    public function testHasWon()
    {
        $this->game->board->layout(array([2], [2], [2], [2048]));
        $this->game->swipeDown();
        $this->assertTrue($this->game->hasReachedGamePoint());
    }

    public function testNoMoreMove()
    {
        $this->game->board->layout(array([2], [4], [2], [4]));
        $this->game->initializeEmptyTile();
        $this->assertTrue($this->game->hasNoValidMove());
    }

    //Using 1x5 layout
    public function testSwipeRightCaseOne(){
        $this->game->board->layout(array(array(null, 2, null, null, null)));
        $this->game->swipeRight();
        $this->assertEquals(array(array(null,null,null,null,2)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeRightCaseTwo(){
        $this->game->board->layout(array(array(null, 2, null, 2, null)));
        $this->game->swipeRight();
        $this->assertEquals(array(array(null,null,null,null,4)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeRightCaseThree(){
        $this->game->board->layout(array(array(2, 2, null, 2, null)));
        $this->game->swipeRight();
        $this->assertEquals(array(array(null,null,null,2,4)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeRightCaseFour(){
        $this->game->board->layout(array(array(2, 2, null, 2, 2)));
        $this->game->swipeRight();
        $this->assertEquals(array(array(null,null,null,4,4)), $this->game->board->layout());
    }

    //Using 2x5 layout
    public function testSwipeRightCaseFive(){
        $this->game->board->layout(array(array(2, 2, null, 2, 2), array(2, 2, null, 2, 2)));
        $this->game->swipeRight();
        $this->assertEquals(array(array(null,null,null,4,4), array(null,null,null,4,4)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeLeftCaseOne(){
        $this->game->board->layout(array(array(null, 2, null, null, null)));
        $this->game->swipeLeft();
        $this->assertEquals(array(array(2,null,null,null,null)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeLeftCaseTwo(){
        $this->game->board->layout(array(array(null, 2, null, 2, null)));
        $this->game->swipeLeft();
        $this->assertEquals(array(array(4,null,null,null,null)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeLeftCaseThree(){
        $this->game->board->layout(array(array(2, 2, null, 2, null)));
        $this->game->swipeLeft();
        $this->assertEquals(array(array(4,2,null,null,null)), $this->game->board->layout());
    }

    //Using 1x5 layout
    public function testSwipeLeftCaseFour(){
        $this->game->board->layout(array(array(2, 2, null, 2, 2)));
        $this->game->swipeLeft();
        $this->assertEquals(array(array(4,4,null,null,null)), $this->game->board->layout());
    }

    //Using 2x5 layout
    public function testSwipeLeftCaseFive(){
        $this->game->board->layout(array(array(2, 2, null, 2, 2), array(2, 2, null, 2, 2)));
        $this->game->swipeLeft();
        $this->assertEquals(array(array(4,4,null,null,null), array(4,4,null,null,null)), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeUpCaseOne(){
        $this->game->board->layout(array([null], [2], [null], [null], [null]));
        $this->game->swipeUp();
        $this->assertEquals(array([2], [null], [null], [null], [null]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeUpCaseTwo(){
        $this->game->board->layout(array([null], [2], [null], [2], [null]));
        $this->game->swipeUp();
        $this->assertEquals(array([4], [null], [null], [null], [null]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeUpCaseThree(){
        $this->game->board->layout(array([null], [2], [null], [2], [2]));
        $this->game->swipeUp();
        $this->assertEquals(array([4], [2], [null], [null], [null]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeUpCaseFour(){
        $this->game->board->layout(array([2], [2], [null], [2], [2]));
        $this->game->swipeUp();
        $this->assertEquals(array([4], [4], [null], [null], [null]), $this->game->board->layout());
    }

    //Using 5x2 layout
    public function testSwipeUpCaseFive(){
        $this->game->board->layout(array([2,2], [2,2], [null,null], [2,2], [2,2]));
        $this->game->swipeUp();
        $this->assertEquals(array([4,4], [4,4], [null,null], [null,null], [null,null]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeDownCaseOne(){
        $this->game->board->layout(array([null], [2], [null], [null], [null]));
        $this->game->swipeDown();
        $this->assertEquals(array([null], [null], [null], [null], [2]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeDownCaseTwo(){
        $this->game->board->layout(array([null], [2], [null], [2], [null]));
        $this->game->swipeDown();
        $this->assertEquals(array([null], [null], [null], [null], [4]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeDownCaseThree(){
        $this->game->board->layout(array([null], [2], [null], [2], [2]));
        $this->game->swipeDown();
        $this->assertEquals(array([null], [null], [null], [2], [4]), $this->game->board->layout());
    }

    //Using 5x1 layout
    public function testSwipeDownCaseFour(){
        $this->game->board->layout(array([2], [2], [null], [2], [2]));
        $this->game->swipeDown();
        $this->assertEquals(array([null], [null], [null], [4], [4]), $this->game->board->layout());
    }

    //Using 5x2 layout
    public function testSwipeDownCaseFive(){
        $this->game->board->layout(array([2,2], [2,2], [null,null], [2,2], [2,2]));
        $this->game->swipeDown();
        $this->assertEquals(array([null,null], [null,null], [null,null], [4,4], [4,4]), $this->game->board->layout());
    }
}
?>
