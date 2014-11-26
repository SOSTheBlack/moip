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
			$table->string('key', 40);
			$table->string('token', 32);
			$table->boolean('environment')->comment('Método que define o ambiente em qual o requisição será processada. False: produção, True: desenvolvimento');
			$table->boolean('validate')->comment('False: Basic, True: Identification');
			$table->string('reason')->comment(' Responsável por definir o motivo do pagamento');
			$table->string('billet_expiration')->comment('Data em formato AAAA-MM-DD ou quantidade de dias');
			$table->boolean('billet_working_days')->comment('Caso billet_expiration seja quantidade de dias você pode definir com true para que seja contado em dias úteis, o padrão será dias corridos');
			$table->string('billet_firstLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_secondLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_lastLine')->comment('Mensagem adicionais a ser impresso no boleto');
			$table->string('billet_urlLogo')->comment('URL de sua logomarca, dimenções máximas 75px largura por 40px altura');
			$table->string('url_return')->comment('definir a URL que o comprador será redirecionado ao finalizar um pagamento através do checkout Moip');
			$table->string('url_notification')->comment('responsável por definir a URL ao qual o Moip deverá notificar com o NASP');
			$table->boolean('payment_creditCard');
			$table->boolean('payment_billet');
			$table->boolean('payment_financing');
			$table->boolean('payment_debit');
			$table->boolean('payment_debitCard');
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
