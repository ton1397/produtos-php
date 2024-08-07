<?php 	

require_once __DIR__ .'/../Model/ProdutosModel.php';

require_once __DIR__ .'/../../config/Config.php';

require_once __DIR__ .'/../Model/Utils/FileUtil.php';

class UpdateProdutoController {
	public function updateProduto($produto)
	{
		try{

			$produtosModel = new ProdutosModel();
	
			$produtos = $produtosModel->updateProduto($produto);
	
			return $produtos;
		} catch (PDOException $exception) {
			return $exception;
		}

	}

	public function validateFields(array $fields) {

		$errors = [];

		if(empty($fields['id'])) {
			$errors['id'] = "O campo id e obrigatorio";
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
		$updateProdutos = new UpdateProdutoController();
		$validate = $updateProdutos->validateFields($_POST);

		if(!empty($validate)) {
			$errors = array("status" => "error", "errors" => $validate);
			throw new Exception(json_encode($errors), 422);
			exit;
		}
		
		$produtosModel = new ProdutosModel();
		$produtosModel->id = $_POST['id'];
		$produtosModel->nome = $_POST['nome'];
		$produtosModel->preco = $_POST['preco'];
		$produtosModel->estoque = $_POST['estoque'];

		if(!empty($_FILES["imagem"])) {
			$file = new FileUtil();
			$file->removeFileId($produtosModel->id);
			$filename = $file->saveFile($_FILES['imagem'], $produtosModel->id);
			$produtosModel->imagem = $filename;
		}

		$res = $produtosModel->updateProduto();

		header('Content-Type: application/json; charset=utf-8');
		http_response_code(200);
		echo json_encode(array("status" => "success", "message" => "Produto atualizado com sucesso"));
	} catch (Exception $exception) {
		header('Content-Type: application/json; charset=utf-8');

		if(!empty($exception->getCode()) && ($exception->getCode() == 422 || $exception->getCode() == 400)) {
			http_response_code($exception->getCode());
			echo $exception->getMessage();
		}else {
			http_response_code(500);
			$error_message = array("status" => "error", "message" => "Erro ao atualizar o produto");
			echo json_encode($error_message);
		}

	}
}

?>