<?php


namespace App\Controllers;

use Config\Services;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Validation\Exceptions\ValidationException;

class MyResourceController extends ResourceController
{
    const CODE_UNACTIVATED = 110;
    
    protected $defaultLimitData = 100;
    protected $rulesCreate = [];
    protected $rulesUpdate = [];
    protected $validationMessage = [];

    protected $user = null;

    protected $validationDbGroup = null;

    protected $helpers = [
        'myfile'
    ];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper("myfile");
        helper("text");
        $this->user = count($request->fetchGlobal('decoded')) > 0 ? $request->fetchGlobal('decoded') : ['role' => '', 'filterIdentifier' => ''];
		date_default_timezone_set('Asia/Kuala_Lumpur');
    }


    /**
     * @description Mengambil data @dataDescription secara masal
     * @queryUrl limit Limit jumlah data
     * @queryUrl offset offset data
     * @return array|mixed
     */
    public function index()
    {
        $this->applyQueryFilter();
        $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        if ($limit != "-1") {
            $this->model->limit($limit);
        }
        $this->model->offset($offset);
        try {
            return $this->response([
                'rows' => $this->model->find(),
                'limit' => $limit,
                'offset' => $offset,
            ]);
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }

    /**
     * @description Mengambil 1 baris data @dataDescription
     * @param $id
     * @return array|mixed
     */
    public function show($id = null)
    {
        if ($id == null)
            return $this->response(null);

        if ($this->request->getGet("with")) {
            $tableName = $this->model->getTableName();
            $this->model->select($tableName . ".*");
            $this->model->with($this->request->getGet("with"));
        }
        return $this->response($this->model->find($id));
    }
    /**
     * @description Menambahkan data @dataDescription baru
     * @return array|mixed
     */
    public function create()
    {
        if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
            $entityClass = $this->model->getReturnType();
            $entity = new $entityClass();
            $entity->fill($this->request->getVar());
            try {
                $status = $this->model->insert($entity, false);
                if ($this->model->getInsertID() > 0) {
                    $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                }
                return $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * @description Update terhadap 1 data jika parameter "id" diisikan dan masal jika tidak diisikan
     * @requiredHeader X-ApiKey,X-Token
     * @param null $id
     * @return array|mixed
     */
    public function update($id = null)
    {
        if ($this->validate($this->rulesUpdate, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
            if ($id == null)
                $this->applyQueryFilter();
            $entityClass = $this->model->getReturnType();
            $entity = new $entityClass();
            $entity->fill($this->request->getVar());
            try {
                $status = $this->model->set($entity->toRawArray())
                    ->update($id);
                return $this->response($this->request->getVar(), ($status ? 200 : 500));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * @description Menghapus 1 data jika parameter "id" diisikan dan masal jika parameter tidak diisikan
     * @requiredHeader X-ApiKey,X-Token
     * @param null $id
     * @return array|mixed
     */
    public function delete($id = null)
    {
        if ($id == null)
            $this->applyQueryFilter();
        try {
            $cek = $this->model->find($id);
            if ($cek) {
                if ($id == null) {
                    $this->applyQueryFilter();
                    $status = $this->model->delete();
                } else {
                    $status = $this->model->delete($id);
                }
                $status = $status ? 200 : 500;
                $message = '';
            } else {
                $status = 400;
                $message = 'Data tidak tersedia';
            }
            return $this->response(null, $status, $message);
        } catch (DatabaseException $ex) {
            return $this->response(null, 500, $ex->getMessage());
        } catch (\mysqli_sql_exception $ex) {
            if ($ex->getCode() === 1451) {
                return $this->response(null, 500, "Data tidak bisa dihapus karena direferensi oleh data lain");
            }
            return $this->response(null, 500, $ex->getMessage());
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }

    /**
     * @description  Memasang query url menjadi query filter untuk database
     */
    protected function applyQueryFilter($isBuilder = false, $paramDatamap = [])
    {
        $params = $this->request->getGet();
        if ($isBuilder === false) {
            $tableName = $this->model->getTableName();
            $this->model->select($tableName . ".*");
        }
        foreach ($params as $fieldRaw => $filter) {
            if (!in_array($fieldRaw, ["limit", "offset", "with", "operator"])) {
                $relationTable = null;
                $fieldArray = explode("_", $fieldRaw);
                if (count($fieldArray) == 1) {
                    if ($isBuilder === false) {
                        $entityClass = $this->model->getReturnType();
                        $entity = new $entityClass();
                        $datamap = $entity->getDatamap();
                    } else {
                        $datamap = $paramDatamap;
                    }
                    $field = isset($datamap[$fieldArray[0]]) ? $datamap[$fieldArray[0]] : $fieldArray[0];
                } else {
                    $relationName = $fieldArray[0];
                    $entityClass = $this->model->getReturnTypeOfRelation($relationName);
                    $entity = new $entityClass();
                    $datamap = $entity->getDatamap();
                    $field = isset($datamap[$fieldArray[1]]) ? $datamap[$fieldArray[1]] : $fieldArray[1];
                    $field = $relationName . "." . $field;
                }
                if (is_array($filter)) {

                    foreach ($filter as $type => $value) {
                        $type = strtolower($type);
                        switch ($type) {
                            case "eq":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field, $value);
                                } else {
                                    $this->model->where($field, $value);
                                }
                                break;
                            case "nq":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field . " !=", $value);
                                } else {
                                    $this->model->where($field . " !=", $value);
                                }
                                break;
                            case "gt":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field . " >", $value);
                                } else {
                                    $this->model->where($field . " >", $value);
                                }
                                break;
                            case "gte":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field . " >=", $value);
                                } else {
                                    $this->model->where($field . " >=", $value);
                                }
                                break;
                            case "lt":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field . " <", $value);
                                } else {
                                    $this->model->where($field . " <", $value);
                                }
                                break;
                            case "lte":
                                if (isset($params['operator']) && $params['operator'] == "OR") {
                                    $this->model->orWhere($field . " <=", $value);
                                } else {
                                    $this->model->where($field . " <=", $value);
                                }
                                break;
                            case "is_null":
                                $this->model->where($field . " IS NULL", null);
                                break;
                            case "not_null":
                                $this->model->where($field . " IS NOT NULL", null);
                                break;
                            case "in":
                                $value = explode(',', $value);
                                $this->model->whereIn($field, $value);
                                break;
                            case "not_in":
                                $value = explode(',', $value);
                                $this->model->whereNotIn($field, $value);
                                break;
                            case "like":
                                $this->model->like($field, $value);
                                break;
                            case "or_like":
                                $this->model->orLike($field, $value);
                                break;
                            case "sort":
                                $this->model->orderBy($field, $value);
                                break;
                            case "group":
                                $this->model->groupBy($field);
                                break;
                        }
                    }
                }
            } elseif ($fieldRaw == "with") {
                if (is_array($filter)) {
                    $this->model->with($filter);
                } else {
                    $this->model->with([$filter]);
                }
            }
        }
    }

    /**
     * @description Fungsi yang berjalan ketika validasi sukses
     */
    protected function afterValidation()
    {
    }


    /**
     * A shortcut to performing validation on input data. If validation
     * is not successful, a $errors property will be set on this class.
     *
     * @param array|string $rules
     * @param array        $messages An array of custom error messages
     *
     * @return boolean
     */
    protected function validate($rules, array $messages = []): bool
    {
        $this->validator = Services::validation();

        // If you replace the $rules array with the name of the group
        if (is_string($rules)) {
            $validation = config('Validation');

            // If the rule wasn't found in the \Config\Validation, we
            // should throw an exception so the developer can find it.
            if (!isset($validation->$rules)) {
                throw ValidationException::forRuleNotFound($rules);
            }

            // If no error message is defined, use the error message in the Config\Validation file
            if (!$messages) {
                $errorName = $rules . '_errors';
                $messages  = $validation->$errorName ?? [];
            }

            $rules = $validation->$rules;
        }

        return $this->validator
            ->withRequest($this->request)
            ->setRules($rules, $messages)
            ->run(null, null, $this->validationDbGroup);
    }

    /**
     * @description Membentuk response dengan format ['data'=>[],'code'=>200,'message'=>'string text'] untuk Web API
     * @requiredHeader X-ApiKey,X-Token
     * @param null $data
     * @param int $code
     * @param null $message
     * @return mixed
     */
    protected function response($data = null, int $code = 200, $message = null)
    {
        return parent::respond([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
