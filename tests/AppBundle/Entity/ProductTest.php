<?php

namespace Tests\AppBundle\Tests;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use BaseBundle\Tests\AbstractEntityTest;

class ProductTest extends AbstractEntityTest
{

    /**
     * {@inheritdoc}
     */
    public function entityClass()
    {
        return new Product();
    }

    /**
     * {@inheritdoc}
     */
    public function dataProvider()
    {
        return [
            ['id', 1],
            ['name', 'Marmita de frango </br>'],
            ['price', 10],
            ['category', $this->mockCategory()],
            ['updatedAt', new \Datetime('2015-09-09 00:00:00')],
            ['createdAt', new \Datetime('2015-09-09 00:00:00')],
            ['version', 1],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function dataArrayCollection()
    {
        return [
            'id' => 2,
            'name' => ' Marmita de 
              carne <script><p>',
            'price' => 2,
            'category' => $this->mockCategory(),
            'updatedAt' => new \Datetime('2015-09-09 00:00:00'),
            'createdAt' => new \Datetime('2015-09-09 00:00:00'),
            'version' => 2,
        ];
    }

    protected function mockCategory()
    {
        $module = \Mockery::mock(Category::class)
            ->shouldIgnoreMissing();

        return $module;
    }

    public function testCheckCleanHtmlAndStripTags()
    {
        $class = $this->entityClass();

        $class->exchangeArray($this->dataArrayCollection());

        $classClone = clone $class;

        $this->filter->filterEntity($class);

        $this->assertNotContains("<script>", $class->getName());
        $this->assertNotContains("<p>", $class->getName());

        $this->assertNotEquals($classClone->getName(), $class->getName());
    }
}
