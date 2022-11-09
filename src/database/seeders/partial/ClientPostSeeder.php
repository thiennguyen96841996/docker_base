<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\MysqlCryptorTrait;
use App\Common\Post\Model\Post;
use Illuminate\Support\Str;

/**
 * ClientPostモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ClientPostSeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10000; $i++) {
            $clientPost = new Post();
            $clientPost->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $clientPost */
            $clientPost->fill([
                'client_id'    => rand(10001, 11000),
                'title'        => 'HOT - 1.4 TỶ FULL NỘI THẤT XỊN - NHÀ ĐẸP NHƯ MỚI - 2PN 2VC',
                'status'       => $i % 4 ? AvailableStatus::AVAILABLE->value : AvailableStatus::NOT_AVAILABLE->value,
                'content'      => "Đây là căn hộ gia đình ở cực kỳ đẹp và giữ gìn. Anh Chị có thể xem trực tiếp nhà bất kỳ lúc nào. Do gia đình đang cần tiền nên quyết định để lại cho gia đình nào có nhu cầu ở thực. Căn hộ được thiết kế hợp lý phù hợp cho các gia đình 4 người ở.
                    Nội thất đảm bảo mới cho khách hàng như hình. Nội thất toàn đồ chất lượng tốt.
                    Cam kết không qua trung gian.
                    Nhà có 3 điều hòa.
                    Nhà có 2 nhà vệ sinh sạch sẽ
                    Nhà có 1 phòng khách thiết kế gọn.
                    Nhà có một phòng bếp có đầy đủ tiện nghi cho chị em vào bếp.
                    Nhà có 1 máy giặt còn tốt.
                    Nhà có đầy đủ giường nệm cho anh chị vào có thể ở được ngay.
                    Chúc quý anh chị sẽ chọn được một căn hộ mà về ở là sẽ hạnh phúc trần ngập.",
                'city'         => 'Hà Nội',
                'district'     => 'Thành Phố Hà Nội',
                'address'      => '0011 PHAN KẾ BÍNH, PHƯỜNG CỐNG VỊ, QUẬN BA ĐÌNH, HÀ NỘI',
                'price'        => rand(100000000, 50000000000),
                'area'         => rand(50, 500),
                'view_counts'  => rand(0, 10000000),
            ])->save();
        }
    }
}
