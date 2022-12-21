<?php
namespace App\Common\Agency\CsvViewModel;

use App\Common\Agency\Contract\AgencyCsvViewModel as AgencyCsvViewModelContract;

/**
 * AgencyCsvViewModel
 * @package App\Common\Agency\CsvViewModel
 */
class AgencyCsvViewModel extends AgencyCsvViewModelContract
{

    /**
     * getHeader
     *
     * @return  array
     */
    public function getHeader()
    {
        return [
            'id'                            => 'Id',
            'name'                          => 'Tên',
            'tel'                           => 'Số điện thoại',
            'address'                       => 'Địa chỉ',
            'status'                        => 'Status',
            'agency_director'               => 'Giám đốc đại lý',
            'establishment_date'            => 'Ngày thành lập',
        ];

    }

    /**
     * convert
     *
     * @param  $data
     * @return  array
     */
    public function convert($data)
    {

        $result = [];
        $viewModel = $this->makeViewModel($data);

        foreach( $this->getHeader() as $key => $name) {
            switch ($key){

                case 'status':
                    $result[$key] = $viewModel->getStatus();
                    break;
                case 'establishment_date':
                    $result[$key] = $viewModel->getEstablishmentDate();
                    break;

                default:
                    $result[$key] = $viewModel->{$key};
                    break;
            }
        }
        return $result;
    }
}

