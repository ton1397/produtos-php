<?php 

require_once __DIR__ .'/Database.php';

class ProdutosModel{
	public ?int $id = null;
	public ?string $nome = null;
	public ?float $preco = null;
	public ?int $estoque = null;
	public ?string $imagem = null;

	public function __construct() {
		
	}

	public function getProdutos() {

		$db = new Database();

		$query = "SELECT id, nome, preco, estoque, imagem FROM produtos";

		$produtos = $db->ExecuteQuery($query);

		return $produtos;
	}

	public function getProdutosByID($id) {

		$db = new Database();

		$query = "SELECT id, nome, preco, estoque, imagem FROM produtos WHERE id = ?";

		$parametros = [
			$id
		];

		$produtos = $db->ExecuteQuery($query, $parametros);

		if(empty($produtos)) {
			return null;
		}

		return $produtos[0];
	}

	public function addProduto() {
		
		try {

			$db = new Database();
	
			$query = "
				INSERT INTO produtos (nome, preco, estoque, imagem)
				VALUES (?, ?, ?, ?)
			";

			$produto = [
				$this->nome,
				$this->preco,
				$this->estoque,
				$this->imagem
			];
	
			$res = $db->ExecuteQuery($query, $produto);
	
			return $res;
		} catch (PDOException $exception) {
			throw $exception;
		}

	}

	public function updateProduto() {
		
		try {

			$db = new Database();
	
			$query = "
				UPDATE produtos
				SET nome = ?, preco = ?, estoque = ?
			";

			if(!empty($this->imagem)) {
				$query .= ", imagem = ?";
			}

			$query .= " WHERE id = ?";

			$produto = [
				$this->nome,
				$this->preco,
				$this->estoque,
			];

			if(!empty($this->imagem)) {
				$produto[] = $this->imagem;
			}

			$produto[] = $this->id;
	
			$res = $db->ExecuteQuery($query, $produto);
	
			return $res;
		} catch (PDOException $exception) {
			throw $exception;
		}

	}

	public function deleteProduto($id) {

		$db = new Database();

		$query = "DELETE FROM produtos WHERE id = ?";

		$parametros = [
			$id
		];

		$produtos = $db->ExecuteQuery($query, $parametros);

		return $produtos;
	}

	public function getNextID(){
		$db = new Database();

		$query = "SELECT MAX(id)+1 as nextId FROM produtos;";

		$nextId = $db->ExecuteQuery($query);

		return $nextId[0]['nextId'];

	}
}

?>