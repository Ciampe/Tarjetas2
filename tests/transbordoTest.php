<?php
namespace Tarjetita;
class TransbordoTest extends \PHPUnit_Framework_TestCase {
  protected $tarjeta,$colectivoA,$colectivoB,$medio;	
  
  public function setup(){
	$this->tarjeta = new Tarjeta(10);
    	$this->medio = new Medio();
	$this->colectivoA = new Colectivo("113 Rojo", "Rosario Bus");
  	$this->colectivoB = new Colectivo("35 Verde", "Rosario Bus");
  }
  
 	public function testTransbordo() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2013/03/10 14:10");
  		$this->tarjeta->pagar($this->colectivoB, "2012/09/30 14:50");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 de saldo y al pagar un colectivo con transbordo debo tener 309.36");
  	}
	
  	public function testNoTransbordo() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2010/01/02 10:01");
   		$this->tarjeta->pagar($this->colectivoB, "2016/08/09 22:22");
  		$this->assertEquals($this->tarjeta->saldo(), 304, "Si tengo 312 de saldo y al pagar un colectivo sin transbordo debo tener 304");
 
  	}
  
  	public function testMedioTransbordo() {
    		$this->medio->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2016/06/28 22:54");
   		$this->tarjeta->pagar($this->colectivoB, "2016/06/28 23:50");
    		$this->assertEquals($this->medio->saldo(), 314.68, "Si tengo 312 de saldo y al pagar un colectivo con transbordo y medio boleto debo tener 314.68");
 	}
  	public function testNoTransbordoMismoColectivo() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2016/06/30 22:50");
  		$this->tarjeta->pagar($this->colectivoA, "2016/06/30 22:54");
  		$this->assertEquals($this->tarjeta->saldo(), 304, "Si tengo 312 de saldo y pago un colectivo sin transbordo ya que es el mismo deberia tener finalmente 304");
  	}
  
  	public function testTresColectivos(){
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2014/06/30 22:56");
  		$this->tarjeta->pagar($this->colectivoB, "2014/06/30 23:00");
  		$this->tarjeta->pagar($this->colectivoA, "2014/06/30 23:10");
  		$this->assertEquals($this->tarjeta->saldo(), 301.36, "Si tengo 312 de saldo y al pagar un colectivo con transbordo y luego otro sin debo tener 301.36");
  	}
	
  	public function testTransbordoSabado() {
  		$this->tarjeta->recargar(272);
		$this->tarjeta->pagar($this->colectivoB, "2013/10/30 15:11");
  		$this->tarjeta->pagar($this->colectivoA, "2011/11/10 14:15");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 de saldo y al pagar un colectivo con transbordo un sabado de 14hs a 22hs debo 309.36");
  	}
	
	public function testTransbordoNoturno() {
   		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2013/12/12 21:25");
  		$this->tarjeta->pagar($this->colectivoB, "2012/12/12 22:12");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 de saldo y al pagar un colectivo con transbordo a la noche de 22hs a 6hs debo tener 309.36");
  	}
	
}
?>
