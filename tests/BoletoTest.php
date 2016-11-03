<?php
namespace Tarjetita;
class BoletoTest extends \PHPUnit_Framework_TestCase {
  protected $tarjeta,$colectivoA,$colectivoB,$medio,$bici;	
  public function setup(){
			$this->tarjeta = new Tarjeta(1);
		  $this->colectivoA = new Colectivo("101 Negro", "Rosario Bus");
  		$this->colectivoB = new Colectivo("101 Rojo", "Rosario Bus");
  }
  public function testBoleto() {
    $this->tarjeta->recargar(272);
    $aux=$this->tarjeta->pagar($this->colectivoA, "2016/03/20 7:45");
    $this->assertEquals($aux->getTipo(),"Normal", "El tipo es Normal");
    $this->assertEquals($aux->getCosto(),8, "El costo del boleto es 8");
    $this->assertEquals($aux->getLinea(),"101 Negro", "Linea: 101 Negro");
    $this->assertEquals($aux->getFecha(),"2016/03/20 7:45", "La Fecha es 2016/03/20 7:45");
    $this->assertEquals($aux->getId(),1, "El id de la tarjeta es 1");
    $this->assertEquals($aux->getSaldo(),312, "Usted tiene 312 de saldo");
    $this->assertEquals($this->tarjeta->saldo(), 312, "Cuando recargo 272 y pago un colectivo deberia tener 312");
  }
 
?>
