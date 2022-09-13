<?php
class Gallery {	
   
	private $userGalleryTable = 'user_gallery';	
	private $conn;
	
	public function __construct($db){
        $this->conn = $db;
    }
	
	function getGalleryList(){	
		$sqlQuery = "
			SELECT id, user_id, image_title, image_description, image_name
			FROM ".$this->userGalleryTable." 
			WHERE user_id='".$_SESSION["userid"]."'";			
			$stmt = $this->conn->prepare($sqlQuery);
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	public function insert(){
		
		if($this->image_name && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO ".$this->userGalleryTable."(`user_id`, `image_title`, `image_description`, `image_name`)
				VALUES(?, ?, ?, ?)");
		
			$this->image_name = htmlspecialchars(strip_tags($this->image_name));
			$this->description = htmlspecialchars(strip_tags($this->description));
			$this->image_title = htmlspecialchars(strip_tags($this->image_title));
			
			$stmt->bind_param("ssss", $_SESSION["userid"], $this->image_title, $this->description, $this->image_name);
			
			if($stmt->execute()){
				return true;
			}		
		}
	}

	public function delete(){
		if($this->id && $_SESSION["userid"]) {		

			$imgSqlQuery = "
				SELECT image_name
				FROM ".$this->userGalleryTable." 
				WHERE id = ? AND user_id='".$_SESSION["userid"]."'";			
			$imgStmt = $this->conn->prepare($imgSqlQuery);
			$imgStmt->bind_param("i", $this->id);
			$imgStmt->execute();	
			$result = $imgStmt->get_result();
			$imageName = '';
			while ($image = $result->fetch_assoc()) { 				
				$imageName = $image["image_name"];
			}

			$stmt = $this->conn->prepare("
				DELETE FROM ".$this->userGalleryTable." 
				WHERE id = ? AND user_id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("ii", $this->id, $_SESSION["userid"]);

			if($stmt->execute()){			
				$filePath = $_SERVER['DOCUMENT_ROOT']."/image-gallery-php/uploads/".$imageName;
				echo  $filePath;
				if ($imageName && file_exists($filePath)) {
					unlink($filePath);
				}				
				return true;
			}
		}
	}
	
	
}
?>