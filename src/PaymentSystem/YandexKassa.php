<?php
namespace DDPaymentManager\PaymentSystem;


use DDPaymentManager\PaymentSystem;
use DDPaymentManager\PaymentSystem\YandexKassa\Output;

class YandexKassa extends PaymentSystem
{
	private
		$secret,
		$output;
	
	private static $paymentTypes = array(
		'PC' => 'Из кошелька в Яндекс.Деньгах',
		'AC' => 'С произвольной банковской карты',
		'MC' => 'Со счета мобильного телефона',
		'GP' => 'Наличными через кассы и терминалы',
		'WM' => 'Из кошелька в системе WebMoney',
		'SB' => 'Через Сбербанк: по смс или Сбербанк Онлайн',
		'MP' => 'Через мобильный терминал (mPOS)',
		'AB' => 'Через Альфа-Клик',
		'MA' => 'Через MasterPass',
		'PB' => 'Через интернет-банк Промсвязьбанка',
		'QW' => 'Через QIWI Wallet',
		'KV' => 'Через КупиВкредит (Тинькофф Банк)',
		'QP' => 'Через сервис Доверительный платеж (Куппи.ру)'
	);
	
	/**
	 * YandexKassa constructor.
	 * 
	 * @param string $secret
	 * @param \DDPaymentManager\Output|null $output
	 */
	public function __construct($secret, \DDPaymentManager\Output $output = null){
		$this->secret = $secret;
		
		if($output === null){
			$output = new Output();
		}
		
		$this->output = $output;
	}
	
	/**
	 * checkSign
	 * 
	 * @desc Проверка контрольной суммы в соответствии с параметрами заказа и секретом (см. https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage/).
	 * 
	 * @param \DDYandexKassa\PaymentSystem\YandexKassa\Query $query 
	 * 
	 * @return string
	 */
	public function checkSign(\DDYandexKassa\PaymentSystem\YandexKassa\Query $query){
		$md5 = strtoupper(md5(
			$query->action.';'.
			$query->orderSumAmount.';'.
			$query->orderSumCurrencyPaycash.';'.
			$query->orderSumBankPaycash.';'.
			$query->shopId.';'.
			$query->invoiceId.';'.
			$query->customerNumber.';'.
			$this->secret
		));
		
		return $query->md5 == $md5;
	}
	
	/**
	 * checkPaymentType
	 * 
	 * Проверяет, является ли тип оплаты подходящим для Яндекс.Кассы.
	 * 
	 * @param string $type — Тип оплаты. @required
	 * 
	 * @return bool
	 */
	public function checkPaymentType($type){
		return isset(static::$paymentTypes[$type]);
	}
}