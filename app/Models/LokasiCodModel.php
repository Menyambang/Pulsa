<?php namespace App\Models;

use App\Models\MyModel;

class LokasiCodModel extends MyModel
{
    protected $table = "m_lokasi_cod";
    protected $primaryKey = "lcdId";
    protected $createdField = "lcdCreatedAt";
    protected $updatedField = "lcdUpdatedAt";
    protected $returnType = "App\Entities\LokasiCod";
    protected $allowedFields = ["lcdNama","lcdLatitude","lcdLongitude","lcdDeletedAt"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function filterByLocationUser($lat, $lng){
        $settingModel = new SettingModel();
        $radius = $settingModel->getValue(SettingModel::RADIUS_KEY);
        $biaya = $settingModel->getValue(SettingModel::BIAYA_KEY);
        $codData = $this->find();
        $codResult = [];

        foreach ($codData as $key => $value) {
            $jarak = $this->haversineGreatCircleDistance($value->latitude, $value->longitude, $lat, $lng);
            if($jarak > $radius){
                unset($codData[$key]);
            }else{
                $codData[$key]->jarak = round($jarak, 2).' Meter';
                $codData[$key]->biaya = intval($biaya * $jarak);
                $codResult[] = $codData[$key];
            }
        }

        return $codResult;
    }

    /**
	 * Calculates the great-circle distance between two points, with
	 * the Haversine formula.
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	private function haversineGreatCircleDistance(
		$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);

		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;

		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		return $angle * $earthRadius;
	}
}