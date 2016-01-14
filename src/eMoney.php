<?php

namespace Gabievi\eMoney;

class eMoney
{

	// wsdl url
	public $wsdl = 'https://api.emoney.ge/distributors/Service.svc?wsdl';

	// distributor name
	protected $distributor;

	// sekcret key
	protected $secret_key;

	// soap client
	protected $client;

	/**
	 * eMoney constructor.
	 */
	public function __construct()
	{
		$this->distributor = config('eMoney.distributor');
		$this->secret_key = config('eMoney.secret');

		$this->client = new \SoapClient($this->wsdl);
	}

	/**
	 * Get all the service groups from eMoney
	 * @return mixed
	 */
	public function GetServiceGroups()
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetServiceGroups%s%s', $this->distributor, $this->secret_key));

		return $this->client->GetServiceGroups(['request' => $request]);
	}

	/**
	 * Get all the allowed services for group
	 *
	 * @param $group_id
	 *
	 * @return mixed
	 */
	public function GetServices($group_id)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetServices%s%s%s', $group_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => ['Key' => 'group', 'Value' => $group_id]];

		return $this->client->GetServices(['request' => $request]);
	}

	/**
	 * Get service parameters
	 *
	 * @param $service_id
	 *
	 * @return mixed
	 */
	public function GetServiceProperties($service_id)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetServiceProperties%s%s%s', $service_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => ['Key' => 'service', 'Value' => $service_id]];

		return $this->client->GetServiceProperties(['request' => $request]);
	}

	/**
	 * @param $service_parameter_id
	 *
	 * @return mixed
	 */
	public function GetServiceParameterReferences($service_parameter_id)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetServiceParameterReferences%s%s%s', $service_parameter_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => ['Key' => 'parameter', 'Value' => $service_parameter_id]];

		return $this->client->GetServiceParameterReferences(['request' => $request]);
	}

	/**
	 * Get abonent information using the parameters returned from GetServiceProperties
	 *
	 * @param $service_id
	 * @param $parameters
	 *
	 * @return mixed
	 */
	public function GetInfo($service_id, $parameters)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetInfo%s%s%s', $service_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => $parameters];

		return $this->client->GetInfo(['request' => $request]);
	}

	/**
	 * Pay for the services using the parameters from GetServiceProperties
	 *
	 * @param $service_id
	 * @param $amount
	 * @param $currency
	 * @param $txn_id
	 * @param $parameters
	 *
	 * @return mixed
	 */
	public function Pay($service_id, $amount, $currency, $txn_id, $parameters)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('Pay%s%.2f%s%s%s%s', $service_id, $amount, $currency, $txn_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => $parameters];

		return $this->client->Pay(['request' => $request]);
	}

	/**
	 * Get details about transaction using our transaction_code
	 *
	 * @param $txn_id
	 *
	 * @return mixed
	 */
	public function GetTransactionDetails($txn_id)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetTransactionDetails%s%s%s', $txn_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => ['Key' => 'transaction', 'Value' => $txn_id]];

		return $this->client->GetTransactionDetails(['request' => $request]);
	}

	/**
	 * Get info about transaction using our transaction_code
	 *
	 * @param $txn_id
	 *
	 * @return mixed
	 */
	public function GetTransactionInfo($txn_id)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetTransactionInfo%s%s%s', $txn_id, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => ['Key' => 'transaction', 'Value' => $txn_id]];

		return $this->client->GetTransactionInfo(['request' => $request]);
	}

	/**
	 * @param $start_date
	 * @param $end_date
	 *
	 * @return mixed
	 */
	public function GetStatement($start_date, $end_date)
	{
		$request = [];
		$parameters = [];

		$parameters[] = ['Key' => 'startdate', 'Value' => date('n/j/Y g:i:s A', strtotime($start_date))];
		$parameters[] = ['Key' => 'enddate', 'Value' => date('n/j/Y g:i:s A', strtotime($end_date))];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetStatement%s%s%s%s', date('Y-m-d', strtotime($start_date)), date('Y-m-d', strtotime($end_date)), $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => $parameters];

		return $this->client->GetStatement(['request' => $request]);
	}

	/**
	 * Get distributor's balance in eMoney
	 * @return mixed
	 */
	public function GetBalance()
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('GetBalance%s%s', $this->distributor, $this->secret_key));

		return $this->client->GetBalance(['request' => $request]);
	}

	/**
	 * @param $txn_id
	 * @param $amount
	 * @param $currency
	 * @param $parameters
	 *
	 * @return mixed
	 */
	public function ConfirmPayment($txn_id, $amount, $currency, $parameters)
	{
		$request = [];

		$request['Distributor'] = $this->distributor;
		$request['Hash'] = hash('SHA256', sprintf('ConfirmPayment%s%.2f%s%s%s', $txn_id, $amount, $currency, $this->distributor, $this->secret_key));
		$request['Parameters'] = ['Parameter' => $parameters];

		return $this->client->ConfirmPayment(['request' => $request]);
	}

	/**
	 * @param $function
	 * @param array ...$args
	 *
	 * @return mixed
	 */
	public function GetResult($function, ...$args)
	{
		return (array)$this->{$function}(...$args)->{$function . 'Result'};
	}
}
