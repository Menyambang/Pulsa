<?php

/**
 * @var $filename
 * @var $allowedFields
 * @var $tableDescription
 * @var $prefixCount
 */
echo "<?php namespace App\Entities;
use App\Entities\MyEntity;

class $filename extends MyEntity
{
    protected \$datamap = [\n";
foreach ($tableDescription as $row) {
    echo "        '" . lcfirst(substr($row['Field'], $prefixCount)) . "' => '$row[Field]',\n";
}
echo "    ];

    protected \$show = [\n";
foreach ($tableDescription as $row) {
    echo "\t\t'" . lcfirst(substr($row['Field'], $prefixCount)) . "',\n";
}
echo "    ];
}";
