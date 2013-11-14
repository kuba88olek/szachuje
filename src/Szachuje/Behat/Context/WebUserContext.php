<?php

namespace Szachuje\Behat\Context;

use Behat\Behat\Exception\BehaviorException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Gherkin\Node\TableNode;

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
     * @Given /^nie powinno być widoczne logo firmy$/
     */
    public function logoFirmySzachujeNiePowinnoBycWidoczne()
    {
        expect($this->getElement('Header')->hasLogo('mobile'))->toBe(false);
    }

    /**
     * @Given /^powinienem w nagłówku zobaczyć logo firmy Szachuje$/
     */
    public function powinienemWNaglowkuZobaczycLogoFirmySzachuje()
    {
        $this->getElement('Header')->hasLogo('pc');
    }

    /**
     * @Given /^w nagłówku powinienem widzieć menu serwisu zawierające następujące elementy$/
     */
    public function wNaglowkuPowinienemWidziecMenuSerwisuZawierajaceNastepujaceElementy(TableNode $table)
    {
        foreach ($table->getHash() as $elementRow) {
            expect($this->getElement('Header')->hasMenuElement($elementRow['Nazwa']))->toBe(true);
        }
    }

    /**
     * @Given /^powinienem zobaczyć stopkę$/
     */
    public function powinienemZobaczycStopke()
    {
        $this->getElement('Footer')->getHtml();
    }

    /**
     * @Given /^stopka powinna zawierać element "([^"]*)" z danymi kontaktowymi firmy$/
     */
    public function stopkaPowinnaZawieracElementZDanymiKontaktowymiFirmy($title)
    {
        $this->getElement('Footer')->hasContactTitleElement($title);
    }

    /**
     * @Given /^dane kontaktowe w stopce powinny zawierać następujące elementy$/
     */
    public function daneKontaktoweWStopcePowinnyZawieracNastepujaceElementy(TableNode $table)
    {
        foreach ($table->getHash() as $elementRow) {
            expect($this->getElement('Footer')->hasDetails($elementRow['Treść']))->toBe(true);
        }
    }

    /**
     * @Given /^w stopce powinno znajdować się menu z pozycjami$/
     */
    public function wStopcePowinnoZnajdowacSieMenuZPozycjami(TableNode $table)
    {
        foreach ($table->getHash() as $elementRow) {
            expect($this->getElement('Footer')->hasMenuElement($elementRow['Nazwa']))->toBe(true);
        }
    }

    /**
     * @Given /^w stopce nie powinno być widoczne menu$/
     */
    public function wStopceNiePowinnoBycWidoczneMenu()
    {
        expect($this->getElement('Footer')->isMenuVisible('mobile'))->toBe(false);
    }
}
