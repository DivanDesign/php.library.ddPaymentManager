<?php
namespace DDPaymentManager;


abstract class Output
{
	abstract public function render($params);
}