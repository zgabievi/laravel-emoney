# laravel-emoney

> Some great updates are comming soon...

[![Latest Stable Version](https://poser.pugx.org/zgabievi/e-money/version?format=flat-square)](https://packagist.org/packages/zgabievi/e-money) [![Total Downloads](https://poser.pugx.org/zgabievi/e-money/d/total?format=flat-square)](https://packagist.org/packages/zgabievi/e-money) [![License](https://poser.pugx.org/zgabievi/e-money/license?format=flat-square)](https://packagist.org/packages/zgabievi/e-money)

| eMoney |     |
|:------:|:----|
| [![eMoney](https://i.imgsafe.org/fbbe1c636f.png)](https://github.com/zgabievi/laravel-emoney) | eMoney payment system integration for [Laravel 5.*](http://laravel.com/) :sunglasses: Trying to make it perfect, easy to use and awesome package :tada: Pull requests are welcome. |

## Table of Contents
- [Installation](#installation)
    - [Composer](#composer)
    - [Laravel](#laravel)
- [Usage](#usage)
- [Example](#example)
- [Codes](#codes)
- [Config](#config)
- [License](#license)

## Installation

### Composer

Run composer command in your terminal.

    composer require zgabievi/e-money

### Laravel

Open `config/app.php` and find the `providers` key. Add `eMoneyServiceProvider` to the array.

```php
Gabievi\eMoney\eMoneyServiceProvider::class
```

Find the `aliases` key and add `Facade` to the array. 

```php
'eMoney' => Gabievi\eMoney\eMoneyFacade::class
```

## Usage

There is main method with will call method by first parameter.
And it will return the result of the request:

`eMoney::GetResult($method, ...$args);`

Example:

```php
return eMoney::GetResult('GetBalance');
```

Outputs:

```json
{
  "Code": 1,
  "ExtraInfo": null,
  "ID": "374E9088F2FA45F5ABF411DFE9B06D36",
  "Message": "Success",
  "SystemCode": "OK",
  "Value": {
    "AccountBalance": {
      "Account": 110100015,
      "Balance": "0",
      "Currency": "GEL"
    }
  }
}
```

Behind the scene it does something like this:

```php
return (array)eMoney::GetBalance(...$args)->GetBalanceResult;
```

---

This is the list of all methods:

- `GetServiceGroups();`
- `GetServices($group_id);`
- `GetServiceProperties($service_id);`
- `GetServiceParameterReferences($service_parameter_id);`
- `GetInfo($service_id, $parameters);`
- `Pay($service_id, $amount, $currency, $txn_id, $parameters);`
- `GetTransactionDetails($txn_id);`
- `GetTransactionInfo($txn_id);`
- `GetStatement($start_date, $end_date);`
- `GetBalance();`
- `ConfirmPayment($txn_id, $amount, $currency, $parameters);`

## Example

```php
return eMoney::GetResult('GetStatement', '01/01/2016', '01/14/2016');
```

Outputs:

```json
{
  "Code": 1,
  "ExtraInfo": null,
  "ID": "3D3FFA52900E468CA3E3F39CD6819E44",
  "Message": "Success",
  "SystemCode": "OK",
  "Value": {
    "StatementEntry": [
      {
        "Amount": "15",
        "Code": 866730178,
        "Credit": 110100052,
        "Currency": "GEL",
        "Date": "2016-01-12T00:00:00",
        "Debit": 110100015,
        "Description": "12345678910, 02.04.1994, Test #1",
        "ID": 16673017,
        "Status": "Canceled",
        "Type": "Test transaction"
      },
      {
        "Amount": "1",
        "Code": 866730178,
        "Credit": 800000003,
        "Currency": "GEL",
        "Date": "2016-01-12T00:00:00",
        "Debit": 110100015,
        "Description": "Test transaction",
        "ID": 16673019,
        "Status": "Canceled",
        "Type": "Test transaction"
      }
    ]
  }
}
```

## Codes

| Key | Value                    | Description                                                             |
|-----|--------------------------|-------------------------------------------------------------------------|
| 1   | Success                  | OK                                                                      |
| 11  | Unknown                  | Unknown error                                                           |
| 12  | InvalidHash              | Invalid hash                                                            |
| 13  | InvalidParameters        | Some of the input parameters are invalid                                |
| 14  | InvalidDistributor       | Invalid distributor name                                                |
| 16  | ServicesProviderNotFound | Service provider not found                                              |
| 17  | AbonentNotFound          | Abonent not found                                                       |
| 19  | ParameterNotFound        | Parameter not found                                                     |
| 20  | ParameterValueNotFound   | Parameter value not found                                               |
| 30  | Error                    | General error                                                           |
| 31  | ServiceNotFound          | Service not found                                                       |
| 34  | ServiceInternalError     | Service internal error                                                  |
| 40  | WrongAmount              | Wrong amount                                                            |
| 41  | ServiceTimeout           | Operation timeout                                                       |
| 42  | PaymentWontBeAccepted    | Payment wont be accepted. Your company has not enough balance in eMoney |
| 43  | AccountOperationDenied   | Account operation denied                                                |
| 44  | AmountLessThanMin        | Amount is less than acceptable minumum                                  |
| 45  | AmountMoreThanMax        | Amount is more than acceptable maximum                                  |
| 46  | TransactionLimitExceeded | Transaction limit exceeded                                              |

## Config

Publish eMoney config file using command:

```
php artisan vendor:publish
```

Created file `config\eMoney.php`. Inside you can change configuration as you wish.

## License

laravel-emoney is licensed under a  [MIT License](https://github.com/zgabievi/laravel-promocodes/blob/master/LICENSE).

## TODO
- [ ] Create tests to check funtionality
- [ ] Create separated file for response codes
- [ ] Make artisan command that will write this response codes in php file
- [ ] Make eMoney object more Model like
