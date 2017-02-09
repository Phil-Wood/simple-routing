<?php
namespace App\Core;

class Helper {
	/**
     * Call this method to get singleton
     *
     * @return Helper
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Helper();
        }
        return $inst;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct() {}

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {}

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {}

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup() {}

    public static function raw($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}