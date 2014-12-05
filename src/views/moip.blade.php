@if ($moip['environment'] === true)
	{{ HTML::script(
		'https://www.moip.com.br/transparente/MoipWidget-v2.js', 
		['charset' => 'ISO-8859-1', 'type' => 'text/javascript']) 
	}}
@else
	{{ HTML::script(
		'https://desenvolvedor.moip.com.br/sandbox/transparente/MoipWidget-v2.js', 
		['charset' => 'ISO-8859-1', 'type' => 'text/javascript']) 
	}}
@endif

 {{ var_dump($moip) }}
<script type="text/javascript">
  	payment = function()
  	{
      	var settings = 
      	{
			"Forma": "{{ $moip['Forma'] }}",
			"Instituicao": "{{ $moip['Instituicao'] }}",
		    "Parcelas": "{{ $moip['Parcelas'] }}",
		    "CartaoCredito": {
		        "Numero": "{{ $moip['CartaoCredito']['Numero'] }}",
		        "Expiracao": "{{ $moip['CartaoCredito']['Expiracao'] }}",
		        "CodigoSeguranca": "{{ $moip['CartaoCredito']['CodigoSeguranca'] }}",
		        "Portador": {
		            "Nome": "{{ $moip['CartaoCredito']['Portador']['Nome'] }}",
		            "DataNascimento": "{{ $moip['CartaoCredito']['Portador']['DataNascimento'] }}",
		            "Telefone": "{{ $moip['CartaoCredito']['Portador']['Telefone'] }}",
		            "Identidade": "{{ $moip['CartaoCredito']['Portador']['Identidade'] }}"
		        }
		    }
        }

    	MoipWidget(settings);
  	}
</script>

<script type="text/javascript">
    var callbackSuccess = function(data){
    	console.log('Sucesso\n' + JSON.stringify(data));
    };

    var callbackFaill = function(data){
        console.log('Falha\n' + JSON.stringify(data));
    };
</script>

<div id="MoipWidget"
    data-token="{{ $moip['token'] }}"
    callback-method-error="callbackFaill"
    callback-method-success="callbackSuccess">
</div>

<a href="javascript:payment();">
 	Imprimir Boleto
</a>