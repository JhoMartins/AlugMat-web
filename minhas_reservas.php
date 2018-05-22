<?php
	$titulo = "Alugmat - Reserva de Materiais e Ferramentas";
	require_once('includes/conexao.php');
	require_once('includes/cabecalho_site.php');
	
	
	/**************************** CANCELAR RESERVA ****************************/
	//Verifica se o usuário clicou no botão "Cancelar Reserva"
	if (isset($_GET['excluir']) && $_GET['excluir'] == 'S') {
		$sqld_itens = "select cd_produto from itens_reserva where cd_reserva = ".$_GET['id_excluir'];
		$res = mysqli_query($dbc,$sqld_itens);
		
		//Atualiza todos os produtos da Reserva para que fiquem Disponíveis novamente
		while ($reg = mysqli_fetch_array($res)) {
			$sqlu_prod = "update produto set disponivel = 'S' where id = ".$reg['cd_produto'];
			mysqli_query($dbc,$sqlu_prod);
		}
		
		//Excluí Itens da Reserva
		$sqld_itens = "delete from itens_reserva where cd_reserva = ".$_GET['id_excluir'];
		mysqli_query($dbc,$sqld_itens);
		
		//Excluí Reserva
		$sqld = "delete from reservas where id = ".$_GET['id_excluir'];
		mysqli_query($dbc,$sqld);
	}
	/**************************************************************************/
	
	
	/**************************** PESQUISAR RESERVA ****************************/
	$id_reserva = (isset($_SESSION['id_reserva'])) ? "= ".$_SESSION['id_reserva'] : "is null";
	
	//Captura o último ID da tabela Reserva
	$sql = "select r.*, c.nome
			from reservas r
			left join cliente c on c.id = r.cd_cliente
			where c.id = ".$_SESSION['id']."
			   or r.id $id_reserva
			order by r.id desc";
	//die("<pre>".$sql."</pre>");
	$res = mysqli_query($dbc, $sql);
	/**************************************************************************/
	
	
	/**************************** FINALIZAR RESERVA ****************************/
	while ($reg = mysqli_fetch_array($res)) {
		
		//Se o usuário acessou a página através do botão "Finalizar Reservas", vai limpar os valores das Sessions ID_RESERVA e TOTAL_ITENS
		//É necessário para que não fique lixo da reserva no código e não de erro caso o usuário queira realizar novas reservas
		if (isset($_GET['finaliza']) && $_GET['finaliza'] == 'S') {
			
			$id = $reg['ID'];
			$cd_cliente = (isset($reg['CD_CLIENTE'])) ? $reg['CD_CLIENTE'] : null;
			$data = date('d/m/Y', strtotime($reg['DATA_RESERVA']));
			$status = $reg['STATUS'];
			$nome_cliente = $reg['nome'];
			
			//Se tiver alguma reserva do cliente logado sem CD_CLIENTE, atualizar a reserva informando o CD_CLIENTE
			if (empty($cd_cliente)) {
				//Atualiza Reserva
				$sqlu = "update reservas set cd_cliente = ".$_SESSION['id']." where id = $id";
				mysqli_query($dbc, $sqlu);
			}
			
			//Capturar Itens da Reserva
			$sql_itens = "select ir.*, p.descricao, p.valor_diaria, p.cd_interno
						  from itens_reserva ir
						  inner join produto p on p.id = ir.cd_produto
						  where ir.cd_reserva = $id
						  order by ir.id";
			//die("<pre>".$sql_itens."</pre>");
			$res_itens = mysqli_query($dbc, $sql_itens);
			
			
			//Atualiza todos os Itens da Reserva para que os Produtos fiquem Indisponíveis
			while ($reg_itens = mysqli_fetch_array($res_itens)) {
				$cd_produto = $reg_itens['CD_PRODUTO'];
				//die($cd_produto);
				
				$sqlu_produto = "update produto set disponivel = 'N' where id = $cd_produto";
				mysqli_query($dbc,$sqlu_produto);
			}
			
			unset($_SESSION['id_reserva']);
			unset($_SESSION['total_itens']);
		}
	}
	/**************************************************************************/
?>

<div class="row">
	<?php if (mysqli_num_rows($res) == 0) { //Se não tiver nenhuma reserva ?>
		<div class="row">
			<div class="col-md-12 h3" align="center">Você não possui nenhuma reserva no momento</div>
		</div>
		<br /><br />
		
	<?php } else { //Se tiver alguma reserva ?>
	<div class="row">
		<div class="col-md-6">
			<h3>Minhas Reservas</h3>
		</div>
	</div>
	<br />


<!-- Exibe os itens do carrinho -->
<div class="row">
	<!-- Exibe itens incluídos no carrinho -->
	<table class="table table-striped table-responsive" >
		<tr>
			<th width="15%" style="text-align: center;">Número da Reserva</th>
			<th width="10%" style="text-align: center;">Data</th>
			<th colspan="2" style="text-align: center;">Itens Reservados</th>
			<th width="10%" style="text-align: center;">Total de Itens</th>
			<th width="10%" style="text-align: rigth;">Valor da Total</th>
			<th width="15%"></th>
		</tr>
	<?php
	/**************************** MONTAR LINHA PARA RESERVA ****************************/
	//Monta uma linha para cada Reserva do usuário logado	
	$res = mysqli_query($dbc,$sql);
	while ($reg = mysqli_fetch_array($res)) {
		$id = $reg['ID'];
		$cd_cliente = $reg['CD_CLIENTE'];
		$data = date('d/m/Y', strtotime($reg['DATA_RESERVA']));
		$nome_cliente = $reg['nome'];
		$status = $reg['STATUS'];
	/***********************************************************************************/
	?>	
		<tr>
			<td align="center" style="vertical-align: middle;"><?= $id; ?></td>
			<td align="center" style="vertical-align: middle;"><?= $data; ?></td>
			
			<td colspan="2" style="vertical-align: middle;"><?php
					/**************************** MONTAR LINHA PARA ITENS ****************************/
					//Exibe cada Item da Reserva em uma linha da linha da Reserva
					$sql_itens = "select ir.*, p.descricao, p.valor_diaria, p.cd_interno
								  from itens_reserva ir
								  inner join produto p on p.id = ir.cd_produto
								  where ir.cd_reserva = $id 
								  order by ir.id";
					$res_itens = mysqli_query($dbc, $sql_itens);
					$total_itens = @mysqli_num_rows($res_itens);
	
					$valor_total = 0;
					$i = 0;
					while ($reg_itens = mysqli_fetch_array($res_itens)) {
						$i++;
						$id_item = $reg_itens['ID'];
						$cd_produto = $reg_itens['CD_PRODUTO'];
						$descricao = $reg_itens['descricao'];
						$valor_diaria = $reg_itens['valor_diaria'];
						$cd_interno = $reg_itens['cd_interno'];
						$valor_total += $valor_diaria;
						echo ($i.'º - '.$descricao.'<br />'); 
					} 
					/***********************************************************************************/
					?>
			</td>
			
			<td align="center" style="vertical-align: middle;"><?= $total_itens; ?></td>
			<td align="center" style="vertical-align: middle;">R$ <?php echo number_format($valor_total,2,',','.'); ?></td>
			<?php 
			/**************************** MONTAR BOTÃO CANCELAR OU STATUS ****************************/
			//Se o cliente ainda não foi retirar o produto na loja, ainda é possível cancelar a reserva
			if (!isset($status)) {
				echo '<td style="vertical-align: middle;"><a href="minhas_reservas.php?id_excluir='.$id.'&excluir=S" class="btn btn-danger">Cancelar Reserva</a></td>';
			}
			//Se o cliente já retirou o produto na loja, o sistema em Delphi altera o Status para F
			else if (isset($status) && $status == 'F') {
				echo '<td style="vertical-align: middle; color: green;"><strong>Reserva Finalizada!</strong></td>';
			}
			//Se 5 dias corridos se passaram desde a data da reserva e o cliente não retirou o produto na loja, a reserva é finalizada automaticamente e o Status é
			//alterado para A
			else if (isset($status) && $status == 'A') {
				echo '<td style="vertical-align: middle; color: red;"><strong>Reserva Finalizada Automaticamente!</strong></td>';
			}
			/*****************************************************************************************/
			?>
			
		</tr>
			
			
		<?php } //Encerra o While que exibe todas as reservas ?>
		<tr>
			<td colspan="7">
				<strong>Atenção! Sua reserva será cancelado automaticamente após 5 dias corridos. Por favor, se dirija a nossa loja mais próxima para realizar o pagamento e retirar o produto.</strong><br /><br />
				<font color="green" size="2"><strong>* Reserva Finalizada:</strong></font> <font size="2" style="font-weight: ligth;">Você já retirou os produtos desta reserva em nossa loja.</font><br />
				<font color="red" size="2"><strong>* Reserva Finalizada Automaticamente:</strong></font> <font size="2" style="font-weight: ligth;">Se passaram 5 dias corridos após a data da Reserva e você não retirou os produtos em nossa loja.</font>
			</td>
		</tr>
		</table>
	<?php } //Encerra o ELSE que verifica se tem itens ?>
	
	<div class="col-md-10"></div>
	<div class="col-md-2" align="center"><a href="index.php" class="btn btn-primary">Voltar para a Loja</a></div>
</div>