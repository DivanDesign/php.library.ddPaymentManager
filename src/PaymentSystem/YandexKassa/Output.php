<?php
namespace DDPaymentManager\PaymentSystem\YandexKassa;


class Output extends \DDPaymentManager\Output
{
	/**
	 * render
	 * 
	 * @desc Формирует ответ в формате XML для запросов Яндекс.Кассы (см. https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage/).
	 * 
	 * @param object|array $params — Объект с параметрами @required
	 * @param 'checkOrder'|'paymentAviso' $params->responseName — Название XML-элемента ответа. @required
	 * @param int $params->shopId — Идентификатор магазина. @required
	 * @param int $params->invoiceId — Идентификатор транзакции в сервисе Яндекс.Денег. @required
	 * @param 0|1|100|200 $params->code — Код результата обработки запроса. Default: 0.
	 * 
	 * @throws \Exception
	 * 
	 * @return string
	 */
	public function render($params){
		if(is_array($params)){
			$params = (object) $params;
		}
		
		if(is_object($params)){
			$params->code = isset($params->code)? $params->code: 0;
			
			$result = '
				<?xml version="1.0" encoding="UTF-8"?>
				<'.$params->responseName.'Response
					performedDatetime="'.date('c').'"
					code="'.$params->code.'"
					shopId="'.$params->shopId.'"
					invoiceId="'.$params->invoiceId.'"
				/>
			';
			
			$output = str_replace(array("\t", PHP_EOL), array('', ' '), trim($result));
		}else{
			throw new \Exception('Failed to create an output');
		}
		
		return $output;
	}
}