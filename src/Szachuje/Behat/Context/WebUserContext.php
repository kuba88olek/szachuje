<?php

namespace Szachuje\Behat\Context;

use Behat\Behat\Context\Step\Given;
use Behat\Behat\Exception\BehaviorException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Tools\SchemaTool;
use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Szachuje\WebBundle\Entity\News;

class WebUserContext extends PageObjectContext implements KernelAwareInterface, MinkAwareInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var Mink
     */
    protected $mink;

    /**
     * @var array
     */
    protected $minkParameters;

    public function getDoctrineManager()
    {
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @BeforeScenario @db
     */
    public function createDatabase()
    {
        $this->dropDatabase();

        $manager = $this->getDoctrineManager();
        $metadata = $manager->getMetadataFactory()->getAllMetadata();
        $tool = new SchemaTool($manager);
        $tool->createSchema($metadata);
    }

    /**
     * @AfterScenario @db
     */
    public function dropDatabase()
    {
        $manager = $this->getDoctrineManager();
        $tool = new SchemaTool($manager);
        $tool->dropDatabase();
    }

    /**
     * @AfterScenario @clearcache
     */
    public function clearCache()
    {
        $cacheDir = $this->kernel->getCacheDir();

        if (empty($cacheDir) || !is_dir($cacheDir)) {
            return;
        }

        `rm -r $cacheDir`;
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }

    /**
     * @Given /^że otworzyłem "([^"]*)" serwisu$/
     * @Given /^że otworzyłem stronę "([^"]*)"$/
     */
    public function zeOtworzylemSerwisu($pageName)
    {
        switch ($pageName) {
            case 'Stronę główną':
                $this->getPage('Strona Glowna')->open();
                break;
            case 'Kontakt':
                $this->getPage('Kontakt')->open();
                break;
            default:
                throw new BehaviorException(sprintf("Cant open page %s", $pageName));
                break;
        }
    }

    /**
     * @Given /^że otworzyłem dowolną stronę serwisu$/
     */
    public function zeOtworzylemDowolnaStroneSerwisu()
    {
        return new Given('że otworzyłem "Stronę główną" serwisu');
    }

    /**
     * @Given /^na karcie w przeglądarce powinienem zobaczyć następujący tytuł$/
     */
    public function naKarcieWPrzegladarcePowinienemZobaczycNastepujacyTytul(PyStringNode $seoTitle)
    {
        expect($this->mink->getSession()->getPage()->find('css', 'title')->getText())->toBe((string) $seoTitle);
    }

    /**
     * @Given /^logo firmy Szachuje powinno być widoczne$/
     */
    public function logoFirmySzachujePowinnoBycWidoczne()
    {
        $logo = $this->mink->getSession()->getPage()->find('css', '#logo');

        if (empty($logo)) {
            throw new \Exception('logo should be visible');
        }

        expect($logo->isVisible())->toBe(true);
    }

    /**
     * @Given /^logo firmy Szachuje nie powinno być widoczne$/
     */
    public function logoFirmySzachujeNiePowinnoBycWidoczne()
    {
        $logo = $this->mink->getSession()->getPage()->find('css', '#logo');
        if (!isset($logo)) {
            return;
        }
        expect($logo->isVisible())->toBe(false);
    }

    /**
     * @Given /^że są zdefiniowane aktualności:$/
     */
    public function zeSaZdefiniowaneAktualnosci(TableNode $table)
    {
        $em = $this->getDoctrineManager();

        foreach ($table->getHash() as $row) {
            $entity = new News();
            $entity->setName($row['Nazwa'])
                ->setDate(new \DateTime($row['Data']))
                ->setContent($row['Treść']);
            $em->persist($entity);
        }

        $em->flush();
    }

    /**
     * @Given /^powinienem zobaczyć nagłowek strony "([^"]*)"$/
     */
    public function powinienemZobaczycNaglowekStrony($name)
    {
        $header = $this->mink->getSession()->getPage()->find('css', '#page-header');
        expect($header)->toNotBeNull();
        expect($header->getText())->toBe($name);
    }

    /**
     * @Given /^powinienem zobaczyć nagłowek prawej kolumny "([^"]*)"$/
     */
    public function powinienemZobaczycNaglowekPrawejKolumny($name)
    {
        $header = $this->getPage('Strona glowna')->find('css', '#column-right-header');
        expect($header)->toNotBeNull();
        expect($header->getText())->toBe($name);
    }

    /**
     * @Given /^powinienem zobaczyć aktualności:$/
     */
    public function powinienemZobaczycAktualnosci(TableNode $table)
    {
        $articles = $this->getPage('Strona glowna')->getElement('Aktualnosci');

        expect($articles->getArticlesCount())->toBe(count($table->getHash()));

        foreach ($table->getHash() as $index => $row) {
            $articleIndex = $index+1;
            expect($articles->getArticleName($articleIndex))->toBe($row['Nazwa']);
            expect($articles->getArticleDate($articleIndex))->toBe($row['Data']);
            expect($articles->getArticleContent($articleIndex))->toBe($row['Treść']);
        }
    }

    /**
     * @Given /^powinienem zobaczyć nagłówki aktualności:$/
     */
    public function powinienemZobaczycNaglowkiAktualnosci(TableNode $table)
    {
        $news = $this->getPage('Strona glowna')->findAll('css', 'article');

        expect($news)->shouldHaveCount(count($table->getHash()));

        $pageArticle = reset($news);
        foreach ($table->getHash() as $row) {
            $articleName = $pageArticle->find('css', '.name');
            expect($articleName->getText())->toBe($row['Nazwa']);

            $articleDate = $pageArticle->find('css', '.date');
            expect($articleDate->getText())->toBe($row['Data']);

            $pageArticle = next($news);
        }
    }

    /**
     * @Given /^powinienem zobaczyć grafikę obrazującą działalność firmy$/
     */
    public function powinienemZobaczycGrafikeObrazujacaDzialalnoscFirmy()
    {
        $page = $this->getPage('Strona glowna');
        expect($page->has('css', 'img.company-image'))->toBe(true);
    }

    /**
     * @Given /^grafikę obrazującą działalność firmy nie powinna być widoczna$/
     */
    public function grafikeObrazujacaDzialalnoscFirmyNiePowinnaBycWidoczna()
    {
        $companyImage = $this->getPage('Strona glowna')->find('css', 'img.company-image');

        if (empty($companyImage)) {
            return;
        }

        expect($companyImage->isVisible())->toBe(false);
    }

    /**
     * @Given /^powinienem zobaczyć treść podstawową:$/
     */
    public function powinienemZobaczycTrescPodstawowa(PyStringNode $expectedContent)
    {
        $page = $this->getPage('Strona glowna');
        expect($page->getContentFirst())->toBe((string) $expectedContent);
    }

    /**
     * @Given /^powinienem zobaczyć treść dodatkową:$/
     */
    public function powinienemZobaczycTrescDodatkowa(PyStringNode $expectedContent)
    {
        $page = $this->getPage('Strona glowna');
        expect($page->getContentSecond())->toBe((string) $expectedContent);
    }

    /**
     * @Given /^powinienem w nagłówku widzieć menu zawierające elementy:$/
     */
    public function powinienemWNaglowkuWidziecMenuSerwisuZawierajaceElementy(TableNode $table)
    {
        $headerMenu = $this->getPage('Strona glowna')->getElement('Menu Naglowka');

        expect($headerMenu->getElementsCount())->shouldBe(count($table->getHash()));

        foreach ($table->getHash() as $index => $row) {
            expect($headerMenu->getElementText($index+1))->toBe($row['Nazwa']);
        }
    }

    /**
     * @Given /^powinienem w stopce zobaczyć nagłowek "([^"]*)"$/
     */
    public function powinienemWStopceZobaczycNaglowek($name)
    {
        $headerMenu = $this->getPage('Strona glowna')->find('css', '#footer-contact-title');

        if (empty($headerMenu)) {
            throw new \Exception('element #footer-contact-title not exists');
        }

        expect($headerMenu->getText())->toBe($name);
    }

    /**
     * @Given /^dane w stopce powiny zawierac treści:$/
     */
    public function daneWStopcePowinyZawieracTresci(TableNode $table)
    {
        $footerContact = $this->getPage('Strona glowna')->getElement('Kontakt Stopki');

        expect($footerContact->getElementsCount())->shouldBe(count($table->getHash()));

        foreach ($table->getHash() as $index => $row) {
            expect($footerContact->getElementText($index+1))->toBe($row['Nazwa']);
        }
    }

    /**
     * @Given /^powinienem w stopce widzieć menu serwisu zawierające elementy:$/
     */
    public function powinienemWStopceWidziecMenuSerwisuZawierajaceElementy(TableNode $table)
    {
        $footerMenu = $this->getPage('Strona glowna')->getElement('Menu Stopki');

        expect($footerMenu->getElementsCount())->shouldBe(count($table->getHash()));

        foreach ($table->getHash() as $index => $row) {
            expect($footerMenu->getElementText($index+1))->toBe($row['Nazwa']);
        }
    }

    /**
     * @Given /^menu w stopce nie powinno być widoczne$/
     */
    public function menuWStopceNiePowinnoBycWidoczne()
    {
        $footerMenu = $this->getPage('Strona glowna')->getElement('Menu Stopki');

        if (empty($footerMenu)) {
            return;
        }

        expect($footerMenu->isVisible())->toBe(false);
    }

    /**
     * @Given /^powinienem zobaczyć formularz z polami:$/
     */
    public function powinienemZobaczycFormularzZPolami(TableNode $table)
    {
        $contactPage = $this->getPage('Kontakt');

        foreach ($table->getHash() as $row) {
            expect($contactPage->hasField($row['Nazwa']))->toBe(true);
        }
    }

    /**
     * @Given /^powinienem zobaczyć przyck "([^"]*)"$/
     */
    public function powinienemZobaczycPrzyck($name)
    {
        expect($this->getPage('Kontakt')->hasButton($name))->toBe(true);
    }

    /**
     * @Given /^nacisnę przycisk "([^"]*)"$/
     */
    public function nacisnePrzycisk($name)
    {
        $this->getPage('Kontakt')->pressButton($name);
    }

    /**
     * @Given /^powinienem zobaczyć komunikat "([^"]*)"$/
     */
    public function powinienemZobaczycKomunikat($text)
    {
        $message = $this->getPage('Kontakt')->find('css', '.alert');

        if (empty($message)) {
            throw new \Exception('no message on page');
        }

        expect($message->getText())->toBe($text);
    }

    /**
     * @Given /^powinny zostać oznaczone jako błędne pola:$/
     */
    public function powinnyZostacOznaczoneJakoBlednePola(TableNode $table)
    {
        $contactPage = $this->getPage('Kontakt');

        foreach ($table->getHash() as $row) {
            $field = $contactPage->findField($row['Nazwa']);
            $className = $field->getAttribute('class');
            expect(strpos($className, 'error'))->toNotBe(false);
        }
    }

    /**
     * @Given /^email nie powinien zostać wysłany$/
     */
    public function emailNiePowinienZostacWyslany()
    {
        $profiler = $this->kernel->getContainer()->get('profiler');
        $profiles = $profiler->find('', '', 1, 'POST', '', '');
        $profileInfo = end($profiles);
        $profile = $profiler->loadProfile($profileInfo['token']);
        $collector = $profile->getCollector('swiftmailer');

        expect($collector->getMessageCount())->toBe(0);
    }

    /**
     * @Given /^wypełniłem pole formularza kontaktowego "([^"]*)" wartością "([^"]*)"$/
     */
    public function wypelnilemPoleFormularzaKontaktowegoWartoscia($name, $value)
    {
        $this->getPage('Kontakt')->fillField($name, $value);
    }

    /**
     * @Given /^na adres email firmy Szachuje powinien zostać wysłany email o temacie "([^"]*)" od nadawcy "([^"]*)" o treści:$/
     */
    public function naAdresEmailFirmySzachujePowinienZostacWyslanyEmailOTemacieOdNadawcyOTresci($subject, $target, PyStringNode $content)
    {
        $profiler = $this->kernel->getContainer()->get('profiler');
        $profiles = $profiler->find('', '', 1, 'POST', '', '');
        $profileInfo = end($profiles);
        $profile = $profiler->loadProfile($profileInfo['token']);
        $collector = $profile->getCollector('swiftmailer');

        expect($collector->getMessageCount())->toBe(1);

        foreach ($collector->getMessages('default') as $message) {
            expect(array_key_exists('szachuje@example.com', $message->getTo()))->toBe(true);
            expect(array_key_exists($target, $message->getFrom()))->toBe(true);
            expect($message->getSubject())->toBe($subject);
            expect($message->getBody())->toBe($content->getRaw());
        }
    }

}
