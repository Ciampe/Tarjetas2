<?php
namespace Tarjetita;
class TarjetaTest extends \PHPUnit_Framework_TestCase {
  protected $tarjeta,$colectivoA,$colectivoB,$medio,$bici;	
public function setup(){
		$this->tarjeta = new Tarjeta(15);
		$this->colectivoA = new Colectivo("101 Negro", "Rosario Bus");
  		$this->colectivoB = new Colectivo("35", "Rosario Bus");
		$this->bici = new Bicicleta("999");
	}	
	public function testCargaSaldo() {

    		$this->tarjeta->recargar(500);
    		$this->assertEquals($this->tarjeta->saldo(), 640, "Al cargar 500 debo tener 640");
        $this->tarjeta = new Tarjeta(11);
    		$this->tarjeta->recargar(272);
    		$this->assertEquals($this->tarjeta->saldo(), 320, "Al cargar 272 debo tener 320");
        $this->tarjeta = new Tarjeta(12);
    		$this->tarjeta->recargar(100);
        $this->assertEquals($this->tarjeta->saldo(), 320, "Al cargar 100 debo tener 100");
  	}
	public function testPagarBici() {
    		$this->tarjeta->recargar(500);
    		$this->tarjeta->pagar($this->bici, "2000/02/27 15:25");
    		$this->assertEquals($this->tarjeta->saldo(), 628, "Si tengo 640 y pago una bici tengo que tener 628");
        $this->tarjeta->pagar($this->bici, "2000/02/28 15:25");
        $this->assertEquals($this->tarjeta->saldo(), 614, "Si tengo 640 y pago dos bicis tengo que tener 614");
  	}
	public function testPagarViajeSinSaldo(){
		$this->assertEquals($this->tarjeta->pagar($this->colectivoA, "2010/01/1 20:50")->getTipo(),"Plus", "Debe devolver boleto tipo Plus");
		$this->assertEquals($this->tarjeta->saldo(),-8, "Si no recargo el saldo es negativo por lo tanto debe ser Plus (-8)");
		$this->assertEquals($this->tarjeta->pagar($this->colectivoA, "2010/01/1 20:50")->getTipo(),"Plus", "Debe devolver boleto tipo Plus");
    $this->assertEquals($this->tarjeta->saldo(),-16, "Si no recargo el saldo es negativo por lo tanto debe ser Plus (-16, ya use los plus)");
	}
  	public function testPagando(){
		$this->tarjeta->recargar(40);
		$this->assertEquals($this->tarjeta->pagar($this->colectivoA, "201$/07/3 11:55")->getTipo(),"Normal", "Debe devolver boleto tipo Normal");
  		$this->assertEquals($this->tarjeta->saldo(), 32, "Cargue 40 y pague un boleta, por lo tanto tengo 32");
	}
?>
