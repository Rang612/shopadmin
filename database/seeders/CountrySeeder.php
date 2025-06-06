<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        $countries = [
            ['id' => 1, 'name' => 'Hà Nội', 'code' => 'HN'],
            ['id' => 2, 'name' => 'Hồ Chí Minh', 'code' => 'HCM'],
            ['id' => 3, 'name' => 'Hải Phòng', 'code' => 'HP'],
            ['id' => 4, 'name' => 'Đà Nẵng', 'code' => 'DN'],
            ['id' => 5, 'name' => 'Cần Thơ', 'code' => 'CT'],
            ['id' => 6, 'name' => 'An Giang', 'code' => 'AG'],
            ['id' => 7, 'name' => 'Bà Rịa - Vũng Tàu', 'code' => 'BRVT'],
            ['id' => 8, 'name' => 'Bắc Giang', 'code' => 'BG'],
            ['id' => 9, 'name' => 'Bắc Kạn', 'code' => 'BK'],
            ['id' => 10, 'name' => 'Bạc Liêu', 'code' => 'BL'],
            ['id' => 11, 'name' => 'Bắc Ninh', 'code' => 'BN'],
            ['id' => 12, 'name' => 'Bến Tre', 'code' => 'BT'],
            ['id' => 13, 'name' => 'Bình Định', 'code' => 'BD'],
            ['id' => 14, 'name' => 'Bình Dương', 'code' => 'BDU'],
            ['id' => 15, 'name' => 'Bình Phước', 'code' => 'BP'],
            ['id' => 16, 'name' => 'Bình Thuận', 'code' => 'BTH'],
            ['id' => 17, 'name' => 'Cà Mau', 'code' => 'CM'],
            ['id' => 18, 'name' => 'Cao Bằng', 'code' => 'CB'],
            ['id' => 19, 'name' => 'Đắk Lắk', 'code' => 'DL'],
            ['id' => 20, 'name' => 'Đắk Nông', 'code' => 'DN'],
            ['id' => 21, 'name' => 'Điện Biên', 'code' => 'DB'],
            ['id' => 22, 'name' => 'Đồng Nai', 'code' => 'DNA'],
            ['id' => 23, 'name' => 'Đồng Tháp', 'code' => 'DT'],
            ['id' => 24, 'name' => 'Gia Lai', 'code' => 'GL'],
            ['id' => 25, 'name' => 'Hà Giang', 'code' => 'HG'],
            ['id' => 26, 'name' => 'Hà Nam', 'code' => 'HNA'],
            ['id' => 27, 'name' => 'Hà Tĩnh', 'code' => 'HT'],
            ['id' => 28, 'name' => 'Hải Dương', 'code' => 'HD'],
            ['id' => 29, 'name' => 'Hậu Giang', 'code' => 'HG'],
            ['id' => 30, 'name' => 'Hòa Bình', 'code' => 'HB'],
            ['id' => 31, 'name' => 'Hưng Yên', 'code' => 'HY'],
            ['id' => 32, 'name' => 'Khánh Hòa', 'code' => 'KH'],
            ['id' => 33, 'name' => 'Kiên Giang', 'code' => 'KG'],
            ['id' => 34, 'name' => 'Kon Tum', 'code' => 'KT'],
            ['id' => 35, 'name' => 'Lai Châu', 'code' => 'LC'],
            ['id' => 36, 'name' => 'Lâm Đồng', 'code' => 'LD'],
            ['id' => 37, 'name' => 'Lạng Sơn', 'code' => 'LS'],
            ['id' => 38, 'name' => 'Lào Cai', 'code' => 'LCA'],
            ['id' => 39, 'name' => 'Long An', 'code' => 'LA'],
            ['id' => 40, 'name' => 'Nam Định', 'code' => 'ND'],
            ['id' => 41, 'name' => 'Nghệ An', 'code' => 'NA'],
            ['id' => 42, 'name' => 'Ninh Bình', 'code' => 'NB'],
            ['id' => 43, 'name' => 'Ninh Thuận', 'code' => 'NT'],
            ['id' => 44, 'name' => 'Phú Thọ', 'code' => 'PT'],
            ['id' => 45, 'name' => 'Phú Yên', 'code' => 'PY'],
            ['id' => 46, 'name' => 'Quảng Bình', 'code' => 'QB'],
            ['id' => 47, 'name' => 'Quảng Nam', 'code' => 'QNA'],
            ['id' => 48, 'name' => 'Quảng Ngãi', 'code' => 'QN'],
            ['id' => 49, 'name' => 'Quảng Ninh', 'code' => 'QNIN'],
            ['id' => 50, 'name' => 'Quảng Trị', 'code' => 'QT'],
            ['id' => 51, 'name' => 'Sóc Trăng', 'code' => 'ST'],
            ['id' => 52, 'name' => 'Sơn La', 'code' => 'SL'],
            ['id' => 53, 'name' => 'Tây Ninh', 'code' => 'TN'],
            ['id' => 54, 'name' => 'Thái Bình', 'code' => 'TB'],
            ['id' => 55, 'name' => 'Thái Nguyên', 'code' => 'TNIN'],
            ['id' => 56, 'name' => 'Thanh Hóa', 'code' => 'TH'],
            ['id' => 57, 'name' => 'Thừa Thiên Huế', 'code' => 'TTH'],
            ['id' => 58, 'name' => 'Tiền Giang', 'code' => 'TG'],
            ['id' => 59, 'name' => 'Trà Vinh', 'code' => 'TV'],
            ['id' => 60, 'name' => 'Tuyên Quang', 'code' => 'TQ'],
            ['id' => 61, 'name' => 'Vĩnh Long', 'code' => 'VL'],
            ['id' => 62, 'name' => 'Vĩnh Phúc', 'code' => 'VP'],
            ['id' => 63, 'name' => 'Yên Bái', 'code' => 'YB'],
        ];

        foreach ($countries as &$country) {
            $country['created_at'] = $now;
            $country['updated_at'] = $now;
        }

        DB::table('countries')->insert($countries);
    }
}
