<?php
namespace Game;

class Board
{
    private $layout = null;

    public function __construct()
    {
        $this->generateLayout(4, 4);

    }//end __construct()

    final public function &layout($updatedLayout=null)
    {
        if (isset($updatedLayout)) {
            $this->layout = $updatedLayout;
        }

        return $this->layout;
    }

    private function generateLayout($noOfRows, $noOfColumns)
    {
        $this->layout = array_fill(0, $noOfRows, array_fill(0, $noOfColumns, null));

    }//end generateLayout()


    final public function resizeLayout($size)
    {
        if (preg_match('/^[0-9]{1,2}x[0-9]{1,2}$/', $size) == false) {
            throw new \Exception("Invalid size. Please follow the example '5x5'.");
        }

        list($noOfRows, $noOfColumns) = explode("x", $size);

        if ($noOfRows > 10 or $noOfColumns > 10) {
            throw new \Exception("Size cannot be greater than '10x10'.");
        }

        $this->generateLayout($noOfRows, $noOfColumns);

    }//end resizeLayout()


}//end class
