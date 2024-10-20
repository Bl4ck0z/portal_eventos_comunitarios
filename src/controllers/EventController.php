<?php
class EventController {
    private $conn;

    // Constructor que recibe la conexión a la base de datos
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Método para obtener eventos más recientes
    public function getRecentEvents($limit = 3) {
        $sql = "SELECT * FROM eventos ORDER BY fecha DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        
        // Utilizar bindParam para evitar inyección SQL
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retornar los resultados como un array asociativo
        } else {
            return []; // Retornar un array vacío si hay un error
        }
    }
}
?>