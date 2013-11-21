<?php

namespace Szachuje\Behat\Context;

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
        $logo = $this->mink->getSession()->getPage()->find('css', '#logo');
        if (!isset($logo)) {
            echo $this->mink->getSession()->getPage()->getHtml();
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
        $header = $this->mink->getSession()->getPage()->find('css', '#column-right-header');
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
        $news = $this->mink->getSession()->getPage('Strona główna')->findAll('css', 'article');

        expect($news)->shouldHaveCount(count($table->getHash()));

        $pageArticle = reset($news);
        foreach ($table->getHash() as $row) {
            $articleName = $pageArticle->find('css', '.name');
            expect($articleName)->toNotBeNull();
            expect($articleName->getText())->toBe($row['Nazwa']);

            $articleDate = $pageArticle->find('css', '.date');
            expect($articleDate)->toNotBeNull();
            expect($articleDate->getText())->toBe($row['Data']);

            $pageArticle = next($news);
        }
    }

    /**
     * @Given /^powinienem zobaczyć grafikę obrazującą działalność firmy$/
     */
    public function powinienemZobaczycGrafikeObrazujacaDzialalnoscFirmy()
    {
        $page = $this->mink->getSession()->getPage('Strona główna');
        expect($page->has('css', 'img.company-image'))->toBe(true);
    }

    /**
     * @Given /^grafikę obrazującą działalność firmy nie powinna być widoczna$/
     */
    public function grafikeObrazujacaDzialalnoscFirmyNiePowinnaBycWidoczna()
    {
        $companyImage = $this->mink->getSession()->getPage()->find('css', 'img.company-image');

        if (empty($companyImage)) {
            return;
        }

        expect($companyImage->isVisible())->toBe(false);
    }


    /**
     * @Given /^powinienem zobaczyć treść strony:$/
     */
    public function powinienemZobaczycTrescStrony(PyStringNode $string)
    {
        $page = $this->mink->getSession()->getPage('Strona główna');
        $contentElement = $page->find('css', '.content');

        expect($contentElement)->toNotBeNull();

        $elementContent = preg_replace('/\s+/', ' ', $contentElement->getText());
        $expectedContent = preg_replace('/\s+/', ' ', (string) $string);
        expect($elementContent)->toBe($expectedContent);
    }

}
