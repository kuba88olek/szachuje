<?php

namespace Szachuje\Behat\Context;

use Behat\Behat\Exception\BehaviorException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class WebUserContext extends PageObjectContext implements MinkAwareInterface
{
    /**
     * @var Mink
     */
    protected $mink;

    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    public function setMinkParameters(array $parameters)
    {
    }

    /**
     * @Given /^że otworzyłem "([^"]*)" serwisu$/
     */
    public function zeOtworzylemSerwisu($pageName)
    {
        switch ($pageName) {
            case 'Stronę główną':
                $this->getPage('Strona Glowna')->open();
                break;
            default:
                throw new BehaviorException(sprintf("Cant open page %s", $pageName));
                break;
        }
    }

    /**
     * @Given /^na karcie w przeglądarce powinienem zobaczyć następujący tytuł$/
     */
    public function naKarcieWPrzegladarcePowinienemZobaczycNastepujacyTytul(PyStringNode $seoTitle)
    {
        expect($this->mink->getSession()->getPage()->find('css', 'title')->getText())->toBe((string) $seoTitle);
    }

    /**
     * @Given /^logo firmy Szachuje nie powinno być widoczne$/
     */
    public function logoFirmySzachujeNiePowinnoBycWidoczne()
    {
        expect($this->mink->getSession()->getPage()->find('css', '#logo')->isVisible())->toBe(false);
    }
}