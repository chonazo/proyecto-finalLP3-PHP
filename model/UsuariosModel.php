<?php
class UsuariosModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    /*Obtiemos la contraseña de un usuario por su id
    ===============================================================================================================*/

    public function getPassById($id_user) {
        $sql = "SELECT password FROM usuarios WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    /*Cambiar contraseña de usuarios
    ===============================================================================================================*/

    public function updatePassword($id_user, $new_md5_password) {
        $sql = "UPDATE usuarios SET password = :password WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':password', $new_md5_password, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*Administrar Usuarios
    ===============================================================================================================*/

    //Listar todos los usuarios
    public function getAllUsers() {
        $sql = "SELECT id_user, username, name_user, foto, permisos_acceso, status FROM usuarios ORDER BY id_user DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Actualizar estado de usuarios (activar/bloquear)
    public function updateUserStatus($id_user, $new_status) {
        $sql = "UPDATE usuarios SET status = :status WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $new_status, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /*Agregar editar Usuarios
===============================================================================================================*/
    //Obtener usuario por id
    public function getById($id_user) {
    $sql = "SELECT id_user, username, name_user, email, telefono, permisos_acceso, foto, status 
            FROM usuarios 
            WHERE id_user = :id_user";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($username, $password, $name_user, $permisos_acceso, $email, $telefono, $foto) {
        $sql = "INSERT INTO usuarios (username, password, name_user, permisos_acceso, email, telefono, foto, status) VALUES (:username, :password, :name_user, :permisos_acceso, :email, :telefono, :foto, 'activo')";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':name_user', $name_user, PDO::PARAM_STR);
        $stmt->bindParam(':permisos_acceso', $permisos_acceso, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateUser($id_user, $username, $name_user, $email, $telefono, $permisos_acceso, $foto, $new_password = null) {
        // Inicializamos la consulta SQL
        $sql = "UPDATE usuarios SET username = :username, name_user = :name_user, email = :email, telefono = :telefono, permisos_acceso = :permisos_acceso, foto = :foto";

        // Si se proporcionó una nueva contraseña, le agregamos a la consulta
        if ($new_password !== null) {
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id_user = :id_user";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':name_user', $name_user, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':permisos_acceso', $permisos_acceso, PDO::PARAM_STR);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

        // Si se proporcionó una nueva contraseña, la bindeamos
        if ($new_password !== null) {
            $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function updateProfile($data) {
        try {
            $sql = "UPDATE usuarios SET username = :username, name_user = :name_user, email = :email, telefono = :telefono, foto = :foto WHERE id_user = :id_user";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindParam(':name_user', $data['name_user'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
            $stmt->bindParam(':foto', $data['foto'], PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $data['id_user'], PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            // Manejo de errores
            error_log("Error en updateProfile: " . $e->getMessage());
            return false;
        }
    }
    

    
}
