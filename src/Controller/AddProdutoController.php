<?php 	

require_once __DIR__ .'/../Model/ProdutosModel.php';

require_once __DIR__ .'/../../config/Config.php';

require_once __DIR__ .'/../Model/Utils/FileUtil.php';

class AddProdutoController {
	public function addProduto($produto)
	{
		try{

			$produtosModel = new ProdutosModel();
	
			$produtos = $produtosModel->addProduto($produto);
	
			return $produtos;
		} catch (PDOException $exception) {
			return $exception;
		}

	}

	public function validateFields(array $fields, array $imagem) {

		$errors = [];

		if(empty($imagem)) {
			$errors['imagem'] = "O campo imagem e obrigatorio";
		}

		if(empty($fields['nome'])) {
			$errors['nome'] = "O campo nome e obrigatorio";
		}

		if(empty($fields['preco'])) {
			$errors['preco'] = "O campo preco e obrigatorio";
		}

		if(!is_numeric($fields['preco'])) {
			$errors['preco'] = "O campo preco deve ser um valor numerico";
		}

		if(empty($fields['estoque'])) {
			$errors['estoque'] = "O campo estoque e obrigatorio";
		}

		if(!is_numeric($fields['estoque'])) {
			$errors['estoque'] = "O campo estoque deve ser um valor numerico";
		}

		return $errors;
	}
}

if(!empty($_POST)) {
	try {
		$addProdutos = new AddProdutoController();
		$validate = $addProdutos->validateFields($_POST, $_FILES);

		if(!empty($validate)) {
			$errors = array("status" => "error", "errors" => $validate);
			throw new Exception(json_encode($errors), 422);
			exit;
		}

		$produtosModel = new ProdutosModel();

		$nextId = $produtosModel->getNextID();
		if(is_null($nextId)){
			$nextId = 1;
		}

		$file = new FileUtil();
		$filename = $file->saveFile($_FILES['imagem'], $nextId);

		$produtosModel->nome = $_POST['nome'];
		$produtosModel->preco = $_POST['preco'];
		$produtosModel->estoque = $_POST['estoque'];
		$produtosModel->imagem = $filename;

		$res = $produtosModel->addProduto();

		header('Content-Type: application/json; charset=utf-8');
		http_response_code(201);
		echo json_encode(array("status" => "success", "message" => "Produto adicionado com sucesso"));

	} catch (Exception $exception) {
		header('Content-Type: application/json; charset=utf-8');

		if(!empty($exception->getCode()) && ($exception->getCode() == 422 || $exception->getCode() == 400)) {
			http_response_code($exception->getCode());
			echo $exception->getMessage();
		}else {
			http_response_code(500);
			$error_message = array("status" => "error", "message" => "Erro ao adicionar o produto");
			echo json_encode($error_message);
		}

	}
}

?>