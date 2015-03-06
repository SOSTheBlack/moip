# MoIP package
----------------------
> Estatísticas

[![Total Downloads](https://poser.pugx.org/sostheblack/moip/downloads.svg)](https://packagist.org/packages/sostheblack/moip)
[![Monthly Downloads](https://poser.pugx.org/sostheblack/moip/d/monthly.png)](https://packagist.org/packages/sostheblack/moip)
[![Daily Downloads](https://poser.pugx.org/sostheblack/moip/d/daily.png)](https://packagist.org/packages/sostheblack/moip)

> Versionamento

[![Latest Stable Version](https://poser.pugx.org/sostheblack/moip/v/stable.svg)](https://packagist.org/packages/sostheblack/moip) [![Latest Unstable Version](https://poser.pugx.org/sostheblack/moip/v/unstable.svg)](https://packagist.org/packages/sostheblack/moip)

> Estado Atual do Package

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SOSTheBlack/moip/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/SOSTheBlack/moip/?branch=develop) [![Build Status](https://scrutinizer-ci.com/g/SOSTheBlack/moip/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/SOSTheBlack/moip/build-status/develop)

> Licença

[![License](https://poser.pugx.org/sostheblack/moip/license.svg)](https://packagist.org/packages/sostheblack/moip)

Package para integrar o seu sistema com o MoIP. 
Neste Package está incluso:

- Dados do comprador podendo realizar o checkout tranparente
- Valores: Total, Desconto, Acréscimo
- Identificador Único
- Motivo da Venda
- Quem ira resceber o pagamento no MoIP
- Parcelas: Min, Max, Juros por parcela (a.m), se o comprador irá pagar o juros MoIP
- Comissão: Valor, motivo, se o valor é porcentagem, conta que irá receber a comissão.
- Boleto: data de vencimento, mensagens do boleto (max 3), logo no boleto
- Mensagem no checkout (max 3)
- URL de retorno após finalizar o checkout
- URL de notificação na qual recebera NASP
- Formas de pagamento: Cartão de crédito e débito, boleto, financiamento, debito em conta

Fazer tudo isso é simples... Muito simples.

No terminal
```
php artisan moip:install
```

No seu código
```php
MoipApi::postOrder($data);
```

### Retorno
O método `MoipApi::postOrder($data)` retorna o método `MoipApi::response()`
```
stdClass Object
(
    [getXML]
    [replyXML]
    [token]
    [url]
)
```

Method | Response
-------|----------
MoipApi::response()->getXML | XML que  é enviado
MoipApi::response()->replyXML | XML de resposta
MoipApi::response()->token | Token do checkout
MoipApi::response()->url | URL do checkout

### Documentação

Confira a documentação completa no nosso [Wiki](https://github.com/SOSTheBlack/moip/wiki)
