<?php
/*
 * Arsors.GlobalContent is written by Marvin Schieler
 * © 2020 until today
 *
 * The following people improved this package:
 * - Here could be your name
 *
 * */

namespace Arsors\GlobalContent\Eel\Helper;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Arsors\GlobalContent\Domain\Repository\GlobalContentRepository;

class globalContent implements ProtectedContextAwareInterface {

    /**
     * @Flow\Inject
     * @var GlobalContentRepository
     */
    protected $GlobalContentRepository;

    /**
    * Wrap the incoming string in curly brackets
    *
    * @param $key string
    * @return string
    */
    public function get($key, $dimension = null) {
        if (!$dimension) $dimension = "";
        $fallback = false;
        $globalContent = new GlobalContentRepository();
        $results = $globalContent->findByGcKey($key);

        if (count($results) > 0) {
            // found by key
            foreach ($results as $result) {
                if ($result->getGcDimension() === "") {
                    $fallback = $result->getGcValue();
                }
                if ($result->getGcDimension() === $dimension) {
                    return $result->getGcValue();
                }
            }
            if ($fallback) return $fallback;
            else return "Can't find a fallback key like \"".$key."\". Add this key for your default dimension.";
        }

        // found nothing
        return "Can't find a key like \"".$key."\".";
    }

    /**
    * All methods are considered safe, i.e. can be executed from within Eel
    *
    * @param string $methodName
    * @return boolean
    */
    public function allowsCallOfMethod($methodName) {
        return true;
    }
}
