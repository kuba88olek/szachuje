<?php

namespace Szachuje\Behat\Context\Page\Element;

use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class Aktualnosci extends Element
{
    protected $selector = array('css' => '.articles');

    public function getArticlesCount()
    {
        $articles = $this->findAll('css', 'article');
        return count($articles);
    }

    public function getArticleName($index)
    {
        $element = $this->find('css', sprintf('article:nth-child(%d) .name', $index));

        if (empty($element)) {
            throw new \Exception();
        }

        return $element->getText();
    }

    public function getArticleDate($index)
    {
        $element = $this->find('css', sprintf('article:nth-child(%d) .date', $index));

        if (empty($element)) {
            throw new \Exception();
        }

        return $element->getText();
    }

    public function getArticleContent($index)
    {
        $element = $this->find('css', sprintf('article:nth-child(%d) .content', $index));

        if (empty($element)) {
            throw new \Exception();
        }

        return $element->getText();
    }

}
