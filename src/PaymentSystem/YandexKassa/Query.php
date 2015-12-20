<?php
namespace DDYandexKassa\PaymentSystem\YandexKassa;


class Query extends \DDPaymentManager\Query
{
	public
		$action,
		$orderSumAmount,
		$orderSumCurrencyPaycash,
		$orderSumBankPaycash,
		$shopId,
		$invoiceId,
		$customerNumber,
		$md5;
	
	/**
	 * Query constructor.
	 * 
	 * @param object|array $params — Параметры запроса от Яндекса. @required
	 * @param string $params->action — Тип запроса. @required
	 * @param float $params->orderSumAmount — Стоимость заказа. @required
	 * @param int $params->orderSumCurrencyPaycash — Код валюты для суммы заказа. @required
	 * @param int $params->orderSumBankPaycash — Код процессингового центра в Яндекс.Деньгах для суммы заказа. @required
	 * @param int $params->shopId — Идентификатор магазина, выдается при подключении к сервису Яндекс.Денег. @required
	 * @param int $params->invoiceId — Уникальный номер транзакции в Яндекс.Деньгах. @required
	 * @param string $params->customerNumber — Идентификатор плательщика на стороне магазина. Присылается в платежной форме. @required
	 * @param string $params->md5 — MD5-хэш параметров платежной формы. С ним производится сравнение. @required
	 * 
	 * @throws \Exception
	 */
	public function __construct($params){
		if(is_array($params)){
			$params = (object) $params;
		}
		
		if(is_object($params)){
			$this->action = $params->action;
			$this->orderSumAmount = $params->orderSumAmount;
			$this->orderSumCurrencyPaycash = $params->orderSumCurrencyPaycash;
			$this->orderSumBankPaycash = $params->orderSumBankPaycash;
			$this->shopId = $params->shopId;
			$this->invoiceId = $params->invoiceId;
			$this->customerNumber = $params->customerNumber;
			$this->md5 = $params->md5;
		}else{
			throw new \Exception('Failed to create a query');
		}
	}
}