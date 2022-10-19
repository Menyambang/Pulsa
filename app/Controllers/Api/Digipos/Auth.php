<?php

namespace App\Controllers\Api\Digipos;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use App\Controllers\Api\Digipos\MyResourceDigipos;
use App\Libraries\Cryptography;

class Auth extends MyResourceDigipos
{
    public function cryptographyPlayground()
    {
        $secretKeyResponse = $this->digiposApi->generateSecretKey('c77ec1794801e322dc93ceef39afbfa57f7527de385f740fa9fa4736e24dbb04954e64a46dc98cb9d7cc46ce218c8f6aeac9594bdf01259762f4755e1e311e646034395471e04f34657844fa1353786e16512b9aa0739a617453feacfe747c8505a5773efcbb3d309685792ca13d0bf7ff0e7d9de674ea8570a9fcc29ff49f8ba3c610de820f69f347a45074cb8f7049972c13fcb695c5b85cf315b074b19c36dd595be3eef871950965b324b25757af6172efb168d2b5e52dcc8d1a032410ba857f939fd9996af3047b14def077618d2016f804ce27b9a268afea3f7a106b2fe21b305aef1c7ef9a623eb125c6ec5a2535d6af68d7156424c459a7250c8813c625698ccf371f0f760e6699318ec949ec92ead2c44dfd76ce247b557255c33e8129fd236b7f0f196ba25eab811b2c9eb6fdcd85657bab83cf3a11a0f7b4a5c48af223e90a373f5234a815622efaea857c1a74ac7e79aa98bd5e3e0c2a14eea7a7ac81002ea1b7b052b18ef476d24019b4729f22fc183ec7cff430b9c79217445d7bf5c880ae4f401f138067cf24a779af811f6fcdf25196b04ea9aa6259368979caca9acb5ab940f3f842ff2c15e1e1ffcae95f6ba3dc16e5581ff5fff1326bebb0740ae4866347a45bd43271cc4e3946fc87f65f830d2d86eb991ba9bfdc0c109b6ebc8e5a8b49d3eaccfe967a4b395400b867d12a56dca41ebcef1568c1a77ef24209b52fe0e3c3f45d44820186ee9b2e5107c21dbcf23b69b7cdfab319383c630405ca43574aaaa20ebb8678be7372429b9329feb0fafeca500fc72955f6ecb9c76e018de30e2d98402e0f9bf981e669cca33f66bb4149bb7be01638981cc99b1367e2c1651b8', '732306357607073103738401', '390537044333677761756485291291100');
        // $cryptPin = new Cryptography('e19bfde71b2141cef379691aa53f7251', 'AES-128-ECB');
        // $cryptResponse = new Cryptography($secretKeyResponse, 'AES-128-ECB');

        return $this->response([
            'secretKey' => $secretKeyResponse,
        //     'pin' => [
        //         'enc' => $cryptPin->sslEncrypt(('918607')), // EXPECT: cfc6557b7254f4261eb34bb3538e112e
        //         'dec' => $cryptPin->sslDecrypt((hex2bin('cfc6557b7254f4261eb34bb3538e112e')))
        //     ],
        //     'response' => [
        //         'dec' => $cryptResponse->sslDecrypt((hex2bin('839cb3f400b3c4219f36d2ca8eadcfb550cffe2963e1524e164020a021d9e1f6d200d57b6ef81f25a4d87128a318f5fa98e42800ff8f2a26e2b29e4a512a16578bacacc0d66524d35286edae9d8ceaece55808a93f9d1ed4ab1467048d2fff95d55383ba05a66f8af1b72631985ffa524f1856e406c3145fe9a67d0bb0e7561e13c363af699462541b5b0f8904a0666dd62bd22ab19776eb0e1533c39a5e2e1f31fae30da13d1a398ee4393b8c483ca6a70897887ade3fbf5f58daf07284b571')))
        //     ], 
            // 'authorization' => $this->digiposApi->generateAuthorization('be1d1aac4a2db00a207f502883d93794')
        ]);
    }

    // function hexToStr($hex)
    // {
    //     $string = '';
    //     for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
    //         $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    //     }
    //     return $string;
    // }

    public function sendOTP()
    {
        if ($this->validate([
            'username' => 'required',
            'password' => 'required',
        ], $this->validationMessage)) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $response = $this->digiposApi->sendOTP($username, $password);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function bypass()
    {
        if ($this->validate([
            'authorization' => 'required',
            'nonce' => 'required',
            'nonce1' => 'required',
        ], $this->validationMessage)) {

            $authorization = $this->request->getPost('authorization');
            $nonce = $this->request->getPost('nonce');
            $nonce1 = $this->request->getPost('nonce1');

            try {
                $this->digiposApi->generateSecretKey($authorization, $nonce, $nonce1);
            
                $response = (object)[
                    'data' => (object)json_decode('{
                        "tncStatus": {
                          "tncUpdate": false,
                          "tncCode": null
                        },
                        "checksum": "ac4e397b701bf4a2423d5831fbaa48e467329fdef88ad4e6afd99cba96c9c5bc",
                        "user": {
                          "userId": 5560996516,
                          "code": "AHM2054104",
                          "name": "Ahmad Juhdi",
                          "roleId": 204,
                          "contactNumber": "81251554104",
                          "createdAt": "2022-08-06 21:58:18.000+0000",
                          "createdBy": null,
                          "updatedAt": null,
                          "updatedBy": null,
                          "rsOutlet": {
                            "userId": null,
                            "rsNumber": "81251554104",
                            "outletId": "4101039552",
                            "outlet": {
                              "outletId": "4101039552",
                              "name": "Ahmad Juhdi",
                              "userOutlets": null,
                              "owner": null,
                              "ownerId": null,
                              "channelCategory": null,
                              "tipe": null,
                              "bank": null,
                              "bankAccount": null,
                              "longitude": null,
                              "latitude": null,
                              "address": null,
                              "salesTerritoryId": null,
                              "createdAt": null,
                              "createdBy": null,
                              "updatedAt": null,
                              "updatedBy": null,
                              "rsOutlets": null,
                              "salesTerritory": null,
                              "kelurahan": null,
                              "kelId": null,
                              "kecamatan": null,
                              "kecamatanId": null,
                              "kabupaten": null,
                              "kabupatenId": null,
                              "kotaId": null,
                              "tcashNo": null,
                              "outletCategory": null,
                              "outletLocationType": null,
                              "nik": null,
                              "city": null,
                              "postalCode": null,
                              "email": null,
                              "nokk": null,
                              "npwp": null,
                              "multichipNumber": null,
                              "sfSchedule": null,
                              "isPilot": null,
                              "isPhysical": null,
                              "enabled": null,
                              "company": null,
                              "companyId": null,
                              "siup": null,
                              "bankBranchName": null,
                              "bankAccountName": null,
                              "status": null,
                              "notifMsisdn": null,
                              "area": null,
                              "region": null,
                              "branch": null,
                              "subBranch": null,
                              "cluster": null,
                              "territoryMapping": null,
                              "imageKtp": null,
                              "imageSelfieKtp": null,
                              "outletPhotoList": [],
                              "isUberNewOutlet": null,
                              "isUberAchieved": null,
                              "outletTypeId": 1,
                              "idExpiryDate": null,
                              "areaCode": null,
                              "regionalCode": null,
                              "regionalName": null,
                              "idKtpUrl": null,
                              "clusterName": null,
                              "dealerCode": null,
                              "changeOrgStatusRequests": null,
                              "balance": null,
                              "outletDetailJourney": null,
                              "stock": null,
                              "cityTypeIds": null,
                              "rewardClassification": null,
                              "specialRewardParticipant": null,
                              "bidIds": null,
                              "ruleIds": [],
                              "groupIds": [],
                              "isSpektaDealer": null,
                              "isGenerateOutletProfile": false
                            },
                            "user": null,
                            "rsStatus": null,
                            "isPic": true,
                            "createdAt": null,
                            "createdBy": null,
                            "updatedAt": null,
                            "updatedBy": null,
                            "rsRedeem": null
                          },
                          "salesTerritory": null,
                          "email": "ahmadjuhdi007@gmail.com",
                          "status": null,
                          "userType": "OLT",
                          "positionId": 40,
                          "position": {
                            "positionID": 40,
                            "roleId": 204,
                            "positionName": "Outlet Owner",
                            "companyType": null,
                            "parentPosition": 0,
                            "createdAt": null,
                            "createdBy": null,
                            "updatedAt": null,
                            "updatedBy": null,
                            "enabled": true,
                            "userType": null
                          },
                          "company": null,
                          "companyId": null,
                          "isPilot": true,
                          "isEmployee": null,
                          "motherName": null,
                          "territoryLevel": {
                            "salesTerritoryLevel": 6,
                            "salesTerritoryName": "CLUSTER"
                          },
                          "salesTerritoryLevel": 6,
                          "salesTerritoryValue": 60,
                          "appMenuRoles": null,
                          "appMenuRoleOutlets": [
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-DATA"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-DATA",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-DATA",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-DATA",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Paket Data",
                                "isShowBanner": true,
                                "orderNo": 1,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-PULSA"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-PULSA",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-PULSA",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-PULSA",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Pulsa",
                                "isShowBanner": true,
                                "orderNo": 2,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-PULSA&outletTypeId=1",
                                "iconFile": "ic_pulsa.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-VOICESMS"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-VOICESMS",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-VOICESMS",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-VOICESMS",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Telepon & SMS",
                                "isShowBanner": true,
                                "orderNo": 3,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-VOICESMS&outletTypeId=1",
                                "iconFile": "ic_voice_sms.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-DIGITAL"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-DIGITAL",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-DIGITAL",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-DIGITAL",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Digital",
                                "isShowBanner": true,
                                "orderNo": 4,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-DIGITAL&outletTypeId=1",
                                "iconFile": "ic_digital.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-PPOB"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-PPOB",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-PPOB",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-PPOB",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Bayar Tagihan",
                                "isShowBanner": null,
                                "orderNo": 5,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-PPOB&outletTypeId=1",
                                "iconFile": "icon_ppob.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": null
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-VF"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-VF",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-VF",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-VF",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Inject VF",
                                "isShowBanner": null,
                                "orderNo": 6,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-VF&outletTypeId=1",
                                "iconFile": "ic_voucher_fisik.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-STOCK-FISIK"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-STOCK-FISIK",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-STOCK-FISIK",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-STOCK-FISIK",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Perdana & VF",
                                "isShowBanner": null,
                                "orderNo": 7,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-STOCK-FISIK&outletTypeId=1",
                                "iconFile": "ic_stok_fisik.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-STOCK-SAYA"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-STOCK-SAYA",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-STOCK-SAYA",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-STOCK-SAYA",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Stok Saya",
                                "isShowBanner": null,
                                "orderNo": 8,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-STOCK-SAYA&outletTypeId=1",
                                "iconFile": "ic_stok_saya.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-PERDANA"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-PERDANA",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-PERDANA",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-PERDANA",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Perdana Internet",
                                "isShowBanner": true,
                                "orderNo": 9,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-PERDANA&outletTypeId=1",
                                "iconFile": "ic_nsb.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-NSP"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-NSP",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-NSP",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-NSP",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "NSP",
                                "isShowBanner": true,
                                "orderNo": 10,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-USIM"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-USIM",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-USIM",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-USIM",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Migrasi USIM",
                                "isShowBanner": null,
                                "orderNo": 11,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-USIM&outletTypeId=1",
                                "iconFile": "ic_migrasi_usim.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-DIGISTAR"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-DIGISTAR",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-DIGISTAR",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-DIGISTAR",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Digistar",
                                "isShowBanner": null,
                                "orderNo": 12,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-DIGISTAR&outletTypeId=1",
                                "iconFile": "ic_digistar.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-ROAMING"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-ROAMING",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-ROAMING",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-ROAMING",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Roaming",
                                "isShowBanner": true,
                                "orderNo": 13,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-ROAMING&outletTypeId=1",
                                "iconFile": "ic_roaming.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-TRADEIN"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-TRADEIN",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-TRADEIN",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-TRADEIN",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "NEW IMEI",
                                "isShowBanner": null,
                                "orderNo": 14,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-TRADEIN&outletTypeId=1",
                                "iconFile": "ic_tradein.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-LOAN"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-LOAN",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-LOAN",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-LOAN",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Pinjaman",
                                "isShowBanner": null,
                                "orderNo": 15,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-LOAN&outletTypeId=1",
                                "iconFile": "ic_loan.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-ORBIT"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-ORBIT",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-ORBIT",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-ORBIT",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "HP & Orbit",
                                "isShowBanner": true,
                                "orderNo": 16,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-ORBIT&outletTypeId=1",
                                "iconFile": "orbit_icon_menu.png",
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-DEALING"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-DEALING",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-DEALING",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-DEALING",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Flash Sale",
                                "isShowBanner": null,
                                "orderNo": 17,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-DEALING&outletTypeId=1",
                                "iconFile": "ic_tradein.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": null
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-EVOUCHER"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-EVOUCHER",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-EVOUCHER",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-EVOUCHER",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "E-Voucher",
                                "isShowBanner": null,
                                "orderNo": 20,
                                "iconUrl": "https://digipos.telkomsel.com/api/secure/mwa/icon/get-image?menuId=DGP-OLT-VF&outletTypeId=1",
                                "iconFile": "ic_voucher_fisik.png",
                                "whitelistType": "TERRITORY"
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "OLT-ADD-FL"
                              },
                              "roleId": 204,
                              "menuId": "OLT-ADD-FL",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "OLT-ADD-FL",
                                  "outletTypeId": 1
                                },
                                "menuId": "OLT-ADD-FL",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Add Frontliner",
                                "isShowBanner": true,
                                "orderNo": null,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "DGP-OLT-WALLET"
                              },
                              "roleId": 204,
                              "menuId": "DGP-OLT-WALLET",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "DGP-OLT-WALLET",
                                  "outletTypeId": 1
                                },
                                "menuId": "DGP-OLT-WALLET",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Aktivasi DigiPOS Wallet",
                                "isShowBanner": true,
                                "orderNo": null,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "OLT-CHG-PIN"
                              },
                              "roleId": 204,
                              "menuId": "OLT-CHG-PIN",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "OLT-CHG-PIN",
                                  "outletTypeId": 1
                                },
                                "menuId": "OLT-CHG-PIN",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Change PIN Outlet",
                                "isShowBanner": null,
                                "orderNo": null,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "OLT-MNG-RS"
                              },
                              "roleId": 204,
                              "menuId": "OLT-MNG-RS",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "OLT-MNG-RS",
                                  "outletTypeId": 1
                                },
                                "menuId": "OLT-MNG-RS",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Manage RS",
                                "isShowBanner": true,
                                "orderNo": null,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            },
                            {
                              "id": {
                                "roleId": 204,
                                "outletTypeId": 1,
                                "menuId": "OLT-DEL-FL"
                              },
                              "roleId": 204,
                              "menuId": "OLT-DEL-FL",
                              "outletTypeId": 1,
                              "appMenuOutlet": {
                                "id": {
                                  "menuId": "OLT-DEL-FL",
                                  "outletTypeId": 1
                                },
                                "menuId": "OLT-DEL-FL",
                                "outletTypeId": 1,
                                "appId": "OLT",
                                "menuName": "Delete Frontliner",
                                "isShowBanner": true,
                                "orderNo": null,
                                "iconUrl": null,
                                "iconFile": null,
                                "whitelistType": null
                              },
                              "allowed": true,
                              "companyType": "OLT"
                            }
                          ],
                          "nik": "6203010706980003",
                          "npwp": "1234567890123456",
                          "enabled": true,
                          "preferredNotificationChannel": "1001",
                          "address": "Jl Mahakam Gg 2 Abadi",
                          "stock": null,
                          "userDsi": null,
                          "userAccess": null,
                          "roleName": null,
                          "areaName": null,
                          "regionName": null,
                          "branchName": null,
                          "subbranchName": null,
                          "clusterName": null,
                          "areaId": null,
                          "regionId": null,
                          "branchId": null,
                          "subbranchId": null,
                          "clusterId": null,
                          "isActivated": true,
                          "ruleProfileId": null,
                          "ruleProfileName": null,
                          "kelurahan": {
                            "name": "TAMBAN BARU SELATAN",
                            "kecamatanId": 4592,
                            "id": 55185
                          },
                          "kelId": 55185,
                          "kecamatan": {
                            "name": "KAPUAS KUALA",
                            "kotaId": 326,
                            "id": 4592
                          },
                          "kecamatanId": 4592,
                          "kabupaten": {
                            "name": "KAPUAS",
                            "provId": 21,
                            "id": 326
                          },
                          "kabupatenId": 326,
                          "hobi": null,
                          "dateOfBirth": null,
                          "paymentMethods": [
                            {
                              "paymentMethod": "NGRS",
                              "isActive": true,
                              "isAvailable": true
                            },
                            {
                              "paymentMethod": "LINKAJA",
                              "isActive": true,
                              "isAvailable": true
                            }
                          ],
                          "imgProfile": null,
                          "territoryMapping": null
                        },
                        "secretKey": {
                          "md5Hex": "004ed0c940883465f4abeb230c182747",
                          "base64": "xzwoSKm1e7Qy8-6UoftL0g=="
                        }
                      }')
                ];

                $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                $keyAccess = config("App")->JWTKeyAccess;
                $keyRefresh = config("App")->JWTKeyRefresh;
                $response->data->secretKey = $this->digiposApi->secretKey;

                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "secret" => $this->digiposApi->secretKey,
                    "user" => $response->data,
                    "key" => $apiKeys
                ];
                $refreshPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                    "secret" => $this->digiposApi->secretKey,
                    "user" => $response->data,
                    "key" => $apiKeys
                ];

                $accessToken = JWT::encode($accessPayload, $keyAccess);
                $refreshToken = JWT::encode($refreshPayload, $keyRefresh);

                return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken, 'secret' => $this->digiposApi->secretKey], 200);

                return $this->response($response, 403, 'Login gagal');
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function auth()
    {
        if ($this->validate([
            'otp' => 'required|numeric|min_length[6]|max_length[6]',
            'token' => 'required',
        ], $this->validationMessage)) {

            $otp = $this->request->getPost('otp');
            $token = $this->request->getPost('token');

            try {
                $response = $this->digiposApi->auth($otp, $token);
           
                if ($response->status == 0) {
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
                    $response->data->secretKey = $this->digiposApi->secretKey;

                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response->data,
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                        "secret" => $this->digiposApi->secretKey,
                        "user" => $response->data,
                        "key" => $apiKeys
                    ];

                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    $refreshToken = JWT::encode($refreshPayload, $keyRefresh);

                    return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken], 200);
                }

                return $this->response($response, 403, 'Login gagal');
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function refresh()
    {
        if ($this->validate(['tokenRefresh' => 'required'])) {
            $apiKeys = $this->request->getHeaderLine("X-ApiKey");
            $tokenRefresh = $this->request->getVar("tokenRefresh");

            try {
                $keyRefresh = config("App")->JWTKeyRefresh;
                $decoded = JWT::decode($tokenRefresh, $keyRefresh, ['HS256']);
                $keyAccess = config("App")->JWTKeyAccess;
                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "secret" => (array) $decoded->secret,
                    "user" => (array) $decoded->user,
                    "key" => $apiKeys
                ];
                $accessToken = JWT::encode($accessPayload, $keyAccess);
                return $this->response(['accessToken' => $accessToken]);
            } catch (BeforeValidException $ex) {
                return $this->response(null, 400, 'Refresh Token belum valid');
            } catch (ExpiredException $ex) {
                return $this->response(null, 400, 'Refresh Token expired');
            } catch (SignatureInvalidException $ex) {
                return $this->response(null, 400, 'Refresh Token Signature Tidak valid');
            } catch (\Exception $ex) {
                return $this->response(null, 400, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function isAuth()
    {
        $response = $this->tokpedApi->isAuth();

        return $this->response($response);
    }
}
