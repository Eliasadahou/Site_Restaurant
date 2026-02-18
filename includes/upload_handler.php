<?php
class UploadHandler {
    private $uploadDir;
    private $allowedTypes;
    private $maxFileSize;

    public function __construct($uploadDir = 'uploads/') {
        $this->uploadDir = $uploadDir;
        $this->allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $this->maxFileSize = 50 * 1024 * 1024; // 50MB - pas de limite stricte
    }

    public function uploadImage($fileInput, $prefix = 'menu') {
        if (!isset($fileInput) || $fileInput['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Vérifier le type de fichier
        $fileType = mime_content_type($fileInput['tmp_name']);
        if (!in_array($fileType, $this->allowedTypes)) {
            throw new Exception("Type de fichier non autorisé. Formats acceptés: JPG, PNG, GIF, WebP");
        }

        // Créer le dossier s'il n'existe pas
        $uploadPath = $this->uploadDir . date('Y/m/');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Générer un nom de fichier unique
        $extension = pathinfo($fileInput['name'], PATHINFO_EXTENSION);
        $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $extension;
        $destination = $uploadPath . $filename;

        // Déplacer le fichier
        if (move_uploaded_file($fileInput['tmp_name'], $destination)) {
            return $destination;
        }

        return null;
    }

    public function deleteImage($imagePath) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
            return true;
        }
        return false;
    }

    public function getImageUrl($imagePath) {
        if ($imagePath && file_exists($imagePath)) {
            return $imagePath;
        }
        return null;
    }
}
?>
