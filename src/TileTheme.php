<?php
namespace Game;

use Colors\Color;

class TileTheme
{


    private static function getTheme($text)
    {
        $theme = array(
                  '2'    => array(
                             'fg' => 'white',
                             'bg' => 'green',
                            ),
                  '4'    => array(
                             'fg' => 'black',
                             'bg' => 'light_green',
                            ),
                  '8'    => array(
                             'fg' => 'white',
                             'bg' => 'yellow',
                            ),
                  '16'   => array(
                             'fg' => 'black',
                             'bg' => 'light_yellow',
                            ),
                  '32'   => array(
                             'fg' => 'white',
                             'bg' => 'blue',
                            ),
                  '64'   => array(
                             'fg' => 'black',
                             'bg' => 'light_blue',
                            ),
                  '128'  => array(
                             'fg' => 'white',
                             'bg' => 'magenta',
                            ),
                  '256'  => array(
                             'fg' => 'black',
                             'bg' => 'light_magenta',
                            ),
                  '512'  => array(
                             'fg' => 'white',
                             'bg' => 'cyan',
                            ),
                  '1024' => array(
                             'fg' => 'black',
                             'bg' => 'light_cyan',
                            ),
                  '2048' => array(
                             'fg' => 'black',
                             'bg' => 'red',
                            ),
                  '0'    => array(
                             'fg' => 'dark_gray',
                             'bg' => 'dark_gray',
                            ),
                 );

        return $theme[$text];

    }//end getTheme()


    public static function apply($text)
    {
        $theme = self::getTheme(trim($text));
        return (new Color($text))->fg($theme['fg'])->highlight($theme['bg']);

    }//end apply()


}//end class
