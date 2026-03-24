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

function fetch_posts(PDO $pdo): array {
    $sql = 'SELECT id, hostname, ip, cidr, gateway, vlan, port, created_at FROM poste ORDER BY id DESC';
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function find_post(PDO $pdo, int $id): ?array {
    $sql = 'SELECT id, hostname, ip, cidr, gateway, vlan, port, created_at FROM poste WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function fetch_pentests(PDO $pdo, int $posteId): array {
    $sql = 'SELECT id, poste_id, type, test_date, result, comment, score, level, created_at FROM pentest WHERE poste_id = :poste_id ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['poste_id' => $posteId]);
    return $stmt->fetchAll();
}
