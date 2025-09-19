<?php
// inc/db.php
// Returns a PDO instance for your Render Postgres database.

function get_db_pdo(): PDO {
    // Directly use your Render Postgres URL
    $url = parse_url('postgres://tryphpdb_user:NUIHpl2WRo2VBQZleyO6LmLiwnrQhFcc@dpg-d36gje7fte5s73bf098g-a.singapore-postgres.render.com/tryphpdb');

    $host = $url['host'] ?? '127.0.0.1';
    $port = $url['port'] ?? 5432;
    $db   = ltrim($url['path'] ?? '', '/');
    $user = $url['user'] ?? null;
    $pass = $url['pass'] ?? null;

    $dsn = "pgsql:host={$host};port={$port};dbname={$db}";

    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $user, $pass, $opts);
}
