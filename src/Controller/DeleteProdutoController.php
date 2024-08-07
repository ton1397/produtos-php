<?php 	

require_once __DIR__ .'/../Model/ProdutosModel.php';

require_once __DIR__ .'/../../config/Config.php';

require_once __DIR__ .'/../Model/Utils/FileUtil.php';

class DeleteProdutoController {
	public function deleteProduto($produto)
	{
		try{

			$produtosModel = new ProdutosModel();
	
			$produtos = $produtosModel->deleteProduto($produto);
	
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

		return $errors;
	}
}


if(!empty($_GET)) {
	try {
		$deleteProduto = new DeleteProdutoController();
		$validate = $deleteProduto->validateFields($_GET);

		if(!empty($validate)) {
			$errors = array("status" => "error", "errors" => $validate);
			throw new Exception(json_encode($errors), 422);
			exit;
		}
		
		$produtosModel = new ProdutosModel();
		$produtosModel->id = intval($_GET['id']);

		$produtoInfo = $produtosModel->getProdutosById($produtosModel->id);


		if(empty($produtoInfo)) {
			$error = array("status" => "error", "message" => "Nenhum registro encontrado");
			throw new Exception(json_encode($error), 400);
			exit;
		}

		$file = new FileUtil();

		$file->removeFileId($produtosModel->id);

		$res = $produtosModel->deleteProduto($produtosModel->id);

		header('Content-Type: application/json; charset=utf-8');
		http_response_code(200);
		echo json_encode(array("status" => "success", "message" => "Produto deletado com sucesso"));
	} catch (Exception $exception) {
		header('Content-Type: application/json; charset=utf-8');

		if(!empty($exception->getCode()) && ($exception->getCode() == 422 || $exception->getCode() == 400)) {
			http_response_code($exception->getCode());
			echo $exception->getMessage();
		}else {
			http_response_code(500);
			$error_message = array("status" => "error", "message" => "Erro ao deletar o produto");
			echo json_encode($error_message);
		}

	}
}

?>