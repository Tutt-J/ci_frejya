<?php
use App\Entity\Product;
use App\Service\Calculator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatorTest extends KernelTestCase{
    private $calculator;

    protected function setUp():void{
        $this->calculator= new Calculator();
    }

    public function testGetTotalHT(){
        $totalHT = $this->calculator->getTotalHT($this->getProducts());

        $this->assertEquals(96, $totalHT);
    }

    public function testGetTotalTTC(){
        $totalTTC = $this->calculator->getTotalTTC($this->getProducts(), 20);

        $this->assertEquals(115.2, $totalTTC);
    }

    public function getProducts()
    {
        return [
            [
                'product' => $this->createProduct("Ballon rouge", 10),
                'quantity' => 3
            ],
            [
                'product' => $this->createProduct("Ballon bleu", 8),
                'quantity' => 2
            ],
            [
                'product' => $this->createProduct("Ballon jaune", 10),
                'quantity' => 5
            ]
        ];
    }
 
    public function createProduct($name, $price)
    {
        return ((new Product())
        ->setName($name)
        ->setPrice($price));
    }
}