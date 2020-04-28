<?php
/*
 * Arsors.GlobalContent is written by Marvin Schieler
 * © 2020 until today
 *
 * The following people improved this package:
 * - Here could be your name
 *
 * */

namespace Arsors\GlobalContent\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages\Message;
use Neos\Flow\Mvc\Controller\ActionController;
use Arsors\GlobalContent\Domain\Model\GlobalContent;
use Arsors\GlobalContent\Domain\Repository\GlobalContentRepository;
use Neos\Flow\Persistence\PersistenceManagerInterface;

class GlobalContentController extends ActionController
{
    /**
     * @Flow\Inject
     * @var GlobalContentRepository
     */
    protected $GlobalContentRepository;

    /**
     * @Flow\Inject
     * @var PersistenceManagerInterface
     */
    protected $persistenceManager;

    /**
     * @var array
     */
    protected $settings;

    /**
     * Inject the settings
     *
     * @param array $settings
     * @return void
     */
    public function injectSettings(array $settings) {
        $this->settings = $settings;
    }


    /**
     * @return void
     */
    public function indexAction(String $dimension = null)
    {
        // Set variables
        $dimension = $dimension ? $dimension : "";

        // Sort by gcOrder
        $this->GlobalContentRepository->setDefaultOrderings(
            array('gcOrder' => \Neos\Flow\Persistence\QueryInterface::ORDER_ASCENDING)
        );

        // findByGcDimension Global Content
        $allContent = $this->GlobalContentRepository->findByGcDimension($dimension);
        $this->view->assign('globalContent', $allContent);

        // Generate dimension menu
        $dimensionMenuAll = $this->GlobalContentRepository->findAll();
        $dimensionMenu = [];
        foreach ($dimensionMenuAll as $dimensionItem) {
            if (
                !in_array($dimensionItem->getGcDimension(), $dimensionMenu) &&
                $dimensionItem->getGcDimension() != ""
            ) $dimensionMenu[]= $dimensionItem->getGcDimension();
        }

        if (count($dimensionMenu) > 0) {
            $dimensionMenu = array_merge([""], $dimensionMenu);
            $this->view->assign('dimensionMenu', $dimensionMenu);
            $this->view->assign('currentDimension', $dimension);
        }
    }

    public function createAction(Array $content) {
        // Slugify gcKey
        $content['gcKey'] = $this->slugify($content['gcKey']);
        // Check if key doesn't exists (depending on gcDimension)
        $dbContent = $this->GlobalContentRepository->findByGcKey($content['gcKey']);
        $error = false;
        if (count($dbContent) !== 0) {
            foreach ($dbContent as $dbItem) {
                if ($dbItem->getGcDimension() === $content['gcDimension']) $error = true;
            }
        }
        // Create Item or send Error Message
        if (!$error) $this->createItemAction($content);
        else $this->addFlashMessage('The key "%s" already exists.', 'Global content created', Message::SEVERITY_WARNING, [htmlspecialchars($content['gcKey'])]);
        $this->redirect('index', NULL, NULL, array('dimension' => $content['gcDimension']));
    }

    public function createItemAction(Array $content) {
        // Iterate all to get the highest gcOrder index
        $gcAll = $this->GlobalContentRepository->findAll();
        $gcOrder = 0;
        foreach ( $gcAll as $item) {
            $index = intval($item->getGcOrder());
            if ($gcOrder < $index) $gcOrder = $index;
        }
        // Create object
        $globalContent = new GlobalContent();
        $globalContent->setGcKey( $content['gcKey'] );
        $globalContent->setGcValue( '' );
        $globalContent->setGcType( $content['gcType'] );
        $globalContent->setGcOrder( $gcOrder + 1 );
        $globalContent->setGcDimension( $content['gcDimension'] );
        // Write object
        $this->GlobalContentRepository->add($globalContent);
        $this->persistenceManager->persistAll();
        // Message and redirect
        $this->addFlashMessage('Your global content was created.', 'Global content created', Message::SEVERITY_OK);
    }

    public function updateAction(Array $globalContent) {
        // Loop through all fields
        foreach ($globalContent as $gc) {
            // Set variables
            $identity = $gc['__identity'];
            $value = $gc['gcValue'];
            // Get current context
            $currentGc = $this->GlobalContentRepository->findByIdentifier($identity);
            // Update object
            $currentGc->setGcValue($value);
            $this->GlobalContentRepository->update($currentGc);
            $this->persistenceManager->persistAll();
        }
        // Message and redirect
        $this->addFlashMessage('Your global content was updated.', 'Global content updated', Message::SEVERITY_OK);
        $this->redirect('index', NULL, NULL, array('dimension' => $globalContent[0]['gcDimension']));
    }

    public function removeAction(Array $identity, String $dimension) {
        // Set variables
        $identity = $identity['__identity'];
        // Get current context
        $currentGc = $this->GlobalContentRepository->findByIdentifier($identity);
        // Remove object
        $this->GlobalContentRepository->remove($currentGc);
        $this->persistenceManager->persistAll();
        // Message and redirect
        $this->addFlashMessage('The content with the key "%s" has been deleted.', 'User deleted', Message::SEVERITY_NOTICE, [htmlspecialchars($currentGc->getGcKey())], 1412374546);
        $this->redirect('index', NULL, NULL, array('dimension' => $dimension));
    }

    /**
     * @param string $gcList
     */
    public function reorderAction($gcList) {
        $gcList = json_decode($gcList, true);

        foreach ($gcList as $item) {
            // Update object
            $currentGc = $this->GlobalContentRepository->findByIdentifier($item[1]);
            $currentGc->setGcOrder($item[0]);
            $this->GlobalContentRepository->update($currentGc);
            $this->persistenceManager->persistAll();
        }

        return 'reordered!';
    }

    public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
