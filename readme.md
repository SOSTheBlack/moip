# MoIP Package For API v1
----------------------

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SOSTheBlack/moip/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SOSTheBlack/moip/?branch=master)
[![Build Status](https://travis-ci.org/SOSTheBlack/moip.svg?branch=master)](https://travis-ci.org/SOSTheBlack/moip) 

Package para integrar o seu negócio com MoIP. Neste Package está incluso:

- Dados do comprador (evita a necessidade do comprador se cadastrar na tela intermediária)
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

Fazer tudo isso é simples... Muito simples
```
MoipApi::postOrder($data);
```

## Instalação - Laravel 4.2 ou inferior
Comece a instalar este pacote através Composer. Edite `composer.json` do seu projeto para exigir `sostheblack/moip` na verssão v1.*
```
"require": {
    "sostheblack/moip": "1.*"
}
```

Em seguida atualize o seu composer pelo terminal:
```
$ composer update
```

Uma vez que tenha sido concluída a operação, o próximo passo é executar este comando no sei terminal
```
$ php artisan migrate --package="vendor/package"
```
Será criada uma tabela chamada moip em seu banco de dados, faça os ajustes necessários e siga para o próximo passo.

O último passo é adicionar o Service Provider e o Facade no seu arquivo `app/config/app.php`

Adicionando um novo item no seu provider
```
'providers' => array(
    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    'SOSTheBlack\Moip\MoipServiceProvider',
),
```

Adicionando um novo item no seu facade
```
'aliases' => array(
    'App'        => 'Illuminate\Support\Facades\App',
    'Artisan'    => 'Illuminate\Support\Facades\Artisan',
    ...
    'MoipApi'           => 'SOSTheBlack\Moip\Facades\Moip',
    'MoipController'    => 'SOSTheBlack\Moip\Facades\Controller',
),
```

## Usando

### Simples
Para cria um simples checkout basta enviar o valor total da compra, outras informações pertinente para criação do mesmo, serão resgatas do banco de dados

```
$data = ['prices' => ['value' => 100] ];
Moip::sendMoip($data);
```
E tera um checkout semelhante a este.

### Advanced
Aqui é criado um checkout totalmente customizado, se for enviado todos os dados referente ao cliente o mesmo não precisará se cadastrar na tela intermediadora de pagamento

```
$data = [
    'unique_id' => false,
    'reason'    => 'Black Friday',
    'receiver' => 'jeancesargarcia@gmail.com',
    'url_notification' => 'https://meusite.com.br/nasp',
    'url_return' => 'https://meusite.com.br/cliente/pedido/bemvindodevolta',
    'payer' => [
        'name'      => 'Nome Sobrenome',
        'email'     => 'email@cliente.com.br',
        'payerId'   => 'id_usuario',
        'billingAddress' => [
            'address'       => 'Rua do Zézinho Coração',
            'number'        => '45',
            'complement'    => 'z',
            'city'          => 'São Paulo',
            'neighborhood'  => 'Palhaço Jão',
            'state'         => 'SP',
            'country'       => 'BRA',
            'zipCode'       => '01230-000',
            'phone'         => '(11)8888-8888'
        ]
    ],
    'prices'    => [
        'value' => 100,
        'adds'  => 30,
        'deduct'=> 10
    ],
    'paymentWay' => [
    	'creditCard',
    	'billet',
    	'financing',
    	'debit'	,
    	'debitCard'
    ],
    'billet' => [
        'expiration'    => 3,
        'workingDays'   => false,
        'instructions'  => [
            'firstLine',
            'secondLine'
        ],
        'uriLogo' => 'http://seusite.com.br/logo.gif',
    ],
    'message' => [
        'message 01',
        'message 02',
        'message 03'
    ],
    'comission' => [
        ['reason' => 'comission reason', 'receiver' => 'adm.the_black@hotmail.com', 'value' => 5.00],
        ['reason' => 'comission reason', 'receiver' => 'adm.the_black@hotmail.com', 'value' => 12.00, 'percentageValue' => true, 'ratePayer' => true]
    ],
    'parcel' => [
        ['min' => '2', 'max' => '4'],
        ['min' => '5', 'max' => '7', 'rate' => '1.00'],
        ['min' => '8', 'max' => '12', 'rate' => null, 'transfer' => true, 'receipt' => true]
    ]
];

Moip::postOrder($data);
```

E tera um checkout semelhante a este.

## Parametros enviados
Agora vamos ver detalhadamente o que cada informação sigunifica.

#### unique_id
----------------------
##### $id: String

1. $id: Seu identificador único de pedido, essa mesma informações será enviada para você em nossas notificações de alterações de status para que você possa identificar o pedido e tratar seu status.

```
$data['unique_id'] = $id;
```

#### payer
----------------------
##### $value : ['name','email','payerId','identity', 'phone','billingAddress' => ['address','number','complement','city','neighborhood','state','country','zipCode','phone']]

Envia os dados do comprador, obrigatório se você for utilizar checkout tranparente
```
$data['payer'] = [
    'name'      => 'Nome Sobrenome',
    'email'     => 'email@cliente.com.br',
    'payerId'   => 'id_usuario',
    'billingAddress' => [
        'address'       => 'Rua do Zézinho Coração',
        'number'        => '45',
        'complement'    => 'z',
        'city'          => 'São Paulo',
        'neighborhood'  => 'Palhaço Jão',
        'state'         => 'SP',
        'country'       => 'BRA',
        'zipCode'       => '01230-000',
        'phone'         => '(11)8888-8888'
    ]
],
```

#### prices
----------------------
##### $prices ['value', 'adds', 'deduct']

1. $value: Responsável por definir o valor que deverá ser pago.
2. $adds: Responsável por definir o valor adicional que deverá ser pago.
3. $deduct:  Responsável por definir o valor de desconto que será subtraído do total a ser pago.
```
$data['prices'] = [
    'value'     => 100,
    'adds'      => 30,
    'dedudct'   => 10
];
```

#### reason
----------------------
##### $reason: String

1. $reason: Responsável por definir o motivo do pagamento.

```
$data['reason'] = $reason;
```

#### receiver
----------------------
##### $receiver String

1. $receiver: Login Moip do recebedor primario.

```
$data['receiver'] = $receiver;
```

#### parcel
----------------------
##### $parcel [$min, $max, $rate , $transfer]

Responsible for the installment which will be available to the paying options.

1. $min : Quantidade mÃ­nima de parcelas disponível ao pagador.
2. $max : Quantidade máxima de parcelas disponíveis ao pagador.
3. $rate : Valor de juros a.m por parcela.
4. $transfer : Caso "true" define que o valor de juros padrão do Moip será pago pelo pagador.
5. $receipt: Define o modo que o vendedor irá receber o pagamento do Moip - false = A Vista, true = Parcelado
```
$data['parcel'] = [
    ['min' => '2', 'max' => '4'],
    ['min' => '5', 'max' => '7', 'rate' => '1.00'],
    ['min' => '8', 'max' => '12', 'rate' => null, 'transfer' => true, 'receipt' => true]
];
```

#### comission
----------------------
##### $comission  [$reason, $receiver, $value, $percentageValue, $ratePayer]

1. $reason: Razão/Motivo ao qual o recebedor secundário receberá o valor definido
2. $receiver: Login Moip do usuario que receberá o valor
3. $value: Valor ao qual será destinado ao recebedor secundário
4. $percentageValue: Caso "true" define que valor será calculado em relação ao percentual sobre o valor total da transação
5. $ratepayer: Caso "true" define que esse recebedor secundário irá pagar a Taxa Moip com o valor recebido

```
$data['comission'] = [
    ['reason' => 'comission reason', 'receiver' => 'adm.the_black@hotmail.com', 'value' => 5.00],
    ['reason' => 'comission reason', 'receiver' => 'adm.the_black@hotmail.com', 'value' => 12.00, 'percentageValue' => true, 'ratePayer' => true]
];
```

#### billet
----------------------
##### $billet [$expiration, $workingDays, $instructions, $uriLogo]

1. $expiration: Data em formato "AAAA-MM-DD" ou quantidade de dias.
2. $workingDays: Caso "$expiration" seja quantidade de dias você pode definir com "true" para que seja contado em dias Ãºteis, o padrão será dias corridos.
3. $instructions: Mensagem adicionais a ser impresso no boleto, até três mensagens.
4. $urlLogo: URL de sua logomarca, dimensÃµes máximas 75px largura por 40px altura.

```
$data['billet'] = [
    'expiration'    => 3,
    'workingDays'   => false,
    'instructions'  => [
        'firstLine',
        'secondLine',
        'lastLine'
    ],
    'uriLogo' => 'http://seusite.com.br/logo.gif',
];
```

#### message
----------------------
##### $message []

1. $message: Define mensagem adicional a ser exibida no checkout Moip.

```
$data['message'] = [
    'message 01',
    'message 02',
    'message 03',
    ...
];
```

#### returnURL
----------------------
##### $returnURL String

1. $returnURL: Responsável por definir a URL que o comprador será redirecionado ao finalizar um pagamento através do checkout Moip.

```
$data['returnURL'] = 'https://meusite.com.br/pedidofinalizado';
```

#### notificationURL
----------------------
##### $notificationURL String

1. $notificationURL: Responsável por definir a URL ao qual o Moip deverá notificar com o NASP (Notificação de Alteração de Status de Pagamento) as mudança de status.

```
$data['notificationURL'] = 'https://meusite.com.br/nasp';
```

#### paymentWay
----------------------
##### $paymentWay [creditCard, billet, financing, debit, debitCard]

1. $paymentWay: Define quais as formas de pagamento que serão exibidas ao pagador no Checkout Moip. 

```
$data['paymentWay'] = [
    'creditCard',
    'billet',
    'financing',
    'debit' ,
    'debitCard'
];
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


### Gerando Parcelas
----------------------
O método `MoipApi::parcel($parcel)` retorna um array contendo as informações de parcelas e seus respectivos valores cobrados por parcela e o valor total a ser pago referente a taxa de juros simulada

$parcel [ $login $maxParcel $rate $simulatedValue ]

1. RESQUEST.
    * $login: Login Moip do usuario.
    * $maxParcel: Máximo de parcelar a ser consultado.
    * $rate: Taxa de juros para simulação.
    * $simulatedValue: Valor pago ao qual será simulado.

```
$parcel = [
    'login'         => 'jean@comunicaweb.com.br',
    'maxParcel'     => 2,
    'rate'          => 1.99,
    'simulatedValue'=> 100
];
```

2. RESPONSE.
    * Total a ser pago.
    * Total a ser pago.
    * Valor por parcela.

```
[1] => [
    [total] => 100.00
    [rate] => 1.99
    [value] => 100.00
]


[2] => [
    [total] => 103.00
    [rate] => 1.99
    [value] => 51.50
]
```


## Checkout transparent (Teste)
```
php artisan asset:publish sostheblack/moip
```
```
$pgto = [
	"Forma" 		=> "CartaoCredito",
	"Instituicao" 	=> "Visa",
    "Parcelas"		=> "1",
    "CartaoCredito" => [
        "Numero" 		 => "4073020000000002",
        "Expiracao" 	 => "12/15",
        "Cofre"			 => "0b2118bc-fdca-4a57-9886-366326a8a647",
        "CodigoSeguranca"=> "123",
        "Portador" 		 => [
        	"Nome" 			=> "Nome Sobrenome",
            "DataNascimento"=> "30/12/1987",
            "Telefone" 		=> "(11)3165-4020",
            "Identidade" 	=> "222.222.222-22"
        ]
    ]
];

return MoipController::transparent($pgto);
```