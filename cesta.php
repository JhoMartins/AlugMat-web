<?php
	$titulo = "Alugmat - Reserva de Materiais e Ferramentas";
	require_once('includes/conexao.php');
	require_once('includes/cabecalho_site.php');
	
	//Recuperar valores passado pela página detalhes
	$produto = isset($_GET['produto']) ? $_GET['produto'] : '';
	$inserir = isset($_GET['inserir']) ? $_GET['inserir'] : '';
	
	//Captura o último ID da tabela PEDIDO
	$sql = "select id from reservas order by id desc";
	//die($sql);
	$res = mysqli_query($dbc, $sql);
	$reg = mysqli_fetch_array($res);
	$id_r = (isset($reg['id'])) ? $reg['id'] : 0;
	$cd_cliente = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;
	
	$atualiza_pk = "alter table reservas auto_increment = $id_r";
	mysqli_query($dbc,$atualiza_pk);
	
	//Insere um registro na tabela pedidos com o número do pedido
	if (!isset($_SESSION['id_reserva']) && $inserir == 'S') {
		//Incrementa 1 ao último pedido
		$id_reserva = $id_r + 1;
		//die("id_r: ".$id_r." - id_reserva: ".$id_reserva);
		
		//Prepara o número (id_pedido)
		$_SESSION['id_reserva'] = $id_reserva;
		
		$sqli = "insert into reservas (data_reserva) values (NOW())";
		//die($sqli);
		mysqli_query($dbc, $sqli);
	}
	
	if (isset($_SESSION['id']) && isset($_SESSION['id_reserva'])) {
		$sqlu = "update reservas set cd_cliente = ".$_SESSION['id']." where id = ".$_SESSION['id_reserva'];
		//die($sqlu);
		mysqli_query($dbc, $sqlu);
	}
	
	//Excluir item do carrinho
	$excluir = isset($_GET['excluir']) ? $_GET['excluir'] : '';
	$id_item = isset($_GET['id']) ? $_GET['id'] : '';
	
	if ($excluir == "S") {
		$sqld = "delete from itens_reserva where id = '" . $id_item . "'";
		mysqli_query($dbc,$sqld);
	}
	
	//Capturar dados do produto selecionado
	$sql = "select id, descricao, cd_interno, valor_diaria, cd_cliente from produto where id = '" . $id_item . "'";
	$res = mysqli_query($dbc, $sql);
	$reg = mysqli_fetch_array($res);
	
	$id = $reg["id"];
	$descricao = $reg["descricao"];
	$cd_interno = $reg["cd_interno"];
	$valor_diaria = $reg["valor_diaria"];
	$cd_cliente = $reg["cd_cliente"];
	
	//Verifica se o item já se encontra no carrinho
	$sql_dup = "select cd_produto from itens_reserva where cd_produto = '" . $produto . "' and cd_reserva = '" . @$_SESSION['id_reserva'] . "'";
	$res_dup = mysqli_query($dbc, $sql_dup);
	$item_duplicado = mysqli_num_rows($res_dup);
	
	if ($item_duplicado == 0 && $inserir == 'S') {
		$sqli = "insert into itens_reserva (cd_reserva, cd_produto) VALUES (".$_SESSION['id_reserva'].", $produto)";
		//die($sqli);
		mysqli_query($dbc,$sqli);
	}
	
	//Capturar itens do carrinho
	$sql = "select ir.*, p.descricao, p.valor_diaria, p.cd_interno
			from itens_reserva ir
			inner join produto p on p.id = ir.cd_produto
			where ir.cd_reserva = " . @$_SESSION['id_reserva'] . " 
			order by ir.id";
	//die("<pre>".$sql."</pre>");
	$res = mysqli_query($dbc, $sql);
	$total_itens = @mysqli_num_rows($res);
	$_SESSION['total_itens'] = $total_itens;
?>

<div class="row">
	<?php if (!isset($_SESSION['id_reserva'])) { ?>
		<div class="row">
			<div class="col-md-12 h3" align="center">Seu carrinho está vazio</div>
		</div>
		<br /><br />
		
			<div class="col-md-10"></div>
			<div class="col-md-2" align="center"><a href="index.php" class="btn btn-primary">Voltar para a Loja</a></div>
		
	<?php } else { ?>
	<div class="row">
		<div class="col-md-6">
			<h3>Meu carrinho</h3>
		</div>
			<div class="col-md-6 h3">
				<div align="right">Numero da sua reserva:
					<span class="bg-success">
						<?php echo $_SESSION['id_reserva']; ?>
					</span>
				</div>
		</div>
	</div>
	<br />

<!-- Exibe os itens do carrinho -->
<div class="row">
	<form name="cesta" method="post" action="cesta.php?atualiza=S" onsubmit="return valida_form(this);">

	<!-- Exibe itens incluídos no carrinho -->
		<table class="table table-striped table-responsive" >
			<tr>
				<th colspan="2">Descrição do Produto</th>
				<th width="15%" style="text-align: center;">Cód. Interno</th>
				<th width="10%" style="text-align: center;">Excluir Item</th>
				<th width="10%" style="text-align: center;">Valor da Diária</th>
			</tr>
			
			<?php
				$total = 0;
				$n = 0;
				
				while ($reg = mysqli_fetch_array($res)) {
					$n++;
					$id_item = $reg['ID'];
					$cd_produto = $reg['CD_PRODUTO'];
					$descricao = $reg['descricao'];
					$valor_diaria = $reg['valor_diaria'];
					$cd_interno = $reg['cd_interno'];
					$total += $valor_diaria;
			?>
			
			<tr>
				<td colspan="2" style="vertical-align: middle;"><img src='img/<?= $cd_produto; ?>.jpg' width="53" height='32' align='absmiddle' />&nbsp;&nbsp;&nbsp;<?= $cd_produto; ?> - <?= $descricao; ?></td>
				<td align="center" style="vertical-align: middle;"><?= $cd_interno; ?></td>
				<td align="center" style="vertical-align: middle;"><a href="cesta.php?id=<?= $id_item; ?>&excluir=S"><img src="img/btn_removerItem.gif" alt="Remover" hspace="5" border="0" /></a></td>
				<td align="right" style="vertical-align: middle;">R$ <?php echo number_format($valor_diaria,2,',','.'); ?></td>
				
				<!-- Armazena id e código do item nos campos ocultos para serem capturados pelo POST do formulário -->
				<input type="hidden" name="id<?= $produto; ?>" value= "<?= $id_item; ?>" />
				<input type="hidden" name="cod<?= $produto; ?>" value= "<?= $produto; ?>" />
			</tr>
			<?php } ?>
			
			<tr>
				<th colspan="3">* Após reservar seu produto, por favor, se dirija à nossa loja mais próxima para realizar o pagamento e retirar seu produto.</th>
				<th align="right" style="text-align: right;">Total:</th>
				<th align="right" style="text-align: right;">R$ <?php echo number_format($total,2,',','.'); ?></th>
			</tr>

			<tr>
				<td colspan="4"><a href="index.php" class="btn btn-default">Reservar mais produtos</a>
				<?php if (!isset($_SESSION['id'])) { ?>
					<td><div align="right"><a href="adm/login.php" class="btn btn-success">Finalizar Reservas</a></div></td>
				<?php } else { ?>
					<td><div align="right"><a href="minhas_reservas.php?finaliza=S" class="btn btn-success">Finalizar Reservas</a></div></td>
				<?php }
				} //Encerra o ELSE que verifica se tem itens no carrinho ?>
				
			</tr>
		</table>
	</form>	
</div>