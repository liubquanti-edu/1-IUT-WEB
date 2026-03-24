<?php
function get_pdo(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_NAME') ?: 'auditdb';
    $user = getenv('DB_USER') ?: 'audit_user';
    $pass = getenv('DB_PASS') ?: 'audit_pass1!';

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $dbname);
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function fetch_posts(PDO $pdo, int $userId): array {
    $sql = 'SELECT id, hostname, ip, cidr, gateway, vlan, port, created_at
            FROM poste
            WHERE utilisateur_id = :user_id
            ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}

function find_post(PDO $pdo, int $id, int $userId): ?array {
    $sql = 'SELECT id, hostname, ip, cidr, gateway, vlan, port, created_at, utilisateur_id
            FROM poste
            WHERE id = :id AND utilisateur_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'user_id' => $userId]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function fetch_pentests(PDO $pdo, int $posteId, int $userId): array {
    $sql = 'SELECT id, poste_id, type, test_date, result, comment, score, level, created_at
            FROM pentest
            WHERE poste_id = :poste_id AND utilisateur_id = :user_id
            ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['poste_id' => $posteId, 'user_id' => $userId]);
    return $stmt->fetchAll();
}

function find_user_by_credentials(PDO $pdo, string $login, string $password): ?array {
    $sql = 'SELECT id, login FROM utilisateur WHERE login = :login AND mot_de_passe = :password LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'login'    => $login,
        'password' => $password,
    ]);
    $row = $stmt->fetch();
    return $row ?: null;
}
