<?php

namespace Database\Seeders\Partial;

use Illuminate\Database\Seeder;
use App\Common\Database\Definition\AvailableStatus;
use App\Common\Database\Definition\DatabaseDefs;
use App\Common\Database\MysqlCryptorTrait;
use App\Common\News\Model\News;
use Illuminate\Support\Str;

/**
 * ClientNewsモデルの初期データを登録するクラス。
 * @package \Database\Seeders
 */
class ClientNewsSeeder extends Seeder
{
    use MysqlCryptorTrait;
    /**
     * 初期データを登録する。
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10000; $i++) {
            $clientNews = new News();
            $clientNews->setConnection(DatabaseDefs::CONNECTION_NAME_MIGRATION);

            /** @var \Illuminate\Database\Eloquent\Builder $clientNews */
            $clientNews->fill([
                'client_id'    => rand(10001, 11000),
                'title'        => 'Chuyên gia: Bỏ khung giá đất khiến nguồn cung bất động sản càng khan hiếm',
                'status'       => $i % 4 ? AvailableStatus::AVAILABLE->value : AvailableStatus::NOT_AVAILABLE->value,
                'content'      => "Việc bỏ khung giá đất sau 30 năm áp dụng – một điều khoản trong Dự thảo Luật Đất đai (sửa đổi) mới được Bộ Tài nguyên và Môi trường đưa ra lấy ý kiến đang là vấn đề nóng trên nghị trường quốc hội.
                Tác động tích cực đầu tiên của việc bỏ khung giá đất là giá đất sẽ theo sát mặt bằng giá thực tế, tạo cơ sở tính thuế đầy đủ, tránh gây thất thu thuế cho Nhà nước, đồng thời từng bước xóa bỏ “cơ chế 2 giá” vốn gây khó khăn trong công tác quản lý cũng như triển khai các dự án có sử dụng đất.
                Bên cạnh đó, việc bỏ khung giá đất giao UBND cấp tỉnh ban hành bảng giá đất và công bố định kỳ hàng năm, có điều chỉnh theo biến động của thị trường được kỳ vọng sẽ bảo đảm quyền lợi cho người dân bị thu hồi đất và giảm thiểu tình trạng sai phạm trong lĩnh vực đất đai, giảm thiểu kiện cáo khi thu hồi đất.
                Mặc dù bỏ khung giá đất mang lại những điểm tích cực nhưng nhiều chuyên gia lo ngại nếu được áp dụng mà không tính toán thật kỹ thì “lợi bất cập hại” cho cả thị trường bất động sản và nền kinh tế nói chung. Thấy rõ nhất là việc trầm trọng thêm tình trạng tắc nghẽn nguồn cung.
                Lý do là khi chuyển định giá đất theo khung giá quy định sẵn sang khung theo giá thị trường cần nhiều thời gian nghiên cứu tính toán và thống nhất để ra được bảng giá hợp lý. Chưa kể, khi bỏ khung giá, các địa phương còn phải mất thêm một khoảng thời gian để chờ đợi hướng dẫn cụ thể từ Bộ Tài Chính, Bộ Tài nguyên và Môi trường, Bộ Xây dựng để tránh sai sót khi xác định giá đất theo thị trường.
                Thứ hai là khả năng khiếu kiện vẫn sẽ xảy ra, bởi xác định thế nào là “giá thị trường” sẽ rất khác nhau trong mắt từng người dân và các chính quyền địa phương, tiềm ẩn tranh cãi khiếu kiện không kém gì việc áp dụng khung giá đất hiện tại.
                Bàn thêm về vấn đề này, chia sẻ với truyền thông TS. Lê Bá Chí Nhân cho rằng, có nguy cơ dẫn đến tình trạng “mạnh ai nấy làm”. Chẳng hạn, TP. Hồ Chí Minh áp dụng giá đền bù đất nông nghiệp ở quận 2 là 2 – 5 triệu đồng/m2, thậm chí lên tới 10 triệu đồng/m2. Nếu các tỉnh lân cận như Long An, Bình Dương không theo được mức giá đó sẽ dẫn đến độ vênh, và sẽ khiến người dân so sánh, bức xúc.
                Tất cả những yếu tố trên trở thành điểm nghẽn cho việc chuyển đổi mục đích đất, cấp dự án mới, đề bù giải phóng mặt bằng…khiến tiến độ một số dự án trong vài năm tới có thể sẽ chịu ảnh hưởng, thậm chí dậm chân tại chỗ. Và dĩ nhiên, trong bối cảnh đó thì rất khó hạ nhiệt giá bất động sản như kỳ vọng, giấc mơ có nhà của người dân càng thêm xa vời.

                Áp lực dồn vào người mua cuối
                
                Một vấn đề đáng lo ngại không kém là gia tăng chi phí đầu vào. Đương nhiên, khi áp giá đền bù theo thị trường, chi phí dự án sẽ đội lên rất nhiều, thậm chí khó dự liệu trước và tất cả các chi phí đội thêm sẽ được cộng vào giá nhà.
                “Đây là bài toán cân bằng giữa các bên trong xã hội, giúp cho thị trường minh bạch hơn. Bỏ khung giá đất có thể khiến chi phí đất ở những dự án tăng lên. Nhưng trong tương lai, các địa phương có thể sẽ trì hoãn cấp phép các dự án, các khu đô thị để chờ hướng dẫn rõ ràng hơn”, bà Dương Thùy Dung, Giám đốc Điều hành CBRE Việt Nam, nhận định.
                Điều đáng lo từ khi chi phí đất tăng lên, giá thành xây dựng các dự án cũng phải tăng giá. Hậu quả như PGS TS Đinh Trọng Thịnh cảnh báo là đội giá nhà và người mua nhà sẽ phải gánh khoản chi phí này. Mức giá cao còn khiến nhiều người dù muốn cũng không thể mua nhà. Câu chuyện an sinh, nơi ăn chốn ở cho người dân, vốn đã không dễ thực hiện nay lại càng khó trở thành hiện thực.
                Rộng hơn, theo giới chuyên gia, không chỉ BĐS nhà ở, chi phí hạ tầng tăng cao còn tác động BĐS các khu công nghiệp, khu chế xuất, các công trình dịch vụ, thương mại…Nhà nước sẽ đứng trước bài toán khó, có thể chấp nhận phải chi khoản ngân sách khổng lồ để hỗ trợ về đất đai cho sản xuất, kinh doanh. Với nguồn lực có hạn, không dễ để cân đối khoản chi này. Hệ quả là các doanh nghiệp cả trong và ngoài nước sẽ không dám đầu tư vào khi chi phí đầu tăng tăng cao, lợi thế cạnh tranh giảm. 
                “Nguy cơ lớn là dòng vốn ngoại sẽ ngần ngại. Thậm chí các doanh nghiệp FDI đang có mặt tại Việt Nam cũng dần tính toán lại hướng đầu tư khi chi phí đất đai, nhân công đều tăng”, một chuyên gia ngành tài chính bày tỏ lo lắng.
                TS. Lê Xuân Bá, nguyên Viện trưởng Viện Nghiên cứu quản lý kinh tế trung ương (CIEM) cũng cho rằng “ Có bảng giá theo giá thị trường là tốt, nhưng thực tế phải tìm cách giải quyết gốc rễ của những vấn đề vướng mắc về đất đai “.
                Điều đó cho thấy, thay vì bỏ khung giá đất ngay thời điểm này thì nên xem xét các giải pháp khơi thông nguồn cung. Chỉ khi nguồn cung được mở rộng, các chủ đầu tư phải cạnh tranh giành khách thì ngõ hầu mới hạ nhiệt được giá bất động sản và đưa bất động sản về giá trị thực, hiện thực hóa giấc mơ có nhà cho đông đảo người dân.",
            ])->save();
        }
    }
}
