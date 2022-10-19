<?php

/**
 * @var $folder
 * @var $tablename
 * @var $filename
 * @var $primaryKey
 * @var $allowedFields
 * @var $createdAt
 * @var $updatedAt
 * @var $prefixCount
 */
echo "<?php namespace App\Controllers;

use App\Controllers\MyResourceController;
/**
 * Class $filename
 * @note Resource untuk mengelola data $tablename
 * @dataDescription $tablename
 * @package App\Controllers
 */
class $filename extends MyResourceController
{
    protected \$modelName = 'App\Models\\$filename" . "Model';
    protected \$format    = 'json';

    protected \$rulesCreate = [\n";
foreach ($allowedFields as $field) {
    echo "       '" . lcfirst(substr($field, $prefixCount)) . "' => ['label' => '" . lcfirst(substr($field, $prefixCount)) . "', 'rules' => 'required'],\n";
}
echo "   ];

    protected \$rulesUpdate = [\n";
foreach ($allowedFields as $field) {
    echo "       '" . lcfirst(substr($field, $prefixCount)) . "' => ['label' => '" . lcfirst(substr($field, $prefixCount)) . "', 'rules' => 'required'],\n";
}
echo "   ];
}
";
