<?php 	

require_once __DIR__ .'/../Model/ProdutosModel.php';
class ProdutosController {
	public function getProdutos()
	{
		$produtosModel = new ProdutosModel();

		$produtos = $produtosModel->getProdutos();

		return $produtos;
	}
}
?>