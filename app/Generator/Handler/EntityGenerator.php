<?php


namespace App\Generator\Handler;


use App\Generator\Lib\IHandler;

class EntityGenerator implements IHandler
{

    public function generate($arguments, $tableDescription, $prefixCount)
    {
        $tablename = $arguments[0];
        $folder = $arguments[1];
        $filename = $arguments[2];

        $allowedFields = [];
        foreach ($tableDescription as $row) {
            if ($row['Key'] == "PRI") {
                $primaryKey = $row['Field'];
            }
            $isUpdatedAt = (strpos($row['Field'], 'UpdatedAt') !== false);
            $isCreatedAt = (strpos($row['Field'], 'CreatedAt') !== false);
            if ($isCreatedAt) {
                $createdAt = $row['Field'];
            }
            if ($isUpdatedAt) {
                $updatedAt = $row['Field'];
            }
            if ($row['Extra'] != 'auto_increment' && $isCreatedAt == false && $isUpdatedAt == false) {
                $allowedFields[] = $row['Field'];
            }
        }
        ob_start();
        require_once __DIR__ . "/../template/entity.php";
        $template = ob_get_clean();
        file_put_contents(__DIR__ . "/../Output/Entities/" . $filename . ".php", $template);
    }
}
