<?php
class UserModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function authenticate($username, $md5Password) {

        //consulta sql con pdo
        $sql = "SELECT * FROM usuarios WHERE username = :username AND password = :password AND status = 'Activo'";
        $smtp = $this->conn->prepare($sql);

        //Vinculamos los parametros
        $smtp->bindParam(':username', $username, PDO::PARAM_STR);
        $smtp->bindParam(':password', $md5Password, PDO::PARAM_STR);

        //Ejecutamos y obtenemos los resultados
        $smtp->execute();
        $data = $smtp->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function getUserInfo($userId) {
        $sql = "SELECT id_user, name_user, foto, permisos_acceso FROM usuarios WHERE id_user = :userId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    //Métodos para recuperar contraseña por email

    //Método para guardar el token de recuperación y su expiración para un usuario.
    public function saveResetToken($userId, $token, $expiresAt) {
       $sql = "UPDATE usuarios SET reset_token = :token, reset_token_expires_at = :expiresAt WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
        'token' => $token,
        'expiresAt' => $expiresAt,
        'id_user' => $userId
    ]);
}

    //Buscar un usuario por su email.
    public function findUserByEmail($email) {
        $sql = "SELECT id_user, name_user, email FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Busca un usuario por token y verifica si no ha expirado.
    public function findUserByResetToken($token) {
        $sql = "SELECT id_user, email FROM usuarios WHERE reset_token = :token AND reset_token_expires_at > NOW() LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Restablece la contraseña y limpia el token.
    public function resetPassword($userId, $newHashedPassword) {
        // Usamos la tabla 'usuarios'
        $sql = "UPDATE usuarios SET password = :password, reset_token = NULL, reset_token_expires_at = NULL WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'password' => $newHashedPassword,
            'id_user' => $userId
        ]);
    }
}
