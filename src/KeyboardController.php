<?php
namespace Game;

use \Iber\Phkey\Events\KeyPressEvent;
use \Iber\Phkey\Environment\Detector;

class KeyboardController
{


    private static function executeKeyHandler($key, $eventDispatcher)
    {
        switch ($key) {
        case 'right':
            Game::instance()->swipeRight();
            Game::instance()->render();
            break;
        case 'left':
            Game::instance()->swipeLeft();
            Game::instance()->render();
            break;
        case 'up':
            Game::instance()->swipeUp();
            Game::instance()->render();
            break;
        case 'down':
            Game::instance()->swipeDown();
            Game::instance()->render();
            break;
        case 'escape':
            $eventDispatcher->addListener(
                'key:escape',
                function (KeyPressEvent $event) use ($eventDispatcher) {
                    echo 'ESC key was pressed. Quitting game.'. PHP_EOL;
                    $eventDispatcher->dispatch('key:stop:listening');
                }
            );
            break;
        default:
            echo "Invalid key pressed. Use 'arrow keys' for direction and 'ESC' to exit.".PHP_EOL;
            break;
        }//end switch

    }//end executeKeyHandler()


    final public static function listen()
    {
        $detect          = new Detector();
        $listener        = $detect->getListenerInstance();
        $eventDispatcher = $listener->getEventDispatcher();

        $eventDispatcher->addListener(
            'key:press',
            function (KeyPressEvent $event) {
                self::executeKeyHandler($event->getKey(), $event->getDispatcher());
            }
        );

        $listener->start();

    }//end listen()


}//end class
