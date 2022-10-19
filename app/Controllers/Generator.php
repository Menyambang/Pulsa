<?php


namespace App\Controllers;


use CodeIgniter\Controller;
use App\Generator\Handler\ModelGenerator;
use App\Generator\Handler\EntityGenerator;
use App\Generator\Handler\ControllerGenerator;

class Generator extends Controller
{

    /**
     * Auto Generate Controller, Entities, Model, dan Routes untuk Satu Table Database
     * 
     * Penggunaan : 
     * 1. Buka Terminal
     * 2. Masuk ke folder public
     * 3. jalankan perintah php index.php generator run nama_table_DB<space>nama_aplikasi<space>nama_kelas<space>nama_route_link<space>prefix
     * 
     * Contoh : 
     * php index.php generator run sia_t_keluar Simari Keluar keluar 3
     * 
     * prefix 3 : 
     * field klrNim = nim
     * filed klrJudulSkripsi = judulSkripsi
     *
     * @param string $tablename
     * @param string $folder
     * @param string $classname
     * @param string $routelink
     * @param int $prefixCount
     *
     * @return void
     */
    public function run($tablename = null, $folder = null, $classname = null, $routelink = null, $prefixCount = 0)
    {
        helper("myfile");

        $db = \Config\Database::connect();
        $rs = $db->query("DESCRIBE $tablename");

        $controllerGenerator = new ControllerGenerator();
        $modelGenerator = new ModelGenerator();
        $entityGenerator = new EntityGenerator();
        $modelGenerator->generate([$tablename, $folder, $classname], $rs->getResultArray(), $prefixCount);
        $controllerGenerator->generate([$tablename, $folder, $classname], $rs->getResultArray(), $prefixCount);
        $entityGenerator->generate([$tablename, $folder, $classname], $rs->getResultArray(), $prefixCount);

        if (!file_exists(APPPATH . "Controllers")) {
            mkdir(APPPATH . "Controllers");
            mkdir(APPPATH . "Entities");
            mkdir(APPPATH . "Models");
        }

        // if ($file = fopen(APPPATH . "/Config/Routes.php", 'a')) {
        //     fwrite($file, "\n\$route->resource(\"$routelink\",['controller'=>'{$folder}\\$classname','only'=>['index','show','create','update','delete']]);" . PHP_EOL);
        //     fwrite($file, "\$route->put(\"$routelink\",'{$folder}\\$classname::update');" . PHP_EOL);
        //     fwrite($file, "\$route->delete(\"$routelink\",'{$folder}\\$classname::delete');" . PHP_EOL);
        //     fclose($file);
        // }

        if (!file_exists(APPPATH . "Controllers/$classname.php"))
            rename2(APPPATH . "Generator/Output/Controllers/$classname.php", APPPATH . "Controllers/$classname.php");

        if (!file_exists(APPPATH . "Models/$classname" . "Model.php"))
            rename2(APPPATH . "Generator/Output/Models/$classname" . "Model.php", APPPATH . "Models/$classname" . "Model.php");

        if (!file_exists(APPPATH . "Entities/$classname" . ".php"))
            rename2(APPPATH . "Generator/Output/Entities/$classname.php", APPPATH . "Entities/$classname.php");
    }
}
