<html>
  <head>
    <style>
      @page { margin: 0cm 0cm; }
	  table {
		border-collapse: separate;
		border-spacing: 0;
		margin: 0;
		padding: 0;
		width: 100%;
		table-layout: fixed;
		font-size: 13px;
      }

	  th ,td {
	    border-right:none;
	    border-bottom: 2px solid #ddd;
	    background-color: #FFFFF;
	    padding: .35em;
	  }

	  #tr1 th:last-child {
	    border-top: 2px solid #ddd;
	    border-right: 2px solid #ddd;
	    color: #FFFFFF;
	    background-color: #636363;
	  }

	  #tr1 th:nth-child(2) {
	    border-left: 2px solid #ddd;
	    border-top: 2px solid #ddd;
	    color: #FFFFFF;
	    background-color: #636363;
	  }

	  #tr2 {
	    color: #FFFFFF;
	    background-color: #2F426E;
	  }

	  #tr2 th:first-child{
	    border-top: 2px solid #ddd;
	    border-left: 2px solid #ddd;
	  }

	  #tr2 th:last-child{
	    border-top: 2px solid #ddd;
	    border-right: 2px solid #ddd;
	  }

	  tr td:first-child{
	    border-left: 2px solid #ddd;
	  }

	  tr td:last-child{
	    border-right: 2px solid #ddd;
	  }

	  tr td:nth-child(2){
	    background-color: #CDE6FF;
	  }

	  tr td:nth-child(3){
	    background-color: #FFF083;
	  }

	  tr td:nth-child(4){
	    background-color: #C1FFC6;
	  }

	  tfoot tr th {
	    border-bottom: none;
	  }

	  tfoot tr th:nth-child(2){
	    color: #FFFFFF;
	    background-color: #017EE7;
	  }

	  tfoot tr th:nth-child(3){
	    color: #FFFFFF;
	    background-color: #D8A504;
	  }

	  table th,
	  table td {
	    padding: .625em;
	    text-align: center;
	  }

	  table th {
	    font-size: .85em;
	    letter-spacing: .1em;
	    text-transform: uppercase;
	  }

      body {
        margin-top: 3cm;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 2cm;
        font-family: 'Lucida Console', Monaco, monospace;
      }

      header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
      }

      img{
        text-align: center;
        top: 0;
        float:left;
        padding-top: 1.5em;
        padding-left: 2em;
        width: 90px;
        height: 100px
      }

      footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 1.5cm;
        color: #FFFFFF;
        background-color: #636363;
        text-align: center;
        line-height: 1.5cm;
      }
       
      .blank {
	    background-color: #FFFFFF;
	    border: none;
	  }
	  
      .pull-center {
		text-align: center;
	  }

	  .pull-right {
	    text-align: right;
      }

	  .div-table {
		margin-top: 0em;
		width: 100%;
	  }

	  .container {
	    width: 100%;
	    border: 2px solid #ddd;
	    padding: 1em;
	    overflow: auto;
	  }

	  .container div {
	     display: block;
	     width: 50%;
	  }

	  .container div:nth-of-type(1) {
	    float: left;
	  }

	  .container div:nth-of-type(2) {
	    float: right;
	    text-align: right;
	  }

      .amount {
	    margin-top: 1.5em;
      }

      .total {
	    margin-top: 0.3em;
	    border: 2px solid #ddd;
	    padding: 0.5em;
      }

      .date {
	    padding-top: 1em;
	    padding-right: 1em;
      }
    </style>
  </head>
  <body style="">
  	<header>
      <img src="{{url('/img/logo3.png')}}"/>
      <div class="date pull-right">{{ $date }}</div>
    </header>

    <h1 class="pull-center">ARQUEO DE CAJA CENTRAL</h1>

    <div class="container">
	  <div><strong>Fecha Desde:</strong> {{ date('d/m/Y', strtotime($box['date_init'])) }}</div>
	  <div><strong>Realizado por:</strong> {{ $box['created']['causer'] }}</div>
	  <div><strong>Fecha Hasta:</strong> {{ date('d/m/Y', strtotime($box['date_end'])) }}</div>
	</div>

    <div class="div-table">
      <h2 class="pull-center">LISTA DE CUENTAS Y MONTOS</h2>
      <table>
	    <thead>
	      <tr id="tr1">
	        <th class="blank"></th>
	        <th colspan="2">Monto Estimado</th>
	        <th>Total</th>
	      </tr>
	      <tr id="tr2">
	        <th scope="col">Cuenta</th>
	        <th scope="col">Ingresos</th>
	        <th scope="col">Egresos</th>
	        <th scope="col">Saldo</th>
	        <th scope="col">Monto Real</th>
	      </tr>
	    </thead>
	    <tbody>
	      @foreach($accounts as $account)
	        <tr>
	          <td data-label="Cuenta">{{ $account['title']  }}</td>
              <td data-label="Ingresos">{{ number_format($account['incomes'], 2, '.', ',') }}</td>
              <td data-label="Egresos">{{ number_format($account['expenses'], 2, '.', ',') }}</td>
              <td data-label="Saldo">{{ number_format($account['current_amount'], 2, '.', ',') }}</td>
              <td data-label="Monto Real">{{ number_format($account['cash'], 2, '.', ',') }}</td>
	        </tr>
	      @endforeach
	    </tbody>
	    <tfoot>
	      <tr>
	        <th></th>
	        <th>{{ number_format($totals[0], 2, '.', ',') }}</th>
	        <th>{{ number_format($totals[1], 2, '.', ',') }}</th>
	        <th></th>
	      </tr>
	    </tfoot>
	  </table>
    </div>

    <div class="amount"><strong>SALDO ACTUAL EN CAJA:</strong></div>

    <div class="total pull-right">
      <div><strong>TOTAL:</strong>
        <span> {{ number_format($totals[2], 2, '.', ',') }}</span>
      </div>
    </div>

    <div class="amount"><strong>DETALLE CAJA CHICA:</strong></div>

    <table>
		<thead>
		  <tr>  
			<th>USUARIO</th>
			<th>MONTO ASIGNADO</th>
			<th>MONTO GASTADO</th>
			<th>SALDO</th>
		  </tr> 
		</thead>  
		<tbody>
		  @foreach($small_boxes as $smallbox)
		    <tr>
		      <td>{{ $smallbox['user'] }}</td>
		      <td>{{ $smallbox['total_amount'] }}</td>
		      <td>{{ $smallbox['used_amount'] }}</td>
		      <td>{{ number_format($smallbox['total_amount']  - $smallbox['used_amount'], 2, '.', ',') }}</td>
		    </tr>
		  @endforeach
		</tbody>
		</table> 

    <div class="amount"><strong>NOTA:</strong></div>

    <div class="total">
      <div>{{ $box['note'] }}</div>
    </div>

	<footer>Vertical srl &copy; <?php echo date("Y");?></footer> 
  </body>
</html>
  