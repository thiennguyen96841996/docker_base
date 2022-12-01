<?php
namespace App\Admin\Agency\Request;

use App\Common\Agency\Definition\AgencyStatus;
use App\Common\Csv\CsvUpload;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Agency情報を登録する際のバリデーションを行うクラス。
 * @package \App\Admin\Agency\Request
 */
class AgencyCsvUploadRequest extends FormRequest
{

    /**
     * @var CsvUpload
     */
    private CsvUpload $csv;

    /** @var array  */
    private array $csvData = [];

    /**
     * @var array
     */
    private array $csvHeader = [
        'id'                    => 'Id',
        'name'                  => 'Tên',
        'tel'                   => 'Số điện thoại',
        'address'               => 'Địa chỉ',
        'status'                => 'Status',
        'agency_director'       => 'Giám đốc đại lý',
        'establishment_date'    => 'Ngày thành lập',
    ];

    /**
     * リクエストが可能かどうかを返す。
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーターを作成して返す。
     * @param  \Illuminate\Contracts\Validation\Factory $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Factory $factory): Validator
    {
        list($controller, $method) = explode('@', \Route::currentRouteAction());

        switch ($method) {
            case 'csvConfirm':
                $this->redirect = route('admin.agency.csv-upload');
                break;
            case 'csvUpdate':
                $this['csv_data'] = empty($this->get('str_data')) ? null : json_decode($this->get('str_data'), true);
                $this->redirect = route('admin.agency.csv-upload');
                break;
            default:
                break;
        }

        $validator = $factory->make(
            $this->validationData(),
            $this->container->call([$this, 'rules']),
            $this->messages(),
            $this->attributes()
        )->stopOnFirstFailure($this->stopOnFirstFailure);

        $validator->after(function($validator) use ($method) {
            /** @var \Illuminate\Validation\Validator $validator */
            // すでにエラーがある場合は確認しない。
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            switch ($method) {
                case 'csvConfirm':
                    // Get csv data
                    $this->csvData = app()->call([$this, 'loadCsvFile']);

                    // validate row
                    if ($validator->errors()->isEmpty()) {
                        app()->call([$this, 'validateRowForCsv'], ['validator' => $validator]);
                    }
                    break;
                case 'csvUpdate':
                    $this->csvData = $this['csv_data'];
                    if ($validator->errors()->isEmpty()) {
                        app()->call([$this, 'validateRowForCsv'], ['validator' => $validator]);
                    }
                    break;
                default:
                    break;
            }
        });
        return $validator;
    }

    /**
     * バリデーション対象となるデータを取得する。
     * @return array<int, string>
     */
    public function validationData(): array
    {
        $validateData = [];
        list($controller, $method) = explode('@', \Route::currentRouteAction());

        switch ($method) {
            case 'csvConfirm':
                 $validateData = $this->only(['csv_file']);
                break;
            default:
                break;
        }

        return  $validateData;
    }

    /**
     * バリデーションルールの定義を取得する。
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        list($controller, $method) = explode('@', \Route::currentRouteAction());

        switch ($method) {
            case 'csvConfirm':
                $rules = [
                    'csv_file'  =>  [
                        'required',
                        'file',
                        'max:5120',
                        'mimes:csv,txt',
                    ]
                ];
                break;
            default:
                break;
        }

        return $rules;
    }

    /**
     * バリデーションエラー時に返却するメッセージの定義を取得する。
     * @return array
     */
    public function messages(): array
    {
        // メッセージはlang下のファイルで管理する。
        // 上書きしたいメッセージがある場合にのみ設定すること。
        return [];
    }

    /**
     * バリデーション要素の表示名の定義を取得する。
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return ['csv_file' => 'CSV File'];
    }

    /**
     * @param Factory $factory
     * @param $validator
     * @return void
     */
    public function validateRowForCsv(Factory $factory, $validator)
    {
        // Error if less than minimum number of items
        $lackOfColumn = [];
        foreach ($this->csvData as $idx => $data) {
            // line number on file
            $lineNo = $idx + 2;
            // When validation fails, an exception is thrown and you are returned to the previous screen
            // Catch and format the message here.
            try {
                // Ignore last line and empty line
                if($idx === array_key_last($this->csvData) && $data[array_keys($this->csvHeader)[0]] === null) {
                    unset($this->csvData[$idx]);
                    continue;
                }

                // Minimum number of items check
                if (count($data) < count($this->csvHeader)) {
                    $lackOfColumn[] = $lineNo;
                    continue;
                }

                $csvValidator = $factory->make(
                    $data,
                    // rules of each row
                    [
                        'name'                      => [ 'required', 'string', 'max:50' ],
                        'address'                   => [ 'required', 'string', 'max:255' ],
                        'tel'                       => [ 'required', 'tel' ],
                        'status'                    => [ 'required', 'in:' . join(',', AgencyStatus::values()) ],
                        'agency_director'           => [ 'required', 'string', 'max:50' ],
                        'establishment_date'        => [ 'required', 'date_format:Y-m-d' ],
                    ],
                    // message
                    [
                        'tel.tel' => 'Mục :attribute không đúng định dạng.',
                    ],
                    // header title
                    $this->csvHeader
                );

                // run validate
                $csvValidator->validate();
            } catch (ValidationException $e) {
                foreach ($e->errors() ?? [] as $key => $msg) {
                    $validator->errors()->add($key, "【Dòng{$lineNo}】{$msg[0]}");
                }
            }
        }

        // Minimum item check
        if (!empty($rowNum = $lackOfColumn)) {
            $validator->errors()->add('error_count_csv', "Hàng " . implode(',', $rowNum) . " không đủ dữ liệu.（Đảm bảo dữ liệu không chứa dấu phẩy, ngắt dòng, v.v.）");
        }
    }

    /**
     * loadCsvFile
     * @param  CsvUpload $csv
     */
    public function loadCsvFile(CsvUpload $csv): array
    {
        $this->csv = $csv;

        // Specify file path
        $filePath = $this->file('csv_file')->getRealPath();
        $this->csv->setFileResource($filePath);

        // specify header
        $this->csv->setCsvHeader($this->csvHeader);

        // Return as an array
        return $this->csv->toArray();
    }

    /**
     * getUploadCsvAsJson
     * @return string
     */
    public function getUploadCsvAsJson(): string
    {
        if (empty($this->csv)) {
            return json_encode([]);
        }
        return json_encode($this->csvData);
    }

    /**
     * getUploadCsvDataCount
     * @return int
     */
    public function getUploadCsvDataCount(): int
    {
        if (empty($this->csv)) {
            return 0;
        }
        return count($this->csvData);
    }

    /**
     * getCsvParams
     *
     * @return array
     */
    public function getCsvParams(): array
    {
        return array_map(function ($v) {
            return $v;
        }, $this->csvData ?? []);
    }
}
