{{ HTML::script("packages/sostheblack/moip/jquery-2.1.1.js") }}
{{ HTML::script("packages/sostheblack/moip/jquery-2.1.1.min.js") }}
{{ HTML::script($moip['environment'], ["charset" => "ISO-8859-1", "type" => "text/javascript"])}}
{{ var_dump($moip) }}
<html>
	<head>
	    <script type="text/javascript">
	        var callbackSuccess = function(data){
	            console.log('Sucesso\n' + JSON.stringify(data));
	            if (data) {
	            	$.post("{{ route('sostheblack.moip') }}", {moip: data}, function(result){
		            	console.log(result);
		            });
	            };
	        };

	        var callbackFaill = function(data) {
	            console.log('Falha\n' + JSON.stringify(data));
	            $.post("{{ route('sostheblack.moip') }}", {datas: data}, function(result){
	            	console.log(result);
	            });
	        };

	        payment = function() {
	            var settings = {
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
	    </script>
			
		<script type="text/javascript">
		   	$(document).ready(function(){
				payment();
			}); 
		</script>
	</head>
	<body>
	    <div 
	    	id="MoipWidget"
	        data-token="{{ $moip['token'] }}"
	        callback-method-success="callbackSuccess"
	        callback-method-error="callbackFaill">
	    </div>
	</body>
</html>