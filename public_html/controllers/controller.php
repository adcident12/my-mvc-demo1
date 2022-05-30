<?php
class controller
{
    private $db;

    public function __construct()
    {
        $part = str_replace("controllers", "", __DIR__);
        require_once realpath($part . "/vendor/autoload.php");
        require_once realpath($part . "/config/database.php");

        $dotenv = Dotenv\Dotenv::createImmutable($part);
        $dotenv->load();

        $database = new Database($_ENV['HOST'], $_ENV['DATABASE_NAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
        $this->db = $database->getConnection();
    }

    public function connect()
    {
        return $this->db;
    }
}
