<?php 

class FileUtil {

	public function saveFile($file, $id) {
		try {
			$fileOriginalName = $file["name"];
			$ext = strtolower(pathinfo($fileOriginalName, PATHINFO_EXTENSION));
			$filename = "img_".time()."-".$id.".".$ext;
			$targetDir = "../../imgs/";
			$tmpFile = $file["tmp_name"];
			$targetFile = $targetDir . $filename;
			if(@move_uploaded_file($tmpFile, $targetFile)) {
				return $filename;
			} else {
				$error = array("status" => "error", "message" => "Erro ao salvar o arquivo");
				throw new Exception(json_encode($error), 500);
			}
		} catch (Exception $e) {
			$error = array("status" => "error", "message" => $e->getMessage());
			throw new Exception(json_encode($error), 500);
		}
	}

	public function removeFileId($id){
		try{
			$list = glob("../../imgs/*-{$id}*");

			foreach($list as $file){
				if(is_file($file)){
					unlink($file);
				}
			}
		} catch (Exception $e) {
			$error = array("status" => "error", "message" => $e->getMessage());
			throw new Exception(json_encode($error), 500);
		}
	}
}

?>