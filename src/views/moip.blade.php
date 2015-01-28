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
	            	$.post("{{ route('sostheblack.moip') }}", {data: data}, function(result){
		            	console.log(result);
		            });
	            };

	            // $("input[name='Status']").val(data.Status);
	            // $("input[name='Codigo']").val(data.Codigo);
	            // $("input[name='CodigoRetorno']").val(data.CodigoRetorno);
	            // $("input[name='TaxaMoIP']").val(data.TaxaMoIP);
	            // $("input[name='StatusPagamento']").val(data.StatusPagamento);
	            // $("input[name='ClassificacaoCodigo']").val(data.Classificacao.Codigo);
	            // $("input[name='ClassificacaoDescricao']").val(data.Classificacao.Descricao);
	            // $("input[name='CodigoMoIP']").val(data.CodigoMoIP);
	            // $("input[name='Mensagem']").val(data.Mensagem);
	            // $("input[name='TotalPago']").val(data.TotalPago);
	            // $("input[name='url']").val(data.url);
	            // $("input[name='submit']").val(data.submit);
	            // $( "form:first" ).trigger( "submit" );
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

	    <!-- {{ Form::open(['method' => 'post']) }}
	    {{ Form::text('Status') }}
	    {{ Form::text('Codigo') }}
	    {{ Form::text('CodigoRetorno') }}
	    {{ Form::text('TaxaMoIP') }}
	    {{ Form::text('StatusPagamento') }}
	    {{ Form::text('ClassificacaoCodigo') }}
	    {{ Form::text('ClassificacaoDescricao') }}
	    {{ Form::text('CodigoMoIP') }}
	    {{ Form::text('Mensagem') }}
	    {{ Form::text('TotalPago') }}
	    {{ Form::text('url') }}
	    {{ Form::submit('submit') }}
	    <button id="pagarBoleto" onclick="pagarBoleto()"> Imprimir Boleto </button> -->
	</body>
</html>