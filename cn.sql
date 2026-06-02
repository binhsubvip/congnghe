-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th6 02, 2026 lúc 11:02 AM
-- Phiên bản máy phục vụ: 10.11.14-MariaDB-cll-lve
-- Phiên bản PHP: 8.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ywvpewmp_thicongnghe`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers_mcq`
--

CREATE TABLE `answers_mcq` (
  `question_id` int(11) NOT NULL,
  `opt_a` mediumtext DEFAULT NULL,
  `opt_b` mediumtext DEFAULT NULL,
  `opt_c` mediumtext DEFAULT NULL,
  `opt_d` mediumtext DEFAULT NULL,
  `correct_opt` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `answers_mcq`
--

INSERT INTO `answers_mcq` (`question_id`, `opt_a`, `opt_b`, `opt_c`, `opt_d`, `correct_opt`) VALUES
(1, 'sản xuất điện năng.', 'truyền tải điện năng.', 'phân phối điện năng.', 'sử dụng điện năng.', 'A'),
(2, 'R = AB.10C', 'R = A.B.10C', 'R = AB.10C± D%', 'R = A.B.10C ± D%', 'C'),
(3, 'Thiết kế thiết bị điện và điều chỉnh các thông số kỹ thuật của lưới điện.', 'Đóng cắt, điều chỉnh các thông số kỹ thuật lưới điện, thiết bị điện, đảm bảo an toàn lưới điện.', 'Bảo trì hệ thống điện và điều chỉnh các thông số kỹ thuật của lưới điện.', 'Điều chỉnh các thông số kỹ thuật của lưới điện, giáo dục và đào tạo nhân viên mới. ', 'B'),
(4, 'Chữ số thứ nhất', 'Những “số không”', 'Sai số', 'Đáp án khác', 'A'),
(5, 'Máy phát điện xoay chiều ba pha.', 'Máy phát điện xoay chiều một pha.', 'Máy phát điện xoay chiều một pha hoặc ba pha.', 'Máy phát điện xoay chiều một pha và ba pha.', 'A'),
(6, 'Fara', 'Microfara', 'Picofara', 'Cả 3 đáp án trên', 'B'),
(7, 'Ba điểm cuối của ba pha nối với nhau.', 'Đầu pha này đối với cuối pha kia theo thứ tự pha.', 'Ba điểm đầu của ba pha nối với nhau', 'Đầu pha này nối với cuối pha kia không cần theo thứ tự pha.', 'A'),
(8, '1', '2', '3', '4', 'B'),
(9, 'Id = √3 Ip', 'Ud = Up. 	', 'Id = Ip.', 'Ip = √3 Id', 'C'),
(10, 'UAK > 0.', 'UAK < 0.', 'UGK > 0.', 'UAK > 0, UGK > 0', 'A'),
(11, 'Nguồn điện, các tải tiêu thụ.', 'Nguồn điện, lưới điện, các tải tiêu thụ.', 'Nguồn điện, dây dẫn điện và các trạm điện.', 'Dây dẫn, các trạm điện và hộ tiêu dùng.', 'B'),
(12, '1. Là dòng điện chạy trong mỗi pha.', '2. Là dòng điện chạy trong dây pha', 'Cả 1 và 2 đều đúng', 'Đáp án khác', 'B'),
(13, 'Năng lượng không tái tạo		', 'Năng lượng tái tạo.', 'Năng lượng tái tạo và năng lượng không tái tạo.', 'Năng lượng bền vững.', 'A'),
(14, 'Nguy cơ ô nhiễm môi trường từ các tấm pin phế thải đã hết tuổi sử dụng, tạo ra tiếng ồn lớn.', 'Tạo ra tiếng ồn lớn, tạo ra nhiều khí thải gây hiệu ứng nhà kính.', 'Nguy cơ ô nhiễm môi trường từ các tấm pin phế thải đã hết tuổi sử dụng, tạo ra nhiều khí thải gây hiệu ứng nhà kính, tạo ra tiếng ồn lớn.', 'Nguy cơ ô nhiểm môi trường từ các tấm pin phế thải đã hết tuổi sử dụng.', 'D'),
(15, '1', '2', '3', '4', 'C'),
(16, 'Lấy điện 380/220V cung cấp cho máy biến áp hạ áp và phân phối khu vực.', 'Lấy điện từ đường dây trung áp cung cấp cho máy biến áp hạ áp.', 'Lấy điện hạ áp 380/220V phân phối cho các tủ điện phân phối khu vực.', 'Lấy điện hạ áp 380/220V từ tủ điện phân phối khu vực phân phối tiếp cho các hộ gia đình.', 'C'),
(17, 'Điôt bán dẫn', 'Tirixto', 'Tranzito', 'Đáp án khác', 'A'),
(18, 'Đèn sợi đốt', 'Đèn compact', 'Đèn LED', 'Đáp án khác', 'C'),
(19, 'Đầu ra Q có giá trị là 0', 'Đầu ra Q có giá trị là 1', 'Đầu ra Q có giá trị là AB', 'Đáp án khác', 'B'),
(20, 'Bộ đếm', 'Bộ so sánh', 'Bộ so sánh và bộ đếm', 'Đáp án khác', 'C'),
(21, 'Ura = 8(V)', 'Ura = 6(V)', 'Ura = 4(V)', 'Ura = 5(V)', 'D'),
(22, 'Ura = 150(V)', 'Ura = 175(V)', 'Ura = 100(V)', 'Ura = 220(V)', 'B'),
(23, 'Ura = - 12(V)', 'Ura = - 13(V)	', 'Ura = +12(V)', 'Ura = +13(V)', 'A'),
(24, 'Chỉnh sửa mạch điện	', 'Cắm dây vào cổng A0 thay vì cổng A2 ', 'Chỉnh sửa mã chương trình	', 'Nạp chương trình vào vi điều khiển', 'C'),
(29, 'Phương pháp tiện', 'Phương pháp bào', 'Phương pháp khoan', 'Phương pháp đúc', 'D'),
(30, 'xây dựng cơ sở hạ tầng.', 'đời sống sinh hoạt.', 'khoa học môi trường.', 'xây dựng công trình giao thông.', 'B'),
(31, 'Là quá trình chuyển đổi các dạng năng lượng khác thành năng lượng điện.', 'Là quá trình tạo ra điện và cung cấp cho nguồn điện.', 'Truyền năng lượng điện từ nơi sản xuất đến nơi tiêu thụ.', 'Là quá trình chuyển đổi năng lượng điện thành các dạng năng lượng khác.', 'A'),
(32, 'Điac.', 'Triac.', 'Tranzito.', 'Tirixto.', 'C'),
(33, '1:20', '1:200', '20:1', '200:1', 'A'),
(34, 'Vật liệu nano', 'Composite nền hữu cơ', 'Nhựa nhiệt rắn', 'Nhựa nhiệt dẻo', 'A'),
(35, 'thiết kế thiết bị điện tử', 'sản xuất, chế tạo thiết bị điện tử', 'bảo dưỡng, sửa chữa thiết bị điện tử', 'lắp ráp thiết bị điện tử', 'C'),
(36, 'cuộc cách mạng công nghiệp lần thứ nhất', 'cuộc cách mạng công nghiệp lần thứ hai', 'cuộc cách mạng công nghiệp lần thứ ba', 'cuộc cách mạng công nghiệp lần thứ tư', 'D'),
(37, 'Hình A và hình', 'B. Hình A và hình', 'C. Hình B và hình C.', 'Hình B và hình D', 'D'),
(38, 'Tại cacte của động cơ', 'Bên trong xilanh động cơ', 'Tại đường ống nạp và thải', 'Tại thân máy của động cơ', 'B'),
(39, 'Tải phân bố tập trung.', 'Mạng điện dùng cho các thiết bị sản xuất.', 'Lấy điện từ đường dây cao áp.', 'Dùng một máy biến áp riêng.', 'C'),
(40, 'nghiên cứu và ứng dụng linh kiện điện tử, mạch tích hợp,… để thiết kế, chế tạo các thiết bị điện tử phục vụ sản xuất và đời sống.', 'nghiên cứu và ứng dụng linh kiện điện tử, mạch tích hợp,… để thiết kế, chế tạo các phần mềm ứng dụng cho máy tính.', 'nghiên cứu và ứng dụng linh kiện điện tử, để thiết kế, chế tạo các phần mềm để ứng dụng điều khiển tự động sản xuất.', 'sản xuất, chế tạo các chi tiết máy phục vụ cho các nghành công nghiệp.', 'A'),
(41, 'Giàm tốc độ cho ô tô', 'Giúp ô tô tăng tốc và giảm tốc dễ dàng', 'Ngắt nối và truyền mô men từ động cơ đến hộp số', 'Thay đổi hướng chuyển động ô tô', 'C'),
(42, 'Sang trái hoặc ngược chiều kim đồng hồ', 'Sang phải hoặc cùng chiều kim đồng hồ', 'Kéo tay lái về phía trước', 'Kéo tay lái về phái sau', 'A'),
(43, 'đỏ - tím - vàng - nhũ vàng.', 'tím – đỏ - vàng - nhũ vàng.', 'đỏ - tím – vàng – nhũ bạc.', 'đỏ - xám - vàng – nhũ vàng.', 'A'),
(44, 'Ud = 220 V; Up = 110 V.', 'Ud = 110 V; Up = 220 V.', 'Ud = 110 V; Up = 190,5 V.', 'Ud = 190,5 V; Up = 110 V.', 'D'),
(45, 'AND', 'NOR', 'NOT', 'NAND', 'B'),
(46, 'chọn aptomat có dòng điện định mức 6 A', 'chọn aptomat có dòng điện định mức 10 A', 'chọn aptomat có dòng điện định mức 16 A', 'chọn aptomat có dòng điện định mức 20 A', 'C'),
(47, 'Hình sao, không có dây trung tính.', 'Hình tam giác.', 'Hình sao có dây trung tính.', 'Hình sao - tam giác.', 'A'),
(48, 'máy biến áp 110/22 kV.', 'máy biến áp 110/6 kV.', 'máy biến áp 22/6 kV.', 'máy biến áp 22/0,4 kV.', 'D'),
(49, 'phát triển lưới điện thông minh.', 'phát triển hệ thống giao thông sử dụng năng lượng điện.', 'phát triển sản xuất điện năng từ nguồn năng lượng tái tạo.', 'phát triển máy móc thông minh.', 'C'),
(50, 'Q = (A+B) . (A +', 'B. Q = (A . B) + AB', 'Q = A ( A + B) + AB', 'Q = (A + B) + AB', 'B'),
(51, 'Vi điều khiển E chậm hơn vi điều khiển F', 'Vi điều khiển F chậm hơn vi điều khiển E', 'Vi điều khiển E nhanh gấp 2 lần vi điều khiển F', 'Cả hai vi điều khiển có tốc độ bằng nhau', 'A'),
(52, 'Y= 0 và Y= 1', 'Y= 1 và Y= 0', 'Y= 0 và Y= 0', 'Y= 1 và Y= 1', 'C'),
(57, 'Tín hiệu phản hồi.', 'Đầu vào.', 'Bộ phận xử lí.', 'Đầu ra.', 'A'),
(58, 'Dẻo.', 'Cứng.', 'Đàn hồi.', 'Dẫn nhiệt.', 'A'),
(59, 'ở hình chiếu đứng và cạnh.', 'ở hình chiếu đứng và bằng.', 'ở hình chiếu bằng và cạnh.', 'ở hình chiếu bằng.', 'A'),
(60, 'Gia công các sản phẩm có yêu cầu độ kín cao.', 'Gia công các sản phẩm có yêu cầu về cơ tính cao', 'Gia công các sản phẩm có hình dạng và kết cấu phức tạp.', 'Gia công các bề mặt tròn xoay có độ chính xác cao.', 'C'),
(61, 'nổ, nạp, nén, thải.', 'nạp, nén, nổ, thải.', 'thải, nén, nổ, nạp.', 'nén, nổ, thải, nạp.', 'B'),
(62, '360 độ', '180 độ', '720 độ', '540 độ', 'B'),
(63, 'Kỹ sư thiết kế điện.', 'Thợ điện.', 'Cử nhân sản xuất thiết bị điện.', 'Kỹ thuật viên vận hành điện.', 'A'),
(64, 'Giảm sự phụ thuộc vào nhiên liệu hóa thạch.', 'Tăng chi phí sản xuất điện.', 'Tăng hiệu quả sử dụng điện.', 'Mở rộng thị trường tiêu thụ điện.', 'A'),
(65, '33 kV', '66 kV', '110 kV', '220 kV', 'D'),
(66, 'Điểm dây pha.', 'Điểm nối tùy ý.', 'Điểm dây trung tính.', 'Điểm dây đỉnh.', 'C'),
(67, '760V.', '230V.', '220V.', '380V.', 'D'),
(68, 'Điều khiển nhiệt độ.', 'Đo lường điện năng tiêu thụ.', 'Bảo vệ quá tải.', 'Cắt điện khi có sự cố ngắn mạch.', 'B'),
(69, 'công suất tiêu thụ của thiết bị.', 'giá thành của thiết bị.', 'độ bền của thiết bị.', 'tiêu chí đảm bảo vệ sinh môi trường của thiết bị.', 'A'),
(70, 'thợ điện tử kết hợp với kĩ sư cơ khí.', 'thợ cơ khí và kĩ sư điện tử.', 'kĩ sư điện tử và thợ sản xuất.', 'kĩ sư điện tử và kĩ sư cơ khí.', 'C'),
(71, 'ngăn dòng điện xoay chiều và cho dòng một chiều đi qua.', 'ngăn dòng điện một chiều và cho dòng điện xoay chiều đi qua.', 'ngăn dòng điện xoay chiều và dòng điện một chiều đi qua.', 'cho dòng điện một chiều và xoay chiều đi qua.', 'B'),
(72, 'R = 64 kΩ ± 1%.', 'R = 64 kΩ ± 2%.', 'R = 54 kΩ ± 1%.', 'R = 54 kΩ ± 2%.', 'A'),
(73, 'có biên độ biến đổi liên tục theo thời gian.', 'có biên độ không đổi trong một khoảng thời gian nhất định.', 'có biên độ biến đổi liên tục trong một khoảng thời gian nhất định.', 'có biên độ không đổi liên tục theo thời gian.', 'A'),
(74, 'điện tử tương tự.', 'điện tử số', 'mạch khuếch đại thuật toán.', 'mạch khuếch đại đảo.', 'B'),
(75, 'mạch đếm.', 'mạch so sánh.', 'mạch khuếch đại thuật toán', 'mạch cộng không đảo.', 'A'),
(76, 'IC khuếch đại thuật toán.', 'Cổng logic.', 'Flip – Flop.', 'Vi điều khiển.', 'D'),
(77, '\r\n<img src=\"uploads/img_69edda7432f28_1777195636.png\" />\r\n', '\r\n<img src=\"uploads/img_69edda811b90e_1777195649.png\" />\r\n', '\r\n<img src=\"uploads/img_69edda88ee1d9_1777195656.png\" />\r\n', '<img src=\"uploads/img_69edda49cff53_1777195593.png\" />\r\n', 'D'),
(78, 'Đúc', 'Tiện', 'Phay', 'Bào', 'B'),
(79, '15 V.', '22,5 V.', '15,5 V.', '12 V.', 'B'),
(80, '(A+B).C.', 'A.B +', 'C.  A + B.C.', '(A + B).C.', 'B'),
(113, '8 bit/s.', '16 bit/s.', '32 bit/s.', '64 bit/s.', 'A'),
(114, 'cao tần.', 'sóng siêu cao tần.', 'điện.', 'sóng mang.', 'C'),
(115, 'lắp đặt thiết bị điện tử.', 'vận hành thiết bị điện tử.', 'sản xuất, chế tạo thiết bị điện tử.', 'sửa chữa, bảo dưỡng thiết bị điện tử.', 'C'),
(116, 'bảo dưỡng thiết bị điện.', 'sử dụng thiết bị điện.', 'sửa chữa thiết bị điện.', 'thiết kế và lắp đặt điện.', 'D'),
(117, 'Không tắt thiết bị điện khi ra khỏi nhà.', 'Sạc điện thoại khi không sử dụng.', 'Cắm nồi cơm điện và bếp điện với cùng 1 ổ cắm.', 'Dùng máy sấy tóc trong phòng tắm.', 'B'),
(118, 'Hình A', 'Hình B', 'Hình C', 'Hình D', 'B'),
(119, '(4) → (5) → (3) → (2) → (1).', '(1) → (2) → (3) → (4) → (5).', '(3) → (2) → (1) → (5) → (4).', '(2) → (3) → (1) → (4) → (5).', 'D'),
(120, 'trục đo xiên góc cân của vật thể.', 'phối cảnh của vật thể.', 'trục đo vuông góc đều của vật thể.', 'vuông góc của vật thể.', 'B'),
(121, 'Biên độ.', 'Tần số', 'Góc pha.', 'Chu kì.', 'A'),
(122, 'ba.', 'nhất.', 'hai.', 'tư.', 'C'),
(123, 'Ip = 7,6A; Id = 13,16A.', 'Ip = 7,6A; Id = 14,4A.', 'Ip = 4,4A; Id = 4,4A.', 'Ip = 7,6A; Id = 7,6A.', 'A'),
(124, '380V.', '658,2V.', '219,4V.', '127V.', 'C'),
(125, 'nhiên liệu.', 'bôi trơn.', 'làm mát.', 'đánh lửa.', 'D'),
(126, '(1) đầu vào, (2) xử lí, (3) đầu ra.', '(1) nhiên liệu, (2) vật liệu, (3) sản phẩm.', '(1) đầu vào, (2) đầu ra, (3) sản phẩm.', '(1) thiết bị, (2) máy móc, (3) con người.', 'A'),
(127, 'AND.', 'OR.', 'NOT.', 'NAND.', 'D'),
(128, 'truyền tải điện năng,', 'tạo ra điện năng.', 'biển điện năng thành các dạng năng lượng khác.', 'phân phối điện năng.', 'B'),
(129, 'Phích cắm điện.', 'Công tắc điện .', 'Cầu chì.', 'Aptomat.', 'D'),
(130, 'pít tông, thanh truyền, trục khuỷu, cam.', 'pít tông, thanh truyền, trục cam, bánh đà.', 'pít tông, thanh truyền, trục khuỷu, bánh đà.', 'pít tông, thanh truyền, trục cam, xu páp.', 'C'),
(131, 'Đồng và hợp kim đồng.', 'Cao su.', 'Nhôm và hợp kim nhôm.', 'Gốm ôxit.', 'C'),
(132, 'Điều khiển, tự động hóa cho quá trình sản xuất.', 'Nâng cao chất lượng cuộc sống sinh hoạt trong gia đình.', 'Cung cấp năng lượng (điện năng) cho các thiết bị điện trong gia đình.', 'Nâng cao đời sống sinh hoạt cộng đồng.', 'B'),
(133, '- 0,1.', '- 1.', '- 10.', '10.', 'C'),
(134, 'phay.', 'đúc.', 'tiện.', 'khoan.', 'D'),
(135, '560 kΩ ± 5%.', '5,6 kΩ ± 5%.', '560 Ω ± 5%.', '56 kΩ ± 5%.', 'D'),
(136, 'các nhà máy điện có công suất phát điện khác nhau như thủy điện, nhiệt điện.', 'các thiết bị điều phối và đảm bảo an toàn hệ thống truyền tải điện.', 'tập hợp các thiết bị và phần mềm để giám sát và điều khiển lưới điện.', 'các thiết bị điện biến điện năng thành các dạng năng lượng khác.', 'D'),
(141, 'một chuỗi các tín hiệu rời rạc, có tần số không đổi trong một khoảng thời gian nhất định.', 'một chuỗi các tín hiệu rời rạc, có biên độ không đổi trong một khoảng thời gian nhất định.', 'một chuỗi các tín hiệu rời rạc, có biên độ thay đổi trong một khoảng thời gian nhất định.', 'một chuỗi các tín hiệu rời rạc, có tần số thay đổi trong một khoảng thời gian nhất định.', 'B'),
(142, '3', '4', '2', '5', 'A'),
(143, 'Ki thai.', 'Ki nap.', 'Kì nén.', 'Kì cháy-giãn nở (Kì nổ).', 'D'),
(144, 'Đèn huỳnh quang.', 'Đèn compact.', 'Đèn LED.', 'Đèn sợi đốt.', 'C'),
(145, 'Năng lượng mặt trời, năng lượng gió.', 'Năng lượng thủy năng, năng lượng hạt nhân.', 'Năng lượng gió, năng lương nhiệt tử than', 'Năng lượng nhiệt từ phản ứng phân hạch hạt nhân.', 'A'),
(146, 'sản xuất điện năng.', 'truyền tải điện năng.', 'phân phối điện năng.', 'sử dụng điện năng.', 'A'),
(147, '9,4 Ω ', '5,42 Ω', '70 Ω', '0,18 Ω', 'A'),
(148, '0,0003 Ω.', '318,47 kΩ', ' 318,47 Ω. ', '500 Ω.', 'B'),
(149, '(1) →(2) →(3)→ (4) →(5).   ', 'B. (1)→ (2) →(4)→ (3) →(5).', ' (1) →(3) →(2)→ (4) → (5).', 'D. (1) →(3) →(4)→ (2) →(5). ', 'C'),
(150, 'lục, lam, cam, nhũ bạc (bạch kim).', 'lục, lam, cam, nhũ vàng (vàng kim).', 'lam, lục, cam, nhũ vàng (vàng kim).', 'lục, lam, vàng, nhũ vàng (vàng kim).', 'B'),
(151, 'Hóa năng → Cơ năng → Nhiệt năng.   ', 'Nhiệt năng → Hóa năng → Cơ năng ', 'Nhiệt năng → Cơ năng → Hóa năng.  ', 'Hóa năng → Nhiệt năng → Cơ năng.', 'D'),
(152, '100 kΩ ±10%.  ', '100 kΩ ± 5%.', '104 Ω ±10%.', '104 Ω ± 5%.', 'B'),
(153, 'Henry.', 'Oát.', 'Ohm.', 'Fara.', 'C'),
(154, '50000 mH.', '314 H.', '314 ΚΩ.', ' 314 Ω. ', 'D'),
(155, 'đứt mảnh.', 'liền đậm.  ', 'gạch dài chấm mảnh.', 'liền mảnh.', 'B'),
(156, 'Yếu tố nhân trắc.     ', 'Yếu tố năng lượng. ', 'Yếu tố công nghệ.    ', 'Yếu tố an toàn.', 'D'),
(157, 'động cơ thẳng hàng, động cơ chữ V, động cơ hình sao.', 'động cơ 1 xilanh (xi lanh), động cơ nhiều xilanh.', 'động cơ 2 kì, động cơ 4 kì.', 'động cơ xăng, động cơ Diesel và động cơ gas.', 'C'),
(158, 'cùng tần số, cùng biên độ và có góc pha lệch nhau 1200 giữa các pha.', 'cùng tần số và có góc pha lệch nhau 1200 giữa các pha.', 'cùng biên độ và có góc pha lệch nhau 1200 giữa các pha.', 'củng tần số, củng biên độ và có góc pha lệch nhau 1350 giữa các pha', 'A'),
(159, 'Giá trị của tụ điện là 100µF, điện áp là 450 V.', 'Giá trị điện dung của tụ điện là 100µF, điện áp định mức là 450 V.', 'Giá trị của tụ điện là 100F, điện áp là 450V.', 'Tụ điện có giá trị 100µF, điện áp là 450V.', 'B'),
(160, '100μF.', '101μF.', '101pF.', '100pF.', 'D'),
(161, 'Id = Ip, Ud = √3Up    ', 'Id = Ip, Up = √3Ud ', 'Id = √3.Ip, Ud = Up    ', 'Id = √3.Ip, Ud = √3.Up', 'C'),
(162, 'Ip = 4,4A, Id = Ip = 4,4A, Ud = √3.Up = 381V.', 'Ip = 4,4A, Id = √3.Ip = 7,62A, Ud = √3.Up = 381V.', 'Id =4,4A, Ip = √3.Id = 7,62A, Ud = √3.Up = 381V.', 'Ip = 4,4A, Id = Ip = 4,4A, Ud = Up = 220V.', 'A'),
(163, 'Diode.', 'Transistor lưỡng cực.', 'Tụ điện.', 'Cuộn cảm.', 'B'),
(164, ' Đồ thị hành a.   ', 'Đồ thị hình b. ', 'Đồ thị hình c.  ', 'Đồ thị hình a và c. ', 'D');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `answers_tf`
--

CREATE TABLE `answers_tf` (
  `question_id` int(11) NOT NULL,
  `part_a` mediumtext DEFAULT NULL,
  `is_a_true` tinyint(1) DEFAULT NULL,
  `part_b` mediumtext DEFAULT NULL,
  `is_b_true` tinyint(1) DEFAULT NULL,
  `part_c` mediumtext DEFAULT NULL,
  `is_c_true` tinyint(1) DEFAULT NULL,
  `part_d` mediumtext DEFAULT NULL,
  `is_d_true` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `answers_tf`
--

INSERT INTO `answers_tf` (`question_id`, `part_a`, `is_a_true`, `part_b`, `is_b_true`, `part_c`, `is_c_true`, `part_d`, `is_d_true`) VALUES
(25, 'Điện áp dây bằng điện áp pha.', 0, 'Điện áp dây bằng 380V.', 1, 'Dòng điện pha bằng 4,4A.', 1, 'Dòng điện dây gần bằng 7,5A.', 0),
(26, 'Hệ thống điện gồm 2 nhà máy với cấp điện áp lần lượt là 22kV và 10.5kV.', 1, 'Hệ thống điện sử dụng 3 trạm biến áp tăng áp và 1 trạm biến áp hạ áp.', 0, 'Trạm biến áp số 4 hạ áp cấp điện áp từ 220kV xuống 10.5kV.', 1, 'Tải tiêu thụ được nối với mạng điện hạ áp có cấp điện áp 0.4kV.', 1),
(27, 'Đây là mạch tổ hợp sử dụng các phần tử gồm: NOT, NAND, OR.', 0, 'Khi A=0, B=1 thì D = 0.', 0, 'Khi A=0, B=0, C=0 thì trạng thái đầu ra ở Q = 0', 1, 'Khi A=0, B=0, C=0 nếu thay cổng logic có đầu ra D thành cổng AND thì trạng thái kết quả đầu ra ở Q = 0.', 1),
(28, 'Tủ điện phân phối tổng được đặt ở trạm biến áp, lấy điện từ đường dây hạ áp 380/220V của máy biến áp để phân phối cho các tủ điện phân nhánh.', 1, 'Cơ sở sản xuất này có 6 phân xưởng sản xuất .', 0, 'Dây cáp điện dẫn điện kết nối các thành phần của mạng điện từ trạm biến áp đến các tủ điện và đến tải.', 1, 'Mỗi phân xưởng sản xuất có các thiết bị tiêu thụ điện là các loại động cơ điện và các thiết bị chiếu sáng.', 1),
(53, '.	Mắc 3 bóng đèn nối tiếp nhau thành một cụm rồi đấu hình sao vào mạch điện.', 0, '.	Mắc 3 bóng đèn song song thành một cụm rồi đấu hình sao có dây trung tính vào mạch điện.', 1, '.	Nguồn điện đang sử dụng là nguồn điện xoay chiều 3 pha đấu hình sao có dây trung tính.', 1, '.	Nếu mắc song song hai bóng đèn rồi mắc nối tiếp với một đèn còn lại thành một cụm rồi đấu hình sao vào mạch điện thì các bóng đèn vẫn sáng bình thường.', 0),
(54, '.	Có 2 loại mạch cộng hưởng gồm mạch cộng không đảo và mạch cộng đảo', 1, '.	Với mạch cộng đảo, đầu vào đảo được nối với đất.', 0, '.	Với mạch cộng không đảo, các tín hiệu được đưa vào đầu vào không đảo', 1, '.	Mạch cộng thực hiện phép cộng các điện trở nối với đầu vào', 0),
(55, '.	Khi thiết kế lắp đặt mạch điện cần chú ý lắp nối đất với các đồ dùng điện như tủ lạnh, máy giặt, bình nước nóng lạnh để trách rò điện.', 1, '.	Việc tính toán lựa chọn tiết diện dây dẫn điện và aptomat với các thông số phù hợp để đảm bảo an toàn và trách lãng phí.', 1, '.	Nếu có 2 loại dây dẫn điện bằng đồng có mật độ dòng điện là 6 A/mm2 có tiết diện 4 mm2 và 6 mm2 thì nên chọn đường dây chính trong nhà với tiết diện 6 mm2.', 1, '.	Nếu sử dụng bình nước nóng 30 lít với công suất 2500 W, nên chọn loại aptomat chống rò điện với dòng điện định mức 10 A.', 0),
(56, '.	Trong mạch này sử dụng cổng logic gồm: 1 cổng NOT, 1 cổng AND và 1 cổng OR', 1, '.	Kết quả phép logic có đầu vào là A, B, C được thể hiện biểu thức logic như sau: Y= A + (BC).', 1, '.	Tín hiệu nhận được ở đầu ra là 1 khi tín hiệu ở đầu vào có giá trị A = 0, B = 0, C = 0.', 0, '.	Nếu thay thế cổng logic cuối (OR) bằng cổng NOR và tín hiệu ở đầu vào có giá trị A = 0,      B = 1, C = 1, thì tín hiệu nhận được ở đầu ra bằng 1', 0),
(81, 'Theo cấu trúc chung của hệ thống điện trong gia đình, cây nước nước nóng lạnh thuộc thành phần tải điện.', 1, 'Lựa chọn aptomat đóng cắt bảo vệ cho cây nước nóng lạnh có dòng điện định mức nhỏ hơn hoặc bằng dòng điện tính toán được.', 0, 'Chọn dây dẫn có tiết diện: S = I  = 6,818 = 1,71 (mm2).  	\r\n                                                             J         4', 1, 'Cần chọn Aptomat sử dụng cho cây nước nóng lạnh có thông số dòng điện định mức 10 A, điện áp định mức 230 V.', 1),
(82, 'Nguồn 220V là điện áp pha và 380V là điện áp dây.', 1, 'Mỗi pha của tải 1 gồm ba đèn mắc nối tiếp với nhau.', 0, 'Dòng điện pha của tải thứ 2 bằng 12,67 A.', 1, 'Nếu tải 1 nối hình tam giác thì các đèn vẫn sáng bình thường.', 0),
(83, 'Mạch điện thuộc công nghệ điện tử số.', 0, 'Đây là kiểu mạch khuếch đại thuật toán.', 1, 'Mạch điện thực hiện cộng không đảo đối với các tín hiệu điện áp đầu vào.', 1, 'Điện áp ra được tính là: Ura = 30 V.', 0),
(84, 'Mạch điện trên có 3 cổng NOT và 1 cổng NAND.', 0, 'Y1 = 1 khi X1=0 và X2=1 hoặc X1=1 và X2=0 hoặc X1=1 và X2=1.', 1, 'Lập bảng chân lý cho Y2.\r\n<img src=\"uploads/img_69edd9f7e7f03_1777195511.png\" />\r\n', 1, 'Khi có cả 2 tín hiệu đầu vào hoặc một trong 2 tín hiệu đầu vào thì LED sáng hoặc còi kêu.', 0),
(137, 'Kĩ thuật điện là ngành kĩ thuật liên quan đến nghiên cứu và ứng dụng công nghệ điện, điện tử vào sản xuất, truyền tải, phân phối và sử dụng điện năng.', 1, 'Kĩ thuật điện cung cấp điện năng cho sản xuất, cho các thiết bị điện trong gia đình; giúp nâng cao chất lượng cuộc sống; điều khiển, tự động hóa cho quá trình sản xuất.', 1, 'Đế hạn chế tổn hao do truyền tải đi xa, kĩ thuật điện cần nghiên cứu phát triển các nhà máy thủy điện phân bố đều các vùng trong cả nước.', 0, 'Để bảo vệ môi trường, kĩ thuật điện cần nghiên cứu phát triển điện gió, điện mặt trời và điện hạt nhân ..', 1),
(138, 'Mạng điện sử dụng nguồn điện xoay chiều 1 pha điện áp 220V.', 1, 'Việc lắp aptomat riêng cho bình nước nóng giúp đảm bảo an toàn cho người và thiết bị.', 1, 'Tổng công suất các thiết bị là 4800W.', 0, 'Nên chọn loại aptomat chống dò điện cho bình nước nóng có dòng điện định mức 10A.', 0),
(139, 'Mạch logic tổ hợp sử dụng một cổng logic AND, một cống NOT và một đèn LED.', 1, 'Biểu thức logic đầu ra <img src=\"uploads/img_69f43fec6f589_1777614828.png\" />\r\n', 0, 'Nếu quy ước: công tắc ON = mức 1, OFF = mức 0; LED sáng = mức 1, LED tắt = mức 0 thì LED sáng khi đầu vào A = 0, B = 1.', 1, 'Khi thay thế mạch logic tổ hợp trên bằng cổng logic NAND thì chức năng của mạch không thay đổi.', 0),
(140, 'Mạch khuếch đại không đào tạo ra tín hiệu đầu ra cùng pha với tín hiệu đầu vào.', 1, 'Hệ số khuếch đại được tính theo công thức: <img src=\"uploads/img_69f43f686e196_1777614696.png\" />', 0, 'Với Vin = 0,2V thì tín hiệu ra Vout =1,8V. ', 0, 'Để tín hiệu đầu ra Vout ≤ 15V thì tín hiệu đầu vào Vin ≤ 1,5 V.', 1),
(165, 'Để chiếu sáng cho nhà xưởng có thể sử dụng ba bóng đèn có thông số kĩ thuật 200W – 220V \r\nmắc vào mạch điện theo cách mắc của tải 2.', 0, 'Quan hệ giữa điện áp pha và dòng điện pha (Up1 và Ip1) với điện áp dây và dòng điện dây \r\n(Ud1 và Id1) của tải 1 là Up1 = Ud1;  Ip1 = Id1 /√3', 0, 'Dòng điện chạy qua mỗi pha của tải 1 là 22A.', 1, 'Trong mạch điện này, tải 1 nối hình sao có dây trung tính, tải 2 nối hình tam giác.', 1),
(166, 'Điện trở dùng để lắp ráp mạch điện này có 3 vạch màu biểu thị giá trị lần lượt là nâu – đen - cam.', 0, 'Đây là mạch phân chia điện áp sử dụng điện trở R và biến trở VR.', 1, 'Muốn tăng giá trị dòng điện chạy trong mạch điện này, cần điều chỉnh để giá trị của biển trở \r\nVR tăng lên.', 0, 'Để giá trị điện thế tại điểm A là 3V thì biến trở VR phải có giá trị bằng R/3.', 1),
(167, 'Bóng đèn có thông số 200W – 220V, mật độ dòng điện cho phép của dây dẫn là J = 6 A/mm \r\nthì tiết diện dây dẫn theo tính toán là 0,15 mm.', 1, 'Nếu thay công tắc CT1 và CT2 bằng 2 công tắc 2 cực thì mạch điện vẫn đáp ứng yêu cầu.', 0, 'Ý tưởng thiết kế được thể hiện bằng sơ đồ nguyên li.', 1, 'CT1 và CT2 là công tắc 3 cực đặt ở vị trí cần bật/tắt đèn.', 1),
(168, 'Trong mạch sử dụng các linh kiện như điện trở, biến trở, LED, transistor lưỡng cực.', 1, 'Loại transistor lưỡng cực sử dụng trong mạch là PNP.', 0, 'LED sáng khi UBE = 0.', 0, 'Khi điều chỉnh biến trở RBT, độ sáng của LED thay đổi.', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_shuffled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `exams`
--

INSERT INTO `exams` (`id`, `title`, `code`, `duration`, `description`, `status`, `created_at`, `is_shuffled`) VALUES
(1, 'SỞ GIÁO DỤC VÀ ĐÀO TẠO PHÚ YÊN TRƯỜNG THPT CHU VĂN AN', 'ĐỀ THI TỐT NGHIỆP THPT (THAM KHẢO)', 50, '', 'active', '2026-04-26 09:13:38', 1),
(2, 'SỞ GIÁO DỤC VÀ ĐÀO TẠO PHÚ YÊN  TRƯỜNG THPT NGUYỄN TRẢI', 'ĐỀ THI TỐT NGHIỆP THPT (THAM KHẢO)', 50, '', 'active', '2026-04-26 09:22:27', 1),
(3, 'SỞ GIÁO DỤC VÀ ĐÀO TẠO PHÚ YÊN TRƯỜNG THPT LÊ TRUNG KIÊN', 'ĐỀ (THAM KHẢO) THI  TỐT NGHIỆP THPT 2025', 50, '', 'active', '2026-04-26 09:28:48', 1),
(5, 'SỞ GIÁO DỤC VÀ ĐÀO TẠO NAM ĐỊNH 		', 'ĐỀ THI THỬ TỐT NGHIỆP LÀN 2 NĂM HỌC: 2024-2025', 50, '', 'active', '2026-05-01 05:54:09', 1),
(6, 'SỞ GIÁO DỤC VÀ ĐÀO TẠO BẾN TRE ', 'ĐỀ THI THỬ TỐT NGHIỆP THPT NĂM 2025  ', 50, '', 'active', '2026-05-04 12:57:18', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `q_type` enum('mcq','tf') NOT NULL,
  `q_index` int(11) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `shared_context` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `q_type`, `q_index`, `content`, `shared_context`) VALUES
(1, 1, 'mcq', 1, 'Việc nghiên cứu chuyển đổi các dạng năng lượng khác thành năng lượng điện là những hoạt động trong lĩnh vực kĩ thuật điện để', NULL),
(2, 1, 'mcq', 2, 'Trị số điện trở màu tính theo công thức:', NULL),
(3, 1, 'mcq', 3, 'Nhiệm vụ của vận hành điện trong trung tâm điều độ quốc gia là gì?', NULL),
(4, 1, 'mcq', 4, 'Đối với điện trở màu, vòng màu thứ nhất chỉ:', NULL),
(5, 1, 'mcq', 5, 'Để tạo ra dòng điện xoay chiều ba pha, người ta dùng:', NULL),
(6, 1, 'mcq', 6, 'Đơn vị ghi trên tụ điện thường là:', NULL),
(7, 1, 'mcq', 7, 'Nối hình sao:', NULL),
(8, 1, 'mcq', 8, 'Mạch điện ba pha bốn dây tạo ra mấy trị số điện áp khác nhau?', NULL),
(9, 1, 'mcq', 9, 'Nếu tải ba pha đối xứng, khi nối hình sao thì:\r\n', NULL),
(10, 1, 'mcq', 10, 'Điôt dẫn điện khi:', NULL),
(11, 1, 'mcq', 11, 'Hệ thống điện quốc gia gồm có:', NULL),
(12, 1, 'mcq', 12, 'Dòng điện dây:', NULL),
(13, 1, 'mcq', 13, 'Than đá dùng để sản xuất điện năng được xếp vào nguồn năng lượng nào?', NULL),
(14, 1, 'mcq', 14, 'Điện mặt trời có nhiều ưu điểm như: năng lượng tái tạo, sạch, vô tận nhưng cũng gây ra nhược điểm:', NULL),
(15, 1, 'mcq', 15, 'Trong chương trình công nghệ 12, giới thiệu mấy loại sơ đồ mạch ba pha của máy phát điện xoay chiều ba pha?', NULL),
(16, 1, 'mcq', 16, 'Ở mạng điện hạ áp dùng trong sinh hoạt, tủ điện phân phối tổng có nhiệm vụ:', NULL),
(17, 1, 'mcq', 17, 'Đây là kí hiệu của:\r\n<img src=\"uploads/img_69edd650252aa_1777194576.png\" />\r\n', NULL),
(18, 1, 'mcq', 18, 'Để tiết kiệm điện năng, em sẽ lựa chọn loại đèn nào ở Bảng 12.1?\r\n<img src=\"uploads/img_69edd6567e9fb_1777194582.png\" />\r\n', NULL),
(19, 1, 'mcq', 19, 'Nếu đầu vào A = 1, B = 1, sau khi qua cổng AND thì đầu ra Q có giá trị là bao nhiêu?\r\n', NULL),
(20, 1, 'mcq', 20, 'Em hãy cho biết đồng hồ hiển thị trên cây xăng hoạt động dựa trên bộ so sánh, bộ đếm hay cả hai?', NULL),
(21, 1, 'mcq', 21, 'Một mạch cộng đảo ở Hình 19.16 có Rf = 3 kΩ , R1 = 1 kΩ , R2 = 1,5 kΩ. Tính điện áp Ura khi Uvào 1 = 1(V) và Uvào 2 = 1(V)?\r\n<img src=\"uploads/img_69edd65b99ec2_1777194587.png\" />\r\n', NULL),
(22, 1, 'mcq', 22, 'Mạch trừ ở Hình 19.14 có R1 = R3 = 2 kΩ, R2 = R4 = 10 kΩ. Tính điện áp Ura \r\nnếu Uvào 1 = 1(V), Uvào 2 = 5(V)?\r\n \r\n<img src=\"uploads/img_69edd663cf903_1777194595.png\" />\r\n', NULL),
(23, 1, 'mcq', 23, 'Một mạch so sánh đảo ở Hình 19.17 có Ucc =12 V, - Ucc = - 12 V.Tính điện áp Ura \r\nnếu Uvào = 3(V), Ungưỡng = -3(V)?\r\n<img src=\"uploads/img_69edd6a7be366_1777194663.png\" />\r\n', NULL),
(24, 1, 'mcq', 24, 'Trong ví dụ Hình 25.5, nếu muốn chuyển dữ liệu từ cảm biến vào vi điều khiển thông qua cổng A0 thay vì cổng A2 thì ta cần thay đổi như thế nào?\r\n\r\n<img src=\"uploads/img_69edd6c03a2bf_1777194688.png\" />\r\n', NULL),
(25, 1, 'tf', 25, 'Cho mạch điện ba pha tải đối xứng nối theo hình sao trong đó điện áp pha Up = 220V và tải ba pha gồm 3 điện trở R= 50Ω:\r\n<img src=\"uploads/img_69edd6d94eddc_1777194713.png\" />\r\n', NULL),
(26, 1, 'tf', 26, 'Cho sơ đồ hệ thống điện như hình vẽ:', NULL),
(27, 1, 'tf', 27, 'Cho sơ đồ mạch như h́ình trên. Mạch này có các đặc điểm sau:\r\n<img src=\"uploads/img_69edd6ddbb85a_1777194717.png\" />\r\n', NULL),
(28, 1, 'tf', 28, 'Quan sát sơ đồ cấu trúc chung của mạng điện sản xuất quy mô nhỏ, em hãy cho biết các nhận định nào sau đây là đúng, sai?\r\n<img src=\"uploads/img_69edd6e38f1f1_1777194723.png\" />\r\n', NULL),
(29, 2, 'mcq', 1, 'Trong các phương pháp gia công cơ khí sau đây, phương pháp nào là phương pháp gia công không phoi?', NULL),
(30, 2, 'mcq', 2, 'Cuộc sống hằng ngày của con người càng tiện nghi, an toàn nhờ các thiết bị điện thể hiện vai trò của kĩ thuật điện trong', NULL),
(31, 2, 'mcq', 3, 'Sản xuất điện năng là gì?', NULL),
(32, 2, 'mcq', 4, 'Kí hiệu dưới đây là kí hiệu của:\r\n<img src=\"uploads/img_69edd8f36f9b1_1777195251.png\" />\r\n', NULL),
(33, 2, 'mcq', 5, 'Một cái tủ có kích thước chiều dài là 1 m. Khi biểu diễn cái tủ trên bản vẽ bằng hình chiếu vuông góc, kích thước chiều dài được vẽ là 50 mm. Hình biểu diễn đã vẽ với tỉ lệ là', NULL),
(34, 2, 'mcq', 6, 'Kính sẽ có chống khả năng chống bám nước, bám bụi, cản được tia tử ngoại và bức xạ sóng ngắn trong khi độ trong suốt không ảnh hưởng nếu được ứng dụng bởi vật liệu nào', NULL),
(35, 2, 'mcq', 7, 'Công việc chẩn đoán, kiểm tra trạng thái kĩ thuật, theo dõi, ngăn ngừa các sự cố và khắc phục những hư hỏng đảm bảo sự hoạt động ổn định và an toàn của thiết bị điện tử là những hoạt động.', NULL),
(36, 2, 'mcq', 8, 'Công nghệ in 3D; công nghệ AI; công nghệ IoT; điện toán đám mây; Big Data là công nghệ nền tảng của', NULL),
(37, 2, 'mcq', 9, 'Quan sát hình 7 và cho biết hai hình nào được vẽ bằng phương pháp hình chiếu trục đo?\r\n<img src=\"uploads/img_69edd8feba02f_1777195262.png\" />\r\n', NULL),
(38, 2, 'mcq', 10, 'Quá trình chuyển đổi nhiệt năng thành cơ năng của động cơ đốt trong được thực hiện ở vị trí nào trong động cơ?', NULL),
(39, 2, 'mcq', 11, 'Đâu không phải đặc điểm của mạng điện sản xuất quy mô nhỏ?', NULL),
(40, 2, 'mcq', 12, 'Kĩ thuật điện tử là một lĩnh vực kĩ thuật có liên quan đến', NULL),
(41, 2, 'mcq', 13, 'Bộ li hợp trong hệ thống truyền lực trên ô tô có nhiệm vụ', NULL),
(42, 2, 'mcq', 14, 'Muốn ô tô chuyển hướng sang trái cần quay vành tay lái', NULL),
(43, 2, 'mcq', 15, 'Một điện trở có trị số điện trở là 270000Ω ± 5% thì vòng màu thứ tự trên thân điện trở là:', NULL),
(44, 2, 'mcq', 16, 'Một máy phát điện xoay chiều 3 pha có điện áp mỗi dây quấn pha là 110V, nếu nối hình sao thì điện áp pha và điện áp dây có giá trị lần lượt là', NULL),
(45, 2, 'mcq', 17, 'Bảng chân lí sau mô tả liên hệ logic giữa các đầu vào X1, X2 và đầu ra F của cổng logic\r\n<img src=\"uploads/img_69edd9146b775_1777195284.png\" />\r\n', NULL),
(46, 2, 'mcq', 18, 'Nhà An có mua một máy nóng lạnh để dùng trong gia đình có công suất tiêu thụ 2200 W, điện áp là 220 V, hệ số công suất là 1, nên khi chọn Aptomat thì An chọn loại nào trong các phương án sau:\r\n', NULL),
(47, 2, 'mcq', 19, 'Một nguồn điện ba pha được nối như hình vẽ, cho biết nguồn điện được nối theo sơ đồ nào?\r\n<img src=\"uploads/img_69edd92c6f5c1_1777195308.png\" />\r\n', NULL),
(48, 2, 'mcq', 20, 'Cho sơ đồ lưới điện phân phối có điện áp 110 kV như hình bên, thiết bị số 3 là\r\n<img src=\"uploads/img_69edd93745913_1777195319.png\" />\r\n', NULL),
(49, 2, 'mcq', 21, 'Quê hương của Nam dự định xây dựng các nhà máy điện sử dụng điện gió và điện mặt trời. Theo em, đây là ứng dụng của', NULL),
(50, 2, 'mcq', 22, 'Một hàm logic có thể thực hiện bởi các cổng logic cơ bản như NOT, OR, AND, NAND, NOR, … Hàm logic của mạch tổ hợp ở hình bên là\r\n<img src=\"uploads/img_69edd93eb9ea0_1777195326.png\" />\r\n', NULL),
(51, 2, 'mcq', 23, 'Hai vi điều khiển E, F cùng loại nhưng được thiết kế hoạt động ở tần số xung nhịp khác nhau. CPU E hoạt động ở tần số xung nhịp là 4 MHz, CPU F hoạt động ở tần số xung nhịp 8 MHz. Kết quả so sánh tốc độ thực thi của hai vi điều khiển sau đây là đúng.', NULL),
(52, 2, 'mcq', 24, 'Cho sơ đồ của hàm logic Y như hình vẽ sau. Hãy xác định trạng thái lối ra của Y theo các lối vào A,B,C cho trong bảng sau:\r\n<img src=\"uploads/img_69edd945bc543_1777195333.png\" />\r\n', NULL),
(53, 2, 'tf', 25, 'Một xưởng sử dụng điện xoay chiều ba pha bốn dây với điện áp dây đo được là 380 V. Nhân viên kĩ thuật đang dự định mắc 9 bóng đèn, mỗi bóng đèn có điện áp định mức 220 V và có cùng công suất để thắp sáng cho xưởng. Một nhân viên khác đưa ra một số ý kiến mắc mạch như sau:', NULL),
(54, 2, 'tf', 26, 'Khuếch đại thuật toán được kết nối với các linh kiện điện tử khác để tạo nên nhiều mạch ứng dụng khác nhau, trong đó có mạch cộng để thực hiện việc cộng điện áp của 2 tín hiệu đầu vào. Dưới đây là các phát biểu về mạch cộng sử dụng khuếch đại thuật toán.', NULL),
(55, 2, 'tf', 27, 'Một nhóm học sinh tìm hiểu cách thiết kế cho một mạng điện trong gia đình với tổng công suất của các thiết bị điện dùng đồng thời là 5000W (hệ số công suất chung của các đồ dùng điện bằng 1). Sau đây là một số ý kiến trao đổi của nhóm:', NULL),
(56, 2, 'tf', 28, 'Cho mạch logic như hình bên dưới\r\n<img src=\"uploads/img_69edd9514fa8a_1777195345.png\" />\r\n', NULL),
(57, 3, 'mcq', 1, 'Cấu trúc hệ thống mạch hở và mạch kín khác nhau ở phần tử?', NULL),
(58, 3, 'mcq', 2, 'Công nghệ gia công áp lực dựa vào đặc tính cơ bản nào của kim loại?', NULL),
(59, 3, 'mcq', 3, 'Khi biểu diễn vật thể bằng phương pháp chiếu góc thứ nhất thì chiều cao của vật thể được thể hiện:', NULL),
(60, 3, 'mcq', 4, 'Phương pháp gia công đúc được sử dụng để', NULL),
(61, 3, 'mcq', 5, 'Chu trình công tác của động cơ đốt trong là tổng hợp lần lượt các quá trình xảy ra trong xilanh động cơ theo thứ tự là:', NULL),
(62, 3, 'mcq', 6, 'Trong cơ cấu phân phối khí dùng xu páp, khi trục khuỷu quay 360 độ thì trục cam quay bao nhiêu độ?', NULL),
(63, 3, 'mcq', 7, 'Vị trí công việc phù hợp với người có trình độ đại học ngành kỹ thuật điện?', NULL),
(64, 3, 'mcq', 8, 'Lợi ích của việc phát triển và sản xuất điện từ nguồn năng lượng tái tạo là:', NULL),
(65, 3, 'mcq', 9, 'Cấp điện áp của lưới điện truyền tải trong hệ thống điện nước ta từ bao nhiêu kV trở lên?', NULL),
(66, 3, 'mcq', 10, 'Khi nối nguồn điện xoay chiều ba pha kiểu hình sao, thì ba điểm cuối của các dây pha được nối với nhau để tạo thành', NULL),
(67, 3, 'mcq', 11, 'Khi nối nguồn điện xoay chiều ba pha với tải điện ba pha kiểu hình tam giác, nếu điện áp giữa hai dây pha bất kỳ là 380V thì điện áp pha của mỗi tải sẽ là :', NULL),
(68, 3, 'mcq', 12, 'Trong hệ thống điện gia đình, công tơ điện là thiết bị có chức năng:', NULL),
(69, 3, 'mcq', 13, 'Trong thiết kế, lắp đặt điện, để đảm bảo an toàn điện cần tính toán lựa chọn dây dẫn, cáp điện có thông số về tiết diện lõi dây phải phù hợp với', NULL),
(70, 3, 'mcq', 14, 'Trong lĩnh vực điện tử, công việc sản xuất thiết bị điện tử được thực hiện bởi', NULL),
(71, 3, 'mcq', 15, 'Tụ điện có tác dụng', NULL),
(72, 3, 'mcq', 16, 'Trên thân của một điện trở R có các vạch màu: xanh lam, vàng, cam, nâu. Giá trị điện trở R được xác định là', NULL),
(73, 3, 'mcq', 17, 'Tín hiệu tương tự là tín hiệu', NULL),
(74, 3, 'mcq', 18, 'Các cổng logic cơ bản được sử dụng trong', NULL),
(75, 3, 'mcq', 19, 'Phần tử nhớ Flip-flop(trigger) được sử dụng trong', NULL),
(76, 3, 'mcq', 20, 'Mạch tích hợp nhiều linh kiện điện tử siêu nhỏ có thể lập trình để thực hiện các chức năng tính toán và điều khiển được gọi là:', NULL),
(77, 3, 'mcq', 21, 'Quan sát hình biểu diễn ba chiều của Tấm trượt dọc,\r\nTheo phương pháp chiếu góc thứ nhất với hướng chiếu đã chỉ định. Hãy chọn cách trình bày các hình chiếu vuông đúng nhất?\r\n Hướng chiếu từ trước\r\n<img src=\"uploads/img_69edda2593051_1777195557.png\" />\r\n', NULL),
(78, 3, 'mcq', 22, 'Từ một phôi thép có đường kính Ø40mm và chiều dài 160mm. Để chế tạo chi tiết Trục có các hình chiếu vuông góc như hình bên, người ta gia công chi tiết bằng phương pháp:\r\n<img src=\"uploads/img_69edda1a98322_1777195546.png\" />\r\n', NULL),
(79, 3, 'mcq', 23, 'Cho mạch khuếch đại điện áp. Hãy xác định giá trị của Ura biết R1 = 1 kΩ, Rht = 15 kΩ, \r\nUvào = 1,5 V\r\n<img src=\"uploads/img_69edda150d4a7_1777195541.png\" />\r\n', NULL),
(80, 3, 'mcq', 24, 'Cho mạch xử lí tín hiệu số, gồm các cổng logic ở hình bên. Kết quả đầu ra của mạch là:\r\n<img src=\"uploads/img_69edda10be4ad_1777195536.png\" />\r\n', NULL),
(81, 3, 'tf', 25, 'Cây nước nóng lạnh trong gia đình có công suất tiêu thụ 1500 W, điện áp 220 V, cosφ =1. Cho mật độ dòng điện J = 4 A/mm2 .', NULL),
(82, 3, 'tf', 26, 'Cho mạch điện có hai tải ba pha như hình dưới đây: Tải thứ nhất là 9 bóng đèn (số liệu của mỗi bóng đèn là P = 100W, U = 220V); tải thứ hai là một lò điện trở ba pha (điện trở mỗi pha R = 30Ω, U = 380V). Các tải trên được nối vào mạch điện ba pha bốn dây có điện áp 220/380 V. Sau đây là một số nhận định liên quan đến mạch điện trên.\r\n<img src=\"uploads/img_69edda077a144_1777195527.png\" />\r\n', NULL),
(83, 3, 'tf', 27, 'Cho sơ đồ mạch điện như hình bên. Có thông số như sau: R1 = R2 = 4 kΩ, R3 = R4 = 20 kΩ, U1 = 2 V, U2 = 10V. Dưới đây là những nhận định về mạch điện đó.\r\n<img src=\"uploads/img_69edda01553fa_1777195521.png\" />\r\n', NULL),
(84, 3, 'tf', 28, 'Cho sơ đồ mạch báo cháy như hình vẽ\r\n<img src=\"uploads/img_69edd9f076166_1777195504.png\" />\r\n\r\n', NULL),
(113, 5, 'mcq', 1, 'Tốc độ bit của tín hiệu ở hình dưới đây là', NULL),
(114, 5, 'mcq', 2, 'Tín hiệu âm thanh sau khi đi qua microphone sẽ được chuyển thành tín hiệu', NULL),
(115, 5, 'mcq', 3, 'Kết nối các thiết bị điện tử rời rạc thành một sản phẩm hoàn chỉnh phục vụ trong các lĩnh vực khác nhau thuộc ngành nghề', NULL),
(116, 5, 'mcq', 4, 'Lựa chọn tiết diện lõi dây phù hợp với công suất tiêu thụ của thiết bị là nguyên tắc an toàn trong', NULL),
(117, 5, 'mcq', 5, 'Trong các tình huống dưới đây, tinh huống nào đảm bảo an toàn điện?', NULL),
(118, 5, 'mcq', 6, 'Trong các hình dưới đây, đâu là transistor?', NULL),
(119, 5, 'mcq', 7, 'Quy trình của thiết kế kĩ thuật gồm các bước: (1) Thiết kế sản phẩm; (2) Xác định yêu cầu sản phẩm; (3) Tìm hiểu thông tin, đề xuất lựa chọn; (4) Kiểm tra đánh giá; (5) Lập hồ sơ kĩ thuật. Quy trình đúng của thiết kế kĩ thuật là', NULL),
(120, 5, 'mcq', 8, 'Hình bên là hình chiếu', NULL),
(121, 5, 'mcq', 9, 'Điều chế biên độ (AM) là quá trình điều chỉnh thành phần nào của sóng mang theo tín hiệu cần truyền?', NULL),
(122, 5, 'mcq', 10, 'Một phát minh quan trọng về năng lượng điện và sản xuất hàng loạt là thành tựu của cuộc cách mạng công nghiệp lần thứ', NULL),
(123, 5, 'mcq', 11, 'Cho mạch điện ba pha tải đối xứng nối theo hình tam giác, trong đó điện áp dây Ud = 380V và tải ba pha gồm 3 điện trở R = 50Ω. Giá trị dòng điện mỗi pha của tải và dòng điện dây của mạch điện là', NULL),
(124, 5, 'mcq', 12, 'Một tải ba pha gồm ba điện trở R bằng nhau nối hình sao, đấu vào nguồn điện ba pha có Ud = 380V. Điện áp nha Up có giá trị là', NULL),
(125, 5, 'mcq', 13, 'Động cơ diesel không có hệ thống', NULL),
(126, 5, 'mcq', 14, 'Lựa chọn các cụm từ vào ô trống trong câu sau:\r\n “ Hệ thống kĩ thuật là hệ thống bao gồm các phần tử:......(1)....., ......(2).....và .....(3)..... có mối liên hệ với nhau để thực hiện một nhiệm vụ cụ thể”.', NULL),
(127, 5, 'mcq', 15, 'Tại thời điểm trạng thái các đầu vào x1 = 1, x2 = 1 và đầu ra y = 0 như hình vẽ dưới đây. Cổng logic phù hợp là', NULL),
(128, 5, 'mcq', 16, 'Trong hệ thống điện quốc gia, nguồn điện có vai trò', NULL),
(129, 5, 'mcq', 17, 'Hiện nay, người ta thường lắp thiết bị nào để tự động cắt điện bảo vệ quá tải, ngắn mạch cho mạch điện?', NULL),
(130, 5, 'mcq', 18, 'Trong động cơ đốt trong, cơ cấu trục khuỷu thanh truyền gồm các chi tiết chính là', NULL),
(131, 5, 'mcq', 19, 'Pít tông của động cơ đốt trong ở hình bên được làm bằng vật liệu nào?', NULL),
(132, 5, 'mcq', 20, 'Ngày nay, cuộc sống gia đình ngày càng tiện nghi hơn nhờ các thiết bị điện như: đèn điện, quạt điện, nồi cơm điện, bếp điện, tủ lạnh, máy giặt, điều hòa, ... Điều này thể hiện vị trí, vai trò nào của kĩ thuật điện trong đời sống?', NULL),
(133, 5, 'mcq', 21, 'Một Op-Amp lý tưởng được cấu hình làm bộ khuếch đại đảo với điện trở đầu vào R1 và điện trở hồi tiếp R2 như hình bên. Nếu R1 = 1kΩ và R2 = 10kΩ thì hệ số khuếch đại điện áp của mạch là', NULL),
(134, 5, 'mcq', 22, 'Phương pháp gia công cắt gọt được sử dụng để tạo lỗ trên các sản phẩm là phương pháp', NULL),
(135, 5, 'mcq', 23, 'Một điện trở trên thân có các vòng màu theo thứ tự: xanh lục, xanh lam, cam, vàng kim (nhũ vàng). Điện trở đó có giá trị bằng', NULL),
(136, 5, 'mcq', 24, 'Trong hệ thống điện quốc gia, tải tiêu thụ (tải điện) là', NULL),
(137, 5, 'tf', 25, 'Khi tìm hiểu về vị trí, vai trò và triển vọng phát triển của kĩ thuật điện, nhóm học sinh lớp 12 có các ý kiến như sau:', NULL),
(138, 5, 'tf', 26, 'Khi thực hành thiết kế một mạng điện cho gia đình với các thiết bị gồm: 10 bóng đèn 40W - 220V, 1 tủ lạnh công suất 120W, 1 máy giặt công suất 1500W – 220V, 1 bình nước nóng 30 lít công suất 2500W – 220V, 4 quạt điện công suất 80W – 220V; nhóm học sinh nhận định:', NULL),
(139, 5, 'tf', 27, 'Câu 3 Trong tiết thực hành môn Công nghệ, học sinh được giao bài tập lắp mạch điều khiển đèn LED theo sơ đồ như hình vẽ. Sau đây là một số nhận định\r\n<img src=\"uploads/img_69f43fd1befbc_1777614801.png\" />\r\n', NULL),
(140, 5, 'tf', 28, 'Trong quá trình thiết kế mạch khuếch đại tín hiệu từ cảm biến nhiệt độ, bạn A lựa chọn sử dụng Op-Amp lý tưởng theo cấu hình khuếch đại không đảo. Để đảm bảo tín hiệu đầu ra đủ lớn, bạn A chọn điện trở R =1kΩ, R2 = 9kΩ và cấp nguồn đối xứng +15V cho Op-Amp như hình vẽ. Sau khi cấp tín hiệu đầu vào Vin = 0,2V, bạn A tiến hành quan sát và phân tích hoạt động của mạch. \r\n<img src=\"uploads/img_69f43f2eba888_1777614638.png\" />\r\n', NULL),
(141, 6, 'mcq', 1, 'Tín hiệu số là', NULL),
(142, 6, 'mcq', 2, 'Có mấy loại tỉ lệ trong TCVN 7286:2003?', NULL),
(143, 6, 'mcq', 3, 'Trong chu trình làm việc của động cơ đốt trong bốn kì, kì nào được gọi là kì sinh công?', NULL),
(144, 6, 'mcq', 4, 'Để tiết kiệm điện năng trong chiếu sáng, nên lựa chọn loại đèn nào sau đây?', NULL),
(145, 6, 'mcq', 5, 'Nguồn năng lượng nào sản xuất điện không gây phát thải khí nhà kính?', NULL),
(146, 6, 'mcq', 6, 'Việc nghiên cứu chuyển đổi các dạng năng lượng khác thành năng lượng điện là những \r\nhoạt động trong lĩnh vực kĩ thuật điện để', NULL),
(147, 6, 'mcq', 7, 'Mạch điện ba pha ba dây, có Ud = 380V, tải là ba điện trở R bằng nhau nối hình tam \r\ngiác. Cho biết Id = 70 (A). Điện trở R có giá trị nào sau đây? ', NULL),
(148, 6, 'mcq', 8, 'Tụ điện mắc vào mạch điện xoay chiều một pha có tần số f = 50 Hz, trị số điện dung C = \r\n10 µF. Dung kháng của tụ điện đó là', NULL),
(149, 6, 'mcq', 9, 'Cho các bước sau: \r\n(1) Đọc bản vẽ chi tiết.   \r\n(2) Gia công chi tiết.\r\n(3) Chuẩn bị phôi.\r\n(4) Lắp rắp.    \r\n(5) Kiểm tra chất lượng sản phẩm. \r\nQuy trình đúng của chế tạo cơ khí là:', NULL),
(150, 6, 'mcq', 10, 'Một điện trở có giá trị 56 x 10³ Ω ±5%. Vạch màu tương ứng theo thứ tự là:', NULL),
(151, 6, 'mcq', 11, 'Quá trình biến đổi năng lượng xảy ra trong xi lanh (xilanh) động cơ theo trình tự nào \r\nsau đây?', NULL),
(152, 6, 'mcq', 12, 'Một điện trở có 4 vòng màu lần lượt là: nâu, đen, vàng, nhũ vàng (vàng kim) thì giá trị \r\nđiện trở của nó là', NULL),
(153, 6, 'mcq', 13, 'Đơn vị của cảm kháng của cuộn cảm (XL) là', NULL),
(154, 6, 'mcq', 14, 'Cuộn cảm mắc vào mạch điện xoay chiều một pha có tần số f = 50 Hz, trị số điện cảm L \r\n= 1000 mH. Cảm kháng của cuộn cảm đó là', NULL),
(155, 6, 'mcq', 15, 'Khung vẽ (Khung bản vẽ) được vẽ bằng nét', NULL),
(156, 6, 'mcq', 16, 'Một số máy giặt có thiết kế trên bảng điều khiển nút bấm “Khóa trẻ em” để tránh trường \r\nhợp trẻ em bị kẹt trong lồng máy giặt. Sau khi kích hoạt chế độ này, nếu cửa máy giặt bị mở ra, \r\nmáy sẽ phát ra âm thanh báo động kèm một thông báo lỗi xuất hiện và máy sẽ ngưng hoạt động. \r\nNhư vậy, người thiết kế sản phẩm này đã quan tâm tới yếu tố nào trong quá trình thiết kế kĩ \r\nthuật?', NULL),
(157, 6, 'mcq', 17, 'Theo số hành trình của pít tông trong một chu trình công tác, động cơ đốt trong được \r\nphân loại thành:', NULL),
(158, 6, 'mcq', 18, 'Dòng điện xoay chiều ba pha là hệ thống ba dòng điện xoay chiều một pha có', NULL),
(159, 6, 'mcq', 19, 'Tụ điện có ghi thông số 100µF/450V. Ý nghĩa của thông số này là:', NULL),
(160, 6, 'mcq', 20, 'Trên một tụ điện có ghi con số 101, giá trị điện dung của tụ điện này là', NULL),
(161, 6, 'mcq', 21, 'Một mạch điện 3 pha đối xứng có tải nối hình tam giác, các thông số hiệu dụng của dây \r\nkí hiệu là Id và Ud, các thông số hiệu dụng của pha kí hiệu là Ip và Up. Mối quan hệ giữa các \r\nthông số trên là:', NULL),
(162, 6, 'mcq', 22, 'Cho mạch điện ba pha đối xứng có nguồn điện và tải nối theo hình sao, trong đó điện áp \r\npha Up = 220V và tải ba pha gồm 3 điện trở R = 50Ω. Tính dòng điện pha, dòng điện dây và \r\nđiện áp dây của mạch.', NULL),
(163, 6, 'mcq', 23, 'Linh kiện có 3 lớp bán dẫn, 3 cực là', NULL),
(164, 6, 'mcq', 24, 'Quan sát hình sau và cho biết tín hiệu nào là tín hiệu tương tự?\r\n<img src=\"uploads/img_69f896c0ca7f4_1777899200.png\" />\r\n', NULL),
(165, 6, 'tf', 25, 'Một hộ sản xuất quy mô nhỏ vừa lắp đặt mạch điện 3 pha cho một nhà xưởng. Mạch điện \r\nsử dụng nguồn điện xoay chiều 3 pha lấy từ lưới điện hạ áp có điện áp dây Ud = 380V cung cấp \r\ncho các tải như hình vẽ dưới đây. Tải 1 là một lò sấy 3 pha, mỗi pha có điện trở R = 10Ω. Tài 2 \r\nlà động cơ không đồng bộ 3 pha có tổng trở mỗi pha là Z, truyền động cho một máy cắt gọt kim \r\nloại. Các tải làm việc bình thường.\r\n<img src=\"uploads/img_69f897417119c_1777899329.png\" />\r\n', NULL),
(166, 6, 'tf', 26, 'Trong giờ học công nghệ một nhóm học sinh được giao nhiệm vụ tìm hiểu về các linh \r\nkiện điện tử cơ bản. Khi quan sát một mạch điện tử có sơ đồ như hình bên, nhóm học sinh đưa ra \r\ncác ý kiến:\r\n<img src=\"uploads/img_69f8975f6afad_1777899359.png\" />\r\n', NULL),
(167, 6, 'tf', 27, 'Một nhóm học sinh được yêu cầu thiết kế, lắp ráp mạch điện chiếu sáng sân vườn cho gia \r\nđình. Mạch điện điều khiển bật/tắt một bóng đèn tại 2 vị trí khác nhau. Hình sau là ý tưởng thiết \r\nkế của nhóm học sinh này.\r\n<img src=\"uploads/img_69f8976becb7b_1777899371.png\" />\r\n', NULL),
(168, 6, 'tf', 28, 'Hình bên là sơ đồ nguyên lí của một mạch điện tử điều khiển LED thông qua việc đóng \r\nmở transistor lưỡng cực. Sau đây là các mô tả về mạch điện tử này:\r\n<img src=\"uploads/img_69f897797f4cb_1777899385.png\" />\r\n', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `score` decimal(4,2) DEFAULT NULL,
  `mcq_score` decimal(4,2) DEFAULT NULL,
  `tf_score` decimal(4,2) DEFAULT NULL,
  `time_taken` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `device` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `results`
--

INSERT INTO `results` (`id`, `user_id`, `exam_id`, `score`, `mcq_score`, `tf_score`, `time_taken`, `ip`, `device`, `created_at`) VALUES
(1, 2, 1, 0.10, 0.00, 0.10, 8, '2001:ee1:ee13:1290:4819:4e4:ea1d:c711', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-26 09:14:04'),
(2, 2, 3, 0.25, 0.25, 0.00, 124, '2001:ee1:ee13:1290:443b:2889:7538:36d4', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '2026-04-26 14:53:50'),
(3, 2, 1, 4.50, 3.00, 1.50, 363, '14.191.236.83', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Mobile Safari/537.36', '2026-05-08 11:43:43'),
(4, 2, 6, 0.00, 0.00, 0.00, 3, '2402:800:629e:3d75:ed36:8f19:4814:8967', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Mobile Safari/537.36', '2026-05-14 10:57:11'),
(5, 2, 3, 0.00, 0.00, 0.00, 21, '116.98.2.155', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Mobile Safari/537.36', '2026-05-14 13:41:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `result_details`
--

CREATE TABLE `result_details` (
  `id` int(11) NOT NULL,
  `result_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_answer` mediumtext DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `points` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `result_details`
--

INSERT INTO `result_details` (`id`, `result_id`, `question_id`, `user_answer`, `is_correct`, `points`) VALUES
(1, 1, 1, NULL, 0, 0.00),
(2, 1, 2, NULL, 0, 0.00),
(3, 1, 3, NULL, 0, 0.00),
(4, 1, 4, NULL, 0, 0.00),
(5, 1, 5, 'C', 0, 0.00),
(6, 1, 6, NULL, 0, 0.00),
(7, 1, 7, NULL, 0, 0.00),
(8, 1, 8, NULL, 0, 0.00),
(9, 1, 9, NULL, 0, 0.00),
(10, 1, 10, NULL, 0, 0.00),
(11, 1, 11, NULL, 0, 0.00),
(12, 1, 12, NULL, 0, 0.00),
(13, 1, 13, NULL, 0, 0.00),
(14, 1, 14, NULL, 0, 0.00),
(15, 1, 15, NULL, 0, 0.00),
(16, 1, 16, NULL, 0, 0.00),
(17, 1, 17, NULL, 0, 0.00),
(18, 1, 18, NULL, 0, 0.00),
(19, 1, 19, NULL, 0, 0.00),
(20, 1, 20, NULL, 0, 0.00),
(21, 1, 21, NULL, 0, 0.00),
(22, 1, 22, NULL, 0, 0.00),
(23, 1, 23, NULL, 0, 0.00),
(24, 1, 24, NULL, 0, 0.00),
(25, 1, 25, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(26, 1, 26, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":1}', 0, 0.10),
(27, 1, 27, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(28, 1, 28, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(29, 2, 57, NULL, 0, 0.00),
(30, 2, 58, NULL, 0, 0.00),
(31, 2, 59, 'D', 0, 0.00),
(32, 2, 60, NULL, 0, 0.00),
(33, 2, 61, NULL, 0, 0.00),
(34, 2, 62, NULL, 0, 0.00),
(35, 2, 63, NULL, 0, 0.00),
(36, 2, 64, NULL, 0, 0.00),
(37, 2, 65, 'C', 0, 0.00),
(38, 2, 66, 'C', 1, 0.25),
(39, 2, 67, NULL, 0, 0.00),
(40, 2, 68, NULL, 0, 0.00),
(41, 2, 69, NULL, 0, 0.00),
(42, 2, 70, NULL, 0, 0.00),
(43, 2, 71, NULL, 0, 0.00),
(44, 2, 72, NULL, 0, 0.00),
(45, 2, 73, NULL, 0, 0.00),
(46, 2, 74, NULL, 0, 0.00),
(47, 2, 75, NULL, 0, 0.00),
(48, 2, 76, 'C', 0, 0.00),
(49, 2, 77, NULL, 0, 0.00),
(50, 2, 78, NULL, 0, 0.00),
(51, 2, 79, NULL, 0, 0.00),
(52, 2, 80, 'A', 0, 0.00),
(53, 2, 81, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(54, 2, 82, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(55, 2, 83, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(56, 2, 84, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(57, 3, 1, 'A', 1, 0.25),
(58, 3, 2, 'D', 0, 0.00),
(59, 3, 3, 'D', 0, 0.00),
(60, 3, 4, 'A', 1, 0.25),
(61, 3, 5, 'A', 1, 0.25),
(62, 3, 6, 'D', 0, 0.00),
(63, 3, 7, 'B', 0, 0.00),
(64, 3, 8, 'B', 1, 0.25),
(65, 3, 9, 'A', 0, 0.00),
(66, 3, 10, 'A', 1, 0.25),
(67, 3, 11, 'C', 0, 0.00),
(68, 3, 12, 'B', 1, 0.25),
(69, 3, 13, 'A', 1, 0.25),
(70, 3, 14, 'D', 1, 0.25),
(71, 3, 15, 'B', 0, 0.00),
(72, 3, 16, 'A', 0, 0.00),
(73, 3, 17, 'A', 1, 0.25),
(74, 3, 18, 'C', 1, 0.25),
(75, 3, 19, 'B', 1, 0.25),
(76, 3, 20, 'A', 0, 0.00),
(77, 3, 21, 'D', 1, 0.25),
(78, 3, 22, 'D', 0, 0.00),
(79, 3, 23, 'D', 0, 0.00),
(80, 3, 24, 'B', 0, 0.00),
(81, 3, 25, '{\"a\":1,\"b\":1,\"c\":1,\"d\":1}', 0, 0.25),
(82, 3, 26, '{\"a\":1,\"b\":1,\"c\":1,\"d\":1}', 0, 0.50),
(83, 3, 27, '{\"a\":1,\"b\":1,\"c\":1,\"d\":1}', 0, 0.25),
(84, 3, 28, '{\"a\":1,\"b\":1,\"c\":1,\"d\":1}', 0, 0.50),
(85, 4, 141, NULL, 0, 0.00),
(86, 4, 142, NULL, 0, 0.00),
(87, 4, 143, NULL, 0, 0.00),
(88, 4, 144, NULL, 0, 0.00),
(89, 4, 145, NULL, 0, 0.00),
(90, 4, 146, NULL, 0, 0.00),
(91, 4, 147, NULL, 0, 0.00),
(92, 4, 148, NULL, 0, 0.00),
(93, 4, 149, NULL, 0, 0.00),
(94, 4, 150, NULL, 0, 0.00),
(95, 4, 151, NULL, 0, 0.00),
(96, 4, 152, NULL, 0, 0.00),
(97, 4, 153, NULL, 0, 0.00),
(98, 4, 154, NULL, 0, 0.00),
(99, 4, 155, NULL, 0, 0.00),
(100, 4, 156, NULL, 0, 0.00),
(101, 4, 157, NULL, 0, 0.00),
(102, 4, 158, NULL, 0, 0.00),
(103, 4, 159, NULL, 0, 0.00),
(104, 4, 160, NULL, 0, 0.00),
(105, 4, 161, NULL, 0, 0.00),
(106, 4, 162, NULL, 0, 0.00),
(107, 4, 163, NULL, 0, 0.00),
(108, 4, 164, NULL, 0, 0.00),
(109, 4, 165, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(110, 4, 166, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(111, 4, 167, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(112, 4, 168, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(113, 5, 57, NULL, 0, 0.00),
(114, 5, 58, NULL, 0, 0.00),
(115, 5, 59, NULL, 0, 0.00),
(116, 5, 60, NULL, 0, 0.00),
(117, 5, 61, NULL, 0, 0.00),
(118, 5, 62, NULL, 0, 0.00),
(119, 5, 63, NULL, 0, 0.00),
(120, 5, 64, NULL, 0, 0.00),
(121, 5, 65, NULL, 0, 0.00),
(122, 5, 66, NULL, 0, 0.00),
(123, 5, 67, NULL, 0, 0.00),
(124, 5, 68, NULL, 0, 0.00),
(125, 5, 69, NULL, 0, 0.00),
(126, 5, 70, NULL, 0, 0.00),
(127, 5, 71, NULL, 0, 0.00),
(128, 5, 72, NULL, 0, 0.00),
(129, 5, 73, NULL, 0, 0.00),
(130, 5, 74, NULL, 0, 0.00),
(131, 5, 75, NULL, 0, 0.00),
(132, 5, 76, NULL, 0, 0.00),
(133, 5, 77, NULL, 0, 0.00),
(134, 5, 78, NULL, 0, 0.00),
(135, 5, 79, NULL, 0, 0.00),
(136, 5, 80, NULL, 0, 0.00),
(137, 5, 81, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(138, 5, 82, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(139, 5, 83, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00),
(140, 5, 84, '{\"a\":-1,\"b\":-1,\"c\":-1,\"d\":-1}', 0, 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('favicon', 'uploads/img_69edd37b5f4b2_1777193851.png'),
('logo_icon', 'fa-solid fa-microchip'),
('logo_image', ''),
('logo_type', 'icon');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$OyFOQVliV/KwCRADoa5HF.qY1p1mFCFZ3R6M8TwN7C0VDqGJ8naRG', 'Qu?n Tr? Viên', 'admin', '2026-04-26 08:57:17'),
(2, 'binhsubvip', '$2y$10$LsYnFV2zhqc5GPyLqtyQLOc8UEEg/frwCLxazF43DGezhMSSI9Znm', 'Thanh Bình', 'user', '2026-04-26 09:13:52');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `answers_mcq`
--
ALTER TABLE `answers_mcq`
  ADD PRIMARY KEY (`question_id`);

--
-- Chỉ mục cho bảng `answers_tf`
--
ALTER TABLE `answers_tf`
  ADD PRIMARY KEY (`question_id`);

--
-- Chỉ mục cho bảng `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Chỉ mục cho bảng `result_details`
--
ALTER TABLE `result_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_id` (`result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT cho bảng `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `result_details`
--
ALTER TABLE `result_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `answers_mcq`
--
ALTER TABLE `answers_mcq`
  ADD CONSTRAINT `answers_mcq_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `answers_tf`
--
ALTER TABLE `answers_tf`
  ADD CONSTRAINT `answers_tf_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `result_details`
--
ALTER TABLE `result_details`
  ADD CONSTRAINT `result_details_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `results` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `result_details_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
