<?php

namespace Szachuje\Behat\Context;

use Behat\Behat\Exception\BehaviorException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Exception\PendingException;

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

    /**
     * @Given /^w nagłówku element menu "([^"]*)" powininen być elementem aktywnym$/
     */
    public function wNaglowkuElementMenuPowininenBycElementemAktywnym($menuElement)
    {
        expect($this->getPage('Strona Glowna')->isHeaderMenuElementActive($menuElement))->toBe(true);
    }

    /**
     * @Given /^element menu "([^"]*)" w stopce powinien być aktywny$/
     */
    public function elementMenuWStopcePowinienBycAktywny($menuElement)
    {
        expect($this->getPage('Strona Glowna')->isFooterMenuElementActive($menuElement))->toBe(true);
    }

    /**
     * @Given /^powinienem zobaczyć nagłówek "([^"]*)"$/
     */
    public function powinienemZobaczycNaglowek($headerText)
    {
        expect($this->getPage('Strona Glowna')->hasHeaderText($headerText))->toBe(true);
    }

    /**
     * @Given /^powinienem zobaczyć tekst powitalny$/
     */
    public function powinienemZobaczycTekstPowitalny()
    {
        expect($this->getPage('Strona Glowna')->hasWelcomeContent())->toBe(true);
    }

    /**
     * @Given /^powinienem widzieć grafikę przedstawiąjącą działalność firmy$/
     */
    public function powinienemWidziecGrafikePrzedstawiajacaDzialalnoscFirmy()
    {
        expect($this->getPage('Strona Glowna')->isImageVisible('pc'))->toBe(true);
    }

    /**
     * @Given /^powinienem zobaczyć dział "([^"]*)" z najnowszymi aktualnościami$/
     */
    public function powinienemZobaczycDzialZNajnowszymiAktualnosciami($title)
    {
        expect($this->getPage('Strona Glowna')->hasHeaderText($title))->toBe(true);
    }

    /**
     * @Given /^powinien być również widoczny tekst$/
     */
    public function powinienBycRowniezWidocznyTekst(PyStringNode $content)
    {
        expect($this->getPage('Strona Glowna')->getSecondText())->toBe((string) $content);
    }

    /**
     * @Given /^nie powinienem widzieć grafiki przedstawiąjącą działalność firmy$/
     */
    public function niePowinienemWidziecGrafikiPrzedstawiajacaDzialalnoscFirmy()
    {
        expect($this->getPage('Strona Glowna')->isImageVisible('mobile'))->toBe(false);
    }

    /**
     * @Given /^że mam w bazie następujące aktualności$/
     */
    public function zeMamWBazieNastepujaceAktualnosci(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given /^otworzyłem "([^"]*)" serwisu$/
     */
    public function otworzylemSerwisu($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^w dziale aktualności powinienem zobaczyć "([^"]*)" najnowsze wpisy z następującymi elementami$/
     */
    public function wDzialeAktualnosciPowinienemZobaczycNajnowszeWpisyZNastepujacymiElementami($arg1, TableNode $table)
    {
        throw new PendingException();
    }

}
