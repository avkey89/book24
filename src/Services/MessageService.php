<?php


namespace App\Services;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class MessageService
{
    private array $settingsDB = [
        "1" => [
            'url' => 'mysql://root:@localhost/test'
        ],
        "2" => [
            'url' => 'mysql://root:@localhost/test1'
        ],
        "3" => [
            'url' => 'mysql://root:@localhost/test2'
        ],
    ];

    private Configuration $configDB;

    public function __construct()
    {
        $this->configDB = new Configuration();
    }

    public function run(array $messages): void
    {
        $groupMessagesFirm = $this->generateGroupMessage($messages, 'firm_id');

        foreach($groupMessagesFirm as $firm_id => $messageFirm) {
            $this->sendMessage($messageFirm, (string)$firm_id);
        }

        return;
    }

    private function generateGroupMessage(array $messages, $key): array
    {
         $groups = [];
         foreach($messages as $message) {
             if(!isset($message[$key])) {
                 // Exception || Logger
             }
             $groups[$message[$key]][] = $message;
         }

         return $groups;
    }

    private function sendMessage(array $messageFirm, string $key)
    {
        if (isset($this->settingsDB[$key])) {
            try {
                $connection = DriverManager::getConnection($this->settingsDB[$key], $this->configDB);
                $connection->beginTransaction();
                try {
                    $sql = "INSERT INTO table_name(`subject`, `body`, `from`, `to`) VALUES (:subject, :body, :from, :to)";
                    foreach($messageFirm as $message) {
                        unset($message["firm_id"]);
                        $connection->executeQuery($sql, $message);
                    }
                    $connection->commit();
                } catch (\Exception $e) {
                    $connection->rollBack();
                    // Exception || Logger
                }
            } catch (Exception $exception) {
                // Exception || Logger
            }
        } else {
            // Exception || Logger
        }
    }
}