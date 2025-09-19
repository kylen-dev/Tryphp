<?php
// inc/db.php
// Returns a PDO instance. Looks for DATABASE_URL first (e.g., render's DATABASE_URL),
// otherwise falls back to DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD.

function get_db_pdo(): PDO {
    $dsn = null;
    $user = null;
    $pass = null;
    if (!empty(getenv('DATABASE_URL'))) {
        // Support DATABASE_URL like: postgres://user:pass@host:port/dbname
        $url = parse_url(getenv('DATABASE_URL'));
        $scheme = $url['scheme'] ?? '';
        if ($scheme === 'postgres' || $scheme === 'postgresql') {
            $host = $url['host'] ?? '127.0.0.1';
            $port = $url['port'] ?? 5432;
            $db   = ltrim($url['path'] ?? '', '/');
            $user = $url['user'] ?? null;
            $pass = $url['pass'] ?? null;
            $dsn  = "pgsql:host={$host};port={$port};dbname={$db}";
        } else {
            // assume mysql-like
            $host = $url['host'] ?? '127.0.0.1';
            $port = $url['port'] ?? 3306;
            $db   = ltrim($url['path'] ?? '', '/');
            $user = $url['user'] ?? null;
            $pass = $url['pass'] ?? null;
            $dsn  = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        }
    } else {
        $driver = getenv('DB_CONNECTION') ?: 'mysql';
        $host   = getenv('DB_HOST') ?: '127.0.0.1';
        $port   = getenv('DB_PORT') ?: ($driver === 'pgsql' ? 5432 : 3306);
        $db     = getenv('DB_DATABASE') ?: 'app';
        $user   = getenv('DB_USERNAME') ?: 'root';
        $pass   = getenv('DB_PASSWORD') ?: '';
        if ($driver === 'pgsql') {
            $dsn = "pgsql:host={$host};port={$port};dbname={$db}";
        } else {
            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        }
    }

    if (!$dsn) {
        throw new Exception("No database DSN configured in environment.");
    }

    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    return new PDO($dsn, $user, $pass, $opts);
}
