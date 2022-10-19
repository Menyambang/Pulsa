<?php

namespace App\Controllers;

use Config\Services;
use App\Models\AclModel;
use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Validation\Exceptions\ValidationException;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $rules = [];
	protected $isUploadWithId = false;
	protected $defaultLimitData = 100;
	protected $acl = null;

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session = \Config\Services::session();
		$this->validator = Services::validation();
		$this->template = Services::template([], true);
		$this->acl = new AclModel();

		date_default_timezone_set('Asia/Kuala_Lumpur');

		if (isset($this->modelName))
			$this->model = new $this->modelName() ?? '';
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
		return [
			'code' => $code,
			'message' => $message,
			'data' => $data
		];
	}

	/**
	 * grid
	 * 
	 * Menampilkan data di Datatable
	 *
	 * @return void
	 */
	public function grid()
	{
		$request = $this->request->getGet();

		$this->_applyFillter($request);

		$response = $this->model->dataTableHandler($this->request->getGet());
		return $this->response->setJSON($response);
	}

	protected function uploadFile($id)
	{
	}

	public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
				if (!$this->isUploadWithId) {
					try {
						$this->uploadFile(null);
					} catch (\Exception $ex) {
						$response =  $this->response(null, 500, $ex->getMessage());
						return $this->response->setJSON($response);
					}
				}

				try {
					$primaryId = $this->request->getVar($primary);
					$entityClass = $this->model->getReturnType();
					$entity = new $entityClass();
					$entity->fill($this->request->getVar());

					$this->model->transStart();
					if ($primaryId == '') {
						$this->model->insert($entity, false);
						if ($this->model->getInsertID() > 0) {
							$primaryId = $this->model->getInsertID();
							$entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
						}
					} else {
						$this->model->set($entity->toRawArray())
							->update($primaryId);
					}

					$this->model->transComplete();
					$status = $this->model->transStatus();

					if ($this->isUploadWithId) {
						try {
							$this->uploadFile($primaryId);
						} catch (\Exception $ex) {
							$response =  $this->response(null, 500, $ex->getMessage());
							return $this->response->setJSON($response);
						}
					}

					$response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
					return $this->response->setJSON($response);
				} catch (DatabaseException $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\mysqli_sql_exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\Exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				}
			} else {
				$response =  $this->response(null, 400, $this->validator->getErrors());
				return $this->response->setJSON($response);
			}
		}
	}

	public function hapus($id)
	{
		try {
			$this->model->transStart();
			$cek = $this->model->find($id);
			if ($cek) {
				$status = $this->model->delete($id);
			}

			$this->model->transComplete();
			$status = $this->model->transStatus();

			$response = $this->response(null, ($status ? 200 : 500));
			return $this->response->setJSON($response);
		} catch (DatabaseException $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		} catch (\mysqli_sql_exception $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		} catch (\Exception $ex) {
			$response =  $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($response);
		}
	}

	/**
	 * Apply datatable filter lanjutan
	 *
	 * @param [type] $request
	 *
	 * @return void
	 */
	protected function _applyFillter(&$request)
	{
		parse_str($this->request->getGet("filter"), $filter);
		unset($request['filter']);
		foreach ($filter as $field => $row) {
			if ($row['keyword'] != "") {
				$request[$field . "[" . $row['operator'] . "]"] = $row['keyword'];
			}
		}
	}

	public function checkData($id)
	{
		$data = $this->model->find($id);
		return $data;
	}

	public function findAll()
	{
		$data = $this->model->find();
		return $this->response->setJSON($data);
	}

	public function show()
	{
		$this->applyQueryFilter();
		$limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
		$offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
		if ($limit != "-1") {
			$this->model->limit($limit);
		}
		$this->model->offset($offset);
		try {
			return $this->response->setJSON([
				'rows' => $this->model->find(),
				'limit' => $limit,
				'offset' => $offset,
			]);
		} catch (\Exception $ex) {
			$data = $this->response(null, 500, $ex->getMessage());
			return $this->response->setJSON($data);

		}
	}

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
}
