<?php

interface Tarjeta {
	public function pagar(Transporte $transporte, $fecha_y_hora);
	public function recargar($monto);
	public function saldo();
	public function viajesRealizados();
}

class Viaje {
	private $tipo;
	private $monto;
	private $transporte;
	private $tiempo;

	public function __construct($tipo, $monto, $transporte, $tiempo) {
		$this->tipo = $tipo;
		$this->monto = $monto;
		$this->transporte = $transporte;
	}

	public function tipo() { 
		return $this->tipo; }
	public function monto() { 
		return $this->monto; }
	public function transporte() { 
		return $this->transporte; }
	public function tiempo() { 
		return $this->tiempo; }
}

class MOVI implements Tarjeta {
	private $saldo = 0;
	private $viajes = [];
	protected $descuento;
	
	public function __construct() {
		$this->descuento = 1;
	}

	public function pagar(Transporte $transporte, $fecha_y_hora) {
		if ($transporte->tipo() == "colectivo") {
			$trasbordo = false;
			if (count($this->viajes) > 0) {
				if (end($this->viajes)->tiempo() - $fecha_y_hora < strtotime("+1 hour")) {
					$trasbordo = true;
				}
			}

			$monto = 0;
			if ($trasbordo)
				$monto = 2.64*$this->descuento;
			else
				$monto = 8.50*$this->descuento;

			$this->viajes[] = new Viaje($transporte->tipo(), $monto, $transporte, strtotime($fecha_y_hora));
			$this->saldo = $this->saldo-$monto;} 
		else 
			if ($transporte->tipo() == "bici") {
			$this->viajes[] = new Viaje($transporte->tipo(), 12, $transporte, strtotime($fecha_y_hora));
			$this->saldo = $this->saldo-12;
		}
	}
	public function viajesRealizados() { return $this->viajes; }
	public function recargar($monto) {
		if ($monto == 272)
			$this->saldo = $this->saldo+320;
		else if ($monto = 500)
			$this->saldo = $this->saldo+640;
		else
			$this->saldo = $this->saldo+$monto;
	}
	public function saldo() { echo "Su saldo es de: " . $this->saldo . "<br>"; }

	
}

class MedioBoleto extends MOVI {
	public function __construct() {
		$this->descuento = 0.5;
	}
}

class PaseLibre extends MOVI {
	public function __construct() {
		$this->descuento = 0;
	}
}

class Transporte {
	protected $tipo;

	public function Tipo() {
		return $this->tipo;
	}
}

class Colectivo extends Transporte {
	private $nombre;
	private $linea;

	public function __construct($nombre, $linea) {
		$this->tipo = "colectivo";
		$this->nombre = $nombre;
		$this->linea = $linea;
	}

	public function Nombre() {
		return $this->nombre;
	}
	public function Linea() {
		return $this->linea;
	}
}

class Bici extends Transporte {
	private $patente;

	public function __construct($patente) {
		$this->tipo = "bici";
		$this->patente = $patente;
	}

	public function Nombre() {
		return $this->patente;
	}
}

$tarjeta = new MOVI;
$tarjeta->recargar(272);
$tarjeta->saldo() . "<br>";
$colectivo143Negro = new Colectivo("143 Negro", "Rosario Bus");
$tarjeta->pagar($colectivo143Negro, "2016/06/30 22:50");
$tarjeta->saldo() . "<br>";
$colectivo133 = new Colectivo("133", "Rosario Bus");
$tarjeta->pagar($colectivo133, "2016/06/30 23:10");
$tarjeta->saldo() . "<br>";
$bici = new Bici(1234);
$tarjeta->pagar($bici, "2016/07/02 08:10");
echo "Su travesia fue: <br>";
foreach ($tarjeta->viajesRealizados() as $viaje) {
	if ($viaje->tipo()=="colectivo")
		echo "Se tomo un " . $viaje->tipo() . ". <br>";
		else 
		echo "Se tomo una " . $viaje->tipo() . ". <br>";
	if ($viaje->tipo()=="colectivo")
		echo "Pago " . $viaje->monto() . " el boleto. <br>";
		else 
		echo "Pago " . $viaje->monto() . " la tarifa diaria de la bicicleta. <br>";
	if ($viaje->tipo()=="colectivo")
		echo "Se tomo un " . $viaje->transporte()->nombre() . " de la linea " . $viaje->transporte()->linea() . ". <br>";
		else 
		echo "Se tomo una bici de patente " . $viaje->transporte()->nombre() . ". <br>";
}
?>