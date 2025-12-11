<?php
// Función para cargar variables desde el archivo .env
function loadEnvFile() {
    // Lista de posibles ubicaciones del archivo .env
    $possible_paths = [
        __DIR__ . '/../.env',  // Carpeta superior (raíz del proyecto)
        __DIR__ . '/.env',     // Misma carpeta que db.php
        '.env'                 // Directorio de trabajo actual
    ];
    
    $loaded = false;
    
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {
                // Ignorar comentarios
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                
                // Dividir en clave y valor
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value);
                    
                    // Establecer variable de entorno
                    putenv("$name=$value");
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
            
            $loaded = true;
            break; // Detener después de cargar el primer archivo encontrado
        }
    }
    
    return $loaded;
}

// Intentar cargar el archivo .env
loadEnvFile();

// Detectar el entorno (Docker o producción)
$is_docker_env = getenv('DOCKER_ENV') === 'true' || file_exists('/.dockerenv');

if ($is_docker_env) {
    // Entorno Docker - intentar usar variables del .env con valores predeterminados de respaldo
    $servername = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?? 'db';
    $dbName = $_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE') ?? 'app_db';
    $username = $_ENV['DB_USERNAME'] ?? getenv('DB_USERNAME') ?? 'app_user';
    $password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? 'app_password';
    $port = $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306;
}

/*
$conn = mysqli_init(); 
if (!$conn) {
  die("mysqli_init failed");
}

mysqli_ssl_set($conn, NULL, NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL); 
mysqli_real_connect($conn, $servername, $username, $password, $dbName, 3306);

if (!$conn) {
  die("Connect Error: " . mysqli_connect_error());
}
*/
$conn = mysqli_connect($servername,$username,$password,$dbName,$port);

if(!$conn){
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

mysqli_set_charset($conn,"utf8mb4");

// if (mysqli_connect_errno()) {
//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
//   exit();
// } 

?>