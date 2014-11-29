<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moip', function($table){
			$table->increments('id');
			$table->string('receiver', 50)->comment('Identifica o usuário Moip que irá receber o pagamento no Moip');
			$table->string('key', 40)->default('ABABABABABABABABABABABABABABABABABABABAB');
			$table->string('token', 32)->default('01010101010101010101010101010101');
			$table->boolean('environment')->default(0)->comment('Método que define o ambiente em qual o requisição será processada. False: desenvolvimento, True: produção');
			$table->boolean('validate')->default(0)->comment('False: Basic, True: Identification');
			$table->string('reason')->comment('Responsável por definir o motivo do pagamento');
			$table->string('billet_expiration')->default(3)->comment('Data em formato AAAA-MM-DD ou quantidade de dias');
			$table->boolean('billet_working_days')->default(0)->comment('Caso billet_expiration seja quantidade de dias você pode definir com true para que seja contado em dias úteis, o padrão será dias corridos');
			$table->string('billet_firstLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_secondLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_lastLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_urlLogo')->comment('URL de sua logomarca, dimenções máximas 75px largura por 40px altura');
			$table->string('url_return')->comment('definir a URL que o comprador será redirecionado ao finalizar um pagamento através do checkout Moip');
			$table->string('url_notification')->comment('responsável por definir a URL ao qual o Moip deverá notificar com o NASP');
			$table->boolean('payment_billet')->default(1)->comment('Para disponibilizar a opção Boleto Bancário como forma de pagamento no checkout Moip');
			$table->boolean('payment_financing')->default(1)->comment('Para disponibilizar a opção Financiamento como forma de pagamento no checkout Moip');
			$table->boolean('payment_debit')->default(1)->comment('Para disponibilizar a opção Debito em conta como forma de pagamento no checkout Moip');
			$table->boolean('payment_credit_card')->default(1)->comment('Para disponibilizar a opção Cartão de Crédito como forma de pagamento no checkout Moip');
			$table->boolean('payment_debit_card')->default(1)->comment('Para disponibilizar a opção Cartão de débito como forma de pagamento no checkout Moip');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('moip');
	}

}
