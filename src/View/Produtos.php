<?php 
	require_once __DIR__.'/../Controller/ProdutosController.php';
	
	$produtosController = new ProdutosController();

	$produtos = $produtosController->getProdutos();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<div class="produtos container mx-auto py-10">
	<h1 class="text-4xl font-bold text-white text-center mb-5">Produtos</h1>
	<div class="border border-white rounded-md">

		<table class="table-auto w-full my-2 text-white text-center">
			<thead class="rounded-md border-b h-10 text-xl font-bold">
				<th>Imagem</th>
				<th>Nome</th>
				<th>Preço</th>
				<th>Estoque</th>
				<th>Ações</th>
			</thead>
			<tbody class="text-lg">
				<?php if(empty($produtos)): ?>
					<tr>
						<td colspan="5">Nenhum registro encontrado</td>
					</tr>

				<?php endif; ?>
				
				<?php foreach($produtos as $key => $value): ?>
					<tr class="h-16 rounded-md <?= $key < count($produtos) - 1 ? 'border-b' : '' ?> font-bold hover:bg-white hover:text-green-700 hover:cursor-pointer" 
						data-id="<?= $value['id'] ?>"
					>
						<td onclick="openModal(<?= $value['id'] ?>)">
							<img src="<?= 'imgs/'. $value['imagem'] ?>" alt="" class="w-16 mx-auto rounded-md"/>
						</td>
						<td onclick="openModal(<?= $value['id'] ?>)">
							<?= $value['nome'] ?>
						</td>
						<td onclick="openModal(<?= $value['id'] ?>)">
							<?= "R$ ".str_replace('.', ',', $value['preco']) ?>
						</td>
						<td onclick="openModal(<?= $value['id'] ?>)">
							<?= $value['estoque'] ?>
						</td>
						<td>
							<button onclick="deleteProduto(<?= $value['id'] ?>)" class="background-red-600 bg-red-700 text-white font-bold py-2 px-4 rounded flex mx-auto b-none">
								<svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
									<path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
								</svg>
								
							</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="absolute bottom-10	right-10">
		<button data-modal-target="crud-modal" onclick="openModal()">
			<svg class="w-20 h-20 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
				<path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"/>
			</svg>
		</button>
	</div>

	<!-- Main modal -->
	<?php include __DIR__ .'/../View/Components/ModalProduto.php'; ?>

</div>

<script defer src="./js/Produtos.js"></script>
</body>
</html>