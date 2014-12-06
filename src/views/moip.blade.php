{{ HTML::script("packages/sostheblack/moip/jquery-2.1.1.js") }}
{{ HTML::script("packages/sostheblack/moip/jquery-2.1.1.min.js") }}
{{ HTML::script($moip['environment'], ["charset" => "ISO-8859-1", "type" => "text/javascript"])}}
{{ var_dump($moip) }}
<script type="text/javascript">
	payment = function()
  	{
      	var settings = 
      	{
			"Forma": "{{$moip['Forma']}}",
			"Instituicao": "{{$moip['Instituicao']}}",
		    "Parcelas": "{{$moip['Parcelas']}}",
		    "CartaoCredito": {
		        "Numero": "{{$moip['CartaoCredito']['Numero']}}",
		        "Expiracao": "{{$moip['CartaoCredito']['Expiracao']}}",
		        "CodigoSeguranca": "{{$moip['CartaoCredito']['CodigoSeguranca']}}",
		        "Portador": {
		            "Nome": "{{$moip['CartaoCredito']['Portador']['Nome']}}",
		            "DataNascimento": "{{$moip['CartaoCredito']['Portador']['DataNascimento']}}",
		            "Telefone": "{{$moip['CartaoCredito']['Portador']['Telefone']}}",
		            "Identidade": "{{$moip['CartaoCredito']['Portador']['Identidade']}}"
		        }
		    }
        }

    	MoipWidget(settings);
  	}

  	var callbackSuccess = function(data){
    	console.log("Sucesso\n" + JSON.stringify(data));
    };

    var callbackFaill = function(data){
        console.log("Falha\n" + JSON.stringify(data));
    };

    $(document).ready(function(){
		payment();
	}); 
</script>

<div id="MoipWidget"
    data-token="{{ $moip['token'] }}"
    callback-method-error="callbackFaill"
    callback-method-success="callbackSuccess">
</div>